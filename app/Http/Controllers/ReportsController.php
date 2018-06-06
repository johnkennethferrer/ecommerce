<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Transaction;
use User;
use Carbon\Carbon;

class ReportsController extends Controller
{	
	public function __construct()
    {
        $this->middleware('auth');
    }

	public function getIndex() {

		if (Auth::user()->role_id == 1) {
			$now = Carbon::now('Asia/Manila');
	        $datetime = $now->toDateTimeString();
	        $date = $now->toDateString();
	        $time = $now->toTimeString();

			$counterorder = DB::table('transactions')
				                ->where('status', "Pending")
				                ->count();

			$salestoday = Transaction::where('status', 'Completed')
									->whereDate('created_at', $date)
									->get();
			$totalsale = Transaction::where('status', 'Completed')
									->whereDate('created_at', $date)
									->sum('total_amount');

			return view('reports.index', ['salestoday' => $salestoday, 'totalsale' => $totalsale ,'counterorder' => $counterorder]);
		}
	}

	public function generateReport(Request $request) 
	{

		if (Auth::user()->role_id == 1) {
			$counterorder = DB::table('transactions')
			                ->where('status', "Pending")
			                ->count();

			$sales = Transaction::where('status', 'Completed')
									->whereDate('created_at', '>=' ,$request->input('date_from'))
									->whereDate('created_at', '<=' ,$request->input('date_to'))
									->get();

			$totalsale = Transaction::where('status', 'Completed')
									->whereDate('created_at', '>=' ,$request->input('date_from'))
									->whereDate('created_at', '<=' ,$request->input('date_to'))
									->sum('total_amount');

			return view('reports.showreport', ['sales' => $sales, 'totalsale' => $totalsale, 
											   'counterorder' => $counterorder, 'datefrom' => $request->input('date_from'),
											   'dateto' => $request->input('date_to')]);
		}
		
	}

	public function printReport($datefrom, $dateto)
	{
		if (Auth::user()->role_id == 1) {
			$sales = Transaction::where('status', 'Completed')
								->whereDate('created_at', '>=' ,$datefrom)
								->whereDate('created_at', '<=' ,$dateto)
								->get();

			$totalsale = Transaction::where('status', 'Completed')
									->whereDate('created_at', '>=' ,$datefrom)
									->whereDate('created_at', '<=' ,$dateto)
									->sum('total_amount');

			return view('reports.print', ['sales' => $sales, 'totalsale' => $totalsale, 'datefrom' => $datefrom,
											   'dateto' => $dateto]);
		}
	}

	public function printReportToday()
	{	
		if (Auth::user()->role_id == 1) {
			$now = Carbon::now('Asia/Manila');
		    $date = $now->toDateString();

			$salestoday = Transaction::where('status', 'Completed')
									->whereDate('created_at', $date)
									->get();
			$totalsale = Transaction::where('status', 'Completed')
									->whereDate('created_at', $date)
									->sum('total_amount');

			return view('reports.printsalestoday', ['sales' => $salestoday, 'totalsale' => $totalsale ]);
		}
	}
    
}
