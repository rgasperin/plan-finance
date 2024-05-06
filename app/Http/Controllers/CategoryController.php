<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    private $objCategory;

    public function __construct() {
        $this->objCategory = new Category();
    }

    public function index() 
    {
        $category = $this->objCategory->all();

        return view('category', compact('category'));
    }

    public function create() 
    {
        return view('create_category');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required' 
        ], [
            'name.required' => 'Nome da categoria é obrigatorio' 
        ]);

        $category = $this->objCategory->create([
            'name' => $request->name
        ]);
        $category->save();

        return redirect('categoria');
    }

    public function edit(string $id)
    {
        $category = $this->objCategory->find($id);

        return view('create_category', compact('category'));
    }

    
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->save();

        return redirect('categoria');
    }

    
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        dd($category);
        if (!$category) {
            return redirect()->back()->with('error', 'Categoria não encontrado.');
        }

        $category->delete();
        
        return redirect()->back()->with('success', 'Categoria deletada com sucesso.');
    }
}
