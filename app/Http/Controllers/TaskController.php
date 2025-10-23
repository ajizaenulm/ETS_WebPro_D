<?php // <-- Make sure this is at the very top

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Update the specified task in storage.
     */
    public function toggle(Task $task) // <-- RENAMED from 'update'
    {
        // Check if the authenticated user is the owner of the task
        if (Auth::user()->id !== $task->user_id) {
            abort(403); // Unauthorized
        }

        $task->update([
            'is_completed' => !$task->is_completed,
        ]);

        return redirect(route('dashboard'));
    }
    /**
     * Store a new task in storage.
     */
    public function store(Request $request)
    {
        // 1. Add validation for the description
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string', // <-- ADD THIS
            'deadline_at' => 'nullable|date', // <-- ADD THIS VALIDATION
        ]);

        // 2. Add the description to the create() method
        Auth::user()->tasks()->create([
            'title' => $request->title,
            'description' => trim($request->description), // <-- ADD THIS
            'deadline_at' => $request->deadline_at, // <-- ADD THIS
        ]);

        return redirect(route('dashboard'));
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Task $task)
    {
        // Check if the authenticated user is the owner of the task
        if (Auth::user()->id !== $task->user_id) {
            abort(403); // Unauthorized
        }
        
        $task->delete();

        return redirect(route('dashboard'));
    }

    // app/Http/Controllers/TaskController.php

    // ... (Your store and toggle methods are here) ...

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Task $task)
    {
        // Check if the authenticated user is the owner of the task
        if (Auth::user()->id !== $task->user_id) {
            abort(403); // Unauthorized
        }

        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    /**
     * Update the specified task in storage.
     */
    public function update(Request $request, Task $task)
    {
        // Check if the authenticated user is the owner of the task
        if (Auth::user()->id !== $task->user_id) {
            abort(403); // Unauthorized
        }

        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline_at' => 'nullable|date', // <-- ADD THIS VALIDATION
        ]);

        // Update the task
        $task->update([
            'title' => $request->title,
            'description' => trim($request->description),
            'deadline_at' => $request->deadline_at, // <-- ADD THIS
        ]);

        return redirect(route('dashboard'));
    }
}