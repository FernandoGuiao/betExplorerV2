<?php

namespace App\Http\Controllers;

use App\Handlers\ConfigHandler;
use App\Http\Middleware\Telegram\MustBeRegisteredMiddleware;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Webhook;

class TelegramController
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function webhook(Nutgram $bot): void
    {
        $bot->setRunningMode(Webhook::class);

        $bot->middleware(MustBeRegisteredMiddleware::class);

        $bot->onCommand('/newConfig {param}', [ConfigHandler::class, 'new'])
            ->description('Cria nova configuração de alerta');

        $bot->onCommand('/clearConfig', [ConfigHandler::class, 'clear'])
            ->description('Limpa todas as configurações de alerta');

        $bot->registerMyCommands();

        $bot->run();
    }
}
