<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Order",
 *     type="object",
 *     required={"id_order", "id_customer", "date", "status"},
 *     @OA\Property(property="id_order", type="integer", example=1),
 *     @OA\Property(property="id_customer", type="integer", example=2),
 *     @OA\Property(property="date", type="string", format="date-time", example="2024-02-09T14:30:00Z"),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         enum={"pending", "completed", "cancelled"},
 *         example="pending",
 *         description="Order status (default: pending)"
 *     )
 * )
 */
class Order extends Model
{
    use SOftDeletes;

    protected $table = 'orders';
    protected $primaryKey = 'id_order';
    public $incrementing = true;
    protected $fillable = ['id_order', 'id_customer', 'date', 'status'];
    protected $dates = ['deleted_at'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class, 'id_order');
    }
}
