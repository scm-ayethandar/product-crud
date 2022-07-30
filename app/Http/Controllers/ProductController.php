<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index() 
    {
        $products = Product::paginate(3);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        
        return view('products.create', compact('categories'));
    }

    public function store(ProductRequest $request)
    { 
        $product = Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        // upload multiple image
        foreach($request->file('images') as $file) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $dir = '/upload/images';
            $path = $file->storeAs($dir, $filename);

            $product->images()->create([
                'path' => $path,
            ]);
        }

        $product->categories()->attach($request->category_ids);

        session()->flash('success', 'A post was created successfully.');

        return redirect(route('products.index'));
    }

    public function show($id)
    {
        $product = Product::find($id);

        return view('products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $oldCategoryIds = $product->categories->pluck('id')->toArray();
        $categories = Category::all();

        return view('products.edit', compact('product', 'categories', 'oldCategoryIds'));
    }

    public function update(ProductRequest $request, $id)
    {       
        $product = Product::findOrFail($id);

        if($request->hasFile('images'))
        {
            // delete old image
            foreach($product->images as $image) {
                Storage::delete($image->path);
                Image::where('imageable_id', $product->id)->where('imageable_type', Product::class)->delete();
            }

            // upload a image
            foreach($request->images as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $dir = '/upload/images';
                $path = $file->storeAs($dir, $filename);

                $product->images()->create([
                    'path' => $path,
                ]);
            }
        }

        // update produ$product
        $product->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        $product->categories()->sync($request->category_ids);
        return redirect('/products')->with('success', 'A product was updated successfully.');
    }

    public function destroy($id)
    {
        Product::destroy($id);

        // return "Deleted Post";
        return redirect(route('products.index'))->with('success', 'A product was deleted.');
    }
}
