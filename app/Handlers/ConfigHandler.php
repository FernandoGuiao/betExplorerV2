<?php

namespace App\Handlers;

use App\Models\UserConfig;
use Exception;
use Illuminate\Support\Facades\Log;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Attributes\ParseMode;

class ConfigHandler
{
    public function new(Nutgram $bot, $param): void
    {
        $command = explode(' ', $param);

        Log::info('ConfigHandler@new: ' . $param);

        try {
            UserConfig::create([
                'user_Id' => $bot->user()->id,
                'name' => isset($command[0]) && $command[0] != '-' ? $command[0] : null,
                'min_time' => isset($command[1]) && $command[1] != '-' ? $command[1] : null,
                'max_time' => isset($command[2]) && $command[2] != '-' ? $command[2] : null,
                'min_sum_goals' => isset($command[3]) && $command[3] != '-' ? $command[3] : null,
                'max_sum_goals' => isset($command[4]) && $command[4] != '-' ? $command[4] : null,
                'min_diff_goals' => isset($command[5]) && $command[5] != '-' ? $command[5] : null,
                'max_diff_goals' => isset($command[6]) && $command[6] != '-' ? $command[6] : null,
                'min_sum_shoots' => isset($command[7]) && $command[7] != '-' ? $command[7] : null,
                'max_sum_shoots' => isset($command[8]) && $command[8] != '-' ? $command[8] : null,
                'min_sum_shoots_on_target' => isset($command[9]) && $command[9] != '-' ? $command[9] : null,
                'max_sum_shoots_on_target' => isset($command[10]) && $command[10] != '-' ? $command[10] : null,
                'min_sum_corners' => isset($command[11]) && $command[11] != '-' ? $command[11] : null,
                'max_sum_corners' => isset($command[12]) && $command[12] != '-' ? $command[12] : null,
                'min_sum_red' => isset($command[13]) && $command[13] != '-' ? $command[13] : null,
                'max_sum_red' => isset($command[14]) && $command[14] != '-' ? $command[14] : null,
                'status' => 1,
            ]);

            $bot->sendMessage("✅ Nova configuração salva!");
        } catch (Exception $e) {
            $bot->sendMessage("❌ Erro ao salvar configuração! Verifique os parâmetros e tente novamente.");
        }
    }

    public function paramTest(Nutgram $bot, $param): void
    {

        Log::info('ConfigHandler@paramTest: ' . $param);


        $bot->sendMessage("✅ " . $param);

    }

