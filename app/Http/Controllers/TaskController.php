<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use League\CommonMark\Extension\TaskList\TaskListExtension;

class TaskController extends Controller
{
    //  تابع انشاء مهمة لموظف 
    public function store(Request $request)
{
    $validated = $request->validate([
        'employee_id' => 'required|integer|exists:employees,id',
        'title' => 'required|string|max:50',
        'description' => 'nullable|string|max:200',
        'due_date' => 'required|date',
        'status' => 'required|in:new,in_progress,completed' // أو القيم العربية إذا اخترت ذلك
    ]);

    $task = Task::create($validated);

    return response()->json([
        'message' => 'تم إنشاء المهمة بنجاح',
        'data' => $task
    ], 201);
}


    // تابع التعديل على مهمة معينة
    
    public function update(Request $request , $idTask)
    {
     $request->validate([
        'employee_id'=>'integer|exists:employees,id',
        'title'=>'string|max:50',
         'description'=>'string|max:200',
         'due_date'=>'date',
        'status' => 'required|in:new,in_progress,completed' // أو القيم العربية إذا اخترت ذلك
     ]);
     
      $task = Task::find($idTask);
     if(!$task)
        {
         return response()->json(
            [
                'message'=>'The Task is not found'
            ] , 404);
        }

        $task->update($request->all());
        return response()->json(
            [
                'message'=>'تم التعديل بنجاح' ,
                $task
            ] , 201);
    }


    // تابع حذف مهمة لموظف
    public function delete($idTask)
    {
    $task = Task::find($idTask);
    if(!$task)
        {
         return response()->json(
            [
             'message'=>'المهمة التي تريد حذفها غير موجودة او أنك قمت بحذفها مسبقا'
            ] , 404);
        }

        $task->delete();
        return response()->json(
            [
                'message'=>'تم حذف المهمة بنجاح'
            ] , 200);
    }
}


