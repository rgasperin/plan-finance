<?php

namespace App\Http\Controllers;

use App\Models\AvailableMoney;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AvailableMoneyController extends Controller
{
    private $objAvailableMoney;

    public function __construct()
    {
        $this->objAvailableMoney = new AvailableMoney();
    }

    public function index()
    {
        $carbon = new Carbon();
        $availableMoney = $this->objAvailableMoney->all();

        return view('available_money.index', compact('availableMoney', 'carbon'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('available_money.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'to_spend' => 'required',
            'date' => 'required',
        ], [
            'name.required' => 'O campo NOME é obrigatorio!',
            'to_spend.required' => 'O campo VALOR é obrigatorio!',
            'date.required' => 'O campo DATA é obrigatorio!'
        ]);

        $availableMoney = $this->objAvailableMoney->create([
            'name' => $request->name,
            'to_spend' => $request->to_spend,
            'total_value' => $request->total_value,
            'date' => $request->date,
        ]);

        $availableMoney->save();

        return redirect('entrada');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $availableMoney = $this->objAvailableMoney->find($id);

        return view('available_money.create', compact('availableMoney'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $availableMoney = AvailableMoney::findOrFail($id);

        $availableMoney->name = $request->name;
        $availableMoney->to_spend = $request->to_spend;
        $availableMoney->total_value = $request->total_value;
        $availableMoney->date = $request->date;

        $availableMoney->save();

        return redirect('entrada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $availableMoney = AvailableMoney::findOrFail($id);

        $availableMoney->delete();
        
        return redirect('entrada');
    }

    public function search(Request $request) 
    {
        $filters = $request->except('_token');

        $availableMoney = $this->objAvailableMoney->where('name', 'like' , '%' . $request->search .'%')->paginate(5);

        return view('available_money.index', compact('availableMoney', 'filters'));
    }
}
