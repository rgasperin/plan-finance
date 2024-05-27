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

        $availableMoneys = $this->objAvailableMoney->paginate(5);

        return view('available_money.index', compact('availableMoneys', 'carbon'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $date = Carbon::now();
        
        return view('available_money.create', compact('date'));
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
        $carbon = new Carbon();

        $filters = $request->except('_token');

        $availableMoneys = $this->objAvailableMoney->where('name', 'like' , '%' . $request->search .'%')
                                                   ->orWhere('to_spend', 'like', '%' . $request->search .'%')
                                                   ->paginate(5);

        return view('available_money.index', compact('availableMoneys', 'filters', 'carbon'));
    }
}
