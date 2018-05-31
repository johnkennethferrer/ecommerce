<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use Auth;
use DB;
use App\Product;

class OrdersController extends Controller
{
    public function getIndex() {

    	if (Auth::user()->role_id == 1) {

    		//get orders pending
    		$allorders = Transaction::where('status', "Pending")
    							->get();
    		$countorders = DB::table('transactions')
    						->where('status', "Pending")
    						->count();
    		//get order for delivery
    		$delivery = Transaction::where('status', "Processed")
    							->get();
    		$countdelivery = DB::table('transactions')
    						->where('status', "Processed")
    						->count();
    		//get completed orders
    		$completed = Transaction::where('status', "Completed")
    							->get();
    		$countcompleted = DB::table('transactions')
    						->where('status', "Completed")
    						->count();
    		//get cancelled order
    		$cancelled = Transaction::where('status', "Cancelled")
    							->get();
    		$countcancelled = DB::table('transactions')
    						->where('status', "Cancelled")
    						->count();

    		$orderlists = DB::table('orderlist')
                                ->select(DB::raw(
                                            'orderlist.transaction_id, orderlist.quantity, products.name,
                                            products.price, products.image'
                                        ))
                                ->join('products', 'orderlist.product_id','=','products.id')
                                ->get();

    		return view('orders.orders',[
    									'allorders' => $allorders, 'counterorder' => $countorders,
    									'delivery' => $delivery, 'counterdelivery' => $countdelivery,
    									'completed' => $completed, 'countercompleted' => $countcompleted,
    									'cancelled' => $cancelled, 'countercancelled' => $countcancelled,
    									'orderlists' => $orderlists,
    									]);
    		
    	}

    }

    public function processOrder($id) {
    	
    	$getOrderedProduct = DB::table('orderlist')
    						->where('transaction_id', $id)
    						->get();

    	foreach($getOrderedProduct as $ordered) {
    		
    		$getProduct = Product::find($ordered->product_id); // get product

    			if ($getProduct->stock != 0) { // check if product stock is not 0
    				
    				if ($ordered->quantity < $getProduct) { // if stock is sufficient to order (Success)
    				
    					
    					
    				}
    				else { // if stock is insufficient to the order return message can't process this order

    				}
    			} 
    			else { // if product is 0 return message can't process this order

    			}
    		$deductedStock = $getProduct->stock - $ordered->quantity;
    		print_r($deductedStock." | ");
    	}
    }
}
