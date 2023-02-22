<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Module;
use App\Models\Student;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use DataTables;
use DB;
use Gate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Response;
use Validator;

class ClassesController extends Controller
{
    /**
     * Display a listing of resource for tadatables
     * @return \Iluminate\Http\Response
     */
    public function datatable()
    {
        $where = [];
        if (!Gate::inspect('viewAny', new Classes())->allowed()) {
            $where = array_merge($where, ['classes.user_id' => auth()->user()->id]);
        }
        return DataTables::of(
            Classes::with('user:id,username,firstname,surname,email,rstate')
                ->where($where)
        )->make(true);
    }

    /**
     * Display a listing of resource for tadatables
     * @return \Iluminate\Http\Response
     */
    public function related_students_datatable(Request $request)
    {
        return DataTables::of(Student::where('class_id', $request->input('class_id'))
            ->with([
                'guardian:id,firstname,surname,phone,sex',
            ]))
            ->searchPane(
                'sex',
                fn () => Student::select('sex as value', 'sex as label', DB::raw('count(*) as total'))
                    ->where('class_id', $request->input('class_id', 0))
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
                    ->where('class_id', $request->input('class_id', 0))
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
                    ->where('class_id', $request->input('class_id', 0))
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
                    ->where('class_id', $request->input('class_id', 0))
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
        return view('class.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('class.edit');
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
            'name' => 'required|string|max:45',
            'level' => 'required|integer',
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

        $class = Classes::create($validator->safe(array_keys($rules)));
        if ($class) {
            $out = [
                'data' => $class,
                'message' => 'Class created successfully!',
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
     * @param  \App\Models\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function show(Classes $class)
    {
        //
        $data = [
            'class' => $class,
            'module' => new Module(),
        ];
        return view('class.details', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function edit(Classes $class)
    {
        return view('class.edit', ['class' => $class]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Classes $class)
    {
        $rules = ['name' => 'required|string|max:45'];

        if ($class->level === $request->input('level')) {
            array_merge($rules, ['level' => 'required|integer']);
        }
        if ($class->user_id === $request->input('user_id')) {
            array_merge($rules, ['user_id' => 'nullable|integer|in:classes,user_id|in:users,id']);
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

        $class->name = $request->input('name');
        $class->level = $request->input('level');
        $class->user_id = $request->input('user_id');

        if ($class->save()) {
            $out = [
                'data' => $class,
                'message' => 'Class updated successfully!',
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
     * @param  \App\Models\Classes  $class
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classes $class)
    {
        if ($class->delete()) {
            $out = [
                'message' => 'Class deleted successfully!',
                'status' => true,
            ];
        } else {
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
        if ($request->input('action') === 'delete' && $request->input('data')) {
            $ids = [];
            foreach ($request->input('data') as $class) {
                array_push($ids, $class['id']);
            }
            if (Classes::destroy($ids)) {
                $out = [
                    'message' => 'Class(es) deleted successfully!',
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
            foreach ($request->input('data') as $class) {
                array_push($ids, $class['id']);
            }
            if (Classes::whereIn('id', $ids)->update(['rstate' => 'close'])) {
                $out = [
                    'message' => 'Class(es) closed successfully!',
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
            foreach ($request->input('data') as $class) {
                array_push($ids, $class['id']);
            }
            if (Classes::whereIn('id', $ids)->update(['rstate' => 'open'])) {
                $out = [
                    'message' => 'Class(es) open successfully!',
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

            $where = [];
            if (!Gate::inspect('viewAny', new Classes())->allowed()) {
                $where = array_merge($where, ['classes.user_id' => auth()->user()->id]);
            }

            $classes = Classes::select(['id', DB::raw('name as text')])
                ->where('name', 'LIKE',  "%$term%")
                ->where($where)
                ->orderBy('name', 'asc')
                ->get();
            $out = [
                'results' => $classes,
                'pagination' => [
                    'more' => false,
                ]
            ];

            return Response::json($out);
        }

        return Response::json(['message' => 'Invalid request data']);
    }
}
