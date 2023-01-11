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

class GameHandler
{
    public function gameStatusNow(Nutgram $bot, $param): void
    {

        Log::info('ConfigHandler@gameStatusNow: ' . $param);

        try {
            $latestGameDetail = GameDetail::with('game')->whereHas('game', function ($query) use ($param) {
                $query->where('id', $param);
            })->latest()->first();

            $options = [
                'parse_mode' => ParseMode::HTML,
            ];

            $options['reply_markup'] = [
                'inline_keyboard' => [
                    [
                        ['text' => '🔄️  Atualizar status', 'callback_data' => 'gameStatusNow ' . $param]
                        // ['text' => 'Busca histórico recente', 'callback_data' => 'gameHistory ' . $param], 
                    ],

                ],
            ];

            $bot->sendMessage(
                VerifyData::makeMessage($latestGameDetail),
                $options
            );

        } catch (\Exception $e) {
            Log::alert('ConfigHandler@gameStatusNow: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            $bot->sendMessage("❌ Erro ao enviar atualização de jogo.");
        }
    }

    public function gameHistory(Nutgram $bot, $param): void
    {
        Log::info('ConfigHandler@gameHistory: ' . $param);

        try {
            $game = Game::find($param)->first();
            Log::info('ConfigHandler@gameHistory: ' . $game->home);

            if($game->requested == 2){
                $bot->sendMessage(json_encode($game->extra));
            }else{
                $game->requested = 1;
                $game->requested_user = $bot->user()->id;
                $bot->sendMessage("O histórico foi solicitado. Aguarde um momento enquanto buscamos em nossa base.");
            }
            $game->save();

        } catch (\Exception $e) {
            Log::alert('ConfigHandler@gameHistory: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            $bot->sendMessage("❌ Erro ao enviar histórico dos times.");
        }
    }
}
