<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\UserConfig;
use Illuminate\Console\Command;
use SergiX44\Nutgram\Nutgram;

class WeekReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'week:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'manda relatório semanal de cada configuração';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Week report');

        $users = User::withActiveConfig()->get();
        $this->info('users: ' . $users->count());

        $bot = new Nutgram(env('BOT_TOKEN', '830113645:AAGSt94gcNzKjiHoHrQLSDeDUTGsBzSaGNw'));

        foreach ($users as $user) {
            $message = '<b> 📊  Relatório de quantidade de alertas na samana: </b> ' . PHP_EOL . PHP_EOL;

            foreach($user->userConfig as $config){
                $message .= ($config->name ?? "Sem Nome" ) . ' - <b>' . $config->activated_count . '</b>'. PHP_EOL;
            }

            $bot->sendMessage(
                $message,
                [
                    'chat_id' => $config->user_id ,
                    'parse_mode' => 'HTML',
                ]
            );
        }

        UserConfig::where('activated_count', '!=', 0)->update([
            'activated_count' => 0
        ]);

        return Command::SUCCESS;
    }
}
