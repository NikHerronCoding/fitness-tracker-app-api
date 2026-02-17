<?php

  namespace App\Http\Controllers;
  
  use App\Models\WorkoutSession;                                                                                                         
  use Illuminate\Http\Request;  

  class WorkoutSessionController extends Controller
  {
      public function index(Request $request)
      {
          $userId = $request->user()->id;

          $sessions = WorkoutSession::forUser($userId)
              ->with([
                  'entries' => fn ($q) => $q->orderByRaw('COALESCE(position, id)'),
                  'entries.exerciseVariant.exercise',
                  'entries.sets' => fn ($q) => $q->orderByRaw('COALESCE(position, id)'),
              ])
              ->orderByDesc('started_at')
              ->get();

          return response()->json([
              'workout_sessions' => $sessions,
          ]);
      }
  }                                                                                                                               
        
