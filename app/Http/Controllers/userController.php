<?php

namespace App\Http\Controllers;
use App\payment_type;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class userController extends Controller
{
    //
    public function show()
    {
        $pays = payment_type::all();
        $timeunits = DB::select('select * from time_units');
        return view('user',['pays'=>$pays,'timeunits'=>$timeunits]);
    }    

    public function userList()
    {
        $users = DB::select('select * from users');

        return view('userList',['users'=>$users]);
    }
}
