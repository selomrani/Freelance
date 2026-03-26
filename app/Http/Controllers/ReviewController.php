<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Task;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function leaveReview(Request $request, Task $task)
    {
        $validated = $request->validate([
            'rating' => ['numeric', 'required'],
            'note' => ['string', 'required'],
        ]);
        $validated['task_id'] = $task->id;
        $validated['freelancer_id'] = $task->freelancer_id;
        $review = Review::create($validated);

        return response()->json(['message' => 'goood']);
    }
}
