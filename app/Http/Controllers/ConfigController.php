<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserConfig;
use Illuminate\Http\Request;
use SergiX44\Nutgram\Nutgram;

class ConfigController extends Controller
{
    public function store(Request $request)
    {
        try {
            $user  = User::where('id', $request->user_id)
                ->with("userConfig", function ($query) {
                    $query->where('status', 1);
            })->first();

            if (!$user) { throw new \Exception('Usuário não encontrado'); }
            if ($user->userConfig->count() >= $user->max_configs) { throw new \Exception('O número máximo de configurações ativas para esse usuário é: ' . $user->max_configs); }

            $config = UserConfig::create($request->all());
            $bot = new Nutgram(env('TELEGRAM_TOKEN', '830113645:AAGSt94gcNzKjiHoHrQLSDeDUTGsBzSaGNw'));
            $bot->sendMessage('✅ Nova configuração salva com sucesso!', [
                'chat_id' => $config->user_id,
                'parse_mode' => 'HTML',
            ]);

            return response()->json($config, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
