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
            $sh_sum_shoots = ($row->home_on_target+$row->home_off_target+$row->guest_on_target+$row->guest_off_target)-($row->first_half_home_on_target+$row->first_half_home_off_target+$row->first_half_guest_on_target+$row->first_half_guest_off_target);
            $sum_shoots_on_target = $row->home_on_target+$row->guest_on_target;
            $sh_sum_shoots_on_target = ($row->home_on_target+$row->guest_on_target)-($row->first_half_home_on_target+$row->first_half_guest_on_target);
            $sum_corners = $row->home_corner+$row->guest_corner;
            $sh_sum_corners = ($row->home_corner+$row->guest_corner)-($row->first_half_home_corner+$row->first_half_guest_corner);
            $sum_red = $row->home_red+$row->guest_red;
            $sh_sum_red = ($row->home_red+$row->guest_red)-($row->first_half_home_red+$row->first_half_guest_red);
            $sum_goals = $row->home_goal+$row->guest_goal;
            $sh_sum_goals = ($row->home_goal+$row->guest_goal)-($row->first_half_home_goal+$row->first_half_guest_goal);
            $diff_goals = abs($row->home_goal-$row->guest_goal);

            $configs = DB::select( DB::raw("SELECT A.* FROM user_configs A
                WHERE (min_time is null OR min_time <= '$row->time') AND
                (max_time is null OR max_time >= '$row->time') AND
                (min_sum_goals is null OR min_sum_goals <= '$sum_goals') AND
                (second_half_min_sum_goals is null OR second_half_min_sum_goals <= '$sh_sum_goals') AND
                (max_sum_goals is null OR max_sum_goals >= '$sum_goals') AND
                (second_half_max_sum_goals is null OR second_half_max_sum_goals >= '$sh_sum_goals') AND
                (min_diff_goals is null OR min_diff_goals <= '$diff_goals') AND
                (max_diff_goals is null OR max_diff_goals >= '$diff_goals') AND
                (min_sum_shoots is null OR min_sum_shoots <= '$sum_shoots') AND
                (second_half_min_sum_shoots is null OR second_half_min_sum_shoots <= '$sh_sum_shoots') AND
                (max_sum_shoots is null OR max_sum_shoots >= '$sum_shoots') AND
                (second_half_max_sum_shoots is null OR second_half_max_sum_shoots >= '$sh_sum_shoots') AND
                (min_sum_shoots_on_target is null OR min_sum_shoots_on_target <= '$sum_shoots_on_target') AND
                (second_half_min_sum_shoots_on_target is null OR second_half_min_sum_shoots_on_target <= '$sh_sum_shoots_on_target') AND
                (max_sum_shoots_on_target is null OR max_sum_shoots_on_target >= '$sum_shoots_on_target') AND
                (second_half_max_sum_shoots_on_target is null OR second_half_max_sum_shoots_on_target >= '$sh_sum_shoots_on_target') AND
                (min_sum_corners is null OR min_sum_corners <= '$sum_corners') AND
                (second_half_min_sum_corners is null OR second_half_min_sum_corners <= '$sh_sum_corners') AND
                (max_sum_corners is null OR max_sum_corners >= '$sum_corners') AND
                (second_half_max_sum_corners is null OR second_half_max_sum_corners >= '$sh_sum_corners') AND
                (min_sum_red is null OR min_sum_red <= '$sum_red') AND
                (second_half_min_sum_red is null OR second_half_min_sum_red <= '$sh_sum_red') AND
                (max_sum_red is null OR max_sum_red >= '$sum_red') AND
                (second_half_max_sum_red is null OR second_half_max_sum_red >= '$sh_sum_red') AND
                A.status = 1
            "));

            foreach($configs as $config){

                $game_config = GameUserConfig::where([
                    'user_config_id' => $config->id,
                    'game_id' => $row->game->id
                ])->first();

                if(!$game_config || !$game_config->id){

                    $message = $this->makeMessage($row, $config);

                    TelegramQueue::create([
                        'telegram_user_id' => $config->user_id,
                        'chat' => $message,
                        'game_id' => $row->game->id
                    ]);

                    GameUserConfig::create([
                        'user_config_id' => $config->id,
                        'game_id' => $row->game->id
                    ]);

                    DB::table('user_configs')->where('id', $config->id)->increment('activated_count');
                }
            }
            $row->status = 1;
            $row->save();
        }
        return Command::SUCCESS;
    }

    public static function makeMessage(mixed $gameDetails, mixed $userConfig = null, $compareDetails = null) : string
    {
        $message = '';
        if($userConfig){
            $message =  "📝   <b>Configuração: " . $userConfig->name . " </b>" . PHP_EOL;
        }
        $message =  $message .
        "⏱   <b>" . $gameDetails->time . " </b>" . PHP_EOL .
        "🏆   <b><u>" . $gameDetails->game->league . "</u></b>" . PHP_EOL .
        "👕   <b>" . $gameDetails->home_goal . "</b> - " . $gameDetails->game->home . (($compareDetails && $gameDetails->home_goal-$compareDetails->home_goal) ? ' ⬆️'.'('.($gameDetails->home_goal-$compareDetails->home_goal).')' : '') . PHP_EOL .
        "👕   <b>" . $gameDetails->guest_goal . "</b> - " . $gameDetails->game->guest . (($compareDetails && $gameDetails->guest_goal-$compareDetails->guest_goal) ? ' ⬆️'.'('.($gameDetails->guest_goal-$compareDetails->guest_goal).')' : '') . PHP_EOL . PHP_EOL .

        "🔸   Escanteios: " . (($compareDetails && $gameDetails->home_corner-$compareDetails->home_corner) ? '('.($gameDetails->home_corner-$compareDetails->home_corner).')⬆️ ' : '') . $gameDetails->home_corner . " <b>x</b> " . $gameDetails->guest_corner . (($compareDetails && $gameDetails->guest_corner-$compareDetails->guest_corner) ? ' ⬆️'.'('.($gameDetails->guest_corner-$compareDetails->guest_corner).')' : '') . PHP_EOL .
        "🔸   Chute a gol: " . (($compareDetails && $gameDetails->home_on_target-$compareDetails->home_on_target) ? '('.($gameDetails->home_on_target-$compareDetails->home_on_target).')⬆️ ' : '') . $gameDetails->home_on_target . " <b>x</b> " . $gameDetails->guest_on_target . (($compareDetails && $gameDetails->guest_on_target-$compareDetails->guest_on_target) ? ' ⬆️'.'('.($gameDetails->guest_on_target-$compareDetails->guest_on_target).')' : '') . PHP_EOL .
        "🔸   Chute para fora: " . (($compareDetails && $gameDetails->home_off_target-$compareDetails->home_off_target) ? '('.($gameDetails->home_off_target-$compareDetails->home_off_target).')⬆️ ' : '') . $gameDetails->home_off_target . " <b>x</b> " . $gameDetails->guest_off_target . (($compareDetails && $gameDetails->guest_off_target-$compareDetails->guest_off_target) ? ' ⬆️'.'('.($gameDetails->guest_off_target-$compareDetails->guest_off_target).')' : '') . PHP_EOL .
        "🔸   Cartões Vermelhos: " . (($compareDetails && $gameDetails->home_red-$compareDetails->home_red) ? '('.($gameDetails->home_red-$compareDetails->home_red).')⬆️ ' : '') . $gameDetails->home_red . " <b>x</b> " . $gameDetails->guest_red . (($compareDetails && $gameDetails->guest_red-$compareDetails->guest_red) ? ' ⬆️'.'('.($gameDetails->guest_red-$compareDetails->guest_red).')' : '');

        if($gameDetails->game->half == 2){
            $message = $message .
            PHP_EOL . PHP_EOL .
            "🔸   -- Primeiro Tempo --" . PHP_EOL .
            "🔸   Escanteios: " . $gameDetails->first_half_home_corner . " <b>x</b> " . $gameDetails->first_half_guest_corner . PHP_EOL .
            "🔸   Chute a gol: " . $gameDetails->first_half_home_on_target . " <b>x</b> " . $gameDetails->first_half_guest_on_target . PHP_EOL .
            "🔸   Chute para fora: " . $gameDetails->first_half_home_off_target . " <b>x</b> " . $gameDetails->first_half_guest_off_target . PHP_EOL .
            "🔸   Cartões Vermelhos: " . $gameDetails->first_half_home_red . " <b>x</b> " . $gameDetails->first_half_guest_red;

            $message = $message .
            PHP_EOL . PHP_EOL .
            "🔸   -- Segundo Tempo --" . PHP_EOL .
            "🔸   Escanteios: " . ($gameDetails->home_corner-$gameDetails->first_half_home_corner) . " <b>x</b> " . ($gameDetails->guest_corner-$gameDetails->first_half_guest_corner) . PHP_EOL .
            "🔸   Chute a gol: " . ($gameDetails->home_on_target-$gameDetails->first_half_home_on_target) . " <b>x</b> " . ($gameDetails->guest_on_target-$gameDetails->first_half_guest_on_target) . PHP_EOL .
            "🔸   Chute para fora: " . ($gameDetails->home_off_target-$gameDetails->first_half_home_off_target) . " <b>x</b> " . ($gameDetails->guest_off_target-$gameDetails->first_half_guest_off_target) . PHP_EOL .
            "🔸   Cartões Vermelhos: " . ($gameDetails->home_red-$gameDetails->first_half_home_red) . " <b>x</b> " . ($gameDetails->home_red-$gameDetails->first_half_home_red);
        }

        return $message;
    }
}
