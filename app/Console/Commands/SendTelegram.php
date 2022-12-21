<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TelegramQueue;

use SergiX44\Nutgram\Nutgram;
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
            $message = $bot->sendMessage($row->chat, ['chat_id' => $row->telegram_user_id]);
            $row->status = 1;
            $row->save();
        }

        return Command::SUCCESS;
    }
}
