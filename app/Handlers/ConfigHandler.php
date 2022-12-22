<?php

namespace App\Handlers;

use App\Models\Game;
use App\Models\User;
use App\Models\UserConfig;
use Illuminate\Support\Facades\Log;
use SergiX44\Nutgram\Nutgram;

class ConfigHandler
{
    public function join(Nutgram $bot, $param): void
    {
        $command = explode(' ', $param);

        UserConfig::create([
            'user_Id' => $bot->user()->id,
            'name' => isset($command[0])&&$command[0]!='-'?$command[0]:null,
            'min_time' => isset($command[1])&&$command[1]!='-'?$command[1]:null,
            'max_time' => isset($command[2])&&$command[2]!='-'?$command[2]:null,
            'min_sum_goals' => isset($command[3])&&$command[3]!='-'?$command[3]:null,
            'max_sum_goals' => isset($command[4])&&$command[4]!='-'?$command[4]:null,
            'min_sum_shoots' => isset($command[5])&&$command[5]!='-'?$command[5]:null,
            'max_sum_shoots' => isset($command[6])&&$command[6]!='-'?$command[6]:null,
            'min_sum_corners' => isset($command[7])&&$command[7]!='-'?$command[7]:null,
            'max_sum_corners' => isset($command[8])&&$command[8]!='-'?$command[8]:null,
            'min_sum_red' => isset($command[9])&&$command[9]!='-'?$command[9]:null,
            'max_sum_red' => isset($command[10])&&$command[10]!='-'?$command[10]:null,
            'status' => 1,
        ]);

        $bot->sendMessage("✅ Nova configuração salva!");
    }

    public function clear(Nutgram $bot): void
    {
        UserConfig::where('user_id', $bot->userId())->delete();

        $bot->sendMessage("❎ Configurações apagadas!");
    }
}
