<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Product",
 *     required={"id_product", "name", "description", "price", "stock"},
 *     @OA\Property(property="id_product", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Laptop XYZ"),
 *     @OA\Property(property="description", type="string", example="A high-performance laptop with 16GB RAM and 512GB SSD"),
 *     @OA\Property(property="price", type="bigint", example=12999999),
 *     @OA\Property(property="stock", type="integer", example=50),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-02-09T12:34:56Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-02-10T14:20:30Z"),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true, example=null)
 * )
 */
class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';
    protected $primaryKey = 'id_product';
    public $incrementing = true;
    protected $fillable = ['id_product', 'name', 'description', 'price', 'stock'];
    protected $dates = ['deleted_at'];

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class, 'id_product');
    }
}
