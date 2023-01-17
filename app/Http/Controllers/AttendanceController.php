<?php

namespace App\Http\Controllers;

use App\Models\AdvanceFeePayment;
use App\Models\Attendance;
use App\Models\AttendanceStudent;
use App\Models\Bill;
use App\Models\BillFee;
use App\Models\Classes;
use App\Models\Fee;
use App\Models\FeeType;
use App\Models\Student;
use DataTables;
use DB;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Response;
use Validator;

class AttendanceController extends Controller
{
    /**
     * Display a listing of resource for json
     * @return \Iluminate\Http\Response
     */
    public function related_students_json(Request $request)
    {
        $students = AttendanceStudent::with('student:id,firstname,surname,studentid,sex,avatar')
            ->with('attendance:id,adate,status')
            ->with('bills')
            ->where('attendance_id', $request->input('attendance_id', 0))
            ->get();
        $result = [];
        foreach ($students as $student) {
            $bill = $student->bills->where('student_id', $student->student_id)->first();
            if ($bill) $student->balance = $bill->totalBill();
            else $student->balance = "0.00";

            $student->advance = AdvanceFeePayment::where([
                'attendance_id' => $request->input('attendance_id', 0),
                'student_id' => $student->student_id,
            ])->sum('amount');

            array_push($result, $student);
        }
        return Response::json($result);
    }

