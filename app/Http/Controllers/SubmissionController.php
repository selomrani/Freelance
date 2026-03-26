<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function offer(Request $request, Task $task)
    {
        $validated = $request->validate(['message' => 'required|string',
            'offered_price' => 'required|numeric']);
        $validated['task_id'] = $task->id;
        $validated['offered_by'] = Auth::id();
        $sub = Submission::create($validated);

        return response()->json(['status' => 'success', 'message' => 'Offer submitted successfuly', 'offer' => $sub], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Submission $submission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Submission $submission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Submission $submission)
    {
        //
    }

    public function accept(Task $task, Submission $submission)
    {
        $alreadyAccepted = $task->offers()->where('status', 'accepted')->exists();

        if ($alreadyAccepted) {
            return response()->json([
                'message' => 'The client already accepted another submission/offer',
            ], 422);
        }
        $submission->status = 'accepted';
        $submission->save();
        $task->freelancer_id = $submission->offered_by;
        $task->save();

        return response()->json([
            'message' => 'Offer accepted successfully',
            'accepted_offer' => $submission,
            'offered_by' => $submission->offered_by(),
        ]);
    }
}
