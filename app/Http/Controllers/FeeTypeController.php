<?php

namespace App\Http\Controllers;

use App\Models\FeeType;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Response;
use Validator;

class FeeTypeController extends Controller
{
    /**
     * Display a listing of resource for tadatables
     * @return \Iluminate\Http\Response
     */
    public function datatable()
    {
        return DataTables::of(FeeType::all())->make(true);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = [
            'feetypes' => FeeType::all(),
            'feetype'=> FeeType::find($request->get('id')),
        ];
        return view('attributes.fee-types',$data);
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
            'bill_ex_st_affiliation' => 'nullable|in:staffed,non-staffed',
            'bill_ex_st_transit' => 'nullable|in:walk,bus',
            'bill_ex_st_attendance' => 'nullable|in:present,absent',
            'for_attendance_bills' => 'nullable|boolean',
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

        $feetype = FeeType::create($validator->safe()->except('stay'));
        if($feetype){
            $out = [
                'data' => $feetype,
                'message' => 'Fee type created successfully!',
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FeeType  $feeType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FeeType $feeType)
    {
        $rules = [
            'title' => 'string|max:45',
            'status' => 'required_if:action,change-status',
            'bill_ex_st_affiliation' => 'nullable|in:staffed,non-staffed',
            'bill_ex_st_transit' => 'nullable|in:walk,bus',
            'bill_ex_st_attendance' => 'nullable|in:present,absent',
            'for_attendance_bills' => 'nullable|boolean',
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
        $feeType->fill($validator->safe()->except('action'));

        if($feeType->save()){
            $out = [
                'data' => $feeType,
                'message' => 'Fee type updated successfully!',
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
     * @param  \App\Models\FeeType  $feeType
     * @return \Illuminate\Http\Response
     */
    public function destroy(FeeType $feeType)
    {
        if($feeType->delete()){
            $out = [
                'message' => 'Fee type deleted successfully!',
                'status' => true,
            ];
        }else {
            $out = [
                'message' => "Record couldn't be deleted!",
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

            $feetype = FeeType::select(['id', DB::raw(" title as text")])
                        ->where("title", 'LIKE',  "%$term%")
                        ->orderBy('title', 'asc')
                        ->get();
            $out = [
                'results' => $feetype,
                'pagination' => [
                   'more' => false,]
            ];

            return Response::json($out);
        }

       return Response::json(['message' => 'Invalid request data']);
    }
}
