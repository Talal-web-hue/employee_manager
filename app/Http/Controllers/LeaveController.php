<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    //  store of the leave 
    public function store(Request $request)
    {
      $request->validate(
        [
            'employee_id'=>'required|integer|exists:employees,id',
            'type'=>'required',
            'status'=>'required',
            'start_date'=>'required|date',
            'end_date'=>'required|date',
            'days_count'=>'required|integer'
        ]);

        $leave = Leave::create(
            [
                'employee_id'=>$request->employee_id,
                'type'=>$request->type,
                'status'=>$request->status,
                'start_date'=>$request->start_date,
                'end_date'=>$request->end_date,
                'days_count'=>$request->days_count,
            ]);
            return response()->json(
                [
                'message'=>'تم إنشاء الإجازة بنجاح' ,
                $leave
                ] , 201);
    }


    //  تابع التعديل على الإجازة

    public function update(Request $request , $idLeave)
    {
     $request->validate(
        [
            'employee_id'=>'nullable|integer|exists:employees,id',
            'type'=>'nullable|sometimes',
            'status'=>'nullable|sometimes',
            'start_date'=>'nullable|date',
            'end_date'=>'nullable|date',
            'days_count'=>'nullable|integer'
        ]);
        $leave = Leave::find($idLeave);
        if(!$idLeave)
            {
             return response()->json(
                [
                    'message'=>'الإجازة التي تريد التعديل عليها غير موجودة أو أنك قمت بحذفها مسبقا'
                ] , 404);
            }
        $leave->update($request->all());
        return response()->json(
            [
                'message'=>'تم التعديل بنجاح' ,
                $leave
            ] , 201);
    }

    //  تابع حذف الإجازة 
    
    public function delete($idLeave)
    {
     $leave = Leave::find($idLeave);
     if(!$leave)
        {
         return response()->json(
            [
                'message'=>'الإجازة التي تريد حذفها غير موجودة أو أنك قمت بحذفها من قبل'
            ] , 404);
        }

        $leave->delete();
        return response()->json(
            [
            'message'=>'تم الحذف بنجاح'                
            ] , 200);
    }
}



