<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');
        
        $query = Todo::query();
        
        if ($filter === 'pending') {
            $query->where('completed', false);
        } elseif ($filter === 'completed') {
            $query->where('completed', true);
        }
        
        $todos = $query->latest()->get();
        
        $totalCount = Todo::count();
        $pendingCount = Todo::where('completed', false)->count();
        $completedCount = Todo::where('completed', true)->count();
        
       return view('todo', compact('todos', 'filter', 'totalCount', 'pendingCount', 'completedCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required|string|min:3|max:255' // Added min:3 for consistency
        ]);

       Todo::create([
    'task' => $request->task,
    'description' => $request->description,
    'priority' => $request->priority,
    'due_date' => $request->due_date,
]);
        return redirect()->route('todos.index')
                        ->with('success', 'Task added successfully!');
    }

    // ADD THIS NEW UPDATE METHOD
    public function update(Request $request, Todo $todo)
{
    $request->validate([
        'task' => 'required|string|min:3|max:255',
        'description' => 'nullable|string',
        'priority' => 'nullable|in:low,medium,high',
        'due_date' => 'nullable|date',
    ]);

    $todo->update([
        'task' => $request->task,
        'description' => $request->description,
        'priority' => $request->priority,
        'due_date' => $request->due_date,
    ]);

    return redirect()->route('todos.index')
                    ->with('success', 'Task updated successfully!');
}

    public function toggle(Todo $todo)
    {
        $todo->update(['completed' => !$todo->completed]);

        $status = $todo->fresh()->completed ? 'completed' : 'incomplete'; // Use fresh() to get updated value
        return redirect()->route('todos.index')
                        ->with('success', "Task marked as $status!");
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();

        return redirect()->route('todos.index')
                        ->with('success', 'Task deleted successfully!');
    }
}