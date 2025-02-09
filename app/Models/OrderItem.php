<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="OrderItem",
 *     type="object",
 *     required={"id_order_item", "id_order", "id_product", "quantity", "price"},
 *     @OA\Property(property="id_order_item", type="integer", example=1),
 *     @OA\Property(property="id_order", type="integer", example=10),
 *     @OA\Property(property="id_product", type="integer", example=5),
 *     @OA\Property(property="quantity", type="integer", example=3),
 *     @OA\Property(property="price", type="bigint", example=15000000),
 * )
 */
class OrderItem extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'id_order_item';
    public $incrementing = true;
    protected $fillable = ['id_order_item', 'id_order', 'id_product', 'quantity', 'price'];

    public function order()
    {
        return $this->belongTo(Order::class, 'id_order');
    }

    public function product()
    {
        return $this->belongTo(Product::class, 'id_product');
    }
}
