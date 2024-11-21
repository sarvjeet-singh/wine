<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cuisine;

class CuisineSeeder extends Seeder
{
    public function run()
    {
        $cuisines = [
            ['name' => 'African', 'slug' => 'african', 'description' => 'Diverse and rich flavors from the African continent.', 'status' => 1],
            ['name' => 'American', 'slug' => 'american', 'description' => 'Classic American dishes and flavors.', 'status' => 1],
            ['name' => 'American Bistro', 'slug' => 'american-bistro', 'description' => 'A fusion of American and European bistro cuisine.', 'status' => 1],
            ['name' => 'BBQ', 'slug' => 'bbq', 'description' => 'Smoky and grilled meats, often served with sauces.', 'status' => 1],
            ['name' => 'Brazilian', 'slug' => 'brazilian', 'description' => 'Flavorful dishes including rice, beans, and meat.', 'status' => 1],
            ['name' => 'Breakfast', 'slug' => 'breakfast', 'description' => 'Hearty meals to start your day.', 'status' => 1],
            ['name' => 'Cajun', 'slug' => 'cajun', 'description' => 'Spicy dishes originating from Louisiana.', 'status' => 1],
            ['name' => 'Caribbean', 'slug' => 'caribbean', 'description' => 'Vibrant flavors from the Caribbean islands.', 'status' => 1],
            ['name' => 'Chinese', 'slug' => 'chinese', 'description' => 'A variety of flavors and styles from China.', 'status' => 1],
            ['name' => 'Cuban', 'slug' => 'cuban', 'description' => 'Rich and flavorful dishes from Cuba.', 'status' => 1],
            ['name' => 'Ethiopian', 'slug' => 'ethiopian', 'description' => 'Unique spices and communal dining culture.', 'status' => 1],
            ['name' => 'Filipino', 'slug' => 'filipino', 'description' => 'A mix of indigenous and foreign flavors.', 'status' => 1],
            ['name' => 'French', 'slug' => 'french', 'description' => 'Sophisticated and varied culinary traditions.', 'status' => 1],
            ['name' => 'German', 'slug' => 'german', 'description' => 'Hearty meals featuring meats, potatoes, and bread.', 'status' => 1],
            ['name' => 'Greek', 'slug' => 'greek', 'description' => 'Mediterranean flavors with fresh ingredients.', 'status' => 1],
            ['name' => 'Indian', 'slug' => 'indian', 'description' => 'A wide variety of spices and cooking techniques.', 'status' => 1],
            ['name' => 'Italian', 'slug' => 'italian', 'description' => 'Classic pasta and pizza dishes.', 'status' => 1],
            ['name' => 'Jamaican', 'slug' => 'jamaican', 'description' => 'Bold flavors and spices from Jamaica.', 'status' => 1],
            ['name' => 'Japanese', 'slug' => 'japanese', 'description' => 'Delicate flavors and presentation, including sushi.', 'status' => 1],
            ['name' => 'Korean', 'slug' => 'korean', 'description' => 'Spicy and savory dishes, often with fermented ingredients.', 'status' => 1],
            ['name' => 'Mexican', 'slug' => 'mexican', 'description' => 'Rich and vibrant dishes with various flavors.', 'status' => 1],
            ['name' => 'Middle Eastern', 'slug' => 'middle-eastern', 'description' => 'A blend of spices and flavors from the Middle East.', 'status' => 1],
            ['name' => 'Tapas', 'slug' => 'tapas', 'description' => 'Small plates and appetizers from Spain.', 'status' => 1],
            ['name' => 'Thai', 'slug' => 'thai', 'description' => 'Bold flavors with a balance of sweet, sour, and spicy.', 'status' => 1],
            ['name' => 'Vietnamese', 'slug' => 'vietnamese', 'description' => 'Fresh ingredients and aromatic dishes.', 'status' => 1],
        ];

        foreach ($cuisines as $cuisine) {
            Cuisine::create($cuisine);
        }
    }
}

