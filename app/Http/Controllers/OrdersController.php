<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use Auth;
use DB;
use App\Product;
use Mail;

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
    									'deliveries' => $delivery, 'counterdelivery' => $countdelivery,
    									'completed' => $completed,
    									'cancelled' => $cancelled, 'countercancelled' => $countcancelled,
    									'orderlists' => $orderlists,
    									]);
    		
    	}

    }

    public function processOrder($id) { // update status to Processed
    	
    	$updateOrderStatus = Transaction::where('id', $id)
    							->update([
    								'status' => "Processed"
    							]);

    	if ($updateOrderStatus) {
    		return back()->with('success',"Order #$id is successfully processed."); 	
    	} 

    }

    public function deliverOrder($id) {

    	$getOrderedProduct = DB::table('orderlist')
    						->where('transaction_id', $id)
    						->get();

    	foreach($getOrderedProduct as $ordered) { // loop get orders of order # ?
    		
    		$getProduct = Product::find($ordered->product_id); // get product

    			if ($getProduct->stock != 0) { // check if product stock is not 0
    				
    				if ($ordered->quantity < $getProduct->stock) { // if stock is sufficient to order (Success)
    					
    					//deduct the quantity to stock
    					$deductedStock = $getProduct->stock - $ordered->quantity;

    					$updateStock = Product::where('id', $ordered->product_id)
    										->update([
    											'stock' => $deductedStock
    										]);

    				}
    				else { // if stock is insufficient to the order return message can't process this order

    					return back()->with('errors','Product stock is insufficient for the ordered product.');

    				}

    			} 
    			else { // if product is 0 return message can't process this order

    				return back()->with('errors','Product stock is out of stock.');

    			}
    	} //end of foreach

    	//SUCCESS
    	//update the status of order
		$updateStatus = Transaction::where('id', $id)
								->update([
									'status' => "Completed"
								]);
		return back()->with('success','Order is successfully deliver.');
    }

    public function sendEmail() {
        $data = array("name" => "John Doe", "body" => "Test mail");

        Mail::send('orders.sent', $data, function($message) {
            $message->to('kenneth.ferrerskie30@gmail.com', 'Test')
                    ->subject('Logic8 Web Testing Mail');
            $message->from('johnkenneth3010@gmail.com', 'John Kenneth Ferrer');
        });
        echo "Email sent";
    }
}
