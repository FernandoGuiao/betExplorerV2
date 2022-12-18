<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Game;
use App\Models\GameDetail;

class UpdateGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:games';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update games using bling';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $data = file_get_contents(env('DATA_URL'));
        $obj = json_decode($data);

        foreach($obj->rs as $row){

            if(!isset($row->status) || $row->status != 'NS') { //not started

                $game = Game::updateOrCreate(['id'=>$row->id], [
                    'home' => $row->host->n,
                    'guest' => $row->guest->n,
                    'league' => $row->league->fn,
                    'live' => $row->status=='FT' ? false : true
                ]);
    
                if($game){
    
                    $time = $row->status;
                    if($time=='FT'){
                        $time = 90;
                    }elseif($time=='HT'){
                        $time = 45;

                        $game->update(['half' => 2]);
                    }
    
                    $game->gameDetails()->create([
                        'time' => $time,
                        'home_goal' => $row->rd->hg,
                        'guest_goal' => $row->rd->gg,
                        'home_corner' => $row->rd->hc,
                        'guest_corner' => $row->rd->gc,
                        'home_on_target' => $row->plus->hso,
                        'guest_on_target' => $row->plus->gso,
                        'home_off_target' => $row->plus->hsf,
                        'guest_off_target' => $row->plus->gsf,
                        'home_red' => $row->rd->hr,
                        'guest_red' => $row->rd->gr,
                        'home_yellow' => $row->rd->hy,
                        'guest_yellow' => $row->rd->gy,
                    ]);
                }
            }
        }


        return Command::SUCCESS;
    }
}
