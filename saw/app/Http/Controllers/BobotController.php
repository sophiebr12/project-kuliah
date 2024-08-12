<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Bobot;
use App\Models\Hasil;
use App\Models\Supplier;
use App\Models\SupplierItem;
use Illuminate\Http\Request;

class BobotController extends Controller
{
    //

    public function createBobot(Request $request)
    {
        $harga = $request->harga;
        if ($harga > 100) {
            $harga = 100;
        } elseif ($harga < 0) {
            $harga = 0;
        }

        $grade = $request->grade;
        if ($grade > 100) {
            $grade = 100;
        } elseif ($grade < 0) {
            $grade = 0;
        }

        $leadTime = $request->leadTime;
        if ($leadTime > 100) {
            $leadTime = 100;
        } elseif ($leadTime < 0) {
            $leadTime = 0;
        }

        $pembayaran = $request->pembayaran;
        if ($pembayaran > 100) {
            $pembayaran = 100;
        } elseif ($pembayaran < 0) {
            $pembayaran = 0;
        }

        $total = $pembayaran + $leadTime + $grade + $harga;

        // Hitung bobot persentase
        $hargaPersentase = ($harga / $total) * 100;
        $gradePersentase = ($grade / $total) * 100;
        $leadTimePersentase = ($leadTime / $total) * 100;
        $pembayaranPersentase = ($pembayaran / $total) * 100;

        $data = [
            "nama" => $request->nama,
            "harga_w" => $hargaPersentase,
            "grade_w" => $gradePersentase,
            "lead_time_w" => $leadTimePersentase,
            "pembayaran_w" => $pembayaranPersentase,
        ];

        // dd($data, $total);

        $bobot = Bobot::create($data);
        $this->hitungSaw($bobot);

        return redirect()->back();
    }

    public function hitungSaw($bobot)
    {

        /*
        Harga = Cost (jadi Diambil yang paling MIN)
        LeadTime = Cost (jadi Diambil yang paling MIN)
        Grade = Benefit (jadi Diambil yang paling MAX)
        Pembayaran = Benefit (jadi Diambil yang paling MAX) 0 : CASH 1 : Bisa Kredit
        */

        $item = Item::get();
        foreach ($item as $key) {
            // get harga MIN
            $supplierItem = SupplierItem::where('item_id', $key->id)->orderBy('harga', 'asc')->first();
            $hargaMin = $supplierItem['harga'];

            // get Lead TIme MIN
            $supplierId = SupplierItem::where('item_id', $key->id)->pluck('supplier_id');
            $supplier = Supplier::whereIn('id', $supplierId)->orderBy('lead_time', 'asc')->first();

            $leadTimeMin = $supplier['lead_time'];

            // get Grade Max
            $supplier = Supplier::whereIn('id', $supplierId)->orderBy('grade', 'desc')->first();
            $gradeMax = $supplier['grade'];

            // get Pembayaran Max
            $supplier = Supplier::whereIn('id', $supplierId)->selectRaw('MAX(is_cash) as is_cash')->first();
            $pembayaranMax = $supplier['is_cash'];

            // get semua item supplierItem
            $allItem = SupplierItem::where('item_id', $key->id)->get();

            foreach ($allItem as $key2) {
                $newSupplier = Supplier::where('id', $key2->supplier_id)->first();
                // grade, lead_time, is_cash didapat di $newSupplier
                // harga didapat di $key2

                $normalisasiHarga = $hargaMin / $key2['harga'];
                $normalisasiLeadTime = $leadTimeMin / $newSupplier['lead_time'];
                $normalisasiGrade = $newSupplier['grade'] / $gradeMax;
                $normalisasiPembayaran = ($newSupplier['is_cash'] !== 0) ? ($newSupplier['is_cash'] / $pembayaranMax) : 0;

                $totalHarga = ($bobot['harga_w'] * $normalisasiHarga);
                $totalLeadTime = ($bobot['lead_time_w'] * $normalisasiLeadTime);
                $totalGrade = ($bobot['grade_w'] * $normalisasiGrade);
                $totalPembayaran = ($bobot['pembayaran_w'] * $normalisasiPembayaran);

                // Penghitungan Hasil
                // Weight Criteria * Normalisasi (Loop)
                $total = ($bobot['harga_w'] * $normalisasiHarga) + ($bobot['lead_time_w'] * $normalisasiLeadTime) + ($bobot['grade_w'] * $normalisasiGrade) + ($bobot['pembayaran_w'] * $normalisasiPembayaran);

                $data = [
                    "bobot_id" => $bobot['id'],
                    "supplier_item_id" => $key2['id'],
                    "harga" => $totalHarga,
                    "lead_time" => $totalLeadTime,
                    "grade" => $totalGrade,
                    "pembayaran" => $totalPembayaran,
                    "score" => $total,
                ];
                Hasil::create($data);
            }

            // dd($hargaMin, $leadTimeMin, $gradeMax, $pembayaranMax);
        }
    }
}
