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

                $message =
                    "⏱   <b>$row->time</b>" . PHP_EOL .
                    "🏆   <b><u>$row->game->league</u></b>" . PHP_EOL .
                    "👕   <b>$row->home_goal</b> - $row->game->home" . PHP_EOL .
                    "👕   <b>$row->guest_goal</b> - $row->game->guest" . PHP_EOL . PHP_EOL .

                    "🔸   Escanteios: $row->home_corner <b>x</b> $row->guest_corner" . PHP_EOL .
                    "🔸   Chute a gol: $row->home_on_target <b>x</b> $row->guest_on_target" . PHP_EOL .
                    "🔸   Chute para fora: $row->home_off_target <b>x</b> $row->guest_off_target";

                TelegramQueue::create([
                    'telegram_user_id' => $config->user_id,
                    'chat' => $message
                ]);
            }
            $row->status = 1;
            $row->save();
        }
        return Command::SUCCESS;
    }
}
