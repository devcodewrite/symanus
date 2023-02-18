<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Permission;
use App\Models\User;
use App\Models\UserRole;
use DataTables;
use DB;
use Gate;
use Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Response;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of resource for tadatables
     * @return \Iluminate\Http\Response
     */
    public function datatable()
    {
        return DataTables::of(User::with(['userRole'])->latest())
            ->searchPane(
                'sex',
                fn () => User::query()
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
                fn () => User::query()
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
        return view('user.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'roles' => UserRole::all(),
        ];
        return view('user.edit', $data);
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
            'firstname' => ['required', 'string', 'max:45'],
            'surname' => ['required', 'string', 'max:45'],
            'username' => ['required', 'email', 'unique:users'],
            'sex' => ['required', 'string', 'in:male,female,other'],
            'phone' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Password::defaults()],
            'user_role_id' => ['required', 'integer', 'exists:user_roles,id']
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

        $file = $request->file('avatar');
        if ($file) {
            $file_name = $request->input('username');
            $extension = $file->getClientOriginalExtension();
            $path = $request->file('avatar')->storeAs('avatars/users', "$file_name.$extension", 'public');
            $avatar = url("storage/$path");
        } else {
            $avatar = null;
        }

        $user = User::create([
            'firstname' => $request->firstname,
            'surname' => $request->surname,
            'username' => $request->username,
            'sex' => $request->sex,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $avatar,
            'user_role_id' => $request->user_role_id,
            'api_token' => Hash::make(uniqid()),
        ]);
        event(new Registered($user));
        if ($user) {
            $user->sendEmailVerificationNotification();

            $out = [
                'data' => $user,
                'message' => 'user created successfully!',
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $data = [
            'user' => $user,
            'module' => new Module(),
        ];
        return view('user.details', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $data = [
            'user' => $user,
            'roles' => UserRole::all(),
        ];
        return view('user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'firstname' => ['nullable', 'string', 'max:45'],
            'surname' => ['nullable', 'string', 'max:45'],
            'username' => ['nullable', 'email', 'max:45'],
            'sex' => ['nullable', 'string', 'in:male,female,other'],
            'password' => ['nullable', Password::defaults()],
            'user_role_id' => ['nullable', 'integer', 'exists:user_roles,id'],
            'avatar' => ['nullable', 'image']
        ];

        if ($user->phone !== $request->input('phone')) {
            $rules = array_merge($rules, ['phone' => ['nullable', 'string', 'max:255', 'unique:users']]);
        }
        if ($user->email !== $request->input('email')) {
            $rules = array_merge($rules, ['email' => ['nullable', 'string', 'email', 'max:255', 'unique:users']]);
        }

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

        $file = $request->file('avatar');
        if ($file) {
            $file_name = $request->input('username');
            $extension = $file->getClientOriginalExtension();
            $path = $request->file('avatar')->storeAs('avatars/users', "$file_name.$extension", 'public');
            $data = $validator->safe()->merge(['avatar' => url("storage/$path")])->except(['stay']);
        } else {
            $data =  $validator->safe()->except(['avatar', 'stay']);
        }
        $user->fill($data);

        if ($user->save()) {
            $out = [
                'data' => $user,
                'message' => 'user updated successfully!',
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

    public function update_permission(Request $request, User $user)
    {
        $perm = Permission::updateOrCreate(['id' => $user->permission_id], $request->input());
        if ($perm) {
            $out = [
                'data' => $perm,
                'message' => 'permission updated successfully!',
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->delete()){
            $out = [
                'message' => 'User deleted successfully!',
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
     * Display a listing of the resource for select2.
     *
     * @return \Illuminate\Http\Response
     */
    public function select2(Request $request)
    {
        //
        if ($request->ajax()) {

            $term = trim($request->get('term', ''));
            $take = 10;
            $page = $request->get('page', 1);
            $skip = ($page - 1) * $take;

            $total = User::where(DB::raw('concat(firstname ," ", surname)'), 'LIKE',  "%$term%")->count();

            $users = User::select(['id', DB::raw('concat(firstname ," ", surname) as text'), 'avatar', 'sex'])
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
                    'totalPages' => intval($total / $take + ($total % $take > 0 ? 1 : 0))
                ]
            ];

            return Response::json($out);
        }

        return Response::json(['message' => 'Invalid request data']);
    }


    /**
     * Display a listing of the resource for select2.
     *
     * @return \Illuminate\Http\Response
     */
    public function approval_select2(Request $request)
    {
        //
        if ($request->ajax()) {

            $term = trim($request->get('term', ''));

            $users = User::select(['id','user_role_id','permission_id', DB::raw('concat(firstname ," ", surname) as text'), 'avatar', 'sex'])
                ->where(DB::raw('concat(firstname ," ", surname)'), 'LIKE',  "%$term%")
                ->get();
            $users = $users->filter(function ($user) {
                return Gate::forUser($user)->allows('approveAnyExpense',$user);
             });
            $out = [
                'results' => $users,
                'pagination' => [
                    'more' => false,
                ]
            ];

            return Response::json($out);
        }

        return Response::json(['message' => 'Invalid request data']);
    }
}
