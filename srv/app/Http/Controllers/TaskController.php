<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //
    public function create(StoreTaskRequest $request)
    {
        $categories=$request->get('categories',[]);
        $task=$request->get('task','');
        $new_task=Task::create([
            ''=>$task,
        ]);
        dd($request,$categories,$task);
    }
}
