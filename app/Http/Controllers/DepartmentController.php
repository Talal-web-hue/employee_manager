<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function store(Request $request)
    {
     $request->validate(
        [
            'name'=>'required|string|min:3',
            'description'=>'required|string|min:6',
        ]);
        $dept = Department::create(
            [
                'name'=>$request->name,
                'description'=>$request->description,
            ]);
            return response()->json(
                [
                 'message'=>'created successfully'
                ] , 201);
    }


    //  تابع التعديل على القسم
    public function update(Request $request , $id)
    {
     $request->validate(
        [
            'name'=>'string|min:3',  
            'description'=>'string|min:6',
        ]);
        $dept = Department::find($id);   // للبحث عن القسم يلي بدي أعدل عليه
        if(!$dept)
            {
           return response()->json(
            [
                'message'=>'the department is not found'
            ] , 404);
            }

            $dept->update($request->all());
            return response()->json(
                [
                 'message'=>'updated successfully'
                ] , 201);
    }

    // تابع يقوم بعملية حذف القسم 
    public function delete($id)
    {
      $dept = Department::find($id);
      if(!$dept)
        {
        return response()->json(
            [
             'message'=>'القسم الذي ترد حذفه غير موجود أو أنك قمت بحذفه مسبقا'
            ] , 404);
        }

        $dept->delete();
        return response()->json(
            [
                'message'=>'تم الحذف بنجاح'
            ] , 200);
    }

    public function getEmployeesCountInDepartment() // تابع لجلب عدد الموظفين في كل قسم
    {
     $department = Department::withCount('employees')->get();
     $result = $department->map(function($dept){
       return[
        'id'=>$dept->id,
        'name'=>$dept->name,
        'employee_count'=>$dept->employees_count,
       ];
     });

     return response()->json(
        [
            'message'=>'تم جلب عدد الموظفين في كل قسم بنجاح' ,
            'data'=>$result
        ] , 200);
    }
}
