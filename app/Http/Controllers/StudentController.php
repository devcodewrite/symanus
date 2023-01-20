<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Classes;
use App\Models\Guardian;
use App\Models\Module;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Response;
use Str;
use Validator;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    /**
     * Display a listing of resource for tadatables
     * @return \Iluminate\Http\Response
     */
    public function datatable()
    {
        return DataTables::of(Student::with(['class:id,name','guardian:id,firstname,surname,phone,sex'])->latest())
            
            ->searchPane(
                'sex',
                fn () => Student::query()
                    ->select('sex as value', 'sex as label', DB::raw('count(*) as total'))
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
                'class',Student::select([
                    'class_id as value',
                    'classes.name as label',
                    DB::raw('count(*) as total')])
                    ->join('classes', 'classes.id','=','students.class_id')
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
            )
            ->searchPane(
                'transit',
                fn () => Student::query()
                    ->select('transit as value', 'transit as label', DB::raw('count(*) as total'))
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
                fn () => Student::query()
                    ->select('affiliation as value', 'affiliation as label', DB::raw('count(*) as total'))
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
                'rstate',
                fn () => Student::query()
                    ->select('rstate as value', 'rstate as label', DB::raw('count(*) as total'))
                    ->groupBy('rstate')
                    ->get(),
                function (Builder $query, array $values) {
                    return $query
                        ->whereIn(
                            'rstate',
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
    public function related_bills_datatable(Request $request)
    {
        return DataTables::of(Bill::where('student_id', $request->input('student_id'))
                ->with(['user', 'fees'])
                ->latest())
                ->searchPane(
                    'user',Bill::select([
                        'user_id as value',
                        DB::raw('concat(users.firstname," ",users.surname) as label'),
                        DB::raw('count(*) as total')])
                        ->join('users', 'users.id','=','bills.user_id')
                        ->where('student_id', $request->input('student_id'))
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
                    'bdate',
                    fn () => Bill::query()
                        ->select('bdate as value', 'bdate as label', DB::raw('count(*) as total'))
                        ->where('student_id', $request->input('student_id'))
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
        return view('student.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $st = Student::orderBy('id', 'desc')->first();
        $st = $st?$st:(object)['id' => 0];
        $data = [
            'new_studentid' => date('ym').Str::padLeft(strval($st->id + 1),6, 0),
        ];
        return view('student.edit', $data);
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
        $rules = [
            'firstname' => 'required|string|max:45',
            'surname' => 'required|string|max:60',
            'studentid' => 'required|string|max:10|unique:students,studentid',
            'sex' => 'required|string',
            'admitted_at' => 'required|date',
            'class_id' => 'nullable|integer|exists:classes,id',
            'guardian_id' => 'nullable|integer|exists:guardians,id',
            'transit' => 'required|string',
            'affiliation' => 'required|string',
            'address' => 'string|nullable',
            'dateofbirth' => 'nullable|date',
            'avatar' => 'image',
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
        $file = $request->file('avatar');
        if($file){
            $file_name = $request->input('studentid');
            $extension = $file->getClientOriginalExtension();
            $path = $request->file('avatar')->storeAs('avatars/students',"$file_name.$extension",'public');
            $data = $validator->safe()->merge(['avatar'=> url("storage/$path")])->except(['stay']);
        }else {
            $data =  $validator->safe()->except(['avatar','stay']);
        }
        $student = Student::create($data);
        if($student){
            $out = [
                'data' => $student,
                'message' => 'student created successfully!',
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
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
        $data = [
            'student' => $student,
            'module' => new Module(),
        ];
        return view('student.details', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
        return view('student.edit', ['student' => $student]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $rules = [
            'firstname' => 'nullable|string|max:45',
            'surname' => 'nullable|string|max:60',
            'sex' => 'nullable|string',
            'admitted_at' => 'nullable|date',
            'class_id' => 'nullable|integer|exists:classes,id',
            'guardian_id' => 'nullable|integer|exists:guardians,id',
            'transit' => 'nullable|string',
            'affiliation' => 'nullable|string',
            'address' => 'string|nullable',
            'dateofbirth' => 'nullable|date',
            'avatar' => 'image|nullable',
            'rstate' => 'nullable|in:close,open'
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
        $file = $request->file('avatar');
        if($file){
            $file_name = $request->input('studentid');
            $extension = $file->getClientOriginalExtension();
            $path = $request->file('avatar')->storeAs('avatars/students',"$file_name.$extension",'public');
            $data = $validator->safe()->merge(['avatar'=> url("storage/$path")])->except(['stay']);
        }else {
            $data =  $validator->safe()->except(['avatar','stay']);
        }
        $student->fill($data);

        if($student->save()){
            $out = [
                'data' => $student,
                'message' => 'Student updated successfully!',
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        if($student->delete()){
            $out = [
                'message' => 'Student deleted successfully!',
                'status' => true,
            ];
        }else {
            $out = [
                'message' => "Nothing done!",
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
        
        if($request->input('action') === 'delete' && $request->input('data')){
            $ids = [];
            foreach($request->input('data') as $student){
                array_push($ids, $student['id']);
            }
            if(Student::destroy($ids)){
                $out = [
                    'message' => 'Student(s) deleted successfully!',
                    'status' => true,
                    'input' => $request->all()
                ];
            }
            else {
                $out = [
                    'message' => "Nothing done!",
                    'status' => false,
                    'input' => $request->all()
                ];
            }
            return Response::json($out);
            
        }
        else if($request->input('action') === 'close-rstate' 
            && $request->input('data')) {
            $ids = [];
            foreach($request->input('data') as $row){
                array_push($ids, $row['id']);
            }
            if(Student::whereIn('id', $ids)->update(['rstate'=>'close'])){
                $out = [
                    'message' => 'Student(s) closed successfully!',
                    'status' => true,
                    'input' => $request->all()
                ];
            }else {
                $out = [
                    'message' => "Nothing done!",
                    'status' => false,
                    'input' => $request->all()
                ];
            }
            return Response::json($out);

        }else if( $request->input('action') === 'open-rstate' 
            && $request->input('data')) {
            $ids = [];
            foreach($request->input('data') as $student){
                array_push($ids, $student['id']);
            }
            if(Student::whereIn('id', $ids)->update(['rstate'=>'open'])){
                $out = [
                    'message' => 'Student(s) open successfully!',
                    'status' => true,
                    'input' => $request->all()
                ];
            }else {
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

            $term = trim($request->get('term',''));
            $take = 10;
            $page = $request->get('page', 1);
            $skip = ($page - 1 )*$take;

            $total = Student::where(DB::raw('concat(firstname ," ", surname)'), 'LIKE',  "%$term%")->count();
            
            $users = Student::select(['id', DB::raw('concat(firstname ," ", surname) as text'), 'avatar', 'sex'])
                        ->where(DB::raw('concat(firstname ," ", surname)'), 'LIKE',  "%$term%")
                        ->orderBy('firstname', 'asc')
                        ->skip($skip)
                        ->take($take)
                        ->get();
            $out = [
                'results' => $users,
                'pagination' => [
                   'more' => ($skip + $take < $total),
                   'page' => intval($page),
                   'totalRows' => $total,
                   'totalPages' => intval($total/$take + ($total%$take > 0?1:0))
                ]
            ];

            return Response::json($out);
        }

       return Response::json(['message' => 'Invalid request data']);
    }

     /**
     * Display a listing of the resource for json.
     *
     * @return \Illuminate\Http\Response
     */
    public function student_balance_json(Request $request)
    {
        if ($request->json()) {
            $student = Student::find($request->input('data.student.id',0));
            if($student){
            $out = [
                'data' => $student->getBalanceByAttendance($request->input('data.attendance.id', 0)),
                'status' => true,
            ];
        }else {
            $out = [
                'status' => false,
                'message' => "Student not found!",
            ];
        }
            return Response::json($out);
        }
       return Response::json(['message' => 'Invalid request data']);
    }
}
