<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\SMS;
use App\Models\SMSCredit;
use Http;
use Illuminate\Http\Request;
use Response;
use Validator;

class SMSController extends Controller
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
        return view('sms.edit');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function topup(Request $request)
    {
        if ($request->input()) {
            $rules = [
                'action' => 'required|in:confirm',
                'ref' => 'required|string',
            ];
            $validator = Validator::make($request->input(), $rules);

            $validator = Validator::make($request->input(), $rules);
            $error = "";
            foreach ($validator->errors()->messages() as $message) {
                $error .= $message[0] . "\n";
            }

            if ($validator->fails()) {
                $out = [
                    'message' => trim($error),
                    'status' => false,
                    'input' => $request->all()
                ];
            }
            else {
                if(!SMSCredit::find($request->ref)){
                    $response = (object) Http::withToken(env('MIX_PAYSTACK_SECRET_KEY'))
                            ->get(env('MIX_PAYSTACK_BASE_URL')."/transaction/verify/$request->ref")
                            ->json();
                    
                    if(!$response->status){
                        $out = [
                            'message' => $response->message,
                            'status' => false,
                            'input' => $request->all()
                        ];
                        return Response::json($out);
                    }
                    $units = intval(($response->data['amount'] / 100) / env('SMS_TOPUP_CHARGE'));
                   $credit = SMSCredit::create([
                    'ref' => $request->ref,
                    'amount' => $response->data['amount'] / 100,
                    'units' => $units,
                    'user_id' => auth()->user()->id,
                   ]);
                    if($credit){
                        $setting = Setting::find('sms_units');
                        if(!$setting) $setting = new Setting();

                         $setting->setValue('sms_units', $setting->getValue('sms_units',0) +$units);
                        
                        $out = [
                            'data' => $credit,
                            'message' => "SMS credits loaded successfully!",
                            'status' => true,
                            'input' => $request->all()
                        ];
                    }else{
                        $out = [
                            'message' => "Sorry, credits couldn't be saved!",
                            'status' => false,
                            'input' => $request->all()
                        ];
                    }
                    
                }else {
                    $out = [
                        'message' => "Sorry, payment already made!",
                        'status' => false,
                        'input' => $request->all()
                    ];
                }
            }
            return Response::json($out);
        }
        $data = [
            'smsCredits' => SMSCredit::all(),
        ];
        return view('sms.topup',$data);
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
     * @param  \App\Models\SMS  $sMS
     * @return \Illuminate\Http\Response
     */
    public function show(SMS $sMS)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SMS  $sMS
     * @return \Illuminate\Http\Response
     */
    public function edit(SMS $sMS)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SMS  $sMS
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SMS $sMS)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SMS  $sMS
     * @return \Illuminate\Http\Response
     */
    public function destroy(SMS $sMS)
    {
        //
    }
}
