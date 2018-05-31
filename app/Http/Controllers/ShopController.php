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

        Auth::login($user);

        // if (Session::has('oldUrl')) {
        //     $oldUrl = Session::get('oldUrl');
        //     Session::forget('oldUrl');
        //     return redirect()->to($oldUrl);
        // }

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

    public function getAddToCart(Request $request, $id) {
        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);

        $request->session()->put('cart', $cart);
        return redirect()->route('shop.index');

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

            foreach ($cart->items as $cart) {
                
                $saveOrderProduct = DB::table('orderlist')->insert([
                                    'transaction_id' => $lastinsertId,
                                    'product_id' => $cart['item']['id'],
                                    'quantity' => $cart['qty'],
                                ]);
            }

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

                Session::forget('cart');
                return view('shop.order-success',['transaction' => $transaction, 'orders' => $orders]);
                //->with('success', 'Order successfully');
            }

            return "Failed";

        } 

    } 

    public function customerOrders() {

        $orderTransaction = Transaction::find(Auth::user()->id)
                                ->get();
        return view('shop.my-orders', ['transactions' => $orderTransaction]);

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

}
