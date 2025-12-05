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
        // Fetch latest products with pagination
        $products = Product::latest()->paginate(10);

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        // Load the product creation page
        return view('products.create');
    }

    /**
     * Store a newly created product in the database.
     */
    public function store(Request $request)
    {
        // Validate form input fields
        $request->validate([
            'product_name' => 'required|regex:/^[A-Za-z\s]+$/',
            'color'        => 'nullable|regex:/^[A-Za-z\s]+$/',
            'price'        => 'required|numeric',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Handle product image upload
        $mainImage = null;
        if ($request->hasFile('image')) {
            $mainImage = 'product_' . time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $mainImage);
        } 

        // Save product record in the database
        Product::create([
            'product_name' => $request->product_name,
            'image'        => $mainImage,
            'price'        => $request->price,
            'size'         => $request->size,
            'color'        => $request->color,
            'description'  => $request->description,
            'status'       => 1,
        ]);

        // Redirect user back to product list
        return redirect()->route('products.index')->with('success', 'Product Added Successfully');
    }
}
