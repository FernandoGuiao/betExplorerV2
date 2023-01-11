<?php

namespace App\Console\Commands;

use App\Models\Game;
use Illuminate\Console\Command;

class UpdateRequestedGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:requested';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update requested games using bling';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $games = Game::where(['requested'=>1])->get();
        foreach($games as $game){
            $extra = json_decode($game->extra, true);
            Game::getGameStatistics($game, $extra);
        }

        return Command::SUCCESS;
    }
}



