<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use Auth;
use DB;
use App\Product;
use Mail;
use App\User;

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
            //get rejected order
            $rejected = Transaction::where('status', "Rejected")
                                ->get();

    		$orderlists = DB::table('orderlist')
                                ->select(DB::raw(
                                            'orderlist.transaction_id, orderlist.quantity, products.name,
                                            products.price, products.image, products.id as pid'
                                        ))
                                ->join('products', 'orderlist.product_id','=','products.id')
                                ->get();

    		return view('orders.orders',[
    									'allorders' => $allorders, 'counterorder' => $countorders,
    									'deliveries' => $delivery, 'counterdelivery' => $countdelivery,
    									'completed' => $completed,
    									'cancelled' => $cancelled, 'countercancelled' => $countcancelled,
                                        'rejected' => $rejected,
    									'orderlists' => $orderlists,
    									]);
    		
    	}

    }

    public function processOrder($id) { // update status to Processed

        $getOrderedProduct = DB::table('orderlist')
                            ->where('transaction_id', $id)
                            ->get();

        foreach($getOrderedProduct as $ordered) { // loop get orders of order # ?
            
            $getProduct = Product::find($ordered->product_id); // get product

                if ($getProduct->stock != 0) { // check if product stock is not 0
                    
                    if ($ordered->quantity <= $getProduct->stock) {

                        //deduct the quantity to stock
                        $deductedStock = $getProduct->stock - $ordered->quantity;

                        $updateStock = Product::where('id', $ordered->product_id)
                                            ->update([
                                                'stock' => $deductedStock
                                            ]);


                    }
                    else {
                        return back()->with('errors','Product stock is insufficient for the ordered product.');
                    }

                }
                else {
                    return back()->with('errors','Product stock is out of stock.');
                }

        }

        $updateOrderStatus = Transaction::where('id', $id)
                                ->update([
                                    'status' => "Processed"
                                ]);

        if ($updateOrderStatus) {

            $transaction = Transaction::find($id);
            $userId = $transaction->user_id;

            $user = User::find($userId);
            $email = $user->email;

            $admin_email = Auth::user()->email;
            $sendmessage = "Your Order #".$id." is successfully processed and it is ready for shipped.";

            Mail::raw($sendmessage, function($message) use($email, $admin_email) {
                $message->to($email, 'Ecommerce')
                        ->subject('Ecommerce | Logic8 Business Solution Corporation');
                $message->from($admin_email, 'Ecommerce | Administrator');
            });

            return back()->with('success',"Order #$id is successfully processed.");     
        } 

    }

    public function deliverOrder($id) {

    	//update the status of order
		$updateStatus = Transaction::where('id', $id)
								->update([
									'status' => "Completed"
								]);
        if ($updateStatus) {
            return back()->with('success',"Order #$id is successfully delivered.");
        }
        
    }

    public function rejectOrder($id) {
        $updateReject = Transaction::where('id', $id)
                                ->update([
                                    'status' => "Rejected"
                                ]);
        if ($updateReject) {

            $transaction = Transaction::find($id);
            $userId = $transaction->user_id;

            $user = User::find($userId);
            $email = $user->email;

            $admin_email = Auth::user()->email;

            Mail::raw('You order has been rejected.', function($message) use($email, $admin_email) {
                $message->to($email, 'Ecommerce')
                        ->subject('Ecommerce | Logic8 Business Solution Corporation');
                $message->from($admin_email, 'Ecommerce | Administrator');
            });

            return back()->with('success',"Order #$id is successfully rejected.");
        } 
    }

    public function notifyOutOfStock($pid, $oid) // product id, order no
    {
        $getTransaction = Transaction::find($oid); // get transaction
        $getProduct = Product::find($pid); //get product

        $prodName = $getProduct->name;
        $email = $getTransaction->user->email;

        $admin_email = Auth::user()->email;

        $sendmessage = "Order #".$oid." | "."Product name :".$prodName." is out of stock. We will notify you if the have an stock. ASAP!";

        $sendMail = Mail::raw($sendmessage, function($message) use($email, $admin_email) {
            $message->to($email, 'Ecommerce')
                    ->subject('Ecommerce | Logic8 Business Solution Corporation');
            $message->from($admin_email, 'Ecommerce | Administrator');
        }); 

        return back()->with('success',"Notification successfully sent.");

    }

    public function sendEmail() {
        $email = "kenneth.ferrerskie30@gmail.com";
        $anything = "hello";
        $text = "Hi";

        Mail::raw($text, function($message) use($email, $anything) {
            $message->to($email, 'Test')
                    ->subject('Ecommerce | Logic8 Business Solution Corporation');
            $message->from('johnkenneth3010@gmail.com', 'John Kenneth Ferrer');
        });
        echo "Email sent";
    }
}
