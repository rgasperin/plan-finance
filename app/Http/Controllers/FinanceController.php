<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AvailableMoney;
use App\Models\SpentMoney;
use App\Models\Category;
use Carbon\Carbon;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

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

        $item = $this->objSpentMoney->pluck('name')->toArray();

        $data = [
            ['date' => '2024-05-01', 'value' => 100],
            ['date' => '2024-05-02', 'value' => 150],
            ['date' => '2024-05-03', 'value' => 200],
        ];
        
        $formatted_data = [];
        foreach ($data as $item) {
            $formatted_data[$item['date']] = $item['value'];
        }

        $chart_options = [
            'chart_title' => 'Users by months',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\SpentMoney',
            'group_by_field' => 'name',
            'group_by_period' => 'day',
            'chart_type' => 'bar',
            'data' => $formatted_data,
            'fields' => [
                'date' => 'Date', // Nome do campo da data em seu modelo
                'value' => 'Value', // Nome do campo do valor em seu modelo
            ],
        ];

        
        $chart = new LaravelChart($chart_options);

        return view('index', compact('finance', 'chart'));
    }

    public function spentMoney()
    {
        $carbon = new Carbon();

        $finances = $this->objSpentMoney->all();
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
        $availableMoneys = $this->objAvailableMoney->all();

        $financeValue = $finances->sum('value');
        $moneySpend = $availableMoneys->sum('to_spend');

        $diff = $moneySpend - $financeValue;

        return view('spent_money.create', compact('categories', 'availableMoneys', 'date', 'diff'));
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

        $availableMoney = $finance->find($finance->id)->relAvailableMoney;
        $category =  $finance->find($finance->id)->relCategory;

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
        $finances->available_money_id = $request->available_money_id;

        $finances->save();

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
        $carbon = new Carbon();
        $search = $request->input('search');   
        $filters = $request->except('_token');

        $finances = $this->objSpentMoney->where('name', 'like' , '%' . $search .'%')
                                        ->orWhereHas('relCategory', function($query) use ($search) {
                                            $query->where('name', 'like', '%'. $search . '%');
                                        })->orWhere('value', 'like' , '%' . $search .'%')
                                        ->paginate(5);

        $availableMoney = $this->objAvailableMoney->paginate(5);

        $financeValue = $finances->sum('value');
        $moneySpend = $availableMoney->sum('to_spend');

        $diff = $moneySpend - $financeValue;

        return view('spent_money.index', compact('finances', 'filters', 'carbon', 'diff'));
    }
}
