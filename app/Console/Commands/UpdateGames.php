<?php

namespace App\Console\Commands;

use App\Models\Game;
use Illuminate\Console\Command;

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

        foreach ($obj->rs as $row) {

            if (
                !is_object($row) ||
                !isset($row->status) ||
                $row->status == 'NS' ||
                !isset($row->host) ||
                !isset($row->guest) ||
                !isset($row->league)
            ) {
                continue;
            }

            $game = Game::updateOrCreate(['id' => $row->id], [
                'home' => $row->host->n,
                'guest' => $row->guest->n,
                'league' => $row->league->fn,
                'live' => $row->status == 'FT' ? false : true
            ]);

            if ($game) {

                $time = $row->status;
                if ($time == 'FT') {
                    $time = 90;
                } elseif ($time == 'HT') {
                    $time = 45;

                    $game->update(['half' => 2]);
                }

                $game->gameDetails()->create([
                    'time' => $time,
                    'home_goal' => $row->rd->hg ?? null,
                    'guest_goal' => $row->rd->gg ?? null,
                    'home_corner' => $row->rd->hc ?? null,
                    'guest_corner' => $row->rd->gc ?? null,
                    'home_on_target' => $row->plus->hso ?? null,
                    'guest_on_target' => $row->plus->gso ?? null,
                    'home_off_target' => $row->plus->hsf ?? null,
                    'guest_off_target' => $row->plus->gsf ?? null,
                    'home_red' => $row->rd->hr ?? null,
                    'guest_red' => $row->rd->gr ?? null,
                    'home_yellow' => $row->rd->hy ?? null,
                    'guest_yellow' => $row->rd->gy ?? null,
                ]);
            }
        }
        return Command::SUCCESS;
    }
}



