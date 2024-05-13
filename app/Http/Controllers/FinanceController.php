<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AvailableMoney;
use App\Models\SpentMoney;
use App\Models\Category;
use Carbon\Carbon;

class FinanceController extends Controller
{
    private $objSpentMoney;
    private $objAvailableMoney;
    private $objCategory;

    public function __construct() {
        $this->objSpentMoney = new SpentMoney();
        $this->objAvailableMoney = new AvailableMoney();
        $this->objCategory = new Category();
    }

    public function index()
    {
        $finance = $this->objSpentMoney->all();

        return view('index', compact('finance'));
    }

    public function spentMoney()
    {
        $carbon = new Carbon();

        $finance = $this->objSpentMoney->all();
        $availableMoney = $this->objAvailableMoney->all();

        $financeValue = $finance->sum('value');
        $moneySpend = $availableMoney->sum('to_spend');

        $diff = $moneySpend - $financeValue;

        return view('spent_money.index', compact('finance', 'availableMoney', 'diff', 'carbon'));
    }

    public function create()
    {
        $category = $this->objCategory->all();
        $availableMoney = $this->objAvailableMoney->all();

        return view('spent_money.create', compact('category', 'availableMoney'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'value' => 'required',
            'date' => 'required',
        ], [
            'name.required' => 'O campo NOME é obrigatório!',
            'description.required' => 'O campo DESCRIÇÃO é obrigatório!',
            'value.required' => 'O campo VALOR é obrigatório!',
            'date.required' => 'O campo DATA é obrigatório!',
        ]);

        $newValue = str_replace(['R$', ','], '', $request->value);

        $finance = $this->objSpentMoney->create([
            'available_money_id' => $request->available_money_id,
            'categories_id' => $request->categories_id,
            'name' => $request->name,
            'description' => $request->description,
            'value' => $newValue,
            'date' => $request->date,
        ]);
        
        $finance->save();

        return redirect('despesa');
    }

    public function show($id)
    {
        $finance = $this->objSpentMoney->find($id);

        return view('spent_money.show', compact('finance'));
    }

    public function edit($id)
    {
        $finance = $this->objSpentMoney->find($id);
        $category = $this->objCategory->all();
        $availableMoney = $this->objAvailableMoney->all();

        return view('spent_money.create', compact('finance', 'category', 'availableMoney'));
    }

    public function update(Request $request, $id)
    {
        $finance = SpentMoney::findOrFail($id);

        $newValue = str_replace(['R$', ','], '', $request->value);

        $finance->name = $request->name;
        $finance->description = $request->description;
        $finance->value = $newValue;
        $finance->date = $request->date;
        $finance->categories_id = $request->categories_id;
        $finance->available_money_id = $request->available_money_id;

        $finance->save();

        return redirect('despesa');
    }

    public function destroy($id)
    {
        $finance = SpentMoney::findOrFail($id);

        $finance->delete();
        
        return redirect('despesa');
    }

    public function search(Request $request) 
    {
        $filters = $request->except('_token');

        $finance = $this->objSpentMoney->where('name', 'like' , '%' . $request->search .'%')->paginate(5);

        return view('spent_money.index', compact('finance', 'filters'));
    }
}
