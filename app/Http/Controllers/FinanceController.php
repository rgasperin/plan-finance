<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AvailableMoney;
use App\Models\SpentMoney;
use App\Models\Category;

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

    public function create()
    {
        $category = $this->objCategory->all();
        $availableMoney = $this->objAvailableMoney->all();

        return view('create', compact('category', 'availableMoney'));
    }

    public function store(Request $request)
    {
        $request->validade([
            'available_money_id' => 'required',
            'categories_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'value' => 'required',
            'data' => 'required',
        ], []);

        $finance = $this->objSpentMoney->create([
            'name' => $request->name,
            'description' => $request->description,
            'value' => $request->value,
            'data' => $request->data,
        ]);
        $finance->save();

        return redirect('index');

    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
