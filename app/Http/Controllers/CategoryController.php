<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::latest('id')
        ->paginate(5)
        ->withQueryString();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(CategoryRequest $request)
    { 

        $category = Category::create([
            'name' => $request->name,
        ]);

        return redirect(route('category.index'))->with('success', 'A category was created successfully.');
    
    }
}
