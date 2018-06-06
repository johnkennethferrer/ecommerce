<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use App\User;
use Auth;
use Hash;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

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

    public function addAdmin()
    {
        return view('users.addadmin');
    }

    public function registerAdmin(Request $request)
    {
         $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'contact' => 'required|string|min:10',
        ]);

        $saveAdmin = User::create([
                        'name' => $request->input('name'),
                        'email' => $request->input('email'),
                        'contact_no' => $request->input('contact'),
                        'password' => Hash::make($request['password']), 
                        'role_id' => 1
                    ]);

        if ($saveAdmin) {
            return back()->with('success', 'Successfully added a administrator.');
        }
    }

    public function myProfile()
    {
        return view('users.myprofile');
    }

    public function editMyProfile(Request $request)
    {
        $updateProfile = User::where('id', $request->input('id'))
                                ->update([
                                    'name' => $request->input('name'),
                                    'contact_no' => $request->input('contact')
                                ]);

        if ($updateProfile) {
            return back()->with('success','Successfully update profile.');
        }
    }

    public function changePassword(Request $request)
    {
        $this->validate($request,[
            'current-password' => 'required|string',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $message1 = [
                'current-password' => 'Wrong password entered.'
            ];

        $message2 = [
                'password' => 'Failed to update.'
            ];

        $currentpassword = Auth::user()->password;
        if (Hash::check($request['current-password'], $currentpassword)) {
            
            $userId = Auth::user()->id;
            $user = User::find($userId);
            $user->password = Hash::make($request['password']);;
            $user->save();

            if ($user) {
                return back()->with('success', 'Password updated successfully.');
            }
            return Redirect()->back()->withErrors($message2)->withInput();

        }
        else {
            return Redirect()->back()->withErrors($message1)->withInput();
        }
    }
}
