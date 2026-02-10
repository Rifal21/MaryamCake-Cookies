<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function export()
    {
        return Excel::download(new ProductsExport, 'products-' . date('Y-m-d') . '.xlsx');
    }

    public function downloadTemplate()
    {
        return Excel::download(new ProductsExport(true), 'product-import-template.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new ProductsImport, $request->file('file'));

        return back()->with('success', 'Products imported successfully');
    }
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'description' => 'nullable|string',
            'image_file' => 'nullable|image|max:10240',
        ]);

        $data = $request->except('image_file');
        $data['slug'] = Str::slug($request->name) . '-' . time();
        $data['is_active'] = $request->has('is_active');
        $data['is_premium'] = $request->has('is_premium');

        if ($request->hasFile('image_file')) {
            $manager = new ImageManager(new Driver());
            $image = $manager->read($request->file('image_file'));
            $encoded = $image->toJpeg(80);

            $filename = 'products/' . uniqid() . '.jpg';
            Storage::disk('public')->put($filename, $encoded);

            $data['image'] = 'storage/' . $filename;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'description' => 'nullable|string',
            'image_file' => 'nullable|image|max:10240',
        ]);

        $data = $request->except('image_file');
        $data['is_active'] = $request->has('is_active');
        $data['is_premium'] = $request->has('is_premium');

        if ($request->hasFile('image_file')) {
            // Delete old image if exists
            if ($product->image) {
                $oldPath = str_replace('storage/', '', $product->image);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $manager = new ImageManager(new Driver());
            $image = $manager->read($request->file('image_file'));
            $encoded = $image->toJpeg(80);

            $filename = 'products/' . uniqid() . '.jpg';
            Storage::disk('public')->put($filename, $encoded);

            $data['image'] = 'storage/' . $filename;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }
}
