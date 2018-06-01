<?php

namespace App\Http\Controllers;

use App\Product;
use App\Cart;
use Illuminate\Http\Request;
use App\Category;
use Auth;
use DB;
use Session;
use Carbon\Carbon;
use Excel;
use Response;
use App\ExcelImport;

class ProductsController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (Auth::user()->role_id == 1) {
            $products = Product::whereNull('deleted_at')
                                ->get();

            $categories = Category::whereNull('deleted_at')
                                ->get();

            $trashProduct = DB::table('products')
                                ->whereNotNull('deleted_at')
                                ->get();

            $counterorder = DB::table('transactions')
                            ->where('status', "Pending")
                            ->count();

            $criticalProduct = DB::table('products')
                                    ->where('stock','<=',119)
                                    ->get();
            $countCritical = DB::table('products')
                                    ->where('stock','<=',10)
                                    ->count();

            return view('products.index', ['products' => $products, 'categories' => $categories,
                                            'trashedProduct' => $trashProduct, 'counterorder' => $counterorder,
                                            'critical' => $criticalProduct, 'countcritical' => $countCritical]);
        }
        return back();
    }

    public function store(Request $request)
    {
        //
        if (Auth::user()->role_id == 1) {

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
                $insertProduct = Product::create([
                                    'user_id' => Auth::user()->id,
                                    'name' => $request['name'],
                                    'description' => $request['description'],
                                    'stock' => $request['stock'],
                                    'price' => $request['price'],
                                    'category_id' => $request['category'],
                                ]);

                if ($insertProduct) {
                    return back()->with('success','Product added successfully');
                }
                return back()->with('errors','Error adding product');
            }

        }
        return back();
        
    }

    public function edit(Product $product)
    {
        //
        if (Auth::user()->role_id == 1) {

            $findProduct = Product::find($product->id);

            $selectCategory = Category::where('id', "!=", $findProduct->category_id)
                                    ->get();

            $counterorder = DB::table('transactions')
                            ->where('status', "Pending")
                            ->count();

            return view('products.edit', ['product' => $findProduct, 'categories' => $selectCategory,
                                            'counterorder' => $counterorder]); 
        }
        return back(); 
    }

    public function update(Request $request, Product $product)
    {
        //
        if (Auth::user()->role_id == 1) {
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
        return back(); 
    }

    public function destroy(Product $product)
    {
        //
        if (Auth::user()->role_id == 1) {
            if (Product::find($product->id)->delete()) {
                return back()->with('success','Product deleted successfully.');
            }
            return back()->with('errors','Error deleting product.');
        }
        return back(); 

    }

    public function updateImage(Request $request)
    {
        if (Auth::user()->role_id == 1) {

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
        return back(); 
           
    }

    public function exportProduct() 
    {          

        $now = Carbon::now('Asia/Manila');
        $datetime = $now->toDateTimeString();
        $date = $now->toDateString();
        $time = $now->toTimeString();

        $headers = array(
            "Content-type" => "text/xlsx",
            "Content-Disposition" => "attachment; filename=Employees".$datetime.".xlsx",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $products = Product::whereNull('deleted_at')
                            ->get();
        
        $columns = array('ID','Product name', 'Price', 'Stock', 'Category', 'Description');

        $callback = function() use ($products, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($products as $product) {

                fputcsv($file, array($product->id, $product->name, $product->price, $product->stock, $product->category->name, $product->description));
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
    }

    public function importExcelfile(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            
            if ($request->hasFile('excel_file')) { // if not empty the post
                $path = $request->file('excel_file')->getRealPath(); // get the path of file
                $data = array_map('str_getcsv', file($path));

                if (count($data) > 0) { // if not empty the data
                    $excel_data = array_slice($data,1); // slice data ($data,1) removed the first row

                    $excel_data_file = ExcelImport::create([ // store to the csv table db
                        'excel_file' => $request->file('excel_file')->getClientOriginalName(), // get the original name of file
                        'excel_data' => json_encode($excel_data) // save the data in json 
                    ]);

                } else { // if empty return back
                    return redirect()->back();
                }

                $counterorder = DB::table('transactions')
                            ->where('status', "Pending")
                            ->count();

                return view('products.import_excel_fields', compact('excel_data', 'excel_data_file', 'counterorder'));
                    
            }
            return back()->with('errors', 'No file selected.');

        }
    }

    public function processExcelfile(Request $request)
    {
        if (Auth::user()->role_id == 1) {

            $data = DB::table('excel')
                        ->where('id', $request->excel_data_file_id) //get the details of 
                        ->get()
                        ->first();
            $excel_data = json_decode($data->excel_data, true); //decode the json data
                
                $loopdata = [];

                foreach ($excel_data as $product) { // loop the data

                    //select category id 
                    $selectCategoryId = DB::table('categories')
                                            ->select('id')
                                            ->where('name', $product[4])
                                            ->first();
                    $categoryId = $selectCategoryId->id;
                    
                    $loopdata[] = [
                                        'name' => $product[1],
                                        'price' => $product[2],
                                        'stock' => $product[3],
                                        'description' => $product[5],
                                        'category_id' => $categoryId,
                                        'user_id' => Auth::user()->id
                                    ];

                }

                $saveData = DB::table('products')->insert($loopdata);

                if ($saveData) { // if success
                    return redirect()->route('products.index')->with('success' , 'Import successfully.');
                }

                return redirect()->route('products.index')->with('errors', 'Import failed.');

        }

    }

    public function restoreProduct($id)
    {
        $productRestore = Product::where('id', $id)
                                ->restore();
        if ($productRestore) {
            return back()->with('success', 'Product restore successfully.');
        }
        return "Failed";
    }

    public function viewAddStock($id)
    {
        $getProduct = Product::find($id);

        return view('products.addstock', ['products' => $getProduct]);
    }

}
