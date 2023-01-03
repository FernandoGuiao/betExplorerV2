<?php

namespace App\Http\Controllers;

use App\Handlers\ConfigHandler;
use App\Handlers\GameHandler;
use App\Http\Middleware\Telegram\MustBeRegisteredMiddleware;
use App\Telegram\Handlers\VetoPresidentHandler;
use Illuminate\Support\Facades\Log;
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
        Log::info('webhook init');
        $bot->setRunningMode(Webhook::class);

        $bot->middleware(MustBeRegisteredMiddleware::class);
        Log::info('middleware passed');

        $bot->onCommand('start', function ($bot) {
            Log::info('User ' . $bot->user()->first_name . ' started the bot');
            $bot->sendMessage('Olá, ' . $bot->user()->first_name . '!');
            $bot->sendMessage('Utilize o menu de comandos para saber como utilizar o bot');
        });

        $bot->onCommand('newConfig', [ConfigHandler::class, 'help']);

        $bot->onCommand('newConfig {param}', [ConfigHandler::class, 'new'])
            ->description('Cria nova configuração de alerta');

        $bot->onCommand('paramTest {param}', [ConfigHandler::class, 'paramTest'])
            ->description('Cria nova configuração de alerta');

        $bot->onCommand('newWebConfig', [ConfigHandler::class, 'newWeb'])
            ->description('Cria nova configuração de alerta pela web');

        $bot->onCommand('clearConfig', [ConfigHandler::class, 'clear'])
            ->description('Limpa todas as configurações de alerta');

        $bot->onCommand('showConfigs', [ConfigHandler::class, 'show'])
            ->description('Mostra todas as configurações de alerta');

        $bot->onCommand('help', [ConfigHandler::class, 'help'])
            ->description('Mostra ajuda sobre configurações de alerta');

        $bot->onCallbackQueryData('gameStatusNow {param}', [GameHandler::class, 'gameStatusNow']);
        $bot->registerMyCommands();

        $bot->run();
    }

    public function webhookTest(\Illuminate\Http\Request $request): void
    {
        response()->json($request->all());
    }
}
