<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Find or create category
        $categoryName = $row['category_name'];
        $category = Category::firstOrCreate(['name' => $categoryName], [
            'slug' => Str::slug($categoryName)
        ]);

        return new Product([
            'category_id' => $category->id,
            'name'        => $row['product_name'],
            'slug'        => $row['slug'] ?? Str::slug($row['product_name']),
            'description' => $row['description'],
            'price'       => $row['price'],
            'stock'       => $row['stock'] ?? 0,
            'is_active'   => $row['active_10'] ?? 1,
            'is_premium'  => $row['premium_10'] ?? 0,
            'image'       => 'images/products/default.jpg', // Placeholder for imports
        ]);
    }
}
