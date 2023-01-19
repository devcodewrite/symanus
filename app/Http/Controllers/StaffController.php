<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Module;
use App\Models\Staff;
use DataTables;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Response;
use Str;
use Validator;

class StaffController extends Controller
{
    
    /**
     * Display a listing of resource for tadatables
     * @return \Iluminate\Http\Response
     */
    public function datatable()
    {
        return DataTables::of(Staff::with(['classes:id,name', 'user:id,firstname,surname,sex,avatar'])->latest())
            
            ->searchPane(
                'sex',
                fn () => Staff::query()
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
                'rstate',
                fn () => Staff::query()
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
    public function related_attendances_datatable(Request $request)
    {
        return DataTables::of(Attendance::where('staff_id', $request->input('staff_id'))
                ->with(['user', 'fees'])
                ->latest())
                ->searchPane(
                    'user',Attendance::select([
                        'user_id as value',
                        DB::raw('concat(users.firstname," ",users.surname) as label'),
                        DB::raw('count(*) as total')])
                        ->join('users', 'users.id','=','attendances.user_id')
                        ->where('staff_id', $request->input('staff_id'))
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
                    'adate',
                    fn () => Attendance::query()
                        ->select('adate as value', 'adate as label', DB::raw('count(*) as total'))
                        ->where('staff_id', $request->input('staff_id'))
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
        return view('staff.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $st = Staff::orderBy('id', 'desc')->first();
        $st = $st?$st:(object)['id' => 0];
        $data = [
            'new_staffid' => date('ym').Str::padLeft(strval($st->id + 1),6, 0),
        ];
        return view('staff.edit', $data);
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
            'staffid' => 'required|string|max:10|unique:staffs,staffid',
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
            $file_name = $request->input('staffid');
            $extension = $file->getClientOriginalExtension();
            $path = $request->file('avatar')->storeAs('avatars/staffs',"$file_name.$extension",'public');
            $data = $validator->safe()->merge(['avatar'=> url("storage/$path")])->except(['stay']);
        }else {
            $data =  $validator->safe()->except(['avatar','stay']);
        }
        $staff = Staff::create($data);
        if($staff){
            $out = [
                'data' => $staff,
                'message' => 'staff created successfully!',
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
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show(Staff $staff)
    {
        //
        $data = [
            'staff' => $staff,
            'module' => new Module(),
        ];
        return view('staff.details', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit(Staff $staff)
    {
        //
        return view('staff.edit', ['staff' => $staff]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Staff $staff)
    {
        $rules = [
            'firstname' => 'nullable|string|max:45',
            'surname' => 'nullable|string|max:60',
            'sex' => 'nullable|string',
            'admitted_at' => 'nullable|date',
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
            $file_name = $request->input('staffid');
            $extension = $file->getClientOriginalExtension();
            $path = $request->file('avatar')->storeAs('avatars/staffs',"$file_name.$extension",'public');
            $data = $validator->safe()->merge(['avatar'=> url("storage/$path")])->except(['stay']);
        }else {
            $data =  $validator->safe()->except(['avatar','stay']);
        }
        $staff->fill($data);

        if($staff->save()){
            $out = [
                'data' => $staff,
                'message' => 'Staff updated successfully!',
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
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        //
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
            foreach($request->input('data') as $staff){
                array_push($ids, $staff['id']);
            }
            if(Staff::destroy($ids)){
                $out = [
                    'message' => 'Staff(s) deleted successfully!',
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
            if(Staff::whereIn('id', $ids)->update(['rstate'=>'close'])){
                $out = [
                    'message' => 'Staff(s) closed successfully!',
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
            foreach($request->input('data') as $staff){
                array_push($ids, $staff['id']);
            }
            if(Staff::whereIn('id', $ids)->update(['rstate'=>'open'])){
                $out = [
                    'message' => 'Staff(s) open successfully!',
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

            $total = Staff::where(DB::raw('concat(firstname ," ", surname)'), 'LIKE',  "%$term%")->count();
            
            $users = Staff::select(['id', DB::raw('concat(firstname ," ", surname) as text'), 'avatar', 'sex'])
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
    public function staff_balance_json(Request $request)
    {
        if ($request->json()) {
            $staff = Staff::find($request->input('data.staff.id',0));
            if($staff){
            $out = [
                'data' => $staff->getBalanceByAttendance($request->input('data.attendance.id', 0)),
                'status' => true,
            ];
        }else {
            $out = [
                'status' => false,
                'message' => "Staff not found!",
            ];
        }
            return Response::json($out);
        }
       return Response::json(['message' => 'Invalid request data']);
    }
}
