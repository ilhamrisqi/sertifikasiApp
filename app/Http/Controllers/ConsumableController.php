<?php
namespace App\Http\Controllers;

use App\Models\Consumable;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\StockTransaction;

class ConsumableController extends Controller
{
    /**
     * Display a listing of the consumables.
     */
    public function index()
    {
        $consumables = Consumable::with('item')->get();
        return view('consumables.index', compact('consumables'));
    }

    /**
     * Show the form for creating a new consumable.
     */
    public function create()
    {
        $items = Item::all();
        return view('consumables.create', compact('items'));
    }

    /**
     * Store a newly created consumable in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|integer',
            'usage_type' => 'required|string|max:255',
            'sterilization_status' => 'required|in:Sterilized,Not Sterilized',
            'expiry_date' => 'required|date',
        ]);

        // Buat item baru
        $item = Item::create([
            'name' => $validated['name'],
            'quantity' => $validated['quantity'],
            'price' => $validated['price'],
            'item_type' => 'consumable',
        ]);

        // Buat data consumable
        $consumable = Consumable::create([
            'item_id' => $item->id,
            'usage_type' => $validated['usage_type'],
            'sterilization_status' => $validated['sterilization_status'],
            'expiry_date' => $validated['expiry_date'],
        ]);

        // Catat transaksi stok masuk
        StockTransaction::create([
            'item_id' => $item->id,
            'user_id' => 1,
            'quantity' => $validated['quantity'],
            'transaction_type' => 'in',
            'transaction_date' => now(),
        ]);

        return view('consumables.index', [
            'message' => 'Consumable created successfully',
            'consumables' => Consumable::with('item')->get(),
        ]);
    }

    /**
     * Display the specified consumable.
     */
    public function show($id)
    {
        $consumable = Consumable::with('item')->findOrFail($id);
        return response()->json($consumable);
    }

    /**
     * Show the form for editing the specified consumable.
     */
    public function edit($id)
    {
        $consumable = Consumable::with('item')->findOrFail($id);
        $items = Item::all();
        return view('consumables.edit', compact('consumable', 'items'));
    }

    /**
     * Update the specified consumable in storage.
     */
    public function update(Request $request, $id)
    {
        // Cari consumable beserta item terkait
        $consumable = Consumable::findOrFail($id);
        $item = Item::findOrFail($consumable->item_id);
        
        // Validasi input
        $validated = $request->validate([
            'name' => 'string|max:255',
            'quantity' => 'integer',
            'price' => 'decimal:0,2',
            'usage_type' => 'string|max:255',
            'sterilization_status' => 'in:Sterilized,Not Sterilized',
            'expiry_date' => 'date',
        ]);

        // Hitung perubahan kuantitas untuk pencatatan stok
        $quantityDifference = $validated['quantity'] - $item->quantity;
        
        // Update data item
        $item->update([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
        ]);

        // Update data consumable
        $consumable->update([
            'usage_type' => $validated['usage_type'],
            'sterilization_status' => $validated['sterilization_status'],
            'expiry_date' => $validated['expiry_date'],
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

        return redirect()->route('consumables.index')->with('message', 'Barang habis pakai berhasil diperbarui');
    }

    /**
     * Remove the specified consumable from storage.
     */
    public function destroy($id)
    {
        $consumable = Consumable::findOrFail($id);
        $item = Item::findOrFail($consumable->item_id);
        
        // Catat transaksi stok keluar untuk semua kuantitas yang ada
        if ($item->quantity > 0) {
            StockTransaction::create([
                'item_id' => $item->id,
                'user_id' => 1,
                'quantity' => $item->quantity,
                'transaction_type' => 'out',
                'transaction_date' => now(),
                'notes' => 'Penghapusan item barang habis pakai',
            ]);
        }
        
        try {
            // Gunakan transaction untuk memastikan operasi yang aman
            \DB::beginTransaction();
            
            // Hapus semua transaksi stok terkait terlebih dahulu
            StockTransaction::where('item_id', $item->id)->delete();
            
            // Lalu hapus consumable dan item terkait
            $consumable->delete();
            $item->delete();
            
            \DB::commit();
            return redirect()->route('consumables.index')->with('message', 'Barang habis pakai berhasil dihapus');
        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->route('consumables.index')->with('error', 'Gagal menghapus barang habis pakai: ' . $e->getMessage());
        }
    }
}