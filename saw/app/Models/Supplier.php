<?php

namespace App\Models;

use App\Models\Hasil;
use App\Models\SupplierItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        "nama",
        "alamat",
        "no_telp",
        "email",
        "grade",
        "lead_time",
        "is_cash",
    ];

    protected $guarded = [
        "id"
    ];

    public function SupplierItem()
    {
        return $this->hasMany(SupplierItem::class);
    }

    public function Hasil()
    {
        return $this->hasMany(Hasil::class);
    }
}
