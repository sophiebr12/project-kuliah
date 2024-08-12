<?php

namespace App\Models;

use App\Models\Bobot;
use App\Models\Supplier;
use App\Models\SupplierItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hasil extends Model
{
    use HasFactory;

    protected $fillable = [
        "bobot_id",
        // "supplier_id",
        "supplier_item_id",
        "harga",
        "lead_time",
        "grade",
        "pembayaran",
        "score",
    ];

    protected $guarded = [
        "id"
    ];

    public function Bobot()
    {
        return $this->belongsTo(Bobot::class);
    }

    public function SupplierItem()
    {
        return $this->belongsTo(SupplierItem::class);
    }

    public function Supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
