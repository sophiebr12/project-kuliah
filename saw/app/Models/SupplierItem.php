<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierItem extends Model
{
    use HasFactory;

    protected $fillable = [
        "item_id",
        "supplier_id",
        "harga",
    ];

    protected $guarded = [
        "id"
    ];

    public function Supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function Item()
    {
        return $this->belongsTo(Item::class);
    }
}
