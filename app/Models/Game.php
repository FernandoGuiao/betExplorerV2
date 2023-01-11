<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $guarded = [];

    function gameDetails(){
        return $this->hasMany(GameDetail::class);
    }

    public static function getGameStatistics($game, $extra){

        $doc = new \DomDocument;
        $doc->validateOnParse = true;
        libxml_use_internal_errors(true);
        $doc->loadHTMLFile(env('DATA_STATISTIC_URL','https://www.scorebing.com/panlu/').$game->id);
        libxml_clear_errors();

        $scripts = $doc->getElementsByTagName('script');
        $gameArr = [];
        $gameHomeArr = [];
        $gameGuestArr = [];
        $race = [];
        $tmp_league_name = '';
        $tmp_guest_name = '';
        $tmp_host_name = '';
        foreach($scripts as $script){
            $script = $doc->saveXML($script);
            $lines = explode(';', $script);
            $i = 0;
            foreach($lines as $key => $line){
                if (str_starts_with(trim($line), 'race')) {
                    $line = trim($line);
                    $line = str_replace('tmp_league_name','$tmp_league_name', $line);
                    $line = str_replace('tmp_guest_name','$tmp_guest_name', $line);
                    $line = str_replace('tmp_host_name','$tmp_host_name', $line);
                    
                    // echo "$".trim($lines[$key-3]).";";
                    eval("$".trim($lines[$key-3]).";");
                    // echo "$".trim($lines[$key-2]).";";
                    eval("$".trim($lines[$key-2]).";");
                    // echo "$".trim($lines[$key-1]).";";
                    eval("$".trim($lines[$key-1]).";");
                    // echo "$".$line.";";
                    eval("$".$line.";");

                    if($race[$i][4] == $extra['host_id'] || $race[$i][7] == $extra['host_id']){ //home
                        $gameHomeArr[$i]['date'] = $race[$i][2];
                        $gameHomeArr[$i]['home'] = $race[$i][5];
                        $gameHomeArr[$i]['guest'] = $race[$i][8];
                        $gameHomeArr[$i]['league'] = $race[$i][12];
                        $gameHomeArr[$i]['first_home_corner'] = $race[$i][13];
                        $gameHomeArr[$i]['first_guest_corner'] = $race[$i][14];
                        $gameHomeArr[$i]['first_home_goals'] = $race[$i][15];
                        $gameHomeArr[$i]['first_guest_goals'] = $race[$i][16];
                        $gameHomeArr[$i]['full_home_corner'] = $race[$i][17];
                        $gameHomeArr[$i]['full_guest_corner'] = $race[$i][18];
                        $gameHomeArr[$i]['full_home_goals'] = $race[$i][19];
                        $gameHomeArr[$i]['full_guest_goals'] = $race[$i][20];
                    }

                    if($race[$i][4] == $extra['guest_id'] || $race[$i][7] == $extra['guest_id']){ //guest
                        $gameGuestArr[$i]['date'] = $race[$i][2];
                        $gameGuestArr[$i]['home'] = $race[$i][5];
                        $gameGuestArr[$i]['guest'] = $race[$i][8];
                        $gameGuestArr[$i]['league'] = $race[$i][12];
                        $gameGuestArr[$i]['first_home_corner'] = $race[$i][13];
                        $gameGuestArr[$i]['first_guest_corner'] = $race[$i][14];
                        $gameGuestArr[$i]['first_home_goals'] = $race[$i][15];
                        $gameGuestArr[$i]['first_guest_goals'] = $race[$i][16];
                        $gameGuestArr[$i]['full_home_corner'] = $race[$i][17];
                        $gameGuestArr[$i]['full_guest_corner'] = $race[$i][18];
                        $gameGuestArr[$i]['full_home_goals'] = $race[$i][19];
                        $gameGuestArr[$i]['full_guest_goals'] = $race[$i][20];
                    }

                    $i++;
                }
            }

        }

        $gameArr['home'] = $gameHomeArr;
        $gameArr['guest'] = $gameGuestArr;

        $game->update(['extra' => json_encode($gameArr)]);
    }
}
