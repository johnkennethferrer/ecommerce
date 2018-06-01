<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $now = Carbon::now('Asia/Manila');
        $datetime = $now->toDateTimeString();
        $date = $now->toDateString();
        $time = $now->toTimeString();

        $salestotal = DB::table('transactions')
                            ->where('status', "Completed")
                            ->whereDate('created_at', $date)
                            ->sum('total_amount');

        $customers = DB::table('users')
                            ->where('role_id', 2)
                            ->whereNull('deleted_at')
                            ->count();
        $counterorder = DB::table('transactions')
                            ->where('status', "Pending")
                            ->count();

        return view('home',['salestotal' => $salestotal, 'customers' => $customers, 'counterorder' => $counterorder]);
    }
}
