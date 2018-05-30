<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Product::whereNull('deleted_at')
                            ->get();
        $categories = Category::whereNull('deleted_at')
                            ->get();
        return view('shop.index', ['products' => $products, 'categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function customerRegister()
    {
        return view('shop.register');
    }

    public function customerSignup(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'contact' => 'required|string|min:10',
        ]);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'contact_no' => $request['contact'],
            'role_id' => 2,
        ]);

        return redirect()->route('shop.index');
    }   

    public function customerLogin()
    {
        return view('shop.signin');
    }

    public function customerSignin(Request $request) 
    {
        $this->validate($request,[
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        if(Auth::attempt([
                'email' => $request['email'],
                'password' => $request['password']
            ])) {
            return redirect()->route('shop.index');
        }
        return redirect()->back();
    }

    public function customerLogout() {
        Auth::logout();
        return redirect()->route('shop.index');
    }
}
