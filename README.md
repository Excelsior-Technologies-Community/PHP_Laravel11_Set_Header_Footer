# 🚀 Laravel 11 Header–Footer Layout + Product CRUD  
### **Made with ❤️ by Hardik Panchal**

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-ff2d20?style=for-the-badge&logo=laravel" />
  <img src="https://img.shields.io/badge/PHP-8.2-blue?style=for-the-badge&logo=php" />
  <img src="https://img.shields.io/badge/UI-Blade Layouts-purple?style=for-the-badge" />
</p>

---

# 📌 Overview  
This project demonstrates how to build a **complete Header–Footer layout system using Blade templates** in Laravel, along with a **clean Product CRUD module**.

It includes:

- Blade Layout Architecture (`layout.blade.php`)  
- Header Component (`header.blade.php`)  
- Footer Component (`footer.blade.php`)  
- Product CRUD (Create, Read, Edit, Delete)  
- Migration + Controller + Model  
- Bootstrap UI  

---

# ⭐ Features  
- 🧱 Master Layout with `@include`  
- 🎨 Global Header & Footer  
- 📦 Full Product CRUD  
- 🖼 Image support  
- 📄 Clean folder structure  
- 🔧 Laravel Blade best practices  

---

# 📁 Folder Structure  

```
HEADER_FOOTER_USING_LAYOUT/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Controller.php
│   │   │   └── ProductController.php
│   │   └── Middleware/
│   │
│   ├── Models/
│   │   ├── Product.php
│   │   └── User.php
│   │
│   ├── Providers/
│   └── Console/
│
├── bootstrap/
├── config/
│
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   └── 2025_12_03_071312_create_products_table.php
│   └── seeders/
│
├── public/
│   ├── css/
│   ├── js/
│   └── index.php
│
├── resources/
│   ├── views/
│   │   ├── products/
│   │   │   ├── header.blade.php
│   │   │   ├── footer.blade.php
│   │   │   ├── layout.blade.php
│   │   │   ├── index.blade.php
│   │   │   └── create.blade.php
│   │   └── welcome.blade.php
│   │
│   ├── css/
│   └── js/
│
├── routes/
│   ├── web.php
│   └── console.php
│
├── storage/
├── tests/
│
├── .env
├── artisan
├── composer.json
├── package.json
├── vite.config.js
└── README.md

```

---

# ⚙ Installation  

```bash
composer create-project laravel/laravel blog "11.*"
```

---

# 🗄 Environment Setup  

Update `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=header      
DB_USERNAME=root        
DB_PASSWORD=             

```

---

# 🏗 Migration  

```bash
php artisan make:migration create_products_table --create=products
```

Migration contains:

- product_name  
- price  
- description  
- status  
- timestamps  

Run migration:

```bash
php artisan migrate
```

---

# 🧬 Model  

`app/Models/Product.php`

```php
class Product extends Model
{
    protected $fillable = [
        'product_name',
        'price',
        'description',
        'status'
    ];
}
```

---

# 🛣 Routes  

`routes/web.php`

```php
use App\Http\Controllers\ProductController;

Route::resource('products', ProductController::class);
```

---

# 🎮 Controller (Important Methods)

### Display Products  
```php
public function index() {
    $products = Product::latest()->get();
    return view('products.index', compact('products'));
}
```

### Store Product  
```php
public function store(Request $request) {
    $request->validate(['product_name' => 'required']);
    Product::create($request->all());
    return redirect()->route('products.index');
}
```

---

# 🖥 Blade Layout System  

## 📌 1. Master Layout (`layout.blade.php`)  

Contains:

- Header include  
- Footer include  
- `@yield('content')`  

```blade
@include('products.header')

<div class="container mt-4">
    @yield('content')
</div>

@include('products.footer')
```

---

## 📌 2. Header Component (`header.blade.php`)

- Navbar  
- Logo  
- Product links  

---

## 📌 3. Footer Component (`footer.blade.php`)

- Simple copyright footer  

---

# 📄 Blade Pages  

### index.blade.php  
- Product listing table  
- Edit/Delete buttons  

### create.blade.php  
- Form to add new product  

---

# ▶ Run Application  

```bash
php artisan serve
```

Visit:

```
http://localhost:8000/products
```

---

# 📸 Screenshots

<img width="1150" height="459" alt="image" src="https://github.com/user-attachments/assets/40c65a19-3a75-473f-90cb-a9eed9d47f27" />
