<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Clima;
use Carbon\Carbon;
use DB;

class ClimaController extends Controller
{
    public function index(){

        return DB::table('clima')
        ->select('id', 'cidade', 'temperatura', 'created_at', "updated_at")
        ->get();    

    }


    public function cidade($cidade){
       

        try{
            $cityInDb = DB::table('clima')->where("cidade", "{$cidade}")->first();

            if($cityInDb){
                
                $created_at = new Carbon($cityInDb->created_at);
                $now = Carbon::now();
                $resultado = $created_at->diffInMinutes($now);

                if($resultado <= 20){
                    
                    return $cityInDb;

                } else {
                    
                    $response = Http::get("api.openweathermap.org/data/2.5/weather?q={$cidade}&units=metric&appid=052aa4bb9c4cb951d428c008ab04f548");
                    $temp = $response['main']['temp'];

                    DB::table('clima')
                    ->where('cidade', "{$cidade}")
                    ->update(['created_at' => $now], ['updated_at' => $now]);

                    return DB::table('clima')->where("cidade", "{$cidade}")->first();;
                }

            } else {  

                $response = Http::get("api.openweathermap.org/data/2.5/weather?q={$cidade}&units=metric&appid=052aa4bb9c4cb951d428c008ab04f548");
                $city = $response['name'];
                $temp = $response['main']['temp'];
        
                DB::table('clima')->insert([
                'cidade' => "{$cidade}",
                'temperatura' => $temp,
                'created_at' => Carbon::now()
                ]);
        
                return DB::table('clima')->where("cidade", "{$cidade}")->first();;
            }
        } catch (Throwable $e) {
        report($e);

        return false;
    }
}
}