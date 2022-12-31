<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TelegramQueue;

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Attributes\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

class SendTelegram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:telegram';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send telegram message';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $queue = TelegramQueue::where(['status'=>0])->get();
        $bot = new Nutgram(env('BOT_TOKEN', '830113645:AAGSt94gcNzKjiHoHrQLSDeDUTGsBzSaGNw'));
        foreach($queue as $row){
            try {

                $options = [
                        'chat_id' => $row->telegram_user_id,
                        'parse_mode' => ParseMode::HTML,
                ];

                if ($row->game_id) {
                    $options['reply_markup'] = [
                        'inline_keyboard' => [
                            [
                                ['text' => '🔄️  Atualizar status', 'callback_data' => 'gameStatusNow ' . $row->game_id],
                            ],
//                            [
//                                ['text' => 'Atualizar status', 'callback_data' => 'gameStatusNow ' . $row->game_id], // Colocar botão de ver últimos jogos dos times (time 1)
//                                ['text' => 'Atualizar status', 'callback_data' => 'gameStatusNow ' . $row->game_id], // Colocar botão de ver últimos jogos dos times (time 2)
//                            ],
                        ],
                    ];
                }

                $message = $bot->sendMessage(
                    $row->chat, $options);

                $row->status = 1;
                $row->save();
            } catch (\Throwable $th) {
                $row->status = 9;
                $row->save();
            }
        }

        return Command::SUCCESS;
    }
}
