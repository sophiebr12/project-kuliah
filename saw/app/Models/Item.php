<?php

namespace App\Models;

use App\Models\Bobot;
use App\Models\SupplierItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        "nama",
    ];

    protected $guarded = [
        "id"
    ];

    public function Bobot()
    {
        return $this->hasMany(Bobot::class);
    }

    public function SupplierItem()
    {
        return $this->hasMany(SupplierItem::class);
    }
}
