<?php

namespace Bene\Weather\Console\Commands;

use Bene\Weather\City;
use Bene\Weather\UserEmail;
use Bene\Weather\Weather;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CheckWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:weather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        $city = City::orderBy('created_at', 'DESC')->first();
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://api.openweathermap.org/data/2.5/weather?q=' . $city->city . '&APPID=6f3aa95336edac6e5b6296a6e5f37bf2');
        $res = json_decode($res->getBody()->getContents(), true);
        $lastWind = Weather::orderBy('created_at', 'DESC')->first();
        if ($lastWind['is_more_than_10'] == '0' && $res['wind']['speed'] > 10) {
            DB::table('weathers')->insert(['is_more_than_10' => '1', 'created_at' => date('Y/m/d H:i:s')]);
            $this->sendEmail('Greiti perkope 10m/s');
        } else if ($lastWind['is_more_than_10'] == '1' && $res['wind']['speed'] < 10) {
            DB::table('weathers')->insert(['is_more_than_10' => '0', 'created_at' => date('Y/m/d H:i:s')]);
			$this->sendEmail('Greiti yra mazesnis nei 10m/s');
        }

    }

    public function sendEmail($text)
    {
        $emails = UserEmail::all()->pluck('email');
        foreach ($emails as $email) {
            Mail::raw($text, function ($message) use ($email) {
                $message->subject('Vejo greitis');
                $message->from('zygintas.tamulis@gmail.com', 'Website Name');
                $message->to($email);
            });
        }
    }

}
