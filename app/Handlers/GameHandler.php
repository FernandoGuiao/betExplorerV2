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
                        ['text' => '🔄️  Atualizar status', 'callback_data' => 'gameStatusNow ' . $param],
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
}
