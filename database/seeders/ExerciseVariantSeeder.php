<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\MuscleGroup;
use Illuminate\Database\Seeder;

class ExerciseVariantSeeder extends Seeder
{
    public function run(): void
    {
        $bench = Exercise::firstOrCreate(
            ['name' => 'Bench Press', 'created_by_user_id' => null],
            ['category' => 'strength', 'equipment' => 'barbell']
        );

        $benchDefault = $bench->variants()->firstOrCreate(
            ['name' => 'Default'],
            ['is_default' => true]
        );

        $this->syncMuscles($benchDefault, [
            'chest' => 0.60,
            'triceps' => 0.25,
            'front_delts' => 0.15,
        ]);

        $closeGrip = $bench->variants()->firstOrCreate(
            ['name' => 'Close Grip'],
            ['is_default' => false]
        );

        $this->syncMuscles($closeGrip, [
            'chest' => 0.45,
            'triceps' => 0.40,
            'front_delts' => 0.15,
        ]);

        $squat = Exercise::firstOrCreate(
            ['name' => 'Squat', 'created_by_user_id' => null],
            ['category' => 'strength', 'equipment' => 'barbell']
        );

        $squatDefault = $squat->variants()->firstOrCreate(
            ['name' => 'Default'],
            ['is_default' => true]
        );

        $this->syncMuscles($squatDefault, [
            'quads' => 0.45,
            'glutes' => 0.30,
            'adductors' => 0.15,
            'erectors' => 0.10,
        ]);
    }

    private function syncMuscles($variant, array $distribution): void
    {
        $total = array_sum($distribution);
        if (abs($total - 1.0) > 0.001) {
            throw new \RuntimeException('Muscle proportions must sum to 1.0');
        }

        $pivotData = [];

        foreach ($distribution as $slug => $proportion) {
            $muscle = MuscleGroup::where('slug', $slug)->firstOrFail();
            $pivotData[$muscle->id] = [
                'proportion' => $proportion,
            ];
        }

        $variant->muscleGroups()->sync($pivotData);
    }
}
