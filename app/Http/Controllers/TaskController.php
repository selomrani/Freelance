<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all();

        return response()->json(['status' => 'success', 'tasks' => $tasks]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'budget' => 'required|numeric',
            'technologies' => 'required|array',
            'type' => 'required|string',
            // 'status' => 'required|in:pending,accepted,completed',
        ]);
        $validated['created_by'] = Auth::user()->id;

        $task = Task::create($validated);

        return response()->json(['status' => 'success', 'message' => 'task was created successfully', 'task' => $task], 201);
    }

    /**
     * Display the specified resource.
     */
    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        // Since we're using Route Model Binding, $task is already fetched
        return response()->json([
            'status' => 'success',
            'task' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'budget' => 'sometimes|required|numeric',
            'technologies' => 'sometimes|required|array',
            'type' => 'sometimes|required|string',
            'status' => 'sometimes|required|in:pending,accepted,completed',
        ]);
        $task->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Task updated successfully',
            'task' => $task,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json(['status' => 'sucess', 'message' => 'Task was deleted successfuly']);
    }
}
