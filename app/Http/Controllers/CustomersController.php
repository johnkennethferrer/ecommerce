<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use Auth;

class CustomersController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

   	public function getIndex() {
   		if (Auth::user()->role_id == 1) {

	   		$customers = User::where('role_id', 2)
        	   						->whereNull('deleted_at')
        	   						->get();

        $counterorder = DB::table('transactions')
                            ->where('status', "Pending")
                            ->count();

	   		return view('customers.index', ['customers' => $customers, 'counterorder' => $counterorder]);
   		}
    	return back();
   	}

   

}
