<?php

namespace App\Http\Controllers;

use App\Models\ExpenseType;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Response;
use Validator;

class ExpenseTypeController extends Controller
{
    /**
     * Display a listing of resource for tadatables
     * @return \Iluminate\Http\Response
     */
    public function datatable()
    {
        return DataTables::of(ExpenseType::all())->make(true);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = [
            'expensetypes' => ExpenseType::all(),
            'expensetype'=> ExpenseType::find($request->get('id')),
        ];
        return view('attributes.expense-types',$data);
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

        $expensetype = ExpenseType::create($validator->safe()->except('stay'));
        if($expensetype){
            $out = [
                'data' => $expensetype,
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
     * @param  \App\Models\ExpenseType  $expenseType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExpenseType $expenseType)
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
        $expenseType->fill($validator->safe()->except('action'));

        if($expenseType->save()){
            $out = [
                'data' => $expenseType,
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
     * @param  \App\Models\ExpenseType  $expenseType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpenseType $expenseType)
    {
        if($expenseType->delete()){
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

            $expensetype = ExpenseType::select(['id', DB::raw(" title as text")])
                        ->where("title", 'LIKE',  "%$term%")
                        ->orderBy('title', 'asc')
                        ->get();
            $out = [
                'results' => $expensetype,
                'pagination' => [
                   'more' => false,]
            ];

            return Response::json($out);
        }

       return Response::json(['message' => 'Invalid request data']);
    }
}
