<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Payment;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Response;
use Validator;

class PaymentController extends Controller
{
    /**
     * Display a listing of resource for tadatables
     * @return \Iluminate\Http\Response
     */
    public function datatable()
    {
        return DataTables::of(
            Payment::with('user:id,username,firstname,surname,email,rstate')
            ->with('student:id,studentid,firstname,surname,rstate,transit,affiliation')
            ->with('fee_type:id,title')
        )->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [ 
            'amount' => 'required|numeric',
            'paid_by' => 'required|string|max:100',
            'paid_at' => 'required|date',
            'feeTypes' => 'required|array',
            'student_id' => 'required|integer|exists:students,id',
            'bill_id' => 'required|integer|exists:bills,id'
        ];
        $validator = Validator::make($request->input(), $rules);
        $error = "";
        foreach($validator->errors()->messages() as $message){
            $error .= $message[0]."\n";
        }

        if ($validator->fails()) {
            $out = [
                'message' => trim($error),
                'status' => false,
                'input' => $request->all()
            ];
            return Response::json($out);
        }
        $payments  = [];
        foreach($request->input('feeTypes', []) as $feeType){
            $row = [
                'fee_type_id' => $feeType,
                'updated_at' => Carbon::now(),
                'created_at'=> Carbon::now(),
                'user_id' => auth()->user()->id,
            ];
            array_push($payments, $validator->safe()->merge($row)->except('feeTypes'));
        }

        $payment = Payment::insert($payments);

        if($payment){
            $out = [
                'message' => 'Payment made successfully!',
                'status' => true,
                'input' => $request->all()
            ];
        }else {
            $out = [
                'message' => "Data couldn't be processed! Please try again!",
                'status' => false,
                'input' => $request->all()
            ];
        }
        return Response::json($out);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        if($payment->delete()){
            $out = [
                'message' => 'Payment deleted successfully!',
                'status' => true,
            ];
        }else {
            $out = [
                'message' => "Payment couldn't be deleted!",
                'status' => false,
            ];
        }
        return Response::json($out);
    }

    /**
     * Update a resource for json
     * @return \Iluminate\Http\Response
     */
    public function attendance_student_payments_json(Request $request)
    {

        $rules = [ 
            'amount' => 'required|numeric',
            'student_id' => 'required|exists:students,id',
            'attendance_id' => 'required|exists:attendances,id',
            'attendance' => 'required|array',
            'student' => 'required|array',
        ];

        $validator = Validator::make($request->input(), $rules);
        $error = "";
        foreach($validator->errors()->messages() as $message){
            $error .= $message[0]."\n";
        }

        if ($validator->fails()) {
            $out = [
                'message' => trim($error),
                'status' => false,
                'input' => $request->all()
            ];
            return Response::json($out);
        }
        $bill = Bill::where([
            'bdate' => $request->input('attendance.adate'),
            'student_id' => $request->input('student_id')
            ])->first();
         $payment = [
                'student_id'=> $request->input('student_id'),
                'paid_at' => Carbon::now('Africa/Accra')->format('Y-m-d'),
                'paid_by' => $request->input('student.firstname').' '.$request->input('student.surname'),
                'bill_id' => $bill->id,
                'user_id' => auth()->user()->id,
         ];
         $payments = [];
         $feeBalance = floatval($request->input('amount'));
        foreach($bill->fees as $fee){
            $paid = $bill->payments()->where('fee_type_id', $fee->fee_type_id)->first();

            if(($paid?$paid->amount:0) < $fee->amount){
                array_push($payments, array_merge($payment,['fee_type_id' => $fee->fee_type_id, 'amount' => ( $feeBalance< $fee->amount?$feeBalance:$fee->amount )]));
                $feeBalance -= $fee->amount;
            }
            if($feeBalance <= 0) break;
        }
        
        if(Payment::insert($payments)) {
                $out = [
                    'data' => [
                        'balance' => $feeBalance,
                    ],
                    'message' => 'Payment made successfully!',
                    'status' => true,
                    'input' => $request->all()
                ];
            } else {
                $out = [
                    'message' => "Data couldn't be processed! Please try again!",
                    'status' => false,
                    'input' => $request->all()
                ];
            }
        return Response::json($out);
      
    }
}
