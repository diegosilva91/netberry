<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Task extends Model
{
    //
    protected $fillable = ['name_task'];

    public function categoriesNames(): HasManyThrough
    {
        return $this->hasManyThrough(
            Categories::class, TaskCategories::class, 'task_id', 'id', 'id', 'categories_id'
        );
        //                                               task_categories.task_id     categories.id   task.id
    }
    public function categoriesTask(){
        return $this->hasMany(TaskCategories::class,'task_id');
    }
}
