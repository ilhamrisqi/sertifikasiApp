<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Medicine;
use App\Models\MedicalEquipment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua item
        $items = Item::all();

        // Ambil obat yang kedaluwarsa dalam 5 hari ke depan
        $expiredMedicine = Medicine::where('expiry_date', '<=', Carbon::now()->addDays(5))->get();

        // Ambil obat dengan stok rendah
        $lowMedicine = Item::where('quantity', '<=', 5)
            ->where('item_type', 'medicine')
            ->get();

        // Ambil peralatan medis dengan stok rendah
        $lowStockItems = Item::where('quantity', '<=', 5)
            ->where('item_type', 'equipment')
            ->get();

        // Ambil barang yang membutuhkan perawatan dalam 5 hari ke depan
        $itemsNeedingMaintenance = MedicalEquipment::where('maintenance_schedule', '<=', Carbon::now()->addDays(5))->get();


        // Hitung total nilai inventori (jumlah * harga)
        $totalInventoryValue = Item::sum(\DB::raw('quantity * price'));

        // Kirim data ke view
        return view('dashboard', compact(
            'items',
            'expiredMedicine',
            'lowMedicine',
            'lowStockItems',
            'itemsNeedingMaintenance',
            'totalInventoryValue'
        ));
    }
}
