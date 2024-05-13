<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategoryController extends Controller
{
    private $objCategory;

    public function __construct() {
        $this->objCategory = new Category();
    }

    public function index() 
    {
        $categories = $this->objCategory->paginate(5);

        return view('categories.index', compact('categories'));
    }

    public function create() 
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Nome da categoria é obrigatorio' 
        ]);

        $category = $this->objCategory->create([
            'name' => $request->name,
            'color' => $request->color,
        ]);
        $category->save();

        return redirect('categoria');
    }

    public function edit(string $id)
    {
        $category = $this->objCategory->find($id);

        return view('categories.create', compact('category'));
    }

    
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $category->name = $request->name;
        $category->color = $request->color;
        
        $category->save();

        return redirect('categoria');
    }

    
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        $category->delete();
        
        return redirect('categoria');
    }

    public function search(Request $request) 
    {
        $filters = $request->except('_token');

        $categories = $this->objCategory->where('name', 'like' , '%' . $request->search .'%')->paginate(5);

        return view('categories.index', compact('categories', 'filters'));
    }
}
