<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(2);
        return view('admin.categories.indexCategories', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create Category";
        return view('admin.categories.formCategories', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3'
        ]);

        $imageIcon = null;

        if ($request->hasFile('icon') && $request->file('icon')->isValid()) {
            $imageIcon = time() . '.' . $request->file('icon')->extension();
            $request->file('icon')->storeAs('categories', $imageIcon, 'public');
            // Storage::url('categories/' . $imageIcon);
        }

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'icon' => $imageIcon
        ]);

        return redirect()->back()->with('success', 'Category Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $title = 'Edit Category ' . $category->name;
        return view('admin.categories.editCategories', compact('title', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|min:3'
        ]);

        $imageIcon = null;

        if ($request->hasFile('icon') && $request->file('icon')->isValid()) {
            $imageIcon = time() . '.' . $request->file('icon')->extension();
            $request->file('icon')->storeAs('categories', $imageIcon, 'public');

            $path = storage_path('app/public/categories/' . $category->icon);

            if (File::exists($path)) {
                File::delete($path);
            }

            $category->icon = $imageIcon;
        }


        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->update();
        return redirect()->back()->with('success', 'Category Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $path = storage_path('app/public/categories/'.$category->icon);
            if (File::exists($path)) {
                File::delete($path);
            }
            $category->deleteOrFail();

            return redirect()->back()->with('success', 'Category deleted!');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
