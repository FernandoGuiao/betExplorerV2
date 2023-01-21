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
use Illuminate\Support\Facades\DB;

class AdminHandler
{
    public function broadcast(Nutgram $bot, $param): void
    {
        $message = $bot->message()->text;
        Log::info('AdminHandler@broadcast: ' . $param);

        try {

            $users = User::withActiveConfig()->get();
            $message = str_replace('/broadcast ', '', $message);

            foreach ($users as $user) {
                try {
                    $bot->sendMessage(
                        "🚨  <b>Mensagem dos administradores:</b>  🚨" . PHP_EOL . PHP_EOL .
                        $message . PHP_EOL . PHP_EOL .
                        "👉  <b>Admin: </b> @" . $bot->user()->username . "  👈",

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
            Log::alert('AdminHandler@broadcast: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            $bot->sendMessage("❌ Erro ao enviar todas as mensagens de broadcast.");
        }
    }

    public function query(Nutgram $bot, $param): void
    {
        $message = $bot->message()->text;
        Log::info('AdminHandler@broadcast: ' . $param);
        $user = User::where('id', $bot->user()->id)->first();

        try {
            $users = User::withActiveConfig()->get();
            $message = str_replace('/query ', '', $message);

            DB::statement($message);

            $bot->sendMessage(
                "Query Executada com Sucesso!",

                [
                    'chat_id' => $user->id,
                    'parse_mode' => 'HTML',
                ]
            );

        } catch (\Exception $e) {
            Log::alert('AdminHandler@query: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            $bot->sendMessage("❌ Erro ao executar a query.");
        }
    }

}
