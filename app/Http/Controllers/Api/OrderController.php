<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderItemResource;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Orders",
 *     description="API Endpoints for Managing Orders"
 * )
 */
class OrderController extends Controller
{
   /**
     * @OA\Get(
     *     path="/api/orders",
     *     summary="Get all orders",
     *     tags={"Orders"},
     *     @OA\Response(
     *         response=200,
     *         description="List of orders",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Orders get successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id_order", type="integer", example=35),
     *                     @OA\Property(property="id_customer", type="integer", example=3),
     *                     @OA\Property(property="date", type="string", format="date", example="2025-02-07"),
     *                     @OA\Property(property="status", type="string", example="pending"),
     *                     @OA\Property(
     *                         property="order_item",
     *                         type="array",
     *                         @OA\Items(
     *                             type="object",
     *                             @OA\Property(property="id_order_item", type="integer", example=64),
     *                             @OA\Property(property="id_order", type="integer", example=35),
     *                             @OA\Property(property="id_product", type="integer", example=2),
     *                             @OA\Property(property="quantity", type="integer", example=2),
     *                             @OA\Property(property="price", type="integer", example=50000000),
     *                             @OA\Property(property="created_at", type="string", format="date-time", example="2025-02-09T06:47:58.000000Z"),
     *                             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-09T06:47:58.000000Z")
     *                         )
     *                     ),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-02-09T06:47:58.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-09T06:47:58.000000Z")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $orders = Order::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Orders get successfully',
            'data' => OrderResource::collection($orders)
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/orders",
     *     summary="Create a new order",
     *     tags={"Orders"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"id_customer", "date", "status", "order_items"},
     *             @OA\Property(property="id_customer", type="integer", example=3),
     *             @OA\Property(property="date", type="string", format="date", example="2025-02-07"),
     *             @OA\Property(property="status", type="string", enum={"pending", "completed", "cancelled"}, example="pending"),
     *             @OA\Property(
     *                 property="order_items",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     required={"id_product", "quantity", "price"},
     *                     @OA\Property(property="id_product", type="integer", example=2),
     *                     @OA\Property(property="quantity", type="integer", example=2),
     *                     @OA\Property(property="price", type="number", format="float", example=50000000)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Order created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Order created successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="order",
     *                     type="object",
     *                     @OA\Property(property="id_order", type="integer", example=38),
     *                     @OA\Property(property="id_customer", type="integer", example=3),
     *                     @OA\Property(property="date", type="string", format="date", example="2025-02-07"),
     *                     @OA\Property(property="status", type="string", example="pending"),
     *                     @OA\Property(
     *                         property="order_item",
     *                         type="array",
     *                         @OA\Items(
     *                             type="object",
     *                             @OA\Property(property="id_order_item", type="integer", example=70),
     *                             @OA\Property(property="id_order", type="integer", example=38),
     *                             @OA\Property(property="id_product", type="integer", example=2),
     *                             @OA\Property(property="quantity", type="integer", example=2),
     *                             @OA\Property(property="price", type="number", format="float", example=50000000),
     *                             @OA\Property(property="created_at", type="string", format="date-time", example="2025-02-09T12:24:22.000000Z"),
     *                             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-09T12:24:22.000000Z")
     *                         )
     *                     ),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-02-09T12:24:22.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-09T12:24:22.000000Z")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation failed",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Validation failed"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Something went wrong"),
     *             @OA\Property(property="error", type="string", example="Exception message")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_customer' => 'required|exists:customers,id_customer,deleted_at,NULL',
            'date' => 'required|date',
            'status' => 'required|in:pending,completed,cancelled',
            'order_items' => 'required|array|min:1',
            'order_items.*.id_product' => 'required|exists:products,id_product,deleted_at,NULL',
            'order_items.*.quantity' => 'required|integer|min:1',
            'order_items.*.price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        
        DB::beginTransaction();
        try {
            $order = Order::create([
                'id_customer' => $request->id_customer,
                'date' => $request->date,
                'status' => $request->status,
            ]);
    
            if (!$order) {
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to create order'
                ], 500);
            }
    
            foreach ($request->order_items as $item) {
                $orderItem = OrderItem::create([
                    'id_order' => $order->id_order,
                    'id_product' => $item['id_product'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
    
                if (!$orderItem) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Failed to create order item'
                    ], 500);
                }
    
            }
    
            DB::commit();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Order created successfully',
                'data' => [
                    'order' => new OrderResource($order)
                ]
            ], 201);
    
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/orders/{id_order}",
     *     summary="Get a specific order by ID",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="id_order",
     *         in="path",
     *         required=true,
     *         description="ID of the order",
     *         @OA\Schema(type="integer", example=37)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Order get successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id_order", type="integer", example=37),
     *                 @OA\Property(property="id_customer", type="integer", example=3),
     *                 @OA\Property(property="date", type="string", format="date", example="2025-02-07"),
     *                 @OA\Property(property="status", type="string", example="pending"),
     *                 @OA\Property(
     *                     property="order_item",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id_order_item", type="integer", example=68),
     *                         @OA\Property(property="id_order", type="integer", example=37),
     *                         @OA\Property(property="id_product", type="integer", example=2),
     *                         @OA\Property(property="quantity", type="integer", example=2),
     *                         @OA\Property(property="price", type="number", format="float", example=50000000),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2025-02-09T06:58:37.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-09T06:58:37.000000Z")
     *                     )
     *                 ),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-02-09T06:58:37.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-09T06:58:37.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Order not found")
     *         )
     *     )
     * )
     */
    public function show(Order $order)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Order get successfully',
            'data' => new OrderResource($order)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * @OA\Delete(
     *     path="/api/orders/{id_order}",
     *     summary="Delete an order",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="id_order",
     *         in="path",
     *         required=true,
     *         description="ID of the order to delete",
     *         @OA\Schema(type="integer", example=37)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Order deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Order not found")
     *         )
     *     )
     * )
     */
    public function destroy(Order $order)
    {
        $order->delete(); 
    
        return response()->json([
            'status' => 'success',
            'message' => 'Order deleted successfully'
        ], 200);
    }
}
