<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function viewItem()
    {
        $item = Item::get();
        return view("menu/item", compact('item'));
    }

    public function createItem(Request $request)
    {
        $data = [
            "nama" => $request->nama
        ];
        Item::create($data);
        return redirect()->back();
    }
    public function updateItem(Request $request)
    {
        $data = [
            "nama" => $request->nama
        ];
        Item::where('id', $request->id)->update($data);
        return redirect()->back();
    }
    public function deleteItem(Request $request)
    {
        Item::where('id', $request->id)->delete();
        return redirect()->back();
    }
}
