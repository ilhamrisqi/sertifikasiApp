<?php
namespace App\Http\Controllers;
use App\Models\Medicine;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\StockTransaction;
class MedicineController extends Controller
{
    /**
     * Display a listing of the medicines.
     */
    public function index()
    {
        $medicines = Medicine::with('item')->get();
        return view('medicines.index', compact('medicines'));
    }

    public function create()
    {
        $items = Item::all();
        return view('medicines.create', compact('items'));
    }

    /**
     * Store a newly created medicine in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|integer',
            'dosage' => 'required|string|max:255',
            'expiry_date' => 'required|date',
            'requires_prescription' => 'boolean',
        ]);

        // Buat item baru
        $item = Item::create([
            'name' => $validated['name'],
            'quantity' => $validated['quantity'],
            'price' => $validated['price'],
            'item_type' => 'medicine',
        ]);

        // Buat data medicine
        $medicine = Medicine::create([
            'item_id' => $item->id,
            'dosage' => $validated['dosage'],
            'expiry_date' => $validated['expiry_date'],
            'requires_prescription' => $validated['requires_prescription'] ?? false,
        ]);

        // Catat transaksi stok masuk
        StockTransaction::create([
            'item_id' => $item->id,
            'user_id' => 1,
            'quantity' => $validated['quantity'],
            'transaction_type' => 'in',
            'transaction_date' => now(),
        ]);

        return view('medicines.index', [
            'message' => 'Medicine created successfully',
            'medicines' => Medicine::with('item')->get(),
        ]);
    }

    /**
     * Display the specified medicine.
     */
    public function show($id)
    {
        $medicine = Medicine::with('item')->findOrFail($id);
        return response()->json($medicine);
    }

    /**
     * Show the form for editing the specified medicine.
     */
    public function edit($id)
    {
        $medicine = Medicine::with('item')->findOrFail($id);
        $items = Item::all();
        return view('medicines.edit', compact('medicine', 'items'));
    }

    /**
     * Update the specified medicine in storage.
     */
    public function update(Request $request, $id)
    {
        // Cari medicine beserta item terkait
        $medicine = Medicine::findOrFail($id);
        $item = Item::findOrFail($medicine->item_id);
        
        // Validasi input
        $validated = $request->validate([
            'name' => 'string|max:255',
            'quantity' => 'integer',
            'price' => 'decimal:0,2',
            'dosage' => 'string|max:255',
            'expiry_date' => 'date',
            'requires_prescription' => 'boolean',
        ]);

        // Hitung perubahan kuantitas untuk pencatatan stok
        $quantityDifference = $validated['quantity'] - $item->quantity;
        
        // Update data item
        $item->update([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
        ]);

        // Update data medicine
        $medicine->update([
            'dosage' => $validated['dosage'],
            'expiry_date' => $validated['expiry_date'],
            'requires_prescription' => $validated['requires_prescription'] ?? false,
        ]);

        // Catat transaksi stok jika ada perubahan kuantitas
        if ($quantityDifference != 0) {
            StockTransaction::create([
                'item_id' => $item->id,
                'user_id' => 1,
                'quantity' => abs($quantityDifference),
                'transaction_type' => $quantityDifference > 0 ? 'in' : 'out',
                'transaction_date' => now(),
            ]);
        }

        return redirect()->route('medicines.index')->with('message', 'Obat berhasil diperbarui');
    }

    /**
     * Remove the specified medicine from storage.
     */
    public function destroy($id)
    {
        $medicine = Medicine::findOrFail($id);
        $item = Item::findOrFail($medicine->item_id);
        
        // Catat transaksi stok keluar untuk semua kuantitas yang ada
        if ($item->quantity > 0) {
            StockTransaction::create([
                'item_id' => $item->id,
                'user_id' => 1,
                'quantity' => $item->quantity,
                'transaction_type' => 'out',
                'transaction_date' => now(),
                'notes' => 'Penghapusan item obat',
            ]);
        }
        
        try {
            // Gunakan transaction untuk memastikan operasi yang aman
            \DB::beginTransaction();
            
            // Hapus semua transaksi stok terkait terlebih dahulu
            StockTransaction::where('item_id', $item->id)->delete();
            
            // Lalu hapus medicine dan item terkait
            $medicine->delete();
            $item->delete();
            
            \DB::commit();
            return redirect()->route('medicines.index')->with('message', 'Obat berhasil dihapus');
        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->route('medicines.index')->with('error', 'Gagal menghapus obat: ' . $e->getMessage());
        }
    }
}