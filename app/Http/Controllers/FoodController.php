<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Food;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $foods = Food::when($request->search, function($query) use($request){
            $query->where('name', 'like', '%'.$request->search.'%');
        })->with('category')->paginate(2)->appends(['search' => $request->search]);
        // dd($foods);
        return view('admin.food.indexFood', compact('foods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create Food";
        $categories = Category::all();
        return view('admin.food.formFood', compact('title', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3'
        ]);

        $imageFood = null;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageFood = time() . '.' . $request->file('image')->extension();
            $request->file('image')->storeAs('foods', $imageFood, 'public');
            // Storage::url('categories/' . $imageIcon);
        }
        Food::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => str_replace('.','', $request->price),
            'description' => $request->description,
            'image' => $imageFood,
            'category_id' => $request->category,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->back()->with('success', 'Food Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Food $food)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Food $food)
    {
        $title = 'Edit Food ' . $food->name;
        $categories = Category::all();
        return view('admin.food.editFood', compact('title', 'categories', 'food'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Food $food)
    {
        $request->validate([
            'name' => 'required|min:3'
        ]);
        $imageFood = null;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageFood = time() . '.' . $request->file('image')->extension();
            $request->file('image')->storeAs('foods', $imageFood, 'public');

            $path = storage_path('app/public/foods/' . $food->icon);

            if (File::exists($path)) {
                File::delete($path);
            }

            $food->image = $imageFood;
        }


        $food->name = $request->name;
        $food->slug = Str::slug($request->name);
        $food->price = str_replace('.','', $request->price);
        $food->description = $request->description;
        $food->category_id = $request->category;
        $food->user_id = Auth::user()->id;
        $food->update();
        return redirect()->back()->with('success', 'Food Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Food $food)
    {
        try {
            $path = public_path('app/public/foods/'.$food->image);

            if (File::exists($path)) {
                File::delete($path);
            }
            $food->deleteOrFail();

            return redirect()->back()->with('success', 'Food deleted!');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
