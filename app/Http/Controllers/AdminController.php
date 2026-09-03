<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        $totalProducts = Product::count();

        $activeProducts = Product::where(
            'status',
            1
        )->count();

        $inactiveProducts = Product::where(
            'status',
            0
        )->count();

        $recentProducts = Product::oldest()
            ->take(5)
            ->get();

        return view(
            'admin.dashboard',
            compact(
                'totalProducts',
                'activeProducts',
                'inactiveProducts',
                'recentProducts'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Admin Products
    |--------------------------------------------------------------------------
    */

    public function productsIndex(Request $request)
    {
        $query = Product::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where(
                    'product_name',
                    'like',
                    '%' . $search . '%'
                )
                    ->orWhere(
                        'description',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'color',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'size',
                        'like',
                        '%' . $search . '%'
                    );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if (
            $request->status !== null &&
            $request->status !== ''
        ) {

            $status = (int) $request->status;

            if (in_array($status, [0, 1])) {

                $query->where(
                    'status',
                    $status
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Min Price
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
        | Max Price
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
        | Sorting
        |--------------------------------------------------------------------------
        */

        switch ($request->sort) {

            case 'oldest':
                $query->orderBy(
                    'created_at',
                    'asc'
                );
                break;

            case 'name_asc':
                $query->orderBy(
                    'product_name',
                    'asc'
                );
                break;

            case 'name_desc':
                $query->orderBy(
                    'product_name',
                    'desc'
                );
                break;

            case 'price_low':
                $query->orderBy(
                    'price',
                    'asc'
                );
                break;

            case 'price_high':
                $query->orderBy(
                    'price',
                    'desc'
                );
                break;

            case 'newest':
            default:
                $query->orderBy(
                    'created_at',
                    'desc'
                );
                break;
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $products = $query
            ->paginate(5)
            ->withQueryString();

        return view(
            'admin.products.index',
            compact('products')
        );
    }

    public function productsCreate()
    {
        return view(
            'admin.products.create'
        );
    }

    public function productsStore(Request $request)
    {
        $request->validate([

            'product_name' =>
            'required|regex:/^[A-Za-z\s]+$/',

            'color' =>
            'nullable|regex:/^[A-Za-z\s]+$/',

            'price' =>
            'required|numeric|min:0',

            'image' =>
            'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            // SEO
            'seo_meta_title' =>
            'nullable|string|max:255',

            'seo_meta_description' =>
            'nullable|string|max:500',

            'seo_meta_key' =>
            'nullable|string|max:500',

            'seo_meta_image' =>
            'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'seo_canonical' =>
            'nullable|url|max:500',

            // Open Graph
            'og_meta_title' =>
            'nullable|string|max:255',

            'og_meta_description' =>
            'nullable|string|max:500',

            'og_meta_key' =>
            'nullable|string|max:500',

            'og_meta_image' =>
            'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [

            'product_name' =>
            $request->product_name,

            'price' =>
            $request->price,

            'size' =>
            $request->size,

            'color' =>
            $request->color,

            'description' =>
            $request->description,

            'status' =>
            $request->status ?? 1,

            // SEO
            'seo_meta_title' =>
            $request->seo_meta_title,

            'seo_meta_description' =>
            $request->seo_meta_description,

            'seo_meta_key' =>
            $request->seo_meta_key,

            'seo_canonical' =>
            $request->seo_canonical,

            // Open Graph
            'og_meta_title' =>
            $request->og_meta_title,

            'og_meta_description' =>
            $request->og_meta_description,

            'og_meta_key' =>
            $request->og_meta_key,
        ];

        /*
        |--------------------------------------------------------------------------
        | Main Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $imageName =
                'product_' .
                time() .
                '_' .
                uniqid() .
                '.' .
                $request->image->extension();

            $request->image->move(
                public_path('images'),
                $imageName
            );

            $data['image'] = $imageName;
        }

        /*
        |--------------------------------------------------------------------------
        | SEO Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('seo_meta_image')) {

            $seoImageName =
                'seo_' .
                time() .
                '_' .
                uniqid() .
                '.' .
                $request->seo_meta_image->extension();

            $request->seo_meta_image->move(
                public_path('images'),
                $seoImageName
            );

            $data['seo_meta_image'] =
                $seoImageName;
        }

        /*
        |--------------------------------------------------------------------------
        | OG Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('og_meta_image')) {

            $ogImageName =
                'og_' .
                time() .
                '_' .
                uniqid() .
                '.' .
                $request->og_meta_image->extension();

            $request->og_meta_image->move(
                public_path('images'),
                $ogImageName
            );

            $data['og_meta_image'] =
                $ogImageName;
        }

        Product::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with(
                'success',
                'Product Added Successfully'
            );
    }

    public function productsEdit($id)
    {
        $product = Product::findOrFail($id);

        return view(
            'admin.products.edit',
            compact('product')
        );
    }

    public function productsUpdate(
        Request $request,
        $id
    ) {
        $product = Product::findOrFail($id);

        $request->validate([

            'product_name' =>
            'required|regex:/^[A-Za-z\s]+$/',

            'color' =>
            'nullable|regex:/^[A-Za-z\s]+$/',

            'price' =>
            'required|numeric|min:0',

            'image' =>
            'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            // SEO
            'seo_meta_title' =>
            'nullable|string|max:255',

            'seo_meta_description' =>
            'nullable|string|max:500',

            'seo_meta_key' =>
            'nullable|string|max:500',

            'seo_meta_image' =>
            'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'seo_canonical' =>
            'nullable|url|max:500',

            // Open Graph
            'og_meta_title' =>
            'nullable|string|max:255',

            'og_meta_description' =>
            'nullable|string|max:500',

            'og_meta_key' =>
            'nullable|string|max:500',

            'og_meta_image' =>
            'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [

            'product_name' =>
            $request->product_name,

            'price' =>
            $request->price,

            'size' =>
            $request->size,

            'color' =>
            $request->color,

            'description' =>
            $request->description,

            'status' =>
            $request->status ?? 0,

            // SEO
            'seo_meta_title' =>
            $request->seo_meta_title,

            'seo_meta_description' =>
            $request->seo_meta_description,

            'seo_meta_key' =>
            $request->seo_meta_key,

            'seo_canonical' =>
            $request->seo_canonical,

            // Open Graph
            'og_meta_title' =>
            $request->og_meta_title,

            'og_meta_description' =>
            $request->og_meta_description,

            'og_meta_key' =>
            $request->og_meta_key,
        ];

        /*
        |--------------------------------------------------------------------------
        | Main Image
        |--------------------------------------------------------------------------
        */

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

            $imageName =
                'product_' .
                time() .
                '_' .
                uniqid() .
                '.' .
                $request->image->extension();

            $request->image->move(
                public_path('images'),
                $imageName
            );

            $data['image'] = $imageName;
        }

        /*
        |--------------------------------------------------------------------------
        | SEO Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('seo_meta_image')) {

            if (
                $product->seo_meta_image &&
                file_exists(
                    public_path(
                        'images/' .
                            $product->seo_meta_image
                    )
                )
            ) {
                unlink(
                    public_path(
                        'images/' .
                            $product->seo_meta_image
                    )
                );
            }

            $seoImageName =
                'seo_' .
                time() .
                '_' .
                uniqid() .
                '.' .
                $request->seo_meta_image->extension();

            $request->seo_meta_image->move(
                public_path('images'),
                $seoImageName
            );

            $data['seo_meta_image'] =
                $seoImageName;
        }

        /*
        |--------------------------------------------------------------------------
        | OG Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('og_meta_image')) {

            if (
                $product->og_meta_image &&
                file_exists(
                    public_path(
                        'images/' .
                            $product->og_meta_image
                    )
                )
            ) {
                unlink(
                    public_path(
                        'images/' .
                            $product->og_meta_image
                    )
                );
            }

            $ogImageName =
                'og_' .
                time() .
                '_' .
                uniqid() .
                '.' .
                $request->og_meta_image->extension();

            $request->og_meta_image->move(
                public_path('images'),
                $ogImageName
            );

            $data['og_meta_image'] =
                $ogImageName;
        }

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with(
                'success',
                'Product Updated Successfully'
            );
    }

    public function productsDestroy($id)
    {
        $product = Product::findOrFail($id);

        $images = [
            $product->image,
            $product->seo_meta_image,
            $product->og_meta_image,
        ];

        foreach ($images as $image) {

            if (
                $image &&
                file_exists(
                    public_path(
                        'images/' . $image
                    )
                )
            ) {
                unlink(
                    public_path(
                        'images/' . $image
                    )
                );
            }
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with(
                'success',
                'Product Deleted Successfully'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Toggle Status
    |--------------------------------------------------------------------------
    */

    public function productsToggleStatus($id)
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
    | CSV Export
    |--------------------------------------------------------------------------
    */

    public function productsExportCsv(
        Request $request
    ) {
        $query = Product::query();

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where(
                    'product_name',
                    'like',
                    '%' . $search . '%'
                )
                    ->orWhere(
                        'description',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'color',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'size',
                        'like',
                        '%' . $search . '%'
                    );
            });
        }

        if (
            $request->status !== null &&
            $request->status !== ''
        ) {

            $status = (int) $request->status;

            if (in_array($status, [0, 1])) {

                $query->where(
                    'status',
                    $status
                );
            }
        }

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

        switch ($request->sort) {

            case 'oldest':
                $query->orderBy(
                    'created_at',
                    'asc'
                );
                break;

            case 'name_asc':
                $query->orderBy(
                    'product_name',
                    'asc'
                );
                break;

            case 'name_desc':
                $query->orderBy(
                    'product_name',
                    'desc'
                );
                break;

            case 'price_low':
                $query->orderBy(
                    'price',
                    'asc'
                );
                break;

            case 'price_high':
                $query->orderBy(
                    'price',
                    'desc'
                );
                break;

            default:
                $query->orderBy(
                    'created_at',
                    'desc'
                );
                break;
        }

        $products = $query->get();

        $filename =
            'admin_products_' .
            date('Y-m-d_H-i-s') .
            '.csv';

        return new StreamedResponse(
            function () use ($products) {

                $handle =
                    fopen(
                        'php://output',
                        'w'
                    );

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

                        $product->status
                            ? 'Active'
                            : 'Inactive',

                        optional(
                            $product->created_at
                        )->format(
                            'Y-m-d H:i:s'
                        ),
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

    /*
    |--------------------------------------------------------------------------
    | Site Settings
    |--------------------------------------------------------------------------
    */

    public function settings()
    {
        $settings = SiteSetting::first();

        return view(
            'admin.settings',
            compact('settings')
        );
    }

    public function settingsUpdate(
        Request $request
    ) {
        $request->validate([

            'site_name' =>
            'required|string|max:255',

            'site_email' =>
            'required|email',

            'site_phone' =>
            'nullable|string|max:20',

            'site_address' =>
            'nullable|string|max:500',

            'site_logo' =>
            'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'site_favicon' =>
            'nullable|image|mimes:jpg,jpeg,png,webp,ico|max:1024',

            'footer_description' =>
            'nullable|string|max:1000',

            'copyright_text' =>
            'nullable|string|max:255',

            'privacy_policy_url' =>
            'nullable|url|max:500',

            'terms_url' =>
            'nullable|url|max:500',

            'return_policy_url' =>
            'nullable|url|max:500',

            'facebook_url' =>
            'nullable|url|max:500',

            'instagram_url' =>
            'nullable|url|max:500',

            'twitter_url' =>
            'nullable|url|max:500',

            'linkedin_url' =>
            'nullable|url|max:500',

            'youtube_url' =>
            'nullable|url|max:500',

            'site_meta_description' =>
            'nullable|string|max:500',
        ]);

        $settings =
            SiteSetting::firstOrCreate();

        $data = [

            'site_name' =>
            $request->site_name,

            'site_email' =>
            $request->site_email,

            'site_phone' =>
            $request->site_phone,

            'site_address' =>
            $request->site_address,

            'footer_description' =>
            $request->footer_description,

            'copyright_text' =>
            $request->copyright_text,

            'privacy_policy_url' =>
            $request->privacy_policy_url,

            'terms_url' =>
            $request->terms_url,

            'return_policy_url' =>
            $request->return_policy_url,

            'facebook_url' =>
            $request->facebook_url,

            'instagram_url' =>
            $request->instagram_url,

            'twitter_url' =>
            $request->twitter_url,

            'linkedin_url' =>
            $request->linkedin_url,

            'youtube_url' =>
            $request->youtube_url,

            'site_meta_description' =>
            $request->site_meta_description,
        ];

        /*
        |--------------------------------------------------------------------------
        | Logo
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('site_logo')) {

            if (
                $settings->site_logo &&
                file_exists(
                    public_path(
                        'images/' .
                            $settings->site_logo
                    )
                )
            ) {
                unlink(
                    public_path(
                        'images/' .
                            $settings->site_logo
                    )
                );
            }

            $logoName =
                'logo_' .
                time() .
                '_' .
                uniqid() .
                '.' .
                $request->site_logo->extension();

            $request->site_logo->move(
                public_path('images'),
                $logoName
            );

            $data['site_logo'] =
                $logoName;
        }

        /*
        |--------------------------------------------------------------------------
        | Favicon
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('site_favicon')) {

            if (
                $settings->site_favicon &&
                file_exists(
                    public_path(
                        'images/' .
                            $settings->site_favicon
                    )
                )
            ) {
                unlink(
                    public_path(
                        'images/' .
                            $settings->site_favicon
                    )
                );
            }

            $faviconName =
                'favicon_' .
                time() .
                '_' .
                uniqid() .
                '.' .
                $request->site_favicon->extension();

            $request->site_favicon->move(
                public_path('images'),
                $faviconName
            );

            $data['site_favicon'] =
                $faviconName;
        }

        $settings->update($data);

        return redirect()
            ->route('admin.settings')
            ->with(
                'success',
                'Settings Updated Successfully'
            );
    }
}
