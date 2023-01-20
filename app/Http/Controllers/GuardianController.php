<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Guardian;
use App\Models\Student;
use DataTables;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Response;
use Validator;

class GuardianController extends Controller
{
    /**
     * Display a listing of resource for tadatables
     * @return \Iluminate\Http\Response
     */
    public function datatable()
    {
        return DataTables::of(Guardian::with([
            'user:id,username,firstname,surname,email,rstate',
            'students',
            ]))->make(true);
    }

       /**
     * Display a listing of resource for tadatables
     * @return \Iluminate\Http\Response
     */
    public function related_bills_datatable(Request $request)
    {
        return DataTables::of(Bill::where('student_id', $request->input('guardian_id'))
                ->with(['user', 'guardian'])
                ->latest())
                ->searchPane(
                    'user',Bill::select([
                        'user_id as value',
                        DB::raw('concat(users.firstname," ",users.surname) as label'),
                        DB::raw('count(*) as total')])
                        ->with(['user', 'guardian:id'])
                        ->where('guardian.id', $request->input('guardian_id'))
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
                        ->with(['user', 'guardian:id'])
                        ->where('guardian.id', $request->input('guardian_id'))
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
     * Display a listing of resource for tadatables
     * @return \Iluminate\Http\Response
     */
    public function related_students_datatable(Request $request)
    {
        return DataTables::of(Student::where('guardian_id', $request->input('guardian_id', 0))
        ->with(['class']))
            ->searchPane(
                'sex',
                fn () => Student::select('sex as value', 'sex as label', DB::raw('count(*) as total'))
                    ->where('guardian_id', $request->input('guardian_id', 0))
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
                fn () => Student::select('transit as value', 'transit as label', DB::raw('count(*) as total'))
                    ->where('guardian_id', $request->input('guardian_id', 0))
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
                fn () => Student::select('affiliation as value', 'affiliation as label', DB::raw('count(*) as total'))
                    ->where('guardian_id', $request->input('guardian_id', 0))
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
                fn () => Student::select('rstate as value', 'rstate as label', DB::raw('count(*) as total'))
                    ->where('guardian_id', $request->input('guardian_id', 0))
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('guardian.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('guardian.edit');
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
            'firstname' => 'required|string|max:45',
            'surname' => 'required|string|max:60',
            'title' => 'required|string',
            'sex' => 'required|string',
            'phone' => 'required|unique:guardians,phone',
            'occupation' => 'nullable|string',
            'address' => 'string|nullable',
            'avatar' => 'nullable|image',
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
            $file_name = date('ymd').Str::lower("_{$request->firstname}{$request->surname}");
            $extension = $file->getClientOriginalExtension();
            $path = $request->file('avatar')->storeAs('avatars/guardians',"$file_name.$extension",'public');
            $data = $validator->safe()->merge(['avatar'=> url("storage/$path")])->except(['stay']);
        }else {
            $data =  $validator->safe()->except(['avatar','stay']);
        }
        $guardian = Guardian::create($data);
        if($guardian){
            $out = [
                'data' => $guardian,
                'message' => 'guardian created successfully!',
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
     * @param  \App\Models\Guardian  $guardian
     * @return \Illuminate\Http\Response
     */
    public function show(Guardian $guardian)
    {
        $data = [
            'guardian' => $guardian,
        ];
        return view('guardian.details', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Guardian  $guardian
     * @return \Illuminate\Http\Response
     */
    public function edit(Guardian $guardian)
    {
        return view('guardian.edit', ['guardian' => $guardian]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Guardian  $guardian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Guardian $guardian)
    {
        $rules = [
            'firstname' => 'nullable|string|max:45',
            'surname' => 'nullable|string|max:60',
            'title' => 'nullable|string',
            'sex' => 'nullable|string',
            'phone' => 'nullable|numeric|unique:guardians:phone',
            'occupation' => 'nullable|string',
            'address' => 'string|nullable',
            'email' => 'nullable|email|max:255',
            'avatar' => 'nullable|image',
            'rstate' => 'nullable|string|in:open,close',
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
            $file_name = date('ymd').Str::lower("_{$request->firstname}{$request->surname}");
            $extension = $file->getClientOriginalExtension();
            $path = $request->file('avatar')->storeAs('avatars/guardians',"$file_name.$extension",'public');
            $data = $validator->safe()->merge(['avatar'=> url("storage/$path")])->except(['stay']);
        }else {
            $data =  $validator->safe()->except(['avatar','stay']);
        }
        $guardian->fill($data);
        if($guardian->save()){
            $out = [
                'data' => $guardian,
                'message' => 'Guardian updated successfully!',
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
     * @param  \App\Models\Guardian  $guardian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guardian $guardian)
    {
        if($guardian->delete()){
            $out = [
                'message' => 'Guardian delete successfully!',
                'status' => true,
            ];
        }else {
            $out = [
                'message' => "Data couldn't be processed! Please try again!",
                'status' => false,
            ];
        }
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

            $total = Guardian::where(DB::raw('concat(firstname ," ", surname)'), 'LIKE',  "%$term%")->count();
            
            $guardians = Guardian::select(['id', DB::raw('concat(firstname ," ", surname) as text'), 'avatar', 'sex'])
                        ->where(DB::raw('concat(firstname ," ", surname)'), 'LIKE',  "%$term%")
                        ->orderBy('firstname', 'asc')
                        ->skip($skip)
                        ->take($take)
                        ->get();
            $out = [
                'results' => $guardians,
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
}
