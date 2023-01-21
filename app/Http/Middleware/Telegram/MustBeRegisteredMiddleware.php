<?php

namespace App\Http\Middleware\Telegram;

use App\Models\User;
use SergiX44\Nutgram\Nutgram;

class MustBeRegisteredMiddleware
{
    public function __invoke(Nutgram $bot, $next): void
    {

        User::updateOrCreate(
            ['id' => $bot->user()->id],
            [
                'id' => $bot->user()->id,
                'name' => $bot->user()->first_name . ($bot->user()->last_name ? " " . $bot->user()->last_name : ""),
            ]
        );

        $user = User::find($bot->user()->id);

        if (!$user) {
            $bot->sendMessage("⛔ " . 'Envie /start para ser cadastrado novamente');
            return;
        }

        $next($bot);
    }
}
