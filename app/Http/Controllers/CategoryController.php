<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryCreateRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->view('category.index', [
            'categories' => Category::orderBy('updated_at', 'desc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryCreateRequest $request)
    {
        $created = Category::create(['name' => $request->name, 'description' => $request->description, 'user_id' => auth()->user()->id]);

        if ($created) { // inserted success
            return redirect()->route('category.index')
                ->withSuccess('created successfully...!');
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'fails not created..!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryCreateRequest $request, Category $category)
    {
        $category->update($request->all());

        return redirect()->route('category.index')
            ->withSuccess('Updated Successfully...!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('category.index')
            ->withSuccess('Deleted Successfully.');
    }
}
