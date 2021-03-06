<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Cart;
use Session;
use App\Orderlist;
use App\Transaction;
use DB;
use Carbon\Carbon;
use Mail;

class ShopController extends Controller
{

    public function index()
    {
        //
        $products = Product::whereNull('deleted_at')
                            ->orderBy('id', 'desc')
                            ->paginate(6);
        $categories = Category::whereNull('deleted_at')
                            ->orderBy('name', 'asc')
                            ->get();
        return view('shop.index', ['products' => $products, 'categories' => $categories]);
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
            'address' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'contact_no' => $request['contact'],
            'address' => $request['address'],
            'role_id' => 2,
        ]);

        $customerlastinsertId = DB::getPdo()->lastInsertId();

        $email = $request['email'];
        $anything = "Verifaction Code";
        $text = "Click the link to verify your account ( http://127.0.0.1:8000/user/verifyaccount/$customerlastinsertId ).";

        Mail::raw($text, function($message) use($email, $anything) {
            $message->to($email, $anything)
                    ->subject('Ecommerce | Logic8 Business Solution Corporation');
            $message->from('johnkenneth3010@gmail.com', 'Ecommerce | Administrator');
        });

        
        return view('shop.verifyyouraccount');
    } 

    public function verifyAccount($id)
    {  
        $verified = User::find($id);
        $verified->status = "1";
        $verified->save();

        if ($verified) {
            $user = User::find($id);
            Auth::login($user);
            return redirect()->route('shop.index');
        }
        return "failed";
        
    } 

    public function indicatorVerify()
    {
        return view('shop.indicatorverify'); 
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

    public function getAddToCart(Request $request, $id) {
        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);

        $request->session()->put('cart', $cart);
        //return redirect()->route('shop.index');
        return back();

    }

    public function getAddByOne($id) {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->addByOne($id);

        Session::put('cart', $cart);
        return redirect()->route('product.shoppingCart');

    }

    public function getReduceByOne($id) {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->reduceByOne($id);

        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        }
        else {
            Session::forget('cart');
        }
        
        return redirect()->route('product.shoppingCart');

    }

    public function getRemoveItem($id) {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);

        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        }
        else {
            Session::forget('cart');
        }

        return redirect()->route('product.shoppingCart');
    }

    public function getCart() {
        if (!Session::has('cart')) {
            return view('shop.shopping-cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('shop.shopping-cart', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice, 'totalQty' => $cart->totalQty]);
    }

    public function getCheckout() {
        if (!Session::has('cart')) {
            return view('shop.shopping-cart');
        }
        
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $total = $cart->totalPrice;
        //dd($cart->items);
        return view('shop.checkout', ['carts' => $cart->items, 'total' => $total]);
    }

    public function saveOrder(Request $request) {

        $now = Carbon::now('Asia/Manila');
        $datetime = $now->toDateTimeString();
        $date = $now->toDateString();
        $time = $now->toTimeString();

        if (!Session::has('cart')) {
            return view('shop.shopping-cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        $saveTransaction = DB::table('transactions')->insert([
                                        'user_id' => Auth::user()->id,
                                        'status' => 'Pending',
                                        'total_amount' => $cart->totalPrice,
                                        'created_at' => $datetime
                                    ]);

        // Transaction::create([
        //         'user_id' => Auth::user()->id,
        //         'status' => 'Pending',
        //         'total_amount' => $cart->totalPrice,
        //         'created_at' => $datetime
        //     ]);
        // $lastinsertId = $saveTransaction->id;
        $lastinsertId = DB::getPdo()->lastInsertId();

        if ($saveTransaction) {
            $data = [];

            foreach ($cart->items as $cart) {
                $data[] = [
                            'transaction_id' => $lastinsertId,
                            'product_id' => $cart['item']['id'],
                            'quantity' => $cart['qty'],  
                            ];
            }

            $saveOrderProduct = DB::table('orderlist')->insert($data);

            if ($saveOrderProduct) {

                $transaction = Transaction::find($lastinsertId);
                $orders = DB::table('orderlist')
                                ->select(DB::raw(
                                            'orderlist.quantity, products.name,
                                            products.price, products.image'
                                        ))
                                ->join('products', 'orderlist.product_id','=','products.id')
                                ->where('transaction_id', $lastinsertId)
                                ->get();

                $transaction = Transaction::find($lastinsertId);
                $userId = $transaction->user_id;

                $user = User::find($userId);
                $email = $user->email;

                $admin_email = Auth::user()->email;
                $sendmessage = "Your Order #".$lastinsertId." is successfully placed. Wait for another notication for your order. Thank you";

                Mail::raw($sendmessage, function($message) use($email, $admin_email) {
                    $message->to($email, 'Ecommerce')
                            ->subject('Ecommerce | Logic8 Business Solution Corporation');
                    $message->from($admin_email, 'Ecommerce | Administrator');
                });

                Session::forget('cart');
                return view('shop.order-success',['transaction' => $transaction, 'orders' => $orders]);
            }

            return "Failed";

        } 

    } 

    public function customerProfile() {
        $profile = User::find(Auth::user()->id);

        return view('shop.profile', ['profile' => $profile]);
    }

    public function updateProfile(Request $request) 
    {
        $updateProfile = User::where('id',$request->input('id'))
                            ->update([
                                'name' => $request->input('name'),
                                'contact_no' => $request->input('contact'),
                                'address' => $request->input('address')
                            ]);
        if ($updateProfile) {
            return back()->with('success', 'Profile successfully updated.');
        }
        return back()->with('errors', 'Failed updating profile.');
    }

    public function customerOrders() {

        $orderTransaction = Transaction::where('user_id', Auth::user()->id)
                                        ->get();
        $orderCount = Transaction::where('user_id', Auth::user()->id)
                                        ->count();
        return view('shop.my-orders', ['transactions' => $orderTransaction, 'ordercount' => $orderCount]);

    }

    public function cancelOrder(Request $request) {
        $cancelOrder = Transaction::where('id', $request->input('id'))
                                ->update([
                                    'status' => "Cancelled"
                                ]);
        if ($cancelOrder) {
            return back()->with('success',"You cancelled an order successfully.");
        } 
    }

    public function viewOrderList($id) {
        $transaction = Transaction::find($id);
        $orderlist = DB::table('orderlist')
                        ->select(DB::raw(
                                    'orderlist.quantity, products.name,
                                    products.price, products.image'
                                ))
                        ->join('products', 'orderlist.product_id','=','products.id')
                        ->where('transaction_id', $id)
                        ->get();
        return view('shop.orderlist', ['transaction' => $transaction, 'orderlists' => $orderlist]);
    }

    public function filterByCategory($id) {

        $getProductbyCategory = Product::where('category_id', $id)
                                            ->whereNull('deleted_at')
                                            ->orderBy('id', 'desc')
                                            ->paginate(6);

        $getCategory = Category::where('id', $id)
                                ->get()
                                ->first();

        $categories = Category::whereNull('deleted_at')
                            ->orderBy('name', 'asc')
                            ->get();

        return view('shop.category', ['products' => $getProductbyCategory, 'categories' => $categories, 'categoryname' => $getCategory->name]);
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
            $user->password = Hash::make($request['password']);
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
