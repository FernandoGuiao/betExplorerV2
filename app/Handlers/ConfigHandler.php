<?php

namespace App\Handlers;

use App\Models\Game;
use App\Models\User;
use App\Models\UserConfig;
use Illuminate\Support\Facades\Log;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Attributes\ParseMode;

class ConfigHandler
{
    public function new(Nutgram $bot, $param): void
    {
        $command = explode(' ', $param);

        Log::info('ConfigHandler@join: ' . $param);

        try {
            UserConfig::create([
                'user_Id' => $bot->user()->id,
                'name' => isset($command[0]) && $command[0] != '-' ? $command[0] : null,
                'min_time' => isset($command[1]) && $command[1] != '-' ? $command[1] : null,
                'max_time' => isset($command[2]) && $command[2] != '-' ? $command[2] : null,
                'min_sum_goals' => isset($command[3]) && $command[3] != '-' ? $command[3] : null,
                'max_sum_goals' => isset($command[4]) && $command[4] != '-' ? $command[4] : null,
                'min_sum_shoots' => isset($command[5]) && $command[5] != '-' ? $command[5] : null,
                'max_sum_shoots' => isset($command[6]) && $command[6] != '-' ? $command[6] : null,
                'min_sum_corners' => isset($command[7]) && $command[7] != '-' ? $command[7] : null,
                'max_sum_corners' => isset($command[8]) && $command[8] != '-' ? $command[8] : null,
                'min_sum_red' => isset($command[9]) && $command[9] != '-' ? $command[9] : null,
                'max_sum_red' => isset($command[10]) && $command[10] != '-' ? $command[10] : null,
                'status' => 1,
            ]);

            $bot->sendMessage("✅ Nova configuração salva!");
        } catch (\Exception $e) {
            $bot->sendMessage("❌ Erro ao salvar configuração! Verifique os parâmetros e tente novamente.");
        }
    }

    public function clear(Nutgram $bot): void
    {
        UserConfig::where('user_id', $bot->user()->id)->delete();

        $bot->sendMessage("❎ Configurações apagadas!");
    }

    public function show(Nutgram $bot): void
    {
        $configs = UserConfig::where('user_id', $bot->userId())->get();

        foreach ($configs as $config) {
            $bot->sendMessage(
            "📝 <b>" . ($config->name ?? "X") . "</b>". PHP_EOL . PHP_EOL .
               "⏱ Tempo: " . ($config->min_time ?? "X") . " - " . ($config->max_time ?? "X") . PHP_EOL .
               "🥅 Gols: " . ($config->min_sum_goals ?? "X") . " - " . ($config->max_sum_goals ?? "X") . PHP_EOL .
               "⚽ Chutes: " . ($config->min_sum_shoots ?? "X") . " - " . ($config->max_sum_shoots ?? "X") . PHP_EOL .
               "⛳ Escanteios: " . ($config->min_sum_corners ?? "X") . " - " . ($config->max_sum_corners ?? "X") . PHP_EOL .
               "🔴 Cartões Vermelhos: " . ($config->min_sum_red ?? "X") . " - " . ($config->max_sum_red ?? "X"),
                [
                    'parse_mode' => ParseMode::HTML
                ]
            );
        }

        if (count($configs) == 0) {
            $bot->sendMessage("❌ Você não possui configurações!");
        }
    }

    public function help(Nutgram $bot): void
    {
        $bot->sendMessage(
            "<b>Para criar nova configuração de alerta envie o comando '/newConfig' seguido dos filtros:</b>" . PHP_EOL  . PHP_EOL . PHP_EOL .
            "/newConfig [nome da configuração] [mínimo de tempo] [máximo de tempo] [mínimo soma de gols] [máximo soma de gols] " .
            "[mínimo soma de de chutes] [max de soma de chutes] [mínimo de soma de escanteios] [máximo de soma de escanteios] " .
            "[mínimo soma de cartões vermelhos] [máximo soma de cartões vermelhos]",
            [
                'parse_mode' => 'HTML'
            ]
        );
        $bot->sendMessage(
            "<b>Exemplo para jogos entre 20 e 45 minutos que tenha no mínimo 3 gols e 6 escanteios:</b>" ,
            [
                'parse_mode' => 'HTML'
            ]
        );

        $bot->sendMessage(
            "/newConfig NomeQueQuiser 20 45 5 - - - 6 - - -",
            [
                'parse_mode' => 'HTML'
            ]
        );
    }
}
