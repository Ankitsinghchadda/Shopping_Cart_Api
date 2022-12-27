<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Carbon\CarbonImmutable;

class CarbonController extends Controller
{
    public function index()
    {
        $mutable =  Carbon::now();
        $immutable =  CarbonImmutable::now();
        $modifiedMutable = $mutable->add(1, 'day');
        // var_dump($modifiedMutable);
        // var_dump($immutable);

        // Immutable returns a new instance of the date whenever it is modified.
        // $immutable->add(1, 'day');
        // return ($mutable);

        // return $mutable->isoFormat('dddd D Y');

        // $mutable = CarbonImmutable::now()->toMutable();
        // var_dump($mutable->isMutable());
        // var_dump($mutable->isImmutable());
        // $immutable = Carbon::now()->toImmutable();
        // var_dump($immutable->isMutable());
        // var_dump($immutable->isImmutable());

        // Difference in hour between India and Toronto
        // $dtIndia = Carbon::create(2022, 12, 23, 0, 0, 0, 'Asia/Kolkata');
        // $dtToronto = Carbon::create(2022, 12, 23, 0, 0, 0, 'America/Toronto');

        // return ($dtIndia->diffInHours($dtToronto));
        // return $dtIndia;

        // $indiaTime = Carbon::now('Asia/Kolkata');
        // return $indiaTime->tzName;

        // return (new Carbon('first Wednesday of November 2023'))->isoFormat('dddd D M Y');
        // return Carbon::parse('first day of December 2008')->addWeeks(2);


        // $now = Carbon::now();
        // echo $now;
        // echo "<br>";
        // $today = Carbon::today();
        // echo $today;
        // echo "<br>";
        // $tomorrow = Carbon::tomorrow('Asia/Kolkata');
        // echo $tomorrow;
        // echo "<br>";
        // $yesterday = Carbon::yesterday();
        // echo $yesterday;

        // $year = 2000;
        // $month = 4;
        // $day = 19;
        // $hour = 20;
        // $minute = 30;
        // $second = 15;
        // $tz = 'Europe/Madrid';
        // echo Carbon::createFromDate($year, $month, $day, $tz) . "\n";
        // echo Carbon::createMidnightDate($year, $month, $day, $tz) . "\n";
        // echo Carbon::createFromTime($hour, $minute, $second, $tz) . "\n";
        // echo Carbon::createFromTimeString("$hour:$minute:$second", $tz) . "\n";
        // echo Carbon::create($year, $month, $day, $hour, $minute, $second, $tz) . "\n";

        // $date = CarbonImmutable::now();
        // echo $date->calendar();
        // echo "\n";
        // echo $date->sub('1 day 3 hours')->calendar();
        // echo "\n";
        // echo $date->sub('3 days 10 hours 23 minutes')->calendar();
        // echo "\n";
        // echo $date->sub('8 days')->calendar();
        // echo "\n";
        // echo $date->add('1 day 3 hours')->calendar();
        // echo "\n";
        // echo $date->add('3 days 10 hours 23 minutes')->calendar();
        // echo "\n";
        // echo $date->add('8 days')->calendar();
        // echo "\n";
        // echo $date->locale('fr')->calendar();



    }
}
