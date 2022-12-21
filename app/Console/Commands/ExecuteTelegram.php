<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Telegram\Middleware\MustBeRegisteredMiddleware;
use Illuminate\Console\Command;
use SergiX44\Nutgram\Nutgram;
use App\Models\TelegramUpdate;
use App\Models\UserConfig;

class ExecuteTelegram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'execute:telegram';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute telegram command';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $telegram_updates = TelegramUpdate::where(['status'=>0])->get();
        foreach($telegram_updates as $row){
            $command = explode(' ', $row->chat);

            switch($command[0]){
                case '/newConfig':                
                        UserConfig::create([
                        'user_Id' => $row->telegram_user_id,
                        'min_time' => isset($command[1])?$command[1]:null,
                        'max_time' => isset($command[2])?$command[2]:null,
                        'min_sum_shoots' => isset($command[3])?$command[3]:null,
                        'max_sum_shoots' => isset($command[4])?$command[4]:null,
                        'min_sum_corners' => isset($command[5])?$command[5]:null,
                        'max_sum_corners' => isset($command[6])?$command[6]:null,
                        'min_sum_red' => isset($command[7])?$command[7]:null,
                        'max_sum_red' => isset($command[8])?$command[8]:null,
                        'status' => 1,
                    ]);
                    break;
                case '/clearConfig':                
                    UserConfig::where('user_id', $row->telegram_user_id)->delete();
                break;
            }
            $row->status = 1;
            $row->save();
        }

        return Command::SUCCESS;
    }
}
