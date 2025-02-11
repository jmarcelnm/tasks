<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = Task::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->has('completed')) {
            $query->where('completed', $request->input('completed'));
        }

        if ($request->has('sort_by')) {
            $sortBy = $request->input('sort_by');
            $sortOrder = $request->input('sort_order', 'asc');

            $query->orderBy($sortBy, $sortOrder);
        }

        $tasks = $query->paginate($request->input('per_page', 10));

        return response()->json($tasks);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param StoreTaskRequest $request
     * @return JsonResponse
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = Task::create($request->validated());

        return response()->json([
            'message' => 'Task created successfully',
            'task' => $task
        ], 201);
    }

    /**
     * Display the specified resource.
     * 
     * @param int|string $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $task = Task::findOrFail($id);

        return response()->json([
            'message' => 'Task retrieved successfully',
            'task' => $task
        ], 201);
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @param int|string $id
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);

        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param UpdateTaskRequest $request
     * @param int|string $id
     * @return JsonResponse
     */
    public function update(UpdateTaskRequest $request, $id): JsonResponse
    {
        $task = Task::findOrFail($id);

        if ($task->update($request->validated())) {
            return response()->json([
                'message' => 'Task updated successfully',
                'task' => $task,
            ], 200);
        }

        return response()->json([
            'message' => 'Task could not be updated'
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param int|string $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $task = Task::findOrFail($id);

        if ($task->delete()) {
            return response()->json([
                'message' => 'Task deleted successfully'
            ], 200);
        }

        return response()->json([
            'message' => 'Task could not be deleted'
        ], 500);
    }
}
