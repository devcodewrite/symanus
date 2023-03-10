<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillFee;
use App\Models\Fee;
use App\Models\FeeType;
use App\Models\Student;
use Carbon\Carbon;
use DataTables;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Response;
use Str;
use Validator;

class BillController extends Controller
{
    /**
     * Display a listing of resource for tadatables
     * @return \Iluminate\Http\Response
     */
    public function datatable()
    {
        return DataTables::of(Bill::with(['user', 'student', 'billFees', 'payments'])
            ->latest())
            ->searchPane(
                'user',
                Bill::select([
                    'user_id as value',
                    DB::raw('concat(users.firstname," ",users.surname) as label'),
                    DB::raw('count(*) as total')
                ])
                    ->join('users', 'users.id', '=', 'bills.user_id')
                    ->groupBy('user_id')
                    ->groupBy('users.firstname')
                    ->groupBy('users.surname')
                    ->get(),
                function (Builder $query, array $values) {
                    return $query
                        ->whereIn(
                            'user_id',
                            $values
                        );
                }
            )
            ->searchPane(
                'student',
                Bill::select([
                    'student_id as value',
                    DB::raw('concat(students.firstname," ",students.surname) as label'),
                    DB::raw('count(*) as total')
                ])
                    ->join('students', 'students.id', '=', 'bills.student_id')
                    ->groupBy('student_id')
                    ->groupBy('students.firstname')
                    ->groupBy('students.surname')
                    ->get(),
                function (Builder $query, array $values) {
                    return $query
                        ->whereIn(
                            'student_id',
                            $values
                        );
                }
            )->searchPane(
                'bdate',
                fn () => Bill::query()
                    ->select('bdate as value', 'bdate as label', DB::raw('count(*) as total'))
                    ->groupBy('bdate')
                    ->get(),
                function (Builder $query, array $values) {
                    return $query
                        ->whereIn(
                            'bdate',
                            $values
                        );
                }
            )
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('accounting.bill.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'feetypes' => FeeType::all(),
        ];
        return view('accounting.bill.edit', $data);
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
            'bdate' => 'date',
            'fees' => 'required_if:function2,fees|array',
            'feeTypes' => 'required_if:function2,feeTypes|array',
        ];

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
            return Response::json($out);
        }
        $bdate = $request->bdate;
        $billFee = null;
        if ($request->input('function2') === 'fees') {
            $fees = [];
            foreach (Fee::where('rstatus', 'open')
                    ->whereIn('id', $request->input('fees'))
                    ->get() as $fee) {
                $students =  $fee->class->students
                    ->where('rstate', 'open')
                    ->whereNotIn('affiliation', [$fee->feeType->bill_ex_st_affiliation])
                    ->whereNotIn('transit', [$fee->feeType->bill_ex_st_transit]);
                if ($fee) array_push($fees, $fee);

                foreach ($students as $row) {
                    $bill =  Bill::updateOrCreate(['user_id' => auth()->user()->id, 'student_id' => $row->id, 'bdate' => $bdate]);
                    BillFee::where('bill_id', $bill->id)->delete();
                    $billFee = BillFee::updateOrCreate(['bill_id' => $bill->id, 'fee_id' => $fee->id, 'amount' => $fee->amount]);
                }
            }
        } else {
            $fees = Fee::where('rstatus', 'open')
                ->whereIn('fee_type_id', $request->input('feeTypes'))
                ->get();
            foreach ($fees as $fee) {
                $students =  $fee->class->students
                    ->where('rstate', 'open')
                    ->whereNotIn('affiliation', [$fee->feeType->bill_ex_st_affiliation])
                    ->whereNotIn('transit', [$fee->feeType->bill_ex_st_transit]);
                array_push($feeList, $fee->id);
                foreach ($students as $row) {
                    $bill =  Bill::updateOrCreate(
                        array_merge(['user_id' => auth()->user()->id], ['student_id' => $row->id], $bdate)
                    );
                    $billFee = BillFee::updateOrCreate(['bill_id' => $bill->id, 'fee_id' => $fee->id, 'amount' => $fee->amount]);
                }
            }
        }
        if ($billFee) {
            $out = [
                'message' => 'Bill(s) created successfully!',
                'status' => true,
                'input' => $request->all()
            ];
        } else {
            if ($fees->count() > 0)
                $out = [
                    'message' => "Data couldn't be processed! Please try again!",
                    'status' => false,
                    'input' => $request->all()
                ];
            else
                $out = [
                    'message' => "No fees found! Please try again!",
                    'status' => false,
                    'input' => $request->all()
                ];
        }
        return Response::json($out);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bill  $bills
     * @return \Illuminate\Http\Response
     */
    public function show(Bill $bill)
    {
        $data = [
            'feetypes' => FeeType::all(),
            'bill' => $bill,
        ];
        return view('accounting.bill.details', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bill  $bills
     * @return \Illuminate\Http\Response
     */
    public function edit(Bill $bill)
    {
        $data = [
            'feetypes' => FeeType::all(),
            'bill' => $bill,
        ];
        return view('accounting.bill.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bill  $bills
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bill $bill)
    {
        $rules = [
            'fees' => 'nullable|array',
        ];
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
            return Response::json($out);
        }
        BillFee::where('bill_id', $bill->id)->delete();
        foreach ($request->fees as $fee_id)
            $fee = Fee::find($fee_id);
        $bf = BillFee::updateOrCreate(['bill_id' => $bill->id, 'fee_id' => $fee->id, 'amount' => $fee->amount]);

        if ($bf) {
            $out = [
                'data' => $bill,
                'message' => 'Bill update successfully!',
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bill $bill)
    {
        BillFee::where('bill_id', $bill->id)->delete();

        if ($bill->delete()) {
            $out = [
                'message' => 'Bill deleted successfully!',
                'status' => true,
            ];
        } else {
            $out = [
                'message' => "Cannot delete this record!",
                'status' => false,
            ];
        }
        return Response::json($out);
    }

    /**
     * Mass update the resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable_action(Request $request)
    {

        if ($request->input('action') === 'delete' && $request->input('data')) {
            $ids = [];
            foreach ($request->input('data') as $bill) {
                array_push($ids, $bill['id']);
            }
            if (Bill::destroy($ids)) {
                $out = [
                    'message' => 'Bill(es) deleted successfully!',
                    'status' => true,
                    'input' => $request->all()
                ];
            } else {
                $out = [
                    'message' => "Nothing done!",
                    'status' => false,
                    'input' => $request->all()
                ];
            }
            return Response::json($out);
        } else if (
            $request->input('action') === 'close-rstate'
            && $request->input('data')
        ) {
            $ids = [];
            foreach ($request->input('data') as $bill) {
                array_push($ids, $bill['id']);
            }
            if (Bill::whereIn('id', $ids)->update(['rstate' => 'close'])) {
                $out = [
                    'message' => 'Bill(es) closed successfully!',
                    'status' => true,
                    'input' => $request->all()
                ];
            } else {
                $out = [
                    'message' => "Nothing done!",
                    'status' => false,
                    'input' => $request->all()
                ];
            }
            return Response::json($out);
        } else if (
            $request->input('action') === 'open-rstate'
            && $request->input('data')
        ) {
            $ids = [];
            foreach ($request->input('data') as $bill) {
                array_push($ids, $bill['id']);
            }
            if (Bill::whereIn('id', $ids)->update(['rstate' => 'open'])) {
                $out = [
                    'message' => 'Bill(es) open successfully!',
                    'status' => true,
                    'input' => $request->all()
                ];
            } else {
                $out = [
                    'message' => "Nothing done!",
                    'status' => false,
                    'input' => $request->all()
                ];
            }
            return Response::json($out);
        }
        $out = [
            'message' => "Data couldn't be processed! Please try again!",
            'status' => false,
            'input' => $request->all()
        ];

        return Response::json($out);
    }

    /**
     * Display a listing of the resource for select2.
     *
     * @return \Illuminate\Http\Response
     */
    public function select2(Request $request)
    {
        //
        if ($request->ajax()) {

            $term = trim($request->get('term', ''));

            $bills = Bill::select(['id', DB::raw('name as text')])
                ->where('name', 'LIKE',  "%$term%")
                ->orderBy('name', 'asc')
                ->get();
            $out = [
                'results' => $bills,
                'pagination' => [
                    'more' => false,
                ]
            ];

            return Response::json($out);
        }

        return Response::json(['message' => 'Invalid request data']);
    }

    /**
     * Update a resource for json
     * @return \Iluminate\Http\Response
     */
    public function adjust_bill_json(Request $request)
    {
        $rules = [
            'amount' => 'required|numeric',
            'id' => 'required|exists:students,id',
            'attendance.id' => 'required|exists:attendances,id',
        ];

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
            return Response::json($out);
        }
        $bill = Student::find($request->id)->bills->where('attendance_id', $request->input('attendance.id'))->first();
        $fee = $bill->fees()->where('fee_type_id', $request->input('fee_type_id'))->first();
        $bfpayment = [
            'alt_amount' => $request->amount,
        ];
        $params = [
            'bill_id' => $bill->id,
            'fee_id' => $fee->id,
        ];

        BillFee::where($params)->update($bfpayment);

        $bf = BillFee::where($params)->first();
        if ($bf) {
            $out = [
                'data' =>  $bf->alt_amount,
                'message' => 'Bill amount changed successfully!',
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
