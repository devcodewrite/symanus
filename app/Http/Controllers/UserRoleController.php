<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\UserRole;
use App\Models\UserRoleRole;
use DataTables;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Response;
use Validator;

class UserRoleController extends Controller
{

    /**
     * Display a listing of resource for tadatables
     * @return \Iluminate\Http\Response
     */
    public function datatable()
    {
        return DataTables::of(UserRole::with(['userRole'])->latest())
            ->searchPane(
                'sex',
                fn () => UserRole::query()
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
                fn () => UserRole::query()
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('role.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = [
            'userRoles' => UserRole::all(),
            'userRole'=> UserRole::find($request->get('id')),
        ];
        return view('attributes.user-roles',$data);
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
            'title' => 'required|string|max:45',
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

        $userRole = UserRole::create($validator->safe()->except('stay'));
        if($userRole){
            $out = [
                'data' => $userRole,
                'message' => 'User role created successfully!',
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(UserRole $userRole)
    {
        $data = [
            'role' => $userRole,
            'module' => new Module(),
        ];
        return view('role.details', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(UserRole $userRole)
    {
        $data = [
            'role' => $userRole,
        ];
        return view('role.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserRole $userRole)
    {
        $rules = [
            'title' => 'string|max:45',
            'status' => 'required_if:action,change-status',
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
        $userRole->fill($validator->safe()->except('action'));

        if($userRole->save()){
            $out = [
                'data' => $userRole,
                'message' => 'User role updated successfully!',
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserRole $userRole)
    {
        //
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

            $total = UserRole::where(DB::raw('concat(firstname ," ", surname)'), 'LIKE',  "%$term%")->count();
            
            $userRoles = UserRole::select(['id', DB::raw('concat(firstname ," ", surname) as text'), 'avatar', 'sex'])
                        ->where(DB::raw('concat(firstname ," ", surname)'), 'LIKE',  "%$term%")
                        ->orderBy('firstname', 'asc')
                        ->skip($skip)
                        ->take($take)
                        ->get();
            $out = [
                'results' => $userRoles,
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
