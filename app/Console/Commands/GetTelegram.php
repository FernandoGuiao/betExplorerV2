<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Telegram\Middleware\MustBeRegisteredMiddleware;
use Illuminate\Console\Command;
use SergiX44\Nutgram\Nutgram;
use App\Models\TelegramUpdate;

class GetTelegram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:telegram';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get telegram message';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $bot = new Nutgram(env('BOT_TOKEN', '830113645:AAGSt94gcNzKjiHoHrQLSDeDUTGsBzSaGNw'));
        $updates = $bot->getUpdates();
        foreach ($updates as $update) {
            User::updateOrCreate(
                ['id' => $update->message->from->id],
                [
                    'id' => $update->message->from->id,
                    'name' => $update->message->from->first_name . ($update->message->from->last_name ? " " . $update->message->from->last_name : ""),
                ]
            );
            $telegram = TelegramUpdate::updateOrCreate(['id'=>$update->update_id], [
                'telegram_user_id' => $update->message->from->id,
                'name' => $update->message->from->first_name,
                'chat' => $update->message->text
            ]);
        }

        return Command::SUCCESS;
    }
}
