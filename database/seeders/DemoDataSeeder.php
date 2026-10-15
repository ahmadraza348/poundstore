<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\City;
use App\Models\Outlet;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * Demo content for presentations: categories, products, cities and branches.
 *
 * Run:  php artisan db:seed --class=DemoDataSeeder
 *
 * WARNING: this DELETES all existing categories, products, cities and outlets
 * and replaces them with the demo set. Admin users, contact messages and
 * franchise enquiries are not touched. Safe to run repeatedly.
 *
 * The content is curated (not Faker) so names and prices look realistic, and it
 * needs no dev-only packages, so it also runs on a `composer install --no-dev` server.
 * Images are bundled in public/frontend/assets/images/demo (no storage:link needed).
 * Branch addresses and map pins are illustrative demo data, not real locations.
 */
class DemoDataSeeder extends Seeder
{
    private const IMG = 'frontend/assets/images/demo';

    /** name, slug, featured, description, products[name, slug, price, tag] */
    private array $categories = [
        [
            'name' => 'Cosmetics',
            'slug' => 'cosmetics',
            'featured' => true,
            'description' => 'Everyday makeup, skin-care and hair-care basics at pocket-friendly prices.',
            'products' => [
                ['Matte Liquid Lipstick', 'matte-liquid-lipstick', 349, 'Best seller'],
                ['Waterproof Kajal Pencil', 'waterproof-kajal-pencil', 199, null],
                ['Volumizing Mascara', 'volumizing-mascara', 449, null],
                ['Compact Face Powder', 'compact-face-powder', 399, null],
                ['Hydrating Face Wash', 'hydrating-face-wash', 299, 'Best seller'],
                ['Aloe Vera Soothing Gel', 'aloe-vera-soothing-gel', 349, null],
                ['Rose Water Toner', 'rose-water-toner', 279, null],
                ['Nourishing Hand Cream', 'nourishing-hand-cream', 249, null],
                ['Sunscreen SPF 50', 'sunscreen-spf-50', 599, 'New'],
                ['Argan Hair Oil', 'argan-hair-oil', 499, null],
                ['Nail Polish Set of 6', 'nail-polish-set-of-6', 429, 'Gift idea'],
                ['Makeup Brush Set 12 Pcs', 'makeup-brush-set-12-pcs', 699, 'Value pack'],
            ],
        ],
        [
            'name' => 'Crockery',
            'slug' => 'crockery',
            'featured' => true,
            'description' => 'Mugs, plates, bowls and serving ware to set a good table every day.',
            'products' => [
                ['Ceramic Mug Set of 4', 'ceramic-mug-set-of-4', 799, 'Best seller'],
                ['Melamine Dinner Plate Set', 'melamine-dinner-plate-set', 1299, null],
                ['Glass Water Jug', 'glass-water-jug', 649, null],
                ['Porcelain Soup Bowls Set of 6', 'porcelain-soup-bowls-set-of-6', 999, null],
                ['Tea Cup and Saucer Set', 'tea-cup-and-saucer-set', 1199, 'Gift idea'],
                ['Steel Serving Spoon Set', 'steel-serving-spoon-set', 549, null],
                ['Glass Tumbler Set of 6', 'glass-tumbler-set-of-6', 599, 'Value pack'],
                ['Salad Serving Bowl', 'salad-serving-bowl', 449, null],
                ['Ceramic Teapot', 'ceramic-teapot', 1099, null],
                ['Cutlery Set 24 Pcs', 'cutlery-set-24-pcs', 1499, 'Value pack'],
                ['Oval Serving Platter', 'oval-serving-platter', 699, null],
                ['Butter Dish with Lid', 'butter-dish-with-lid', 349, 'New'],
            ],
        ],
        [
            'name' => 'Gifts',
            'slug' => 'gifts',
            'featured' => true,
            'description' => 'Thoughtful little presents for birthdays, weddings and every occasion in between.',
            'products' => [
                ['Scented Candle Jar', 'scented-candle-jar', 449, 'Gift idea'],
                ['Gold Photo Frame', 'gold-photo-frame', 399, null],
                ['Greeting Card Pack of 5', 'greeting-card-pack-of-5', 249, null],
                ['Plush Teddy Bear Medium', 'plush-teddy-bear-medium', 899, 'Best seller'],
                ['Gift Wrap Roll Set', 'gift-wrap-roll-set', 299, null],
                ['Mini Succulent Planter', 'mini-succulent-planter', 349, 'New'],
                ['Decorative Table Clock', 'decorative-table-clock', 799, null],
                ['Ceramic Love Mug', 'ceramic-love-mug', 499, 'Gift idea'],
                ['Jewellery Trinket Box', 'jewellery-trinket-box', 599, null],
                ['LED Fairy Lights 5m', 'led-fairy-lights-5m', 399, null],
                ['Rose Soap Flower Bouquet', 'rose-soap-flower-bouquet', 549, 'Gift idea'],
                ['Personalised Name Keychain', 'personalised-name-keychain', 299, null],
            ],
        ],
        [
            'name' => 'Stationary',
            'slug' => 'stationary',
            'featured' => true,
            'description' => 'Notebooks, pens, art supplies and desk essentials for school, office and home.',
            'products' => [
                ['A4 Notebook 200 Pages', 'a4-notebook-200-pages', 249, 'Best seller'],
                ['Gel Pen Pack of 10', 'gel-pen-pack-of-10', 199, null],
                ['Mechanical Pencil Set', 'mechanical-pencil-set', 299, null],
                ['Highlighter Set of 6', 'highlighter-set-of-6', 279, null],
                ['Neon Sticky Notes Pack', 'neon-sticky-notes-pack', 149, null],
                ['Geometry Box Set', 'geometry-box-set', 349, null],
                ['Colour Pencils 24 Shades', 'colour-pencils-24-shades', 449, 'Value pack'],
                ['Desk Organiser', 'desk-organiser', 799, null],
                ['Spiral Sketchbook A4', 'spiral-sketchbook-a4', 349, 'New'],
                ['Whiteboard Markers Pack of 4', 'whiteboard-markers-pack-of-4', 299, null],
                ['Stapler with Pins', 'stapler-with-pins', 249, null],
                ['Washi Tape Set of 8', 'washi-tape-set-of-8', 299, 'New'],
            ],
        ],
        [
            'name' => 'Toys',
            'slug' => 'toys',
            'featured' => true,
            'description' => 'Playtime favourites for every age, from building blocks to pretend play.',
            'products' => [
                ['Building Blocks 100 Pcs', 'building-blocks-100-pcs', 899, 'Best seller'],
                ['Remote Control Car', 'remote-control-car', 1799, null],
                ['Soft Plush Bunny', 'soft-plush-bunny', 749, null],
                ['Jigsaw Puzzle 120 Pcs', 'jigsaw-puzzle-120-pcs', 549, null],
                ['Doll House Play Set', 'doll-house-play-set', 1499, 'Gift idea'],
                ['Toy Kitchen Set', 'toy-kitchen-set', 1299, null],
                ['Wooden Alphabet Blocks', 'wooden-alphabet-blocks', 799, 'New'],
                ['Pull Back Cars Set of 6', 'pull-back-cars-set-of-6', 649, 'Value pack'],
                ['Play Sand Moulding Kit', 'play-sand-moulding-kit', 699, null],
                ['Water Gun Blaster', 'water-gun-blaster', 499, null],
                ['Family Card Game', 'family-card-game', 349, null],
                ['Musical Piano Toy', 'musical-piano-toy', 999, null],
            ],
        ],
        [
            'name' => 'Perfumes',
            'slug' => 'perfumes',
            'featured' => false,
            'description' => 'Eau de parfum, body mists and attars in fragrances for every mood.',
            'products' => [
                ['Oud Noir Eau de Parfum 100ml', 'oud-noir-eau-de-parfum-100ml', 2499, 'Best seller'],
                ['Rose Petal Body Mist 250ml', 'rose-petal-body-mist-250ml', 699, null],
                ['Fresh Citrus Pocket Perfume', 'fresh-citrus-pocket-perfume', 199, null],
                ['Vanilla Musk Attar 12ml', 'vanilla-musk-attar-12ml', 599, null],
                ['Ocean Breeze Eau de Toilette', 'ocean-breeze-eau-de-toilette', 1799, null],
                ['Jasmine Night Perfume Oil', 'jasmine-night-perfume-oil', 899, 'New'],
                ['Sandalwood Roll-On Attar', 'sandalwood-roll-on-attar', 449, null],
                ['Amber Gold Eau de Parfum', 'amber-gold-eau-de-parfum', 2199, 'Gift idea'],
                ['Cool Blue Deodorant Spray', 'cool-blue-deodorant-spray', 349, null],
                ['Lavender Linen Spray', 'lavender-linen-spray', 499, null],
                ['Mini Perfume Gift Set of 3', 'mini-perfume-gift-set-of-3', 1299, 'Gift idea'],
                ['Oud Incense Sticks Pack', 'oud-incense-sticks-pack', 299, null],
            ],
        ],
        [
            'name' => 'Home Essentials',
            'slug' => 'home-essentials',
            'featured' => false,
            'description' => 'Storage, bedding, lighting and small touches that make a house feel like home.',
            'products' => [
                ['Cotton Bath Towel', 'cotton-bath-towel', 699, 'Best seller'],
                ['Storage Basket with Lid', 'storage-basket-with-lid', 899, null],
                ['Wall Hanging Clock', 'wall-hanging-clock', 1199, null],
                ['Non-Slip Door Mat', 'non-slip-door-mat', 549, null],
                ['Cushion Cover Set of 2', 'cushion-cover-set-of-2', 799, null],
                ['LED Bulb 12W Pack of 3', 'led-bulb-12w-pack-of-3', 599, 'Value pack'],
                ['Plastic Storage Boxes Set of 3', 'plastic-storage-boxes-set-of-3', 999, null],
                ['Hanging Wall Shelf', 'hanging-wall-shelf', 1099, null],
                ['Printed Single Bed Sheet', 'printed-single-bed-sheet', 1499, 'New'],
                ['Clothes Hangers Pack of 12', 'clothes-hangers-pack-of-12', 349, null],
                ['Adhesive Wall Hooks Pack of 10', 'adhesive-wall-hooks-pack-of-10', 249, null],
                ['Modern Table Lamp', 'modern-table-lamp', 1699, null],
            ],
        ],
        [
            'name' => 'Cleaning & Laundry',
            'slug' => 'cleaning-laundry',
            'featured' => false,
            'description' => 'Dishwash, floor care, laundry and cleaning tools to keep things spotless.',
            'products' => [
                ['Lemon Dishwash Liquid 500ml', 'lemon-dishwash-liquid-500ml', 249, 'Best seller'],
                ['Lavender Floor Cleaner 1L', 'lavender-floor-cleaner-1l', 399, null],
                ['Laundry Detergent Powder 1kg', 'laundry-detergent-powder-1kg', 449, null],
                ['Glass Cleaner Spray 350ml', 'glass-cleaner-spray-350ml', 299, null],
                ['Microfibre Cloths Pack of 5', 'microfibre-cloths-pack-of-5', 249, 'Value pack'],
                ['Toilet Brush with Holder', 'toilet-brush-with-holder', 349, null],
                ['Spin Mop with Bucket', 'spin-mop-with-bucket', 1999, null],
                ['Scrub Sponges Pack of 10', 'scrub-sponges-pack-of-10', 199, null],
                ['Foldable Laundry Basket', 'foldable-laundry-basket', 799, 'New'],
                ['Garbage Bags Roll 30 Pcs', 'garbage-bags-roll-30-pcs', 299, null],
                ['Fabric Softener 1L', 'fabric-softener-1l', 549, null],
                ['Broom and Dustpan Set', 'broom-and-dustpan-set', 599, null],
            ],
        ],
        [
            'name' => 'Party Supplies',
            'slug' => 'party-supplies',
            'featured' => false,
            'description' => 'Balloons, banners, tableware and decorations for celebrations of any size.',
            'products' => [
                ['Balloon Pack 50 Pcs', 'balloon-pack-50-pcs', 349, 'Best seller'],
                ['Happy Birthday Banner', 'happy-birthday-banner', 249, null],
                ['Paper Cups Pack of 25', 'paper-cups-pack-of-25', 199, null],
                ['Party Hats Pack of 10', 'party-hats-pack-of-10', 199, null],
                ['Confetti Poppers Pack of 6', 'confetti-poppers-pack-of-6', 399, 'New'],
                ['Foil Number Balloon', 'foil-number-balloon', 299, null],
                ['Disposable Plates Pack of 25', 'disposable-plates-pack-of-25', 249, null],
                ['Plastic Table Cover Roll', 'plastic-table-cover-roll', 299, null],
                ['Birthday Candles Pack of 24', 'birthday-candles-pack-of-24', 149, null],
                ['Streamer Rolls Set of 6', 'streamer-rolls-set-of-6', 249, null],
                ['Party String Lights', 'party-string-lights', 399, 'Gift idea'],
                ['Party Gift Bags Pack of 6', 'party-gift-bags-pack-of-6', 349, 'Value pack'],
            ],
        ],
        [
            'name' => 'Bags & Accessories',
            'slug' => 'bags-accessories',
            'featured' => false,
            'description' => 'Backpacks, totes and everyday accessories for school, work and travel.',
            'products' => [
                ['School Backpack', 'school-backpack', 1999, 'Best seller'],
                ['Canvas Tote Bag', 'canvas-tote-bag', 599, null],
                ['Ladies Hand Bag', 'ladies-hand-bag', 1799, null],
                ['Travel Pouch Set of 3', 'travel-pouch-set-of-3', 799, 'Value pack'],
                ['Insulated Lunch Bag', 'insulated-lunch-bag', 899, null],
                ['Laptop Sleeve 15 Inch', 'laptop-sleeve-15-inch', 1199, null],
                ['Cross Body Sling Bag', 'cross-body-sling-bag', 1299, 'New'],
                ['Floral Coin Purse', 'floral-coin-purse', 299, null],
                ['Hair Scrunchie Pack of 6', 'hair-scrunchie-pack-of-6', 249, null],
                ['UV Protect Sunglasses', 'uv-protect-sunglasses', 699, null],
                ['Analog Wrist Watch', 'analog-wrist-watch', 1499, 'Gift idea'],
                ['Foldable Umbrella', 'foldable-umbrella', 899, null],
            ],
        ],
    ];

