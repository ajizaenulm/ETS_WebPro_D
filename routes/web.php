<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController; // <-- THIS LINE IS LIKELY MISSING
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // <-- You might need this for the dashboard route
use Illuminate\Http\Request; // <-- ADD THIS



Route::get('/', function () {
    return redirect(route('login'));
});


Route::get('/dashboard', function (Request $request) { // <-- ADD Request $request
    
    $sort = $request->query('sort', 'created_at'); // Default to 'created_at'
    $tasksQuery = Auth::user()->tasks(); // Start the query

    if ($sort === 'deadline') {
        // Order by deadline, but put tasks with NO deadline at the end
        $tasksQuery->orderByRaw('deadline_at IS NULL ASC, deadline_at ASC');
    } else {
        // Default: newest tasks first
        $tasksQuery->orderBy('created_at', 'desc');
    }
    
    $tasks = $tasksQuery->get(); // Get the sorted results
    
    return view('dashboard', [
        'tasks' => $tasks,
        'currentSort' => $sort // Pass the current sort to the view
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Our New Task Routes
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
});

require __DIR__.'/auth.php';