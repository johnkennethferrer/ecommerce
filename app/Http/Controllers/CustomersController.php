<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use Auth;
use Mail;

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

    public function sendCustomerEmail(Request $request)
    {
        
        $customer = User::find($request->input('cid'));

        $email = $customer->email; 
        $admin_email = Auth::user()->email;
        $subject = $request->input('subject');

        $sendMail = Mail::raw($request->input('message'), function($message) use($email, $admin_email, $subject) {
            $message->to($email, 'Ecommerce')
                    ->subject($subject);
            $message->from($admin_email, 'Ecommerce | Administrator');
        });

        return back()->with('success', 'Your message sent successfully.');
    }

   

}