    /** name, district, province, latitude, longitude, code */
    private array $cities = [
        ['Lahore', 'Lahore', 'Punjab', 31.5204, 74.3587, 'LHR'],
        ['Islamabad', 'Islamabad', 'Islamabad Capital Territory', 33.6844, 73.0479, 'ISB'],
        ['Rawalpindi', 'Rawalpindi', 'Punjab', 33.5651, 73.0169, 'RWP'],
        ['Karachi', 'Karachi', 'Sindh', 24.8607, 67.0011, 'KHI'],
        ['Faisalabad', 'Faisalabad', 'Punjab', 31.4504, 73.135, 'FSD'],
        ['Gujranwala', 'Gujranwala', 'Punjab', 32.1877, 74.1945, 'GRW'],
        ['Multan', 'Multan', 'Punjab', 30.1575, 71.5249, 'MUX'],
        ['Peshawar', 'Peshawar', 'Khyber Pakhtunkhwa', 34.0151, 71.5249, 'PEW'],
        ['Sialkot', 'Sialkot', 'Punjab', 32.4945, 74.5229, 'SKT'],
        ['Sargodha', 'Sargodha', 'Punjab', 32.074, 72.6861, 'SGD'],
        ['Bahawalpur', 'Bahawalpur', 'Punjab', 29.3956, 71.6836, 'BHV'],
        ['Gujrat', 'Gujrat', 'Punjab', 32.5731, 74.0789, 'GRT'],
        ['Sheikhupura', 'Sheikhupura', 'Punjab', 31.7167, 73.985, 'SKP'],
        ['Hyderabad', 'Hyderabad', 'Sindh', 25.396, 68.3578, 'HYD'],
    ];

