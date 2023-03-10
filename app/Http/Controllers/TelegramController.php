<?php

namespace App\Http\Controllers;

use App\Handlers\AdminHandler;
use App\Handlers\ConfigHandler;
use App\Handlers\GameHandler;
use App\Http\Middleware\Telegram\MustBeAdmin;
use App\Http\Middleware\Telegram\MustBeRegisteredMiddleware;
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

        $bot->onCommand('newConfig {param}', [ConfigHandler::class, 'new']);

        $bot->onCommand('paramTest {param}', [ConfigHandler::class, 'paramTest']);

        $bot->onCommand('newWebConfig', [ConfigHandler::class, 'newWeb']);

        $bot->onCommand('clearConfig', [ConfigHandler::class, 'clear'])
            ->description('Remove TODOS os alertas');

        $bot->onCommand('configs', [ConfigHandler::class, 'show'])
            ->description('Gerenciar alertas');

        $bot->onCommand('help', [ConfigHandler::class, 'help']);

        $bot->onCallbackQueryData('deleteConfig {param}', [ConfigHandler::class, 'delete']);

        $bot->onCallbackQueryData('gameStatusNow {param} {msg_id}', [GameHandler::class, 'gameStatusNow']);

        $bot->onCommand('broadcast {param}', [AdminHandler::class, 'broadcast'])
            ->middleware(MustBeAdmin::class);

        $bot->onCommand('query {param}', [AdminHandler::class, 'query'])
            ->middleware(MustBeAdmin::class);

        $bot->registerMyCommands();

        $bot->run();
    }

    public function webhookTest(\Illuminate\Http\Request $request): void
    {
        response()->json($request->all());
    }
}
