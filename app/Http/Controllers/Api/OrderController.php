<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::transaction();
        try {
            $carts = Cart::where('user_id', Auth::user()->id)->get();

            $records = [];

            foreach ($carts as $row) {
                $record = [
                    'food_id' => $row->food_id,
                    'quantity' => $row->quantity,
                    'price' => $row->price,
                    'user_id' => Auth::user()->id,
                ];

                $records[] = $record;
            }

            OrderDetail::insert($records);

            $code = 'AFD-'.str_replace('.','-', microtime(true));

            $order = Order::create([
                'transaction_code' => $code,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'status' => $request->status
            ]);

            Cart::where('user_id', Auth::user()->id)->delete();
            DB::commit();

            return $this->sendResponse($order, 'Created Order Success');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Failed to create order'. $e->getMessage(), 505);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $code)
    {
        $order = Order::where('transaction_code', $code)->get();
        $data = OrderResource::collection($order);
        return $this->sendResponse($data, 'Get Order Success');
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
        //
    }
}