    public function newWeb(Nutgram $bot): void
    {
        Log::info('ConfigHandler@newWeb');

        try {

            $bot->sendMessage(" Nova configuração !",
                [
                    'parse_mode' => ParseMode::HTML,
                    'reply_markup' => [
                        'inline_keyboard' => [
                            [
                                [
                                    'text' => 'Fazer Nova Config',
                                    'web_app' => [
                                        'url' => url('/') . '/new-config',
//                                        'url' => 'https://ck5gmkxikx.sharedwithexpose.com' . '/new-config',
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            );

        } catch (Exception $e) {
            $bot->sendMessage("❌ Erro ao enviar link para fazer nova configuração.");
            Log::error($e->getMessage(), $e->getTrace());
        }
    }

    public function clear(Nutgram $bot): void
    {
        UserConfig::where('user_id', $bot->user()->id)->delete();

        $bot->sendMessage("❎ Todas as configurações foram apagadas!");
    }

    public function delete(Nutgram $bot, $param): void
    {
        try {
            UserConfig::where('id', $param)->delete();
            $bot->sendMessage("❎ Configuração apagada!");
        } catch (Exception $e) {
            $bot->sendMessage("❌ Erro ao apagar a configuração!");
        }

    }

    public function show(Nutgram $bot): void
    {
        $configs = UserConfig::where('user_id', $bot->userId())->get();

        foreach ($configs as $config) {
            $bot->sendMessage(
                "📝 <b><u>" . ($config->name ?? "X") . "</u></b>" . PHP_EOL .
                "⏱ Minutos: " . ($config->min_time ?? "X") . " - " . ($config->max_time ?? "X") . PHP_EOL . PHP_EOL .
                
                "<b><u>Tempo Total de Jogo:</u></b>". PHP_EOL .                
                "🥅 Gols: " . ($config->min_sum_goals ?? "X") . " - " . ($config->max_sum_goals ?? "X") . PHP_EOL .
                "⚽ Chutes: " . ($config->min_sum_shoots ?? "X") . " - " . ($config->max_sum_shoots ?? "X") . PHP_EOL .               
                "⚽ Chutes no gol: " . ($config->min_sum_shoots_on_target ?? "X") . " - " . ($config->max_sum_shoots_on_target ?? "X") . PHP_EOL .
                "⛳ Escanteios: " . ($config->min_sum_corners ?? "X") . " - " . ($config->max_sum_corners ?? "X") . PHP_EOL . 
                "🔴 Cartões Vermelhos: " . ($config->min_sum_red ?? "X") . " - " . ($config->max_sum_red ?? "X") . PHP_EOL . PHP_EOL .
                
                "⚖️ ⚽ Diferença de Chutes: " . ($config->min_diff_shoots ?? "X") . " - " . ($config->max_diff_shoots ?? "X") . PHP_EOL .
                "⚖️ 🥅 Diferença Gols: " . ($config->min_diff_goals ?? "X") . " - " . ($config->max_diff_goals ?? "X") . PHP_EOL .
                "⚖️ 🔴 Diferença de Cartões Vermelhos: " . ($config->min_diff_red ?? "X") . " - " . ($config->max_diff_red ?? "X") . PHP_EOL . PHP_EOL .
                
                "<b><u>Exclusivamente Segundo Tempo:></u></b>". PHP_EOL .
                "🥅 Gols: " . ($config->second_half_min_sum_goals ?? "X") . " - " . ($config->second_half_max_sum_goals ?? "X") . PHP_EOL .
                "⚽ Chutes: " . ($config->second_half_min_sum_shoots ?? "X") . " - " . ($config->second_half_max_sum_shoots ?? "X") . PHP_EOL .
                "⚽ Chutes no gol: " . ($config->second_half_min_sum_shoots_on_target ?? "X") . " - " . ($config->second_half_max_sum_shoots_on_target ?? "X") . PHP_EOL .
                "⛳ Escanteios: " . ($config->second_half_min_sum_corners ?? "X") . " - " . ($config->second_half_max_sum_corners ?? "X") . PHP_EOL .
                "🔴 Cartões Vermelhos: " . ($config->second_half_min_sum_red ?? "X") . " - " . ($config->second_half_max_sum_red ?? "X") . PHP_EOL . PHP_EOL .
                
                "⚖️ ⚽ Diferença de Chutes: " . ($config->second_half_min_diff_shoots ?? "X") . " - " . ($config->second_half_min_diff_shoots ?? "X"),
                [
                    'parse_mode' => ParseMode::HTML,
                    'reply_markup' => [
                        'inline_keyboard' => [
                            [
                                [
                                    'text' => '⛔ Remover',
                                    'callback_data' => 'deleteConfig ' . $config->id
                                ]
                            ]
                        ]
                    ]
                ]
            );
        }

        if (count($configs) == 0) {
            $bot->sendMessage("❌ Você não possui configurações!");
        }

        $this->newWeb($bot);
    }

    public function help(Nutgram $bot): void
    {
        $bot->sendMessage(
            "<b>Para criar nova configuração de alerta envie o comando '/newConfig' seguido dos filtros:</b>" . PHP_EOL . PHP_EOL . PHP_EOL .
            "/newConfig [nome da configuração] [mínimo de tempo] [máximo de tempo] [mínimo soma de gols] [máximo soma de gols] " .
            "[mínimo de diferença de gols] [máximo de diferença de gols] [mínimo soma de chutes] [max de soma de chutes] " .
            "[mínimo soma de chutes ao gol] [max de soma de chutes ao gol] [mínimo de soma de escanteios] [máximo de soma de escanteios] " .
            "[mínimo soma de cartões vermelhos] [máximo soma de cartões vermelhos]",
            [
                'parse_mode' => 'HTML'
            ]
        );
        $bot->sendMessage(
            "<b>Exemplo para jogos entre 20 e 45 minutos que tenha no mínimo 3 gols e 6 escanteios:</b>",
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
