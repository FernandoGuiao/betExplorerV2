<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Game;
use App\Models\GameDetail;
use App\Models\UserConfig;
use App\Models\GameUserConfig;
use App\Models\TelegramQueue;
use Illuminate\Support\Facades\DB;

class VerifyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verify:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify data from game table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $game_details = GameDetail::where(['status'=>0])->get();
        foreach($game_details as $row){
            $sum_shoots = $row->home_on_target+$row->home_off_target+$row->guest_on_target+$row->guest_off_target;
            $sum_shoots_on_target = $row->home_on_target+$row->guest_on_target;
            $sum_corners = $row->home_corner+$row->guest_corner;
            $sum_red = $row->home_red+$row->guest_red;
            $sum_goals = $row->home_goal+$row->guest_goal;
            $diff_goals = abs($row->home_goal-$row->guest_goal);


            $configs = DB::select( DB::raw("SELECT A.* FROM user_configs A
                WHERE (min_time is null OR min_time <= '$row->time') AND
                (max_time is null OR max_time >= '$row->time') AND
                (min_sum_goals is null OR min_sum_goals <= '$sum_goals') AND
                (max_sum_goals is null OR max_sum_goals >= '$sum_goals') AND
                (min_diff_goals is null OR min_diff_goals <= '$diff_goals') AND
                (max_diff_goals is null OR max_diff_goals >= '$diff_goals') AND
                (min_sum_shoots is null OR min_sum_shoots <= '$sum_shoots') AND
                (max_sum_shoots is null OR max_sum_shoots >= '$sum_shoots') AND
                (min_sum_shoots_on_target is null OR min_sum_shoots_on_target <= '$sum_shoots_on_target') AND
                (max_sum_shoots_on_target is null OR max_sum_shoots_on_target >= '$sum_shoots_on_target') AND
                (min_sum_corners is null OR min_sum_corners <= '$sum_corners') AND
                (max_sum_corners is null OR max_sum_corners >= '$sum_corners') AND
                (min_sum_red is null OR min_sum_red <= '$sum_red') AND
                (max_sum_red is null OR max_sum_red >= '$sum_red') AND A.status = 1
            "));

            // $configs = UserConfig::where('min_time', '<=', $row->time)
            // ->where('max_time', '>=', $row->time)
            // ->where('min_sum_shoots', '<=', ($sum_shoots))
            // ->get();
            foreach($configs as $config){

                $game_config = GameUserConfig::where([
                    'user_config_id' => $config->id,
                    'game_id' => $row->game->id
                ])->first();

                if(!$game_config || !$game_config->id){
                    $message =
                        "📝   <b>Configuração: " . $config->name . " </b>" . PHP_EOL .
                        "⏱   <b>" . $row->time . " </b>" . PHP_EOL .
                        "🏆   <b><u>" . $row->game->league . "</u></b>" . PHP_EOL .
                        "👕   <b>" . $row->home_goal . "</b> - " . $row->game->home . PHP_EOL .
                        "👕   <b>" . $row->guest_goal . "</b> - " . $row->game->guest . PHP_EOL . PHP_EOL .

                        "🔸   Escanteios: " . $row->home_corner . " <b>x </b> " . $row->guest_corner . PHP_EOL .
                        "🔸   Chute a gol: " . $row->home_on_target . " <b>x</b> " . $row->guest_on_target . PHP_EOL .
                        "🔸   Chute para fora: " . $row->home_off_target . " <b>x</b> " . $row->guest_off_target;

                    TelegramQueue::create([
                        'telegram_user_id' => $config->user_id,
                        'chat' => $message
                    ]);

                    GameUserConfig::create([
                        'user_config_id' => $config->id,
                        'game_id' => $row->game->id
                    ]);
                }

            }
            $row->status = 1;
            $row->save();
        }
        return Command::SUCCESS;
    }
}
