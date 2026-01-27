<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class EmployeeController extends Controller
{

    // عملية تسجيل أو إنشاء موظف
    public function store(Request $request)
    {
        $user = Auth::user(); // بتجبلي معلومات المستخدم الحالي
        if(!$user)
        {
            return response()->json(
                [
                    'message'=>'أنت غير مسجل دخولك أو حسابك غير موجود'
                ] , 401);
        }
         $validated = $request->validate(
            [
                'first_name'=>'required|max:15|string',
                'last_name'=>'required|max:15|string',
                'department_id'=>'required|integer',
                'email'=>'required|max:100|string|unique:employees,email',
                'phone'=>'max:15|string',
                'position'=>'required|max:50|string',
                'salary'=>'required|numeric',
                'hire_date'=>'required|date',
                'employee_number'=>'required|string|unique:employees,employee_number',
            ]);
        $employee = Employee::create($validated);
        return response()->json(
            [
                'message'=>'تم تسجيل الموظف بنجاح' ,
                $employee
            ], 201);
    }





    // عملية التعديل على معلومات الموظف

    public function update(Request $request , $employeeNumber)
    {
        $employee = Employee::where('employee_number', $employeeNumber);
        if(!$employee)
        {
            return response()->json(
                [
                    'message'=>'الموظف الذي تريد تعديل معلوماته غير موجود'
                ] , 404);
        }
         $employee->update($request->all());
        return response()->json(
            [
                'message'=>'تم التعديل بنجاح' ,
                $employee->get()
            ], 200);
    }





  //    الاستعلام عن موظف بناءا على رقمه الفريد employee_number
  public function show($employeeNumber)
{
    $employee = Employee::where('employee_number', $employeeNumber)->first();

    if (!$employee) { 
        return response()->json([
            'message' => 'الموظف الذي تريد عرض معلوماته غير موجود'
        ], 404);
    }

    return response()->json($employee);
}


  //  عرض جميع الموظفين
  public function index()
  {
        $employees = Employee::all();
        return response()->json($employees);
  }



//   حذف الموظف بناءا على رقمه الفريد
 public function destroy($employeeNumber)
  {
    $employee = Employee::where('employee_number' , $employeeNumber)->first();
    if(!$employee)
    {
        return response()->json(
            [
                'message'=>'الموظف الذي تريد حذفه غير موجود او أنك قمت بحذفه مسبقا'
            ] , 404);
    }

        $employee->delete();
        return response()->json(
            [
                'message'=>'تم حذف الموظف بنجاح'
            ] , 200);
  }

//  تابع البحث عن الموظف حسب رقمه الفريد و المسمى الوظيفي له

    public function search(Request $request)
    {
     $request->validate(
        [
            'employee_number'=>'string|nullable',
            'position'=>'string|nullable'
        ]);

        // إذا المستخدم لم يرسل أي معلومات عندها سوف يرجع الرسالة التالية 
        if(! $request->filled('employee_number') && ! $request->filled('position'))
            {
            return response()->json(
                [
                    'message'=>'يرجى إرسال رقم الموظف أو المسمى الوظيفي لكي يتم البحث'
                ] , 400);
            }
       $query = Employee::query();   // بناء الاستعلام
       if($request->filled('employee_number')){
       $query->where('employee_number' , $request->employee_number);
       }
       if($request->filled('position')){
       $query->where('position' ,'Like' , '%' . $request->position . '%');
       }
      
       $employees = $query->get();
       return response()->json(
        [
        'message'=> 'تم العثور على الموظفين التالية اسماؤهم' ,
        'data'=>$employees ,
        'عدد الموظفين'=>$employees->count()
        ] , 200);
       }
}