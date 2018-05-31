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
		return view('reports.index');
	}
    
}
