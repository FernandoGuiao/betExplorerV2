<?php

namespace App\Handlers;

use App\Console\Commands\VerifyData;
use App\Models\Game;
use App\Models\GameDetail;
use App\Models\User;
use App\Models\UserConfig;
use Illuminate\Support\Facades\Log;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Attributes\ParseMode;

class AdminHandler
{
    public function broadcast(Nutgram $bot, $param): void
    {
        $message = $bot->message()->text;
        Log::info('AdminHandler@broadcast: ' . $param);
        $user = User::where('id', $bot->user()->id)->first();

        if (!$user->is_admin) {
            $bot->sendMessage("❌ Somente administradores podem fazer essa ação.");
            return;
        }

        try {

            $users = User::withActiveConfig()->get();
            $message = str_replace('/broadcast ', '', $message);

            foreach ($users as $user) {
                try {
                    $bot->sendMessage(
                        "🚨  <b>Mensagem dos administradores:</b>  🚨" . PHP_EOL . PHP_EOL .
                        $message,
                        [
                            'chat_id' => $user->id,
                            'parse_mode' => 'HTML',
                        ]
                    );
                } catch (\Exception $e) {
                    Log::alert('AdminHandler@broadcast: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
                    $bot->sendMessage("❌ Erro ao mandar mensagem para usuário. Nome: " . $user->name);
                }
            }

        } catch (\Exception $e) {
            Log::alert('ConfigHandler@gameStatusNow: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            $bot->sendMessage("❌ Erro ao enviar todas as mensagens de broadcast.");
        }
    }

}
