<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Carbon\Carbon;

class UserDashboardController extends Controller
{
    /**
     * Get user's own activity
     */
    public function userActivity(Request $request)
    {
        try {
            $user = $request->user();
            $limit = $request->get('limit', 10);

            $activities = ActivityLog::where('user_id', $user->id)
                ->latest()
                ->take($limit)
                ->get()
                ->map(function ($activity) {
                    return [
                        'id' => $activity->id,
                        'title' => $activity->title,
                        'description' => $activity->description,
                        'icon' => $activity->icon,
                        'timestamp' => $activity->created_at,
                        'user' => [
                            'id' => $activity->user->id,
                            'name' => $activity->user->name,
                            'email' => $activity->user->email,
                        ],
                    ];
                });

            return response()->json([
                'status' => 'success',
                'data' => $activities,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to load user activity',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
