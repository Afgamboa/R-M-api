<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CharacterController extends Controller
{
    public function addFavorite(Request $request){
        $params = $request->request->all();
        $userId = $params['userId'];
        $characterId = $params['characterId'];

        $newFav = DB::table('favorites')->insert([
            'user_id' => $userId, 
            'characterId' => $characterId
        ]);

        return $newFav;
    }
}
