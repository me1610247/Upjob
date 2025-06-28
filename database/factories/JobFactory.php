<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class JobFactory extends Factory
{
    public function definition(): array
    {
        $cairoLocations = [
            ['name' => 'Hadayek El Qobba', 'lat' => 30.0766, 'lng' => 31.2814],  // حدائق القبة
            ['name' => 'Heliopolis (Masr El Gedida)', 'lat' => 30.0901, 'lng' => 31.3394], // مصر الجديدة
            ['name' => 'El Waily', 'lat' => 30.0572, 'lng' => 31.2772],  // الوايلي


        ];

        $location = $this->faker->randomElement($cairoLocations);

        return [
            'title' => $this->faker->randomElement(['Apartment', 'Villa', 'Duplex']) . ' in ' . $location['name'],
            'category_id' => rand(1, 4),
            'job_type_id' => rand(1, 5),
            'user_id' => rand(1, 6),
            'vacancy' => rand(1, 10),
            'salary' => $this->faker->numberBetween(1000000, 15000000),
            'location' => $location['name'],
            'latitude' => $location['lat'] + $this->faker->randomFloat(5, -0.002, 0.002), // slight random offset
            'longitude' => $location['lng'] + $this->faker->randomFloat(5, -0.002, 0.002),
            'description' => $this->generatePropertyDescription(),
            'benefits' => implode(', ', $this->faker->randomElements([
                'Swimming Pool',
                'Garden',
                'Parking',
                'Security',
                'GYM',
                'Spa',
                'Club House',
                'Kids Area',
                'Green Spaces'
            ], rand(3, 6))),
            'responsibility' => $this->faker->randomElement([null, $this->faker->paragraphs(2, true)]),
            'qualifications' => $this->faker->randomElement([null, $this->faker->paragraphs(2, true)]),
            'keywords' => implode(', ', $this->faker->words(5)),
            'experience' => $this->faker->randomElement(['Furnished', 'Semi-Furnished', 'Unfurnished']),
            'company_name' => $this->faker->randomElement([
                'Tatweer Misr',
                'Emaar Misr',
                'Ora Developers',
                'Palm Hills',
                'Mountain View',
                'SODIC',
                'Madinet Masr',
                'Al Ahly Sabbour',
                'Misr Italia',
                'Rooya Group'
            ]),
            'company_location' => $location['name'] . ', Cairo, Egypt',
            'company_website' => $this->faker->url,
            'image' => 'job_images/property' . rand(1, 20) . '.jpg',
            'residential_type' => $this->faker->randomElement(['Apartment', 'Villa', 'Studio']),
            'bathrooms' => $this->faker->numberBetween(1, 6),
            'created_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
        ];
    }


    protected function generatePropertyDescription(): string
    {
        $descriptions = [
            'Beautifully designed ' . $this->faker->randomElement(['modern', 'classic', 'contemporary', 'luxurious']) . ' property with stunning views.',
            'Spacious ' . $this->faker->randomElement(['family', 'executive', 'luxury']) . ' home in a prime location.',
            'Newly built ' . $this->faker->randomElement(['residence', 'villa', 'apartment']) . ' with high-end finishes.',
            'Exclusive ' . $this->faker->randomElement(['compound', 'gated community', 'residential project']) . ' unit with premium amenities.',
            'Elegant ' . $this->faker->randomElement(['property', 'home', 'residence']) . ' in one of Cairo\'s most sought-after neighborhoods.'
        ];

        return $this->faker->randomElement($descriptions) . ' ' . $this->faker->paragraphs(2, true);
    }
}
