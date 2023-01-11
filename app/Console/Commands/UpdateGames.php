<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Models\Health;
use App\Models\TelegramQueue;
use App\Models\User;
use App\Models\Team;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        $health = Health::where('name', 'update:games')->first();
        try {
            $this->info('Updating games...' . date('Y-m-d H:i:s'));
            $response = Http::get(env('DATA_URL', 'https://lv.scorebing.com/ajax/score/data'));
            $this->info('Data received...' . date('Y-m-d H:i:s'));
            $obj = json_decode($response->body());
        } catch (\Exception $e) {
            Log::error('UpdateGames: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            $health->increment('fails');
            if ($health->fails == config('app.max_fails')) {
                $this->broadcastMessage('⛔  Parece que o site que atualiza os jogos está fora do ar. Assim que voltar a funcionar avisaremos.');
            }
            $this->info('UpdateGames: ' . $e->getMessage());
            return 1;
        }
        if ($health->fails >= config('app.max_fails')) {
            Log::info('UpdateGames: Voltou ao normal ');
            $this->broadcastMessage('✅  Parece que o site que atualiza os jogos voltou a funcionar. Agora já podemos atualizar os jogos.');
        }
        $health->update(['fails' => 0]);

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
                'home_id' => $row->host->i,
                'guest' => $row->guest->n,
                'guest_id' => $row->guest->i,
                'league' => $row->league->fn,
                'live' => $row->status == 'FT' ? false : true
            ]);

            

            if ($game) {

                if($game->wasRecentlyCreated){
                    Team::updateOrCreate(['id' => $row->host->i], [
                        'name' => $row->host->n
                    ]);

                    Team::updateOrCreate(['id' => $row->guest->i], [
                        'name' => $row->guest->n
                    ]);
                }

                $time = $row->status;
                if ($time == 'FT') {
                    $time = 90;

                    $home = Team::find($game->home_id);
                    if($home){
                        $home_stats = json_decode($home->stats, true);
                        if(!isset($home_stats['games'][$game->id])){
                            if(isset($home_stats['games']) && count($home_stats['games']) > 4){
                                unset($home_stats['games'][array_key_first($home_stats['games'])]);
                            }
                            $home_stats['games'][$game->id]['h'] = $game->home; //home
                            $home_stats['games'][$game->id]['g'] = $game->guest; //guest
                            $home_stats['games'][$game->id]['d'] = $game->created_at; //date
                            $home_stats['games'][$game->id]['hg'] = $row->rd->hg; //home goals
                            $home_stats['games'][$game->id]['gg'] = $row->rd->gg; //guest goals
                            $home_stats['games'][$game->id]['hhg'] = $row->rh->hg; //home half goals
                            $home_stats['games'][$game->id]['ghg'] = $row->rh->gg; //guest half goals
                            $home_stats['games'][$game->id]['hc'] = $row->rd->hc; //home corners
                            $home_stats['games'][$game->id]['gc'] = $row->rd->gc; //guest corners
                            $home_stats['games'][$game->id]['hhc'] = $row->rh->hc; //home half corners
                            $home_stats['games'][$game->id]['ghc'] = $row->rh->gc; //guest home corners
                            $home->stats = $home_stats;
                            $home->save();
                        }
                    }

                    $guest = Team::find($game->guest_id);
                    if($guest){
                        $guest_stats = json_decode($guest->stats, true);
                        if(!isset($guest_stats['games'][$game->id])){
                            if(isset($guest_stats['games']) && count($guest_stats['games']) > 4){
                                unset($guest_stats['games'][array_key_first($guest_stats['games'])]);
                            }
                            $guest_stats['games'][$game->id]['h'] = $game->home;
                            $guest_stats['games'][$game->id]['g'] = $game->guest;
                            $guest_stats['games'][$game->id]['d'] = $game->created_at;
                            $guest_stats['games'][$game->id]['hg'] = $row->rd->hg;
                            $guest_stats['games'][$game->id]['gg'] = $row->rd->gg;
                            $guest_stats['games'][$game->id]['hhg'] = $row->rh->hg;
                            $guest_stats['games'][$game->id]['ghg'] = $row->rh->gg;
                            $guest_stats['games'][$game->id]['hc'] = $row->rd->hc;
                            $guest_stats['games'][$game->id]['gc'] = $row->rd->gc;
                            $guest_stats['games'][$game->id]['hhc'] = $row->rh->hc;
                            $guest_stats['games'][$game->id]['ghc'] = $row->rh->gc;
                            $guest->stats = $guest_stats;
                            $guest->save();
                        }
                    }

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
        $this->info('Games updated...' . date('Y-m-d H:i:s'));
        return Command::SUCCESS;
    }

    private function broadcastMessage(string $message)
    {
        $users = User::all();
        foreach ($users as $user) {
            TelegramQueue::create([
                'telegram_user_id' => $user->id,
                'chat' => $message,
            ]);
        }
    }
}



