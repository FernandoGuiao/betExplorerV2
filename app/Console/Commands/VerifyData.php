<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Game;
use App\Models\GameDetail;
use App\Models\UserConfig;
use App\Models\TelegramQueue;

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

            $configs = UserConfig::where('min_time', '<=', $row->time)
            ->where('max_time', '>=', $row->time)
            ->where('min_sum_shoots', '<=', ($sum_shoots))
            ->get();
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
