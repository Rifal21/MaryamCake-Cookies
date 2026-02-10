<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $isTemplate;

    public function __construct(bool $isTemplate = false)
    {
        $this->isTemplate = $isTemplate;
    }

    public function collection()
    {
        if ($this->isTemplate) {
            return collect([]);
        }
        return Product::with('category')->get();
    }

    public function headings(): array
    {
        return [
            'Category Name',
            'Product Name',
            'Slug',
            'Description',
            'Price',
            'Stock',
            'Active (1/0)',
            'Premium (1/0)',
        ];
    }

    public function map($product): array
    {
        return [
            $product->category->name ?? '',
            $product->name,
            $product->slug,
            $product->description,
            $product->price,
            $product->stock,
            $product->is_active,
            $product->is_premium,
        ];
    }
}
