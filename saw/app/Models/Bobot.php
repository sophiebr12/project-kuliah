<?php

namespace App\Models;

use App\Models\Item;
use App\Models\Hasil;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bobot extends Model
{
    use HasFactory;

    protected $fillable = [
        "nama",
        "harga_w",
        "grade_w",
        "lead_time_w",
        "pembayaran_w",
        // "item_id",
    ];

    protected $guarded = [
        "id"
    ];

    public function Item()
    {
        return $this->belongsTo(Item::class);
    }

    public function Hasil()
    {
        return $this->hasMany(Hasil::class);
    }
}
