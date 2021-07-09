<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //
    public function create(StoreTaskRequest $request)
    {
        $categories = $request->get('categories', []);
        $task = $request->get('task', '');
        $new_task = Task::create([
            'name_task' => $task,
        ]);
        if (count($categories) > 0) {
            $array_mass_assign = array_map(function ($item) {
                return ['categories_id' => $item];
            }, $categories);
            $new_task->categoriesTask()
                ->createMany($array_mass_assign);
        }
        dd($request, $categories, $task, $new_task);
    }
    public function index()
    {
        $tasks=Task::with('categoriesNames')->get();
    }
}