    /**
     * Update a resource for json
     * @return \Iluminate\Http\Response
     */
    public function update_related_students_json(Request $request)
    {
        if ($request->input('check_all') !== null) {
            if (AttendanceStudent::where('attendance_id', $request->input('attendance_id', 0))
                ->update(['status' => ($request->input('check_all') ? 'present' : 'absent')])

            ) {
                $students = AttendanceStudent::with('student:id,firstname,surname,studentid,sex,avatar')
                    ->with('attendance:id,adate,status')
                    ->with('bills')
                    ->where('attendance_id', $request->input('attendance_id', 0))
                    ->get();
                $result = [];
                foreach ($students as $student) {
                    $bill = $student->bills->where('student_id', $student->student_id)->first();
                    if ($bill) $student->balance = $bill->totalBill();
                    else $student->balance = "0.00";

                    array_push($result, $student);
                }
                $out = [
                    'data' => $result,
                    'message' => "Attendance updated successfully!",
                    'status' => false,
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
        if (AttendanceStudent::where('attendance_id', $request->input('data.attendance_id', 0))
            ->where('student_id', $request->input('data.student', 0))
            ->update(['status' => $request->input('data.status', 'absent')])
        ) {
            $atst = AttendanceStudent::where('attendance_id', $request->input('data.attendance_id', 0))
                ->with('bills')
                ->where('attendance_id', $request->input('data.attendance_id', 0))
                ->where('student_id', $request->input('data.student', 0))
                ->first();
            $bill = $atst->bills->where('student_id', $atst->student_id)->first();
            $atst->balance = $bill->totalBill();

            $out = [
                'data' => $atst,
                'message' => 'Status changed successfully!',
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
     * Display a listing of resource for tadatables
     * @return \Iluminate\Http\Response
     */
    public function related_students_datatable(Request $request)
    {
        return DataTables::of(Attendance::with('students:id,*')
            ->find($request->input('attendance_id', 0))
            ->students()->with(
                [
                    'guardian:id,firstname,surname,phone,sex',
                ]
            ))
            ->searchPane(
                'sex',
                fn () => AttendanceStudent::select('sex as value', 'sex as label', DB::raw('count(*) as total'))
                    ->join('students', 'students.id', '=', 'attendance_students.student_id')
                    ->where('attendance_id', $request->input('attendance_id', 0))
                    ->groupBy('sex')
                    ->get(),
                function (Builder $query, array $values) {
                    return $query
                        ->whereIn(
                            'sex',
                            $values
                        );
                }
            )
            ->searchPane(
                'transit',
                fn () => AttendanceStudent::select('transit as value', 'transit as label', DB::raw('count(*) as total'))
                    ->join('students', 'students.id', '=', 'attendance_students.student_id')
                    ->where('attendance_id', $request->input('attendance_id', 0))
                    ->groupBy('transit')
                    ->get(),
                function (Builder $query, array $values) {
                    return $query
                        ->whereIn(
                            'transit',
                            $values
                        );
                }
            )
            ->searchPane(
                'affiliation',
                fn () => AttendanceStudent::select('affiliation as value', 'affiliation as label', DB::raw('count(*) as total'))
                    ->join('students', 'students.id', '=', 'attendance_students.student_id')
                    ->where('attendance_id', $request->input('attendance_id', 0))
                    ->groupBy('affiliation')
                    ->get(),
                function (Builder $query, array $values) {
                    return $query
                        ->whereIn(
                            'affiliation',
                            $values
                        );
                }
            )
            ->searchPane(
                'status',
                fn () => AttendanceStudent::select('status as value', 'status as label', DB::raw('count(*) as total'))
                    ->where('attendance_id', $request->input('attendance_id', 0))
                    ->groupBy('status')
                    ->get(),
                function (Builder $query, array $values) {
                    return $query
                        ->whereIn(
                            'status',
                            $values
                        );
                }
            )
            ->make(true);
    }

    /**
     * Display a listing of resource for tadatables
     * @return \Iluminate\Http\Response
     */
    public function datatable()
    {
        return DataTables::of(Attendance::with(
            [
                'class:id,name,level',
                'user:id,username,firstname,surname,email,rstate',
            ]
        ))->searchPane(
            'adate',
            fn () => Attendance::query()
                ->select('adate as value', 'adate as label', DB::raw('count(*) as total'))
                ->groupBy('adate')
                ->get(),
            function (Builder $query, array $values) {
                return $query
                    ->whereIn(
                        'adate',
                        $values
                    );
            }
        )
            ->searchPane(
                'status',
                fn () => Attendance::query()
                    ->select('status as value', 'status as label', DB::raw('count(*) as total'))
                    ->groupBy('status')
                    ->get(),
                function (Builder $query, array $values) {
                    return $query
                        ->whereIn(
                            'status',
                            $values
                        );
                }
            )
            ->searchPane(
                'class',
                fn () => Attendance::select([
                    'class_id as value',
                    'classes.name as label',
                    DB::raw('count(*) as total')
                ])
                    ->join('classes', 'classes.id', '=', 'attendances.class_id')
                    ->groupBy('class_id')
                    ->groupBy('classes.name')
                    ->get(),
                function (Builder $query, array $values) {
                    return $query
                        ->whereIn(
                            'class_id',
                            $values
                        );
                }
            )->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('attendance.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('attendance.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $classid = $request->input('class_id');

        $rules = [
            'adate' => [
                'required',
                'date',
                Rule::unique('attendances')->where(function ($query) use ($classid) {
                    return $query->where('class_id', $classid);
                })
            ],
            'class_id' => 'required|integer|exists:classes,id',
            'user_id' => 'nullable|integer|exists:users,id',
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
        DB::beginTransaction();
        $attendance = Attendance::create($validator->safe()->except('stay'));
        $atsts = Student::select([
            'id as student_id',
            DB::raw("$attendance->id as attendance_id"),
            DB::raw("'absent' as status"),
        ])
            ->where(
                'class_id',
                $request->input('class_id')
            )->get()
            ->toArray();

        if (!AttendanceStudent::insert($atsts) || !$attendance || sizeof($atsts) === 0) {
            DB::rollBack();
        } else {
            if ($request->input('bill_students')) {
                $fees = Fee::where('rstatus','open')->where('class_id',$attendance->class_id)->get();
                foreach ($fees as $fee) {
                    $students =  $fee->class->students
                        ->whereNotIn('affiliation', [$fee->feeType->bill_ex_st_affiliation])
                        ->whereNotIn('transit', [$fee->feeType->bill_ex_st_transit]);

                    foreach ($students as $row) {
                        $bill =  Bill::updateOrCreate([
                                'user_id' => auth()->user()->id,
                                 'student_id' => $row->id, 
                                 'bdate' => $attendance->adate, 
                                 'attendance_id' => $attendance->id
                                 ]);

                        BillFee::updateOrCreate(['bill_id' => $bill->id, 'fee_id' => $fee->id, 'amount' => $fee->amount]);
                    }
                }
            }
        }
        DB::commit();

        if ($attendance && $atsts) {
            $out = [
                'data' => $attendance,
                'message' => 'Attendance created successfully!',
                'status' => true,
                'input' => $request->all()
            ];
        } else {
            if (sizeof($atsts) === 0) {
                $out = [
                    'message' => "No student found for this attendance!",
                    'status' => false,
                    'input' => $request->all()
                ];
            } else {
                $out = [
                    'message' => "Data couldn't be processed! Please try again!",
                    'status' => false,
                    'input' => $request->all()
                ];
            }
        }
        return Response::json($out);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        $data = [
            'attendance' => $attendance,
        ];
        return view('attendance.details', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        $data = [
            'attendance' => $attendance,
        ];
        return view('attendance.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        $rules = [
            'adate' => [
                'nullable',
                'date',
                Rule::unique('attendances')
                    ->where('class_id', $request->input('class_id'))
                    ->where('adate', '<>', $request->input('adate'))
            ],
            'user_id' => 'nullable|integer|exists:users,id',
            'status' => 'nullable|string|in:approved,draft,rejected,submitted'
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
        $attendance->fill($validator->safe()->except('stay', 'class_id'));

        if ($attendance->save()) {
            $out = [
                'data' => $attendance,
                'message' => 'Attendance updated successfully!',
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
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        if ($attendance->delete()) {
            $out = [
                'message' => 'Attendance deleted successfully!',
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
}
