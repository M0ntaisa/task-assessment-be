<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Customer",
 *     type="object",
 *     title="Customer",
 *     description="Customer model schema",
 *     @OA\Property(property="id_customer", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
 *     @OA\Property(property="phone", type="string", example="+62123456789"),
 *     @OA\Property(property="address", type="text", example="123 Main Street, Makassar"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-02-09T12:34:56Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-02-09T12:34:56Z"),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true, example=null)
 * )
 */

class Customer extends Model
{
    use SoftDeletes;

    protected $table = 'customers';
    protected $primaryKey = 'id_customer';
    public $incrementing = true;
    protected $fillable = ['id_customer', 'name', 'email', 'phone', 'address'];
    protected $dates = ['deleted_at'];

    public function order()
    {
        return $this->hasMany(Order::class, 'id_customer');
    }
}
