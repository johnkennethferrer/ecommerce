<?php

namespace App\Http\Controllers;

use App\Product;
use App\Cart;
use Illuminate\Http\Request;
use App\Category;
use Auth;
use DB;
use Session;

class ProductsController extends Controller
{   
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
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

        $trashProduct = DB::table('products')
                            ->whereNotNull('deleted_at')
                            ->get();

        return view('products.index', ['products' => $products, 'categories' => $categories, 'trashedProduct' => $trashProduct]);
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
        if ($request->hasFile('image')) {
                
            $filename = $request->file('image')->getClientOriginalName(); // get the original name
            $path = $request->file('image')->storeAs('public', $filename); // store the new image to the store/public

                if ($path) {
                    $insertProduct = Product::create([
                                        'user_id' => Auth::user()->id,
                                        'name' => $request['name'],
                                        'description' => $request['description'],
                                        'stock' => $request['stock'],
                                        'price' => $request['price'],
                                        'category_id' => $request['category'],
                                        'image' => $filename,
                                    ]);

                    if ($insertProduct) {
                        return back()->with('success','Product added successfully');
                    }
                    return back()->with('errors','Error adding product');

                }

        }
        else
        {
            return "No file selected.";
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
        $findProduct = Product::find($product->id);

        $selectCategory = Category::where('id', "!=", $findProduct->category_id)
                                ->get();
        return view('products.edit', ['product' => $findProduct, 'categories' => $selectCategory]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        $updateProduct = Product::where('id',$product->id)
                                ->update([
                                    'name' => $request['name'],
                                    'category_id' => $request['category'],
                                    'price' => $request['price'],
                                    'stock' => $request['stock'],
                                    'description' => $request['description']
                                ]);
        if ($updateProduct) {
            return back()->with('success','Product updated successfully.');
        }
        return back()->with('errors','Error updating product.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        if (Product::find($product->id)->delete()) {
            return back()->with('success','Product deleted successfully.');
        }
        return back()->with('errors','Error deleting product.');

    }

    public function updateImage(Request $request)
    {
        if ($request->hasFile('uploadImage')) { // if not empty the post file

                $productId = $request->input('productId'); // get the id of employee
                $getImage = Product::find($productId); // get the data of employee

                $imageName = $getImage->image; // get the avatar name

                    if ($imageName == null) { // if null the avatar column on db / no existing image

                        $filename = $request->file('uploadImage')->getClientOriginalName(); // get the orignal name of image
                        $path = $request->file('uploadImage')->storeAs('public', $filename); // store the image to store/app/public

                            if ($path) { // if success of storing the image to directory
                                $fileSave = Product::where('id', $productId) // save the name of image to the database
                                                ->update([
                                                    'image' => $filename
                                                ]);

                                if ($fileSave) { // if success of saving to the database
                                    return back()->with('success' , 'Product image updated successfully');
                                }

                                return back()->withInput()->with('errors', 'Error update product image (Saving the image name to the database)'); // else not success of saving
                            }

                            return back()->withInput()->with('errors', 'Error update product image (Storing the image to the directory)'); // else not success of storing to directory

                    } else { // if not null the avatar column on db / and has a existing image
                            
                        if (Storage::delete('public/'.$imageName)) { // delete the existing image in the store folder

                            $filename = $request->file('uploadImage')->getClientOriginalName(); // get the original name
                            $path = $request->file('uploadImage')->storeAs('public', $filename); // store the new image to the store/public

                                if ($path) { // if success of storing the directory
                                    $fileSave = Product::where('id', $productId) // update to the database the new name db
                                                ->update([
                                                    'image' => $filename
                                                ]);

                                    if ($fileSave) { // if success of updating new name in db
                                        return back()->with('success' , 'Product image updated successfully');
                                    }

                                    return back()->withInput()->with('errors', 'Error update product image (Saving the image name to the database)'); // else failed updating to db
                                }

                                return back()->withInput()->with('errors', 'Error update product image (Storing the new image to the directory)'); // failed to storing to directory
                        }

                        return back()->withInput()->with('errors', 'Error update product image (Deleting the existing image to the directory)'); // failed to delete existing image to directory
                    }

                
            } else {
               return "No file selected"; // if no file selected
            }
    }

    public function getAddToCart(Request $request, $id) {
        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);

        $request->session()->put('cart', $cart);
        return redirect()->route('shop.index');

    }

    public function getCart() {
        if (!Session::has('cart')) {
            return view('shop.shopping-cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('shop.shopping-cart', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice]);
    }
}
