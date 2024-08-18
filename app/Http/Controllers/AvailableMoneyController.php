<?php

namespace App\Http\Controllers;

use App\Models\AvailableMoney;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $availableMoneys = $this->objAvailableMoney
            ->where('user_id', Auth::id()) // Filtra por user_id
            ->paginate(5);

        $availableMoneys->each(function ($availableMoney) {
            $availableMoney->formatted_date = Carbon::parse($availableMoney->date)->format('d/m/Y');
        });

        return view('available_money.index', compact('availableMoneys', 'carbon'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $date = Carbon::now();

        $formName = 'formCad';
        $actionUrl = url('entrada');
        $method = 'POST';

        return view('available_money.create', compact('date', 'formName', 'actionUrl', 'method'));
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
            'date.required' => 'O campo DATA é obrigatorio!',
        ]);

        $this->objAvailableMoney->create([
            'user_id' => Auth::id(), // Define o user_id
            'name' => $request->name,
            'to_spend' => $request->to_spend,
            'date' => $request->date,
        ]);

        return redirect('entrada')->with('success', "Entrada adicionada!");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $availableMoney = $this->objAvailableMoney
            ->where('user_id', Auth::id()) // Filtra por user_id
            ->findOrFail($id);

        $formName = 'formEdit';
        $actionUrl = url('entrada/' . $availableMoney->id);
        $method = 'PUT';

        return view('available_money.create', compact('availableMoney', 'formName', 'actionUrl', 'method'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $availableMoney = $this->objAvailableMoney
            ->where('user_id', Auth::id()) // Filtra por user_id
            ->findOrFail($id);

        $availableMoney->name = $request->name;
        $availableMoney->to_spend = $request->to_spend;
        $availableMoney->date = $request->date;

        $availableMoney->save();

        return redirect('entrada')->with('success', "Entrada atualizada!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $availableMoney = $this->objAvailableMoney
            ->where('user_id', Auth::id()) // Filtra por user_id
            ->findOrFail($id);

        $availableMoney->delete();

        return redirect('entrada')->with('success', "Entrada deletada!");
    }

    public function search(Request $request)
    {
        $carbon = new Carbon();

        $filters = $request->except('_token');

        $availableMoneys = $this->objAvailableMoney
            ->where('user_id', Auth::id()) // Filtra por user_id
            ->where('name', 'like', '%' . $request->search . '%')
            ->orWhere('to_spend', 'like', '%' . $request->search . '%')
            ->paginate(5);

        return view('available_money.index', compact('availableMoneys', 'filters', 'carbon'));
    }
}
