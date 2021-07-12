<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Task;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //
    public function store(StoreTaskRequest $request)
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
//        dd($request, $categories, $task, $new_task,$new_task->categoriesTask());
        return Task::with('categoriesNames')->get();
    }

    public function index()
    {
        $task=Task::with('categoriesNames')->get();
        return $task;
//        return response()->json(['task'=>$task]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $task=Task::destroy($id);
        if($task===1){
            $tasks=Task::with('categoriesNames')->get();
            return response()->json( ['message'=>'Task deleted'],Response::HTTP_ACCEPTED );
        }
        return response()->json( ['error'=>'Task not found'],Response::HTTP_NOT_FOUND );
    }
}
