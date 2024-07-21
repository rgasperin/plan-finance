<?php

namespace App\Http\Controllers;

use App\Models\AvailableMoney;
use App\Models\Category;
use App\Models\Payment;
use App\Models\SpentMoney;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    private $objSpentMoney;
    private $objAvailableMoney;
    private $objCategory;
    private $objPayment;

    public function __construct()
    {
        $this->objSpentMoney = new SpentMoney();
        $this->objAvailableMoney = new AvailableMoney();
        $this->objCategory = new Category();
        $this->objPayment = new Payment();
    }

    public function index()
    {
        $carbon = new Carbon();
        $currentMonth = $carbon->month;
        $currentYear = $carbon->year;

        $finances = $this->objSpentMoney
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->paginate(4);

        $available_moneys = $this->objAvailableMoney->paginate(4);

        return view('index', compact('finances', 'carbon', 'available_moneys'));
    }

    public function spentMoney()
    {
        $carbon = new Carbon();

        $finances = $this->objSpentMoney->paginate(8);
        $availableMoney = $this->objAvailableMoney->all();

        $financeValue = $finances->sum('value');
        $moneySpend = $availableMoney->sum('to_spend');

        $diff = $moneySpend - $financeValue;

        return view('spent_money.index', compact('finances', 'availableMoney', 'diff', 'carbon'));
    }

    public function create()
    {
        $date = Carbon::now();

        $finances = $this->objSpentMoney->all();

        $categories = $this->objCategory->all();
        $payments = $this->objPayment->all();
        $availableMoneys = $this->objAvailableMoney->all();

        $financeValue = $finances->sum('value');
        $moneySpend = $availableMoneys->sum('to_spend');

        $diff = $moneySpend - $financeValue;

        return view('spent_money.create', compact('categories', 'availableMoneys', 'date', 'diff', 'payments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'value' => 'required',
            'date' => 'required',
            'available_money_id' => 'required',
        ], [
            'name.required' => 'O campo NOME é obrigatório!',
            'value.required' => 'O campo VALOR é obrigatório!',
            'date.required' => 'O campo DATA é obrigatório!',
            'available_money_id' => 'O SALDO não ser R$ 0,00',
        ]);

        $newValue = str_replace(['R$', ','], '', $request->value);

        $payable = $request->has('payable') ? 1 : 0;

        $finance = $this->objSpentMoney->create([
            'available_money_id' => $request->available_money_id,
            'categories_id' => $request->categories_id,
            'payments_id' => $request->payments_id ?? null,
            'name' => $request->name,
            'description' => $request->description,
            'payable' => $payable,
            'value' => $newValue,
            'date' => $request->date,
        ]);

        return redirect('despesa')->with('success', "Despesa adicionada!");
    }

    public function show($id)
    {
        $finance = $this->objSpentMoney->find($id);

        $availableMoney = $finance->find($finance->id)->relAvailableMoney;
        $category = $finance->find($finance->id)->relCategory;

        $date = Carbon::parse($finance->date)->format('d/m/Y');

        $financeValue = $finance->sum('value');
        $moneySpend = $availableMoney->sum('to_spend');

        $diff = $moneySpend - $financeValue;

        return view('spent_money.show', compact('finance', 'diff', 'availableMoney', 'category', 'date'));
    }

    public function edit($id)
    {
        $finance = $this->objSpentMoney->find($id);
        $categories = $this->objCategory->all();
        $availableMoneys = $this->objAvailableMoney->all();

        $financeValue = $finance->sum('value');
        $moneySpend = $availableMoneys->sum('to_spend');

        $diff = $moneySpend - $financeValue;

        return view('spent_money.create', compact('finance', 'categories', 'availableMoneys', 'diff'));
    }

    public function update(Request $request, $id)
    {
        $finances = SpentMoney::findOrFail($id);

        $newValue = str_replace(['R$', ','], '', $request->value);

        $finances->name = $request->name;
        $finances->description = $request->description;
        $finances->value = $newValue;
        $finances->date = $request->date;
        $finances->categories_id = $request->categories_id;
        $finances->payments_id = $request->payments_id;
        $finances->payable = $request->payable === 'on' ? 1 : 0;
        $finances->available_money_id = $request->available_money_id;

        $finances->save();

        return redirect('despesa')->with('success', "Despesa atualizada!");
    }

    public function destroy($id)
    {
        $finance = SpentMoney::findOrFail($id);

        $finance->delete();

        return redirect('despesa')->with('success', "Despesa deletada!");
    }

    public function search(Request $request)
    {
        $carbon = new Carbon();
        $search = $request->input('search');
        $filters = $request->except('_token');

        $finances = $this->objSpentMoney->where('name', 'like', '%' . $search . '%')
            ->orWhereHas('relCategory', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })->orWhere('value', 'like', '%' . $search . '%')
            ->paginate(5);

        $availableMoney = $this->objAvailableMoney->paginate(5);

        $financeValue = $finances->sum('value');
        $moneySpend = $availableMoney->sum('to_spend');

        $diff = $moneySpend - $financeValue;

        return view('spent_money.index', compact('finances', 'filters', 'carbon', 'diff'));
    }
}
