<?php

namespace App\Observers;

use App\Models\AdvanceFeePayment;
use App\Models\BillFee;
use App\Models\Payment;
use Carbon\Carbon;

class BillFeeObserver
{
    /**
     * Handle the BillFee "created" event.
     *
     * @param  \App\Models\BillFee  $billFee
     * @return void
     */
    public function created(BillFee $billFee)
    {
          // settle attendance bills if adavance payment is avaliable
          if ($billFee->bill->attendance_id) {
           
            $advances = AdvanceFeePayment::where('student_id', $billFee->bill->student_id)->get();
            $payments = [];
            foreach ($advances as $advance) {
                
                $fee = $billFee->fee()->where('fee_type_id', $advance->fee_type_id)->first();
                $billAmount = $fee->amount;
               
                if($advance->amount - $billAmount >= 0){
                    $advance->amount = $advance->amount - $billAmount;
                  
                    array_push($payments,[
                        'bill_id' => $billFee->bill_id,
                        'amount' => $billAmount,
                        'fee_type_id' => $advance->fee_type_id,
                        'student_id' => $billFee->bill->student_id,
                        'paid_by' => $advance->paid_by,
                        'user_id' => auth()->user()->id,
                        'paid_at' => $billFee->bill->bdate,
                        'updated_at' => Carbon::now(),
                        'created_at'=> Carbon::now(),
                    ]);
                  
                    $advance->save();
                }
            }
            if(sizeof($payments) > 0 )
                if(Payment::insert($payments)){
                    AdvanceFeePayment::where('amount','<=', 0)->delete();
                }
        }
    }

    /**
     * Handle the BillFee "updated" event.
     *
     * @param  \App\Models\BillFee  $billFee
     * @return void
     */
    public function updated(BillFee $billFee)
    {
        //
    }

    /**
     * Handle the BillFee "deleted" event.
     *
     * @param  \App\Models\BillFee  $billFee
     * @return void
     */
    public function deleted(BillFee $billFee)
    {
        //
    }

    /**
     * Handle the BillFee "restored" event.
     *
     * @param  \App\Models\BillFee  $billFee
     * @return void
     */
    public function restored(BillFee $billFee)
    {
        //
    }

    /**
     * Handle the BillFee "force deleted" event.
     *
     * @param  \App\Models\BillFee  $billFee
     * @return void
     */
    public function forceDeleted(BillFee $billFee)
    {
        //
    }
}
