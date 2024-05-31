<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;
use App\Http\Requests\StoreOrderRequest;
use App\Events\OrderPlaced;


class OrderController extends Controller
{


    public function index()
    {
        // Retrieves all orders and returns them as a collection of OrderResource
        return OrderResource::collection(Order::all());
    }

    public function store(StoreOrderRequest $request)
    {
        // Validates and creates a new order
        $order = Order::create($request->validated());
        
        // Fires an OrderPlaced event when a new order is created
        event(new OrderPlaced($order));
        
        // Returns the created order as an OrderResource with a 201 status code
        return new OrderResource($order);
    }

    public function show($id)
    {
        // Finds an order by its ID and returns it as an OrderResource
        return new OrderResource(Order::findOrFail($id));
    }

    public function update(StoreOrderRequest $request, $id)
    {
        // Finds an order by its ID, validates and updates it
        $order = Order::findOrFail($id);
        $order->update($request->validated());
        
        // Returns the updated order as an OrderResource
        return new OrderResource($order);
    }

    public function destroy($id)
    {
        // Finds an order by its ID and deletes it
        Order::findOrFail($id)->delete();
        
        // Returns a 204 No Content response
        return response()->json(null, 204);
    }
}

