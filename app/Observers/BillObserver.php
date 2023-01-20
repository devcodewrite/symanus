<?php

namespace App\Observers;

use App\Models\AdvanceFeePayment;
use App\Models\Bill;
use App\Models\Payment;

class BillObserver
{
    /**
     * Handle the Bill "created" event.
     *
     * @param  \App\Models\Bill  $bill
     * @return void
     */
    public function created(Bill $bill)
    {
        // settle attendance bills if adavance payment is avaliable
        if ($bill->attendance_id) {
            $advances = AdvanceFeePayment::where('attendance_id', $bill->attendance_id)->get();
            $payments = [];
            foreach ($advances as $advance) {
                $fee = $bill->fees()->where('fee_type_id', $advance->fee_type_id)->first();
                $billAmount = $fee->findBillFee($bill->id)->amount;
                if($advance->amount - $billAmount >= 0){
                    $advance->amount = $advance->amount - $billAmount;
                    array_push($payments,[
                        'bill_id' => $bill->id,
                        'amount' => $billAmount,
                        'fee_type_id' => $advance->fee_type_id,
                        'student_id' => $bill->student_id,
                        'paid_by' => $advance->paid_by,
                        'user_id' => auth()->user()->id,
                        'paid_at' => $advance->paid_at,
                    ]);
                    $advance->save();
                }
            }
            if(sizeof($payments) > 0 )
                if(Payment::updateOrCreate($payments)){
                    AdvanceFeePayment::where('amount','<=', 0)->delete();
                }
        }
    }

    /**
     * Handle the Bill "updated" event.
     *
     * @param  \App\Models\Bill  $bill
     * @return void
     */
    public function updated(Bill $bill)
    {
        //
    }

    /**
     * Handle the Bill "deleted" event.
     *
     * @param  \App\Models\Bill  $bill
     * @return void
     */
    public function deleted(Bill $bill)
    {
        //
    }

    /**
     * Handle the Bill "restored" event.
     *
     * @param  \App\Models\Bill  $bill
     * @return void
     */
    public function restored(Bill $bill)
    {
        //
    }

    /**
     * Handle the Bill "force deleted" event.
     *
     * @param  \App\Models\Bill  $bill
     * @return void
     */
    public function forceDeleted(Bill $bill)
    {
        //
    }
}
