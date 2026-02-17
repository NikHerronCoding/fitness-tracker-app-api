<?php

namespace Database\Seeders;

use App\Models\MuscleGroup;
use Illuminate\Database\Seeder;

class MuscleGroupSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            // Upper body
            ['chest', 'Chest', 'upper_body'],
            ['triceps', 'Triceps', 'upper_body'],
            ['biceps', 'Biceps', 'upper_body'],
            ['front_delts', 'Front Delts', 'upper_body'],
            ['side_delts', 'Side Delts', 'upper_body'],
            ['rear_delts', 'Rear Delts', 'upper_body'],
            ['lats', 'Lats', 'upper_body'],
            ['upper_back', 'Upper Back', 'upper_body'],

            // Lower body
            ['quads', 'Quadriceps', 'lower_body'],
            ['hamstrings', 'Hamstrings', 'lower_body'],
            ['glutes', 'Glutes', 'lower_body'],
            ['adductors', 'Adductors', 'lower_body'],
            ['calves', 'Calves', 'lower_body'],

            // Core
            ['abs', 'Abdominals', 'core'],
            ['erectors', 'Spinal Erectors', 'core'],
        ];

        foreach ($groups as [$slug, $name, $region]) {
            MuscleGroup::firstOrCreate(
                ['slug' => $slug],
                ['name' => $name, 'region_slug' => $region]
            );
        }
    }
}
