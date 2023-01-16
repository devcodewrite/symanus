<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Response;

class GuardianController extends Controller
{
    /**
     * Display a listing of resource for tadatables
     * @return \Iluminate\Http\Response
     */
    public function datatable()
    {
        return DataTables::of(Guardian::with('user:id,username,firstname,surname,email,rstate'))->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('guardians.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('guardians.edit');
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
        return view('guardians.details', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Guardian  $guardian
     * @return \Illuminate\Http\Response
     */
    public function edit(Guardian $guardian)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Guardian  $guardian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guardian $guardian)
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
