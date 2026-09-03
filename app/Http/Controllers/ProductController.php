<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductController extends Controller
{
    /**
     * Display products with:
     * Search
     * Status filter
     * Price filter
     * Sorting
     * Pagination
     */
    public function index(Request $request)
    {
        $query = Product::query();

        /*
        |--------------------------------------------------------------------------
        | 1. Search
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where('product_name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('color', 'like', '%' . $search . '%')
                    ->orWhere('size', 'like', '%' . $search . '%');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | 2. Status Filter
        |--------------------------------------------------------------------------
        */
        if ($request->status !== null && $request->status !== '') {

            $status = (int) $request->status;

            if (in_array($status, [0, 1])) {
                $query->where('status', $status);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Minimum Price
        |--------------------------------------------------------------------------
        */
        if ($request->filled('min_price')) {

            $query->where(
                'price',
                '>=',
                $request->min_price
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 4. Maximum Price
        |--------------------------------------------------------------------------
        */
        if ($request->filled('max_price')) {

            $query->where(
                'price',
                '<=',
                $request->max_price
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 5. Sorting
        |--------------------------------------------------------------------------
        */
        switch ($request->sort) {

            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;

            case 'name_asc':
                $query->orderBy('product_name', 'asc');
                break;

            case 'name_desc':
                $query->orderBy('product_name', 'desc');
                break;

            case 'price_low':
                $query->orderBy('price', 'asc');
                break;

            case 'price_high':
                $query->orderBy('price', 'desc');
                break;

            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        /*
        |--------------------------------------------------------------------------
        | 6. Pagination
        |--------------------------------------------------------------------------
        */
        $products = $query
            ->paginate(5)
            ->withQueryString();

        return view(
            'products.index',
            compact('products')
        );
    }

    /**
     * Show create form.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store product.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|regex:/^[A-Za-z\s]+$/',
            'color'        => 'nullable|regex:/^[A-Za-z\s]+$/',
            'price'        => 'required|numeric|min:0',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $mainImage = null;

        if ($request->hasFile('image')) {

            $mainImage =
                'product_' .
                time() .
                '_' .
                uniqid() .
                '.' .
                $request->image->extension();

            $request->image->move(
                public_path('images'),
                $mainImage
            );
        }

        Product::create([
            'product_name' => $request->product_name,
            'image'        => $mainImage,
            'price'        => $request->price,
            'size'         => $request->size,
            'color'        => $request->color,
            'description'  => $request->description,
            'status'       => $request->status ?? 1,
        ]);

        return redirect()
            ->route('products.index')
            ->with(
                'success',
                'Product Added Successfully'
            );
    }

    /**
     * Show edit form.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view(
            'products.edit',
            compact('product')
        );
    }

    /**
     * Show product details.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view(
            'products.show',
            compact('product')
        );
    }

    /**
     * Update product.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'product_name' => 'required|regex:/^[A-Za-z\s]+$/',
            'color'        => 'nullable|regex:/^[A-Za-z\s]+$/',
            'price'        => 'required|numeric|min:0',
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

            if (
                $product->image &&
                file_exists(
                    public_path(
                        'images/' . $product->image
                    )
                )
            ) {
                unlink(
                    public_path(
                        'images/' . $product->image
                    )
                );
            }

            $mainImage =
                'product_' .
                time() .
                '_' .
                uniqid() .
                '.' .
                $request->image->extension();

            $request->image->move(
                public_path('images'),
                $mainImage
            );

            $data['image'] = $mainImage;
        }

        $product->update($data);

        return redirect()
            ->route('products.index')
            ->with(
                'success',
                'Product Updated Successfully'
            );
    }

    /**
     * Delete product.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if (
            $product->image &&
            file_exists(
                public_path(
                    'images/' . $product->image
                )
            )
        ) {
            unlink(
                public_path(
                    'images/' . $product->image
                )
            );
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with(
                'success',
                'Product Deleted Successfully'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | 7. Toggle Product Status
    |--------------------------------------------------------------------------
    */

    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);

        $product->status = !$product->status;

        $product->save();

        return back()->with(
            'success',
            'Product status updated successfully.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | 8. CSV Export
    |--------------------------------------------------------------------------
    */

    public function exportCsv(Request $request)
    {
        $query = Product::query();

        /*
        | Search
        */
        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where('product_name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('color', 'like', '%' . $search . '%')
                    ->orWhere('size', 'like', '%' . $search . '%');
            });
        }

        /*
        | Status
        */
        if ($request->status !== null && $request->status !== '') {

            $status = (int) $request->status;

            if (in_array($status, [0, 1])) {
                $query->where('status', $status);
            }
        }

        /*
        | Price
        */
        if ($request->filled('min_price')) {
            $query->where(
                'price',
                '>=',
                $request->min_price
            );
        }

        if ($request->filled('max_price')) {
            $query->where(
                'price',
                '<=',
                $request->max_price
            );
        }

        /*
        | Sort
        */
        switch ($request->sort) {

            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;

            case 'name_asc':
                $query->orderBy('product_name', 'asc');
                break;

            case 'name_desc':
                $query->orderBy('product_name', 'desc');
                break;

            case 'price_low':
                $query->orderBy('price', 'asc');
                break;

            case 'price_high':
                $query->orderBy('price', 'desc');
                break;

            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->get();

        $filename =
            'products_' .
            date('Y-m-d_H-i-s') .
            '.csv';

        return new StreamedResponse(
            function () use ($products) {

                $handle = fopen('php://output', 'w');

                fputcsv($handle, [
                    'ID',
                    'Product Name',
                    'Price',
                    'Size',
                    'Color',
                    'Description',
                    'Status',
                    'Created At',
                ]);

                foreach ($products as $product) {

                    fputcsv($handle, [
                        $product->id,
                        $product->product_name,
                        $product->price,
                        $product->size,
                        $product->color,
                        $product->description,
                        $product->status ? 'Active' : 'Inactive',
                        optional($product->created_at)
                            ->format('Y-m-d H:i:s'),
                    ]);
                }

                fclose($handle);
            },
            200,
            [
                'Content-Type' =>
                'text/csv; charset=UTF-8',

                'Content-Disposition' =>
                'attachment; filename="' .
                    $filename .
                    '"',
            ]
        );
    }
}
