<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::factory()->create([
            'name' => 'Admin Maryam',
            'email' => 'admin@maryam.com',
            'password' => bcrypt('password'),
        ]);

        // Categories
        $cookiesCat = Category::create([
            'name' => 'Cookies',
            'slug' => 'cookies',
        ]);

        $cakesCat = Category::create([
            'name' => 'Cakes',
            'slug' => 'cakes',
        ]);

        $customCat = Category::create([
            'name' => 'Custom',
            'slug' => 'custom',
        ]);

        // Products - Cookies
        Product::create([
            'category_id' => $cookiesCat->id,
            'name' => 'Premium Assorted Cookies',
            'slug' => 'premium-assorted-cookies',
            'description' => 'A selection of our finest handmade cookies, perfect for any occasion.',
            'price' => 85000,
            'image' => 'images/cookies.png',
            'stock' => 100,
            'is_premium' => true,
        ]);

        Product::create([
            'category_id' => $cookiesCat->id,
            'name' => 'Red Velvet Dream Cookies',
            'slug' => 'red-velvet-dream-cookies',
            'description' => 'Deep crimson cookies with a hint of cocoa and white chocolate chips.',
            'price' => 90000,
            'image' => 'images/cookies.png',
            'stock' => 80,
            'is_premium' => false,
        ]);

        Product::create([
            'category_id' => $cookiesCat->id,
            'name' => 'Matcha White Choco',
            'slug' => 'matcha-white-choco',
            'description' => 'Premium Japanese matcha paired with creamy white chocolate chunks.',
            'price' => 95000,
            'image' => 'images/cookies.png',
            'stock' => 60,
            'is_premium' => false,
        ]);

        Product::create([
            'category_id' => $cookiesCat->id,
            'name' => 'Nutty Almond Crunch',
            'slug' => 'nutty-almond-crunch',
            'description' => 'Butter cookies loaded with roasted California almonds and a touch of sea salt.',
            'price' => 85000,
            'image' => 'images/cookies.png',
            'stock' => 120,
            'is_premium' => false,
        ]);

        // Products - Cakes
        Product::create([
            'category_id' => $cakesCat->id,
            'name' => 'Fudgy Walnut Brownies',
            'slug' => 'fudgy-walnut-brownies',
            'description' => 'Rich, dark chocolate brownies with a fudgy center and crunchy walnuts.',
            'price' => 120000,
            'image' => 'images/brownies.png',
            'stock' => 50,
            'is_premium' => true,
        ]);

        Product::create([
            'category_id' => $cakesCat->id,
            'name' => 'Signature Tiramisu',
            'slug' => 'signature-tiramisu',
            'description' => 'Classic Italian dessert with espresso-soaked ladyfingers and mascarpone cream.',
            'price' => 150000,
            'image' => 'images/brownies.png',
            'stock' => 40,
            'is_premium' => true,
        ]);

        Product::create([
            'category_id' => $cakesCat->id,
            'name' => 'Zesty Lemon Cake',
            'slug' => 'zesty-lemon-cake',
            'description' => 'Refreshing lemon-infused sponge cake with a light and tangy glaze.',
            'price' => 110000,
            'image' => 'images/brownies.png',
            'stock' => 35,
            'is_premium' => false,
        ]);

        Product::create([
            'category_id' => $cakesCat->id,
            'name' => 'Belgian Chocolate Ganache',
            'slug' => 'belgian-chocolate-ganache',
            'description' => 'Decadent layer cake smothered in smooth, high-quality Belgian chocolate.',
            'price' => 180000,
            'image' => 'images/brownies.png',
            'stock' => 25,
            'is_premium' => true,
        ]);

        // Products - Custom
        Product::create([
            'category_id' => $customCat->id,
            'name' => 'Custom Celebration Cake',
            'slug' => 'custom-celebration-cake',
            'description' => 'Beautifully crafted custom cakes for birthdays, weddings, or anniversaries.',
            'price' => 350000,
            'image' => 'images/custom-cake.png',
            'stock' => 10,
            'is_premium' => true,
        ]);

        Product::create([
            'category_id' => $customCat->id,
            'name' => 'Kids Birthday Special',
            'slug' => 'kids-birthday-special',
            'description' => 'Fun and colorful themed cakes designed to make your child\'s birthday magical.',
            'price' => 280000,
            'image' => 'images/custom-cake.png',
            'stock' => 15,
            'is_premium' => true,
        ]);

        Product::create([
            'category_id' => $customCat->id,
            'name' => 'Elegant Wedding Tiers',
            'slug' => 'elegant-wedding-tiers',
            'description' => 'Stunning multi-tiered cakes tailored to your wedding theme and flavors.',
            'price' => 1500000,
            'image' => 'images/custom-cake.png',
            'stock' => 5,
            'is_premium' => true,
        ]);

        Product::create([
            'category_id' => $customCat->id,
            'name' => 'Corporate Milestone Cake',
            'slug' => 'corporate-milestone-cake',
            'description' => 'Professional and grand cakes to celebrate your company\'s achievements.',
            'price' => 500000,
            'image' => 'images/custom-cake.png',
            'stock' => 8,
            'is_premium' => true,
        ]);
    }
}
