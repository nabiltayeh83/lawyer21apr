<?php

namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\City;

class CityController extends Controller
{

    public function getCities($id){
        return City::where('country_id', $id)->where('status', 'active')->get();
    }

    public function getCountries(){
        return Country::where('status', 'active')->get();
    }

}
