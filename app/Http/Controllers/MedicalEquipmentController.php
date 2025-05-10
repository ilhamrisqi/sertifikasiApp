<?php

namespace App\Http\Controllers;

use App\Models\MedicalEquipment;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\DB;

class MedicalEquipmentController extends Controller
{
    public function index()
    {
        $equipments = MedicalEquipment::with('item')->get();
        return view('medical.index', compact('equipments'));
    }

    public function create()
    {
        $items = Item::all();
        return view('medical.create', compact('items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|integer',
            'department' => 'required|string|max:255',
            'operational_status' => 'required|in:Active,Maintenance,Broken',
            'maintenance_schedule' => 'nullable|date',
        ]);

        $item = Item::create([
            'name' => $validated['name'],
            'quantity' => $validated['quantity'],
            'price' => $validated['price'],
            'item_type' => 'equipment',
        ]);

        $equipment = MedicalEquipment::create([
            'item_id' => $item->id,
            'department' => $validated['department'],
            'operational_status' => $validated['operational_status'],
            'maintenance_schedule' => $validated['maintenance_schedule'],
        ]);

        StockTransaction::create([
            'item_id' => $item->id,
            'user_id' => auth()->id() ?? 1,
            'quantity' => $validated['quantity'],
            'transaction_type' => 'in',
            'transaction_date' => now(),
        ]);

        return redirect()->route('medical.index')->with('message', 'Medical equipment created successfully');
    }

    public function show($id)
    {
        $equipment = MedicalEquipment::with('item')->findOrFail($id);
        return view('medical.show', compact('equipment'));
    }

    public function edit($id)
    {
        $equipment = MedicalEquipment::with('item')->findOrFail($id);
        $items = Item::all();
        return view('medical.edit', compact('equipment', 'items'));
    }

    public function update(Request $request, $id)
    {
        $equipment = MedicalEquipment::findOrFail($id);
        $item = Item::findOrFail($equipment->item_id);

        $validated = $request->validate([
            'name' => 'string|max:255',
            'quantity' => 'integer',
            'price' => 'decimal:0,2',
            'department' => 'string|max:255',
            'operational_status' => 'in:Active,Maintenance,Broken',
            'maintenance_schedule' => 'nullable|date',
        ]);

        $quantityDifference = $validated['quantity'] - $item->quantity;

        $item->update([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
        ]);

        $equipment->update([
            'department' => $validated['department'],
            'operational_status' => $validated['operational_status'],
            'maintenance_schedule' => $validated['maintenance_schedule'],
        ]);

        if ($quantityDifference != 0) {
            StockTransaction::create([
                'item_id' => $item->id,
                'user_id' => auth()->id() ?? 1,
                'quantity' => abs($quantityDifference),
                'transaction_type' => $quantityDifference > 0 ? 'in' : 'out',
                'transaction_date' => now(),
            ]);
        }

        return redirect()->route('medical.index')->with('message', 'Medical equipment updated successfully');
    }

    public function destroy($id)
    {
        $equipment = MedicalEquipment::findOrFail($id);
        $item = Item::findOrFail($equipment->item_id);

        if ($item->quantity > 0) {
            StockTransaction::create([
                'item_id' => $item->id,
                'user_id' => auth()->id() ?? 1,
                'quantity' => $item->quantity,
                'transaction_type' => 'out',
                'transaction_date' => now(),
                'notes' => 'Penghapusan item',
            ]);
        }

        try {
            DB::beginTransaction();

            StockTransaction::where('item_id', $item->id)->delete();
            $equipment->delete();
            $item->delete();

            DB::commit();

            return redirect()->route('medical.index')->with('message', 'Medical equipment deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('medical.index')->with('error', 'Failed to delete medical equipment: ' . $e->getMessage());
        }
    }
}
