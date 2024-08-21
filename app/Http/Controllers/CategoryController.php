<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    private $objCategory;

    public function __construct()
    {
        $this->objCategory = new Category();
    }

    public function index()
    {
        $categories = $this->objCategory
            ->where('user_id', Auth::id())
            ->paginate(6);

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
            'name.required' => 'Nome da categoria é obrigatorio',
        ]);

        $category = $this->objCategory->create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'color' => $request->color,
        ]);
        $category->save();

        return redirect('categoria')->with('success', "Categoria adicionada!");
    }

    public function edit(string $id)
    {
        $category = $this->objCategory
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('categories.create', compact('category'));
    }

    public function update(Request $request, string $id)
    {
        $category = $this->objCategory
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $category->name = $request->name;
        $category->color = $request->color;

        $category->save();

        return redirect('categoria')->with('success', "Categoria atualizada!");
    }

    public function destroy(string $id)
    {
        $category = $this->objCategory
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $category->delete();

        return redirect('categoria')->with('success', "Categoria deletada!");
    }

    public function search(Request $request)
    {
        $filters = $request->except('_token');

        $categories = $this->objCategory
            ->where('user_id', Auth::id())
            ->where('name', 'like', '%' . $request->search . '%')->paginate(5);

        return view('categories.index', compact('categories', 'filters'));
    }
}
