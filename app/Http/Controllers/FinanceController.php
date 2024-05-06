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
    }

    public function store(Request $request)
    {
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
