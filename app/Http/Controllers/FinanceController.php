<?php

namespace App\Http\Controllers;

use App\Models\AvailableMoney;
use App\Models\Category;
use App\Models\Payment;
use App\Models\SpentMoney;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{
    private $objSpentMoney;
    private $objAvailableMoney;
    private $objCategory;
    private $objPayment;
    private $carbon;

    public function __construct()
    {
        $this->objSpentMoney = new SpentMoney();
        $this->objAvailableMoney = new AvailableMoney();
        $this->objCategory = new Category();
        $this->objPayment = new Payment();
        $this->carbon = new Carbon();
    }

    public function index()
    {
        $currentMonth = $this->carbon->month;
        $currentYear = $this->carbon->year;

        $finances = $this->objSpentMoney
            ->where('user_id', Auth::id())
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->orderBy('date', 'desc')
            ->paginate(6);

        $finances->each(function ($finance) {
            $finance->formatted_date = Carbon::parse($finance->date)->format('d/m/Y');
        });

        $available_moneys = $this->objAvailableMoney
            ->where('user_id', Auth::id())
            ->paginate(6);

        return view('index', compact('finances', 'available_moneys'));
    }

    public function spentMoney()
    {
        $currentMonth = $this->carbon->month;
        $currentYear = $this->carbon->year;

        $finances = $this->objSpentMoney
            ->where('user_id', Auth::id())
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->orderBy('date', 'desc')
            ->paginate(6);

        $finances->each(function ($finance) {
            $finance->category = $finance->relCategory;
            $finance->payment = $finance->relPayment;
            $finance->formatted_date = Carbon::parse($finance->date)->format('d/m/Y');
        });

        $availableMoney = $this->objAvailableMoney
            ->where('user_id', Auth::id())
            ->get();

        $financeValue = $finances->sum('value');
        $moneySpend = $availableMoney->sum('to_spend');

        $diff = $moneySpend - $financeValue;

        return view('spent_money.index', compact('finances', 'availableMoney', 'diff'));
    }

    public function create()
    {
        $formName = 'formCad';
        $actionUrl = url('despesa');
        $method = 'POST';

        $date = Carbon::now();

        $finances = $this->objSpentMoney
            ->where('user_id', Auth::id())
            ->get();

        $availableMoneys = $this->objAvailableMoney
            ->where('user_id', Auth::id())
            ->get();

        $categories = $this->objCategory
            ->where('user_id', Auth::id())
            ->get();

        $payments = $this->objPayment->all();

        $financeValue = $finances->sum('value');
        $moneySpend = $availableMoneys->sum('to_spend');

        $diff = $moneySpend - $financeValue;

        return view('spent_money.create', compact('categories', 'availableMoneys', 'date', 'diff', 'payments', 'formName', 'actionUrl', 'method'));
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

        $this->objSpentMoney->create([
            'user_id' => Auth::id(),
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

    public function showModal($id)
    {
        $finance = $this->objSpentMoney
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $availableMoney = $finance->relAvailableMoney;
        $category = $finance->relCategory;

        $date = Carbon::parse($finance->date)->format('d/m/Y');

        $financeValue = $finance->sum('value');
        $moneySpend = $availableMoney->sum('to_spend');

        $diff = $moneySpend - $financeValue;

        return view('templates.modal_details', compact('finance', 'diff', 'availableMoney', 'category', 'date'));
    }

    public function edit($id)
    {
        $finance = $this->objSpentMoney
            ->where('user_id', Auth::id())
            ->find($id);

        $formName = 'formEdit';
        $actionUrl = url('despesa/' . $finance->id);
        $method = 'PUT';

        $categories = $this->objCategory
            ->where('user_id', Auth::id())
            ->get();

        $availableMoneys = $this->objAvailableMoney
            ->where('user_id', Auth::id())
            ->get();

        $payments = $this->objPayment->all();

        $financeValue = $finance->sum('value');
        $moneySpend = $availableMoneys->sum('to_spend');

        $diff = $moneySpend - $financeValue;

        return view('spent_money.create', compact('finance', 'categories', 'availableMoneys', 'diff', 'payments', 'formName', 'actionUrl', 'method'));
    }

    public function update(Request $request, $id)
    {
        $finances = $this->objSpentMoney->where('user_id', Auth::id())->findOrFail($id);

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
        $finance = $this->objSpentMoney
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $finance->delete();

        return redirect('despesa')->with('success', "Despesa deletada!");
    }

    public function search(Request $request)
    {
        $carbon = $this->carbon;
        $search = $request->input('search');
        $filters = $request->except('_token');

        $finances = $this->objSpentMoney->where('name', 'like', '%' . $search . '%')
            ->where('user_id', Auth::id())
            ->orWhereHas('relCategory', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })->orWhere('value', 'like', '%' . $search . '%')
            ->paginate(5);

        $availableMoney = $this->objAvailableMoney->where('user_id', Auth::id())->paginate(5);

        $financeValue = $finances->sum('value');
        $moneySpend = $availableMoney->sum('to_spend');

        $diff = $moneySpend - $financeValue;

        return view('spent_money.index', compact('finances', 'filters', 'carbon', 'diff'));
    }
}
