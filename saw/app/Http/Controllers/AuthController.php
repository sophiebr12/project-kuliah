<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Bobot;
use App\Models\Hasil;
use App\Models\Supplier;
use Illuminate\Support\Str;
use App\Models\SupplierItem;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //

    public function viewIndex(Request $request)
    {



        $bobot = Bobot::get();
        $item = Item::get();

        if (isset($request->bobot_id) && isset($request->item_id)) {

            if ($request->bobot_id == 0 || $request->item_id == 0) {
                return redirect()->back();
            }

            $itemNow = Item::find($request->item_id);
            $bobotNow = Bobot::find($request->bobot_id);

            $data = [
                "bobotName" => $bobotNow['nama'] . " (" . $bobotNow['created_at'] . ")",
                "itemName" => $itemNow['nama'],
            ];

            $result = [];
            $x = SupplierItem::where('item_id', $request->item_id)->pluck('id');
            $y = Hasil::whereIn('supplier_item_id', $x)->where('bobot_id', $request->bobot_id)->orderBy('score', 'DESC')->get();

            //build logic
            foreach ($y as $key) {
                $supplierItem = SupplierItem::where('id', $key['supplier_item_id'])->first();
                $supplier = Supplier::where('id', $supplierItem['supplier_id'])->first();

                if ($supplier['grade'] == 4) {
                    $grade = "Excellent";
                } elseif ($supplier['grade'] == 3) {
                    $grade = "Good";
                } elseif ($supplier['grade'] == 2) {
                    $grade = "Moderate";
                } else {
                    $grade = "Awful";
                }

                $result[] = [
                    "nama" => $supplier['nama'],
                    "leadTime" => Str::substr($key['lead_time'], 0, 4) . " | (" . $supplier['lead_time'] . " hari)",
                    "harga" => Str::substr($key['harga'], 0, 5) . " | (Rp." . $supplierItem['harga'] . ")",
                    "grade" => Str::substr($key['grade'], 0, 5) . " | (" . $grade . " | " . $supplier['grade'] . ")",
                    "pembayaran" => Str::substr($key['pembayaran'], 0, 5),
                    "pembayaran_text" => $supplier['is_cash'],
                    "score" => Str::substr($key['score'], 0, 5),
                ];
            }

            // dd($result);

            $displayBobot = [
                "harga" => $bobotNow['harga_w'],
                "grade" => $bobotNow['grade_w'],
                "leadTime" => $bobotNow['lead_time_w'],
                "pembayaran" => $bobotNow['pembayaran_w'],
            ];


            return view('menu/rekomendasi', compact('bobot', 'item', 'data', 'result', "displayBobot"));
        } else {
            $data = [
                "bobotName" => "Kosong",
                "itemName" => "Kosong",
            ];

            // dd($result);
            // return view('menu/rekomendasi', compact('bobot', 'item'));
            return view('menu/rekomendasi', compact('bobot', 'item', 'data'));
        }
    }

    public function viewLogin()
    {
        return view('auth/login');
    }

    public function authenticate(Request $request)
    {
        // Validasi email dan password yang dikirimkan oleh form login
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Coba untuk melakukan otentikasi dengan email dan password
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Intended digunakan untuk melewati Middleware dan mengarahkan ke halaman yang dimaksud
            return redirect()->intended(route('index'));
        } else {
            // Jika otentikasi gagal, kirim pesan error
            return back()->with('error', 'Email atau Kata Sandi salah!');
        }
    }

    public function logout(Request $request)
    {
        if (auth()) {
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            // Redirect ke halaman login dengan pesan logout sukses
            return redirect(route('login'))->with('logout-success', 'Berhasil keluar!');
        } else {
            // Jika tidak ada pengguna yang terautentikasi, redirect ke halaman login
            abort(404);
        }
    }
}
