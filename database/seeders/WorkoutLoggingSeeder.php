<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class WorkoutLoggingSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Pick an existing user (adjust if you want a specific email)
        $userId = DB::table('users')->min('id');
        if (!$userId) {
            throw new \RuntimeException('No users found. Create a user first.');
        }

        DB::transaction(function () use ($userId, $now) {
            // Pick a couple existing exercise variants
            $variantIds = DB::table('exercise_variants')->orderBy('id')->limit(2)->pluck('id')->all();
            if (count($variantIds) < 2) {
                throw new \RuntimeException('Need at least 2 exercise_variants seeded first.');
            }

            // Session 1 (ended)
            $session1Id = DB::table('workout_sessions')->insertGetId([
                'user_id' => $userId,
                'started_at' => $now->copy()->subDays(2)->setTime(17, 10),
                'ended_at' => $now->copy()->subDays(2)->setTime(18, 5),
                'notes' => 'Seed: lower day',
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            // Entry 1
            $entry1Id = DB::table('workout_entries')->insertGetId([
                'workout_session_id' => $session1Id,
                'exercise_variant_id' => $variantIds[0],
                'position' => 1,
                'notes' => 'Seed: controlled eccentric',
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            // Sets for Entry 1
            DB::table('workout_sets')->insert([
                [
                    'workout_entry_id' => $entry1Id,
                    'position' => 1,
                    'weight' => 140.00,
                    'reps' => 6,
                    'rir' => 2.0,
                    'notes' => 'Seed: moved fast',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'workout_entry_id' => $entry1Id,
                    'position' => 2,
                    'weight' => 140.00,
                    'reps' => 6,
                    'rir' => 1.0,
                    'notes' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'workout_entry_id' => $entry1Id,
                    'position' => 3,
                    'weight' => 135.00,
                    'reps' => 8,
                    'rir' => null,
                    'notes' => 'Seed: backoff',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);

            // Entry 2
            $entry2Id = DB::table('workout_entries')->insertGetId([
                'workout_session_id' => $session1Id,
                'exercise_variant_id' => $variantIds[1],
                'position' => 2,
                'notes' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            // Sets for Entry 2
            DB::table('workout_sets')->insert([
                [
                    'workout_entry_id' => $entry2Id,
                    'position' => 1,
                    'weight' => 60.00,
                    'reps' => 12,
                    'rir' => 3.0,
                    'notes' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'workout_entry_id' => $entry2Id,
                    'position' => 2,
                    'weight' => 60.00,
                    'reps' => 12,
                    'rir' => 2.0,
                    'notes' => 'Seed: burn',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);

            // Session 2 (active, not ended)
            $session2Id = DB::table('workout_sessions')->insertGetId([
                'user_id' => $userId,
                'started_at' => $now->copy()->subHours(3),
                'ended_at' => null,
                'notes' => 'Seed: active session',
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            // One entry in active session (no sets yet)
            DB::table('workout_entries')->insert([
                'workout_session_id' => $session2Id,
                'exercise_variant_id' => $variantIds[0],
                'position' => 1,
                'notes' => 'Seed: warmup only',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        });
    }
}
