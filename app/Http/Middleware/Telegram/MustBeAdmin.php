<?php

namespace App\Http\Middleware\Telegram;

use App\Models\User;
use SergiX44\Nutgram\Nutgram;

class MustBeAdmin
{
    public function __invoke(Nutgram $bot, $next): void
    {
        $user = User::find($bot->user()->id);

        if (!$user->is_admin) {
            $bot->sendMessage("⛔ Somente administradores podem fazer essa ação.");
            return;
        }

        $next($bot);
    }
}