    /** city name => [area, address, landmark, latitude, longitude, type, featured] */
    private array $outlets = [
        'Lahore' => [
            ['Gulberg III', 'Shop 12, Main Boulevard, Gulberg III', 'Near Liberty Market roundabout', 31.514, 74.347, 'retail_store', true],
            ['DHA Phase 5', 'Plaza 8, Y-Block Commercial, DHA Phase 5', 'Opposite Y-Block Market', 31.472, 74.41, 'retail_store', false],
            ['Johar Town', 'Block R1, Main Canal Road, Johar Town', 'Near Emporium Mall', 31.469, 74.273, 'retail_store', false],
            ['Model Town', 'Link Road, Model Town', 'Near Model Town Park', 31.483, 74.325, 'retail_store', false],
            ['Mall Road', 'The Mall, Near GPO Chowk', 'Opposite Lahore GPO', 31.56, 74.327, 'retail_store', false],
        ],
        'Islamabad' => [
            ['F-10 Markaz', 'Shop 5, Ground Floor, F-10 Markaz', 'Near the F-10 food court', 33.694, 73.012, 'retail_store', true],
            ['Blue Area', 'Plot 14, Jinnah Avenue, Blue Area', 'Near Centaurus Mall', 33.709, 73.064, 'retail_store', false],
            ['I-8 Markaz', 'Block B, I-8 Markaz', 'Near I-8 Bank Square', 33.666, 73.075, 'retail_store', false],
        ],
        'Rawalpindi' => [
            ['Saddar', 'Bank Road, Saddar', 'Near Saddar Metro Station', 33.597, 73.05, 'retail_store', false],
            ['Bahria Town Phase 4', 'Civic Centre, Bahria Town Phase 4', 'Near Bahria Town Civic Centre', 33.517, 73.1, 'retail_store', false],
        ],
        'Karachi' => [
            ['Clifton Block 5', 'Shop 3, Do Talwar Road, Clifton Block 5', 'Near Do Talwar', 24.823, 67.031, 'retail_store', true],
            ['Gulshan-e-Iqbal', 'Block 13-D, Main University Road', 'Near Aladin Park', 24.918, 67.097, 'retail_store', false],
            ['North Nazimabad', 'Block H, Hyderi Market Road', 'Near Hyderi Market', 24.94, 67.037, 'retail_store', false],
            ['DHA Phase 6', 'Khayaban-e-Shahbaz, DHA Phase 6', 'Near Shahbaz Commercial', 24.797, 67.064, 'retail_store', false],
        ],
        'Faisalabad' => [
            ['D Ground', 'Main Boulevard, D Ground', 'Near D Ground Chowk', 31.4247, 73.0801, 'retail_store', false],
            ['Susan Road', 'Susan Road, Madina Town', 'Near Susan Road Roundabout', 31.4096, 73.098, 'retail_store', false],
        ],
        'Gujranwala' => [
            ['Central Warehouse', 'G.T. Road Industrial Estate', 'Near the G.T. Road bypass', 32.148, 74.167, 'warehouse', false],
            ['Satellite Town', 'Main Market, Satellite Town', 'Near Satellite Town Chowk', 32.166, 74.19, 'retail_store', true],
            ['Model Town', 'Block C, Model Town', 'Near Model Town Park', 32.183, 74.202, 'retail_store', false],
        ],
        'Multan' => [
            ['Cantt', 'Abdali Road, Multan Cantt', 'Near Nishtar Chowk', 30.193, 71.456, 'retail_store', false],
            ['Bosan Road', 'Bosan Road, Gulgasht', 'Near Bosan Road Flyover', 30.201, 71.47, 'retail_store', false],
        ],
        'Peshawar' => [
            ['University Town', 'University Road, University Town', 'Near the University Road signal', 34.002, 71.493, 'retail_store', false],
            ['Hayatabad Phase 3', 'Main Market, Hayatabad Phase 3', 'Near Hayatabad Market', 33.99, 71.438, 'retail_store', false],
        ],
        'Sialkot' => [
            ['Paris Road', 'Paris Road, Sialkot City', 'Near Paris Road Chowk', 32.489, 74.529, 'retail_store', false],
            ['Cantt', 'Shopping Centre, Sialkot Cantt', 'Near Cantt Shopping Centre', 32.5017, 74.5388, 'retail_store', false],
        ],
        'Sargodha' => [
            ['University Road', 'University Road, Sargodha', 'Near Satellite Town turn', 32.085, 72.67, 'retail_store', false],
        ],
        'Bahawalpur' => [
            ['Farid Gate', 'Farid Gate Market, Bahawalpur', 'Near Farid Gate', 29.3957, 71.683, 'retail_store', false],
        ],
        'Gujrat' => [
            ['G.T. Road', 'G.T. Road, Gujrat', 'Near Gujrat Bypass', 32.572, 74.08, 'retail_store', false],
        ],
        'Sheikhupura' => [
            ['Lahore Road', 'Lahore Road, Sheikhupura', 'Near Sheikhupura Chowk', 31.714, 73.983, 'retail_store', false],
        ],
        'Hyderabad' => [
            ['Latifabad', 'Unit 7, Latifabad', 'Near Latifabad Chowk', 25.377, 68.34, 'retail_store', false],
            ['Qasimabad', 'Main Road, Qasimabad', 'Near Qasimabad Roundabout', 25.404, 68.301, 'retail_store', false],
        ],
    ];

    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Product::truncate();
        Outlet::truncate();
        City::truncate();
        Category::truncate();
        Schema::enableForeignKeyConstraints();

