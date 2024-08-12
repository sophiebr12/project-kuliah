<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Hasil;
use App\Models\Supplier;
use App\Models\SupplierItem;
use Illuminate\Http\Request;
use App\Models\Bobot;

class SupplierController extends Controller
{
    public function viewSupplier()
    {
        $supplier = Supplier::get();
        $item = Item::get();
        return view("menu/supplier", compact('supplier', 'item'));
    }

    public function createSupplier(Request $request)
    {
        $alamat = "";
        $no_telp = "";
        $email = "";

        if (isset($request->alamat)) {
            $alamat = $request->alamat;
        }
        if (isset($request->no_telp)) {
            $no_telp = $request->no_telp;
        }
        if (isset($request->email)) {
            $email = $request->email;
        }

        $data = [
            "nama" => $request->nama,
            "alamat" => $alamat,
            "no_telp" => $no_telp,
            "email" => $email,
            "grade" => $request->grade,
            "lead_time" => $request->lead_time,
            "is_cash" => $request->pembayaran,
        ];

        Supplier::create($data);
        return redirect()->back();
    }
    public function updateSupplier(Request $request)
    {
        $data = [
            "nama" => $request->nama
        ];
        Supplier::where('id', $request->id)->update($data);
        return redirect()->back();
    }
    public function deleteSupplier(Request $request)
    {
        $x = SupplierItem::where('supplier_id', $request->id)->get();
        foreach ($x as $key) {
            Hasil::where('supplier_item_id', $key['id'])->delete();
        }
        SupplierItem::where('supplier_id', $request->id)->delete();
        Supplier::where('id', $request->id)->delete();
        return redirect()->back();
    }

    public function createItemSupplier(Request $request)
    {
        // dd($request);

        $data = [
            "item_id" => $request->itemId,
            "supplier_id" => $request->id,
            "harga" => $request->harga,
        ];

        $supplierItem = SupplierItem::create($data);
        $bobot = Bobot::get();

        // $this->hitungSawUpdateItem($bobot, $supplierItem);

        return redirect()->back();
    }

    public function getItem(Request $request)
    {
        $x = SupplierItem::where('supplier_id', $request->id)->get();
        // return response()->json($x);

        $result = [];
        foreach ($x as $key) {
            $i = Item::find($key->item_id);
            $result[] = [
                "item_id" => $key->id,
                "harga" => $key->harga,
                "nama" => $i->nama,
            ];
        }
        return response()->json($result);
    }

    public function deleteItemSupplier(Request $request)
    {
        Hasil::where('supplier_item_id', $request->id)->delete();
        SupplierItem::where('id', $request->id)->delete();
        return redirect()->back();
    }

    // public function hitungSawUpdateItem($bobot, $supplierItem)
    // {

    //     // bobot ada di $key
    //     // Harga ada di param2 : $supplierItem
    //     // grade, lead_time, is_cash (pembayaran) ada di Supplier ID


    //     $item = Item::where('id', $supplierItem['item_id'])->first();
    //     $supplierNow = Supplier::where('id', $supplierItem['supplier_id'])->first();

    //     // looping dari bobotnya dulu jika ada 2 maka 2x saja krn orientasinya bobot
    //     foreach ($bobot as $key) {
    //         $weightHarga = $key['harga_w'];
    //         $weightGrade = $key['grade_w'];
    //         $weightLeadTime = $key['lead_time_w'];
    //         $weightPembayaran = $key['pembayaran_w'];

    //         // get max min dulu
    //         // get harga MIN
    //         $x = SupplierItem::where('item_id', $item['id'])->orderBy('harga', 'asc')->first();
    //         $hargaMin = $x['harga'];

    //         // get Lead TIme MIN
    //         $supplierId = SupplierItem::where('item_id', $item['id'])->pluck('supplier_id');
    //         $supplier = Supplier::whereIn('id', $supplierId)->orderBy('lead_time', 'asc')->first();
    //         $leadTimeMin = $supplier['lead_time'];

    //         // get Grade Max
    //         $supplier = Supplier::whereIn('id', $supplierId)->orderBy('grade', 'desc')->first();
    //         $gradeMax = $supplier['grade'];

    //         // get Pembayaran Max
    //         $supplier = Supplier::whereIn('id', $supplierId)->selectRaw('MAX(is_cash) as is_cash')->first();
    //         $pembayaranMax = $supplier['is_cash'];

    //         // $newSupplier = Supplier::where('id', $key2->supplier_id)->first();

    //         $normalisasiHarga = $hargaMin / $supplierItem['harga'];
    //         $normalisasiLeadTime = $leadTimeMin / $supplierNow['lead_time'];
    //         $normalisasiGrade = $gradeMax / $supplierNow['grade'];
    //         $normalisasiPembayaran = ($supplierNow['is_cash'] !== 0) ? ($pembayaranMax / $supplierNow['is_cash']) : 0;

    //         $total = ($weightHarga * $normalisasiHarga) + ($weightLeadTime * $normalisasiLeadTime) + ($weightGrade * $normalisasiGrade) + ($weightPembayaran * $normalisasiPembayaran);

    //         $totalHarga = ($weightHarga * $normalisasiHarga);
    //         $totalLeadTime = ($weightLeadTime * $normalisasiLeadTime);
    //         $totalGrade = ($weightGrade * $normalisasiGrade);
    //         $totalPembayaran = ($weightPembayaran * $normalisasiPembayaran);

    //         $data = [
    //             "bobot_id" => $key['id'],
    //             "supplier_item_id" => $supplierItem['id'],
    //             "harga" => $totalHarga,
    //             "lead_time" => $totalLeadTime,
    //             "grade" => $totalGrade,
    //             "pembayaran" => $totalPembayaran,
    //             "score" => $total,
    //         ];
    //         Hasil::create($data);
    //     }
    // }
}
