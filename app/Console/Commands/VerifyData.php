<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Game;
use App\Models\GameDetail;
use App\Models\UserConfig;
use App\Models\TelegramQueue;
use DB;

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
            $sum_corners = $row->home_corner+$row->guest_corner;
            $sum_red = $row->home_red+$row->guest_red;


            $configs = DB::select( DB::raw("SELECT * FROM user_configs 
                WHERE (min_time is null OR min_time <= '$row->time') AND
                (max_time is null OR max_time >= '$row->time') AND
                (min_sum_shoots is null OR min_sum_shoots <= '$sum_shoots') AND
                (max_sum_shoots is null OR max_sum_shoots >= '$sum_shoots') AND
                (min_sum_corners is null OR min_sum_corners <= '$sum_corners') AND
                (max_sum_corners is null OR max_sum_corners >= '$sum_corners') AND
                (min_sum_red is null OR min_sum_red <= '$sum_red') AND
                (max_sum_red is null OR max_sum_red >= '$sum_red')
            "));

            // $configs = UserConfig::where('min_time', '<=', $row->time)
            // ->where('max_time', '>=', $row->time)
            // ->where('min_sum_shoots', '<=', ($sum_shoots))
            // ->get();
            foreach($configs as $config){
                TelegramQueue::create([
                    'telegram_user_id' => $config->user_id,
                    'chat' => 
                        $row->game->league."\n".
                        $row->game->home." ".
                        $row->home_goal." vs ".$row->guest_goal." ".$row->game->guest.
                        "\nTotal de Chutes: ".$sum_shoots,
                ]);
            }
            $row->status = 1;
            $row->save();
        }
        return Command::SUCCESS;
    }
}
