<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Transaction;
use User;
use Carbon\Carbon;

class ReportsController extends Controller
{

	public function getIndex() {
		$counterorder = DB::table('transactions')
			                ->where('status', "Pending")
			                ->count();
		return view('reports.index', ['counterorder' => $counterorder]);
	}
    
}