        $this->seedCatalogue();
        $this->seedStoreNetwork();

        $this->command?->info(sprintf(
            'Demo data ready: %d categories, %d products, %d cities, %d outlets.',
            Category::count(), Product::count(), City::count(), Outlet::count()
        ));
    }

    private function seedCatalogue(): void
    {
        foreach ($this->categories as $row) {
            $category = Category::create([
                'name'        => $row['name'],
                'slug'        => $row['slug'],
                'description' => $row['description'],
                'image'       => self::IMG . '/categories/' . $row['slug'] . '.png',
                'is_featured' => $row['featured'],
                'status'      => true,
            ]);

            foreach ($row['products'] as $i => [$name, $slug, $price, $tag]) {
                Product::create([
                    'category_id' => $category->id,
                    'name'        => $name,
                    'slug'        => $slug,
                    'price'       => $price,
                    'tag'         => $tag,
                    'image'       => self::IMG . '/products/' . $slug . '.png',
                    'description' => $name . ' from our ' . $row['name'] . ' range. Availability varies by branch.',
                    'is_featured' => $tag === 'Best seller',
                    'status'      => true,
                ]);
            }
        }
    }

    private function seedStoreNetwork(): void
    {
        foreach ($this->cities as $i => [$name, $district, $province, $lat, $lon, $code]) {
            $city = City::create([
                'name'       => $name,
                'slug'       => Str::slug($name),
                'district'   => $district,
                'province'   => $province,
                'latitude'   => $lat,
                'longitude'  => $lon,
                'status'     => true,
                'sort_order' => $i + 1,
            ]);

            foreach ($this->outlets[$name] ?? [] as $n => [$area, $address, $landmark, $olat, $olon, $type, $featured]) {
                $isWarehouse = $type === 'warehouse';

                Outlet::create([
                    'city_id'           => $city->id,
                    'name'              => $isWarehouse ? 'Pound Store Central Warehouse' : 'Pound Store ' . $area,
                    'slug'              => Str::slug('pound-store-' . $area . '-' . $name),
                    'branch_code'       => sprintf('PS-%s-%02d', $code, $n + 1),
                    'outlet_type'       => $type,
                    'area'              => $area,
                    'address'           => $address . ', ' . $name,
                    'landmark'          => $landmark,
                    'phone'             => '0347 0006050',
                    'whatsapp'          => '0347 0006050',
                    'latitude'          => $olat,
                    'longitude'         => $olon,
                    'location_verified' => true,
                    'opening_hours'     => $this->hours($isWarehouse),
                    'description'       => 'Demo listing for ' . $area . ', ' . $name . '.',
                    'is_featured'       => $featured,
                    'status'            => true,
                    'sort_order'        => $n + 1,
                ]);
            }
        }
    }

    private function hours(bool $warehouse): array
    {
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $hours = [];

        foreach ($days as $day) {
            $hours[$day] = $warehouse
                ? ($day === 'sunday' ? ['closed' => true] : ['open' => '9:00 AM', 'close' => '6:00 PM'])
                : ['open' => '10:00 AM', 'close' => '10:00 PM'];
        }

        return $hours;
    }
}
