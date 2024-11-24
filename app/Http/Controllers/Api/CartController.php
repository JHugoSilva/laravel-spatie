<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        $data = CartResource::collection($cart);
        return $this->sendResponse($data, 'Get Menu Success');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'food_id' => 'required',
        ]);

        $cart = Cart::updateOrCreate(
            [
                'food_id' => $request->food_id,
                'user_id' => Auth::user()->id
            ],
            [
                'quantity' => DB::raw('quantity + '.$request->quantity),
                'price' => $request->price
            ]
        );

        return $this->sendResponse(null, 'Save Menu Success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cart = Cart::find($id);
        if ($cart) $cart->delete();
        return $this->sendResponse(null, 'Delete Menu Success', 200);
    }
}
