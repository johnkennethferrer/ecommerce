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
        $categories = Category::whereNull('deleted_at')
                            ->get();
        return view('categories.index', ['categories' => $categories]);
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
        $findCategory = Category::find($category->id);
        return view('categories.edit', ['category' => $category]);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
        $findCategory = Category::find($category->id);

        if ($findCategory->delete()) {
            return back()->with('success' , 'Category deleted successfully');
        }
        return back()->withInput()->with('errors', 'Error deleting category');
    }
}
