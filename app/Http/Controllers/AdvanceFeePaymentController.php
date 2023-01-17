<?php

namespace App\Http\Controllers;

use App\Models\AdvanceFeePayment;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Response;
use Validator;

class AdvanceFeePaymentController extends Controller
{
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdvanceFeePayment  $advanceFeePayment
     * @return \Illuminate\Http\Response
     */
    public function show(AdvanceFeePayment $advanceFeePayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdvanceFeePayment  $advanceFeePayment
     * @return \Illuminate\Http\Response
     */
    public function edit(AdvanceFeePayment $advanceFeePayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AdvanceFeePayment  $advanceFeePayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdvanceFeePayment $advanceFeePayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdvanceFeePayment  $advanceFeePayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdvanceFeePayment $advanceFeePayment)
    {
        //
    } 
    /**
    * Update a resource for json
    * @return \Iluminate\Http\Response
    */
   public function make_payments_json(Request $request)
   {
       $rules = [ 
           'amount' => 'required|numeric',
           'id' => 'required|exists:students,id',
           'attendance.id' => 'required|exists:attendances,id',
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

        $payment = [
               'student_id'=> $request->input('id'),
               'amount' => $request->amount,
               'paid_at' => Carbon::now('Africa/Accra')->format('Y-m-d'),
               'paid_by' => $request->firstname.' '.$request->surname,
               'attendance_id' => $request->input('attendance.id'),
               'fee_type_id' => $request->input('fee_type_id'),
               'user_id' => auth()->user()->id,
        ];

        $dvfeepay = AdvanceFeePayment::updateOrCreate($payment);
       if($dvfeepay) {
               $out = [
                   'data' => $dvfeepay,
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
