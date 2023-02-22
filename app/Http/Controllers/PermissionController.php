<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Response;
use Validator;

class PermissionController extends Controller
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
        $rules = [
            'settings' =>'nullable|array',
            'permissions' =>'nullable|array',
            'modules' =>'nullable|array',
            'user_roles' =>'nullable|array',
            'users' =>'nullable|array',
            'students' =>'nullable|array',
            'guardians' =>'nullable|array',
            'classes' =>'nullable|array',
            'attendances' =>'nullable|array',
            'fee_types' =>'nullable|array',
            'fees' =>'nullable|array',
            'expense_types' =>'nullable|array',
            'expenses' =>'nullable|array',
            'bills' =>'nullable|array',
            'semesters' =>'nullable|array',
            'staffs' =>'nullable|array',
            'sms' =>'nullable|array',
            'is_admin' => 'nullable|boolean',
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

        $permission = new Permission();
        $permissions = [];
        foreach($validator->safe()->except('is_admin') as $key => $perm){
            $permissions = array_merge($permissions, [$key => implode(',', $perm)]);
        }
       
        $permissions = array_merge($permissions, $validator->safe(['is_admin']));
        $permission->fill($permissions);

        if($permission->save()){
            if($request->input('user_id')){
                $user = User::find($request->user_id);
                $user->permission_id = $permission->id;
                $user->save();
            }
            $out = [
                'data' => $permission,
                'message' => 'Permission updated successfully!',
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
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $rules = [
            'settings' =>'nullable|array',
            'permissions' =>'nullable|array',
            'modules' =>'nullable|array',
            'user_roles' =>'nullable|array',
            'users' =>'nullable|array',
            'students' =>'nullable|array',
            'guardians' =>'nullable|array',
            'classes' =>'nullable|array',
            'attendances' =>'nullable|array',
            'fee_types' =>'nullable|array',
            'fees' =>'nullable|array',
            'expense_types' =>'nullable|array',
            'expenses' =>'nullable|array',
            'bills' =>'nullable|array',
            'semesters' =>'nullable|array',
            'staffs' =>'nullable|array',
            'sms' =>'nullable|array',
            'is_admin' => 'required|boolean',
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

        $permissions = [];
        foreach($validator->safe()->except('is_admin') as $key => $perm){
            $permissions = array_merge($permissions, [$key => implode(',', $perm)]);
        }
        foreach($rules as $key => $field){
            if($request->input($key) === null){
                $permission[$key] = null;
            }
        }
        $permissions =  array_merge($permissions, $validator->safe(['is_admin']));
      
        $permission->fill($permissions);

       if($permission->save()){
        $out = [
            'data' => $permission,
            'message' => 'Permission updated successfully!',
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
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        //
    }
}
