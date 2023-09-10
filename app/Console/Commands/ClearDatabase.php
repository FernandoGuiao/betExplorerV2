<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        Db::table('games')
            ->where('created_at', '<', Carbon::now()->subDays(182))
            ->delete();

        Db::table('telegram_queue')
            ->where('created_at', '<', Carbon::now()->subDays(30))
            ->delete();

        Db::table('game_details')
            ->orWhere(function ($query) {
                $query->where('created_at', '<', Carbon::now()->subDays(182));
            })
            ->orWhere(function ($query) {
                $query->where('created_at', '<', Carbon::now()->subDays(30))
                    ->where('time', '!=', 45)
                    ->where('time', '!=', 90);
            })
            ->delete();


        return Command::SUCCESS;
    }
}
