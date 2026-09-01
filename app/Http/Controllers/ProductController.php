<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display list of all products.
     */
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created product in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|regex:/^[A-Za-z\s]+$/',
            'color'        => 'nullable|regex:/^[A-Za-z\s]+$/',
            'price'        => 'required|numeric',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $mainImage = null;
        if ($request->hasFile('image')) {
            $mainImage = 'product_' . time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $mainImage);
        }

        Product::create([
            'product_name' => $request->product_name,
            'image'        => $mainImage,
            'price'        => $request->price,
            'size'         => $request->size,
            'color'        => $request->color,
            'description'  => $request->description,
            'status'       => 1,
        ]);

        return redirect()->route('products.index')->with('success', 'Product Added Successfully');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'product_name' => 'required|regex:/^[A-Za-z\s]+$/',
            'color'        => 'nullable|regex:/^[A-Za-z\s]+$/',
            'price'        => 'required|numeric',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'product_name' => $request->product_name,
            'price'        => $request->price,
            'size'         => $request->size,
            'color'        => $request->color,
            'description'  => $request->description,
            'status'       => $request->status ?? 0,
        ];

        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path('images/' . $product->image))) {
                unlink(public_path('images/' . $product->image));
            }
            $mainImage = 'product_' . time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $mainImage);
            $data['image'] = $mainImage;
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product Updated Successfully');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image && file_exists(public_path('images/' . $product->image))) {
            unlink(public_path('images/' . $product->image));
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product Deleted Successfully');
    }
}
