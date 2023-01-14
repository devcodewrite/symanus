<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Classes;
use App\Models\FeeType;
use App\Models\Student;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use PhpParser\Builder\Class_;
use Validator;

class ReportingController extends Controller
{
    
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function billsByClass(Request $request)
    {
        $data = [
            'feeTypes' => [],
            'classes' => [],
        ];

        if($request->input()){
            $rules = [ 
                'report_from' => 'required|date',
                'report_to' => 'required|date',
            ];
            $validator = Validator::make($request->input(), $rules);
            if ($validator->fails()) {

            }
            $data['feeTypes']= FeeType::all();
            $data['reportFrom'] =  $request->input('report_from');
            $data['reportTo'] =  $request->input('report_to');
            $data['classes'] = Classes::with(['bills'])
                            ->get();
        }
        return view('reporting.bills-by-class', $data);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function billsByUser(Request $request)
    {
        $data = [
            'feeTypes' => [],
            'users' => [],
        ];

        if($request->input()){
            $rules = [ 
                'report_from' => 'required|date',
                'report_to' => 'required|date',
            ];
            $validator = Validator::make($request->input(), $rules);
            if ($validator->fails()) {

            }
            $data['feeTypes']= FeeType::all();
            $data['reportFrom'] =  $request->input('report_from');
            $data['reportTo'] =  $request->input('report_to');
            $data['users'] = User::with(['bills:id'])
                            ->get();
        }
        return view('reporting.bills-by-user', $data);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function incomeByClass(Request $request)
    {
        $data = [
            'feeTypes' => [],
            'classes' => [],
        ];

        if($request->input()){
            $rules = [ 
                'report_from' => 'required|date',
                'report_to' => 'required|date',
            ];
            $validator = Validator::make($request->input(), $rules);
            if ($validator->fails()) {

            }
            $data['feeTypes']= FeeType::all();
            $data['reportFrom'] =  $request->input('report_from');
            $data['reportTo'] =  $request->input('report_to');
            $data['classes'] = Classes::with(['payments'])->get();
        }
        return view('reporting.income-by-class', $data);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function incomeByUser(Request $request)
    {
        $data = [
            'feeTypes' => [],
            'users' => [],
        ];

        if($request->input()){
            $rules = [ 
                'report_from' => 'required|date',
                'report_to' => 'required|date',
            ];
            $validator = Validator::make($request->input(), $rules);
            if ($validator->fails()) {

            }
            $data['feeTypes']= FeeType::all();
            $data['reportFrom'] =  $request->input('report_from');
            $data['reportTo'] =  $request->input('report_to');
            $data['users'] = User::with(['payments'])->get();
        }
        return view('reporting.income-by-user', $data);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function studentBalances(Request $request)
    {
        $data = [
            'feeTypes' => [],
            'students' => [],
            'class' => null,
        ];

        if($request->input()){
            $rules = [ 
                'report_from' => 'required|date',
                'report_to' => 'required|date',
                'class_id' => 'required|integer|exists:classes,id',
            ];
            $validator = Validator::make($request->input(), $rules);
            if ($validator->fails()) {

            }
            $classId = $request->input('class_id');
            $data['feeTypes']= FeeType::all();
            $data['class'] = Classes::find($classId);
            $data['reportFrom'] =  $request->input('report_from');
            $data['reportTo'] =  $request->input('report_to');
            $data['students'] = Student::with(['payments:id', 'bills:id'])
                            ->where('class_id', $classId)
                            ->get();
        }
        return view('reporting.student-balances', $data);
    }
}
