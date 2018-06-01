<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Auth;
use DB;

class CategoriesController extends Controller
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

            $categories = Category::whereNull('deleted_at')
                            ->get();

            $counterorder = DB::table('transactions')
                            ->where('status', "Pending")
                            ->count();

            return view('categories.index', ['categories' => $categories, 'counterorder' => $counterorder]);
            
        }
        return back();
    }

    public function store(Request $request)
    {
        //
        if (Auth::user()->role_id == 1) {

            $category = Category::create([
                            'name' => $request['name'],
                            'description' => $request['description'],
                            'user_id' => Auth::user()->id,
                        ]);

            if ($category) {
                return back()->with('success','Category added successfully');
            }
            return back()->with('errors','Error adding category');

        }
        return back();

    }


    public function edit(Category $category)
    {
        //
        if (Auth::user()->role_id == 1) {
            $findCategory = Category::find($category->id);
            $counterorder = DB::table('transactions')
                            ->where('status', "Pending")
                            ->count();
            return view('categories.edit', ['category' => $category, 'counterorder' => $counterorder]);
        }
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
        if (Auth::user()->role_id == 1) {
            $updateCategory = Category::where('id', $category->id)
                            ->update([
                                'name' => $request['name'],
                                'description' => $request['description'],
                            ]);

            if ($updateCategory) {
                return back()->with('success','Category updated successfully');
            }
            return back()->with('errors','Error updating category');
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
        if (Auth::user()->role_id == 1) {
            $findCategory = Category::find($category->id);

            if ($findCategory->delete()) {
                return back()->with('success' , 'Category deleted successfully');
            }
            return back()->withInput()->with('errors', 'Error deleting category');
        }
        return back();
    }
}
