<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalProducts = Product::count();
        $activeProducts = Product::where('status', 1)->count();
        $inactiveProducts = Product::where('status', 0)->count();
        $recentProducts = Product::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalProducts', 'activeProducts', 'inactiveProducts', 'recentProducts'));
    }

    public function productsIndex()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function productsCreate()
    {
        return view('admin.products.create');
    }

    public function productsStore(Request $request)
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
            'status'       => $request->status ?? 1,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product Added Successfully');
    }

    public function productsEdit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function productsUpdate(Request $request, $id)
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

        return redirect()->route('admin.products.index')->with('success', 'Product Updated Successfully');
    }

    public function productsDestroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image && file_exists(public_path('images/' . $product->image))) {
            unlink(public_path('images/' . $product->image));
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product Deleted Successfully');
    }

    public function settings()
    {
        $settings = SiteSetting::first();
        return view('admin.settings', compact('settings'));
    }

    public function settingsUpdate(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email',
            'site_phone' => 'nullable|string|max:20',
            'site_address' => 'nullable|string|max:500',
            'site_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'site_favicon' => 'nullable|image|mimes:jpg,jpeg,png,webp,ico|max:1024',
        ]);

        $settings = SiteSetting::firstOrCreate();

        $data = [
            'site_name' => $request->site_name,
            'site_email' => $request->site_email,
            'site_phone' => $request->site_phone,
            'site_address' => $request->site_address,
        ];

        if ($request->hasFile('site_logo')) {
            if ($settings->site_logo && file_exists(public_path('images/' . $settings->site_logo))) {
                unlink(public_path('images/' . $settings->site_logo));
            }
            $logoName = 'logo_' . time() . '.' . $request->site_logo->extension();
            $request->site_logo->move(public_path('images'), $logoName);
            $data['site_logo'] = $logoName;
        }

        if ($request->hasFile('site_favicon')) {
            if ($settings->site_favicon && file_exists(public_path('images/' . $settings->site_favicon))) {
                unlink(public_path('images/' . $settings->site_favicon));
            }
            $faviconName = 'favicon_' . time() . '.' . $request->site_favicon->extension();
            $request->site_favicon->move(public_path('images'), $faviconName);
            $data['site_favicon'] = $faviconName;
        }

        $settings->update($data);

        return redirect()->route('admin.settings')->with('success', 'Settings Updated Successfully');
    }
}
