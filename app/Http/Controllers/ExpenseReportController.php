<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseReport;
use DataTables;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Response;
use Validator;

class ExpenseReportController extends Controller
{
    /**
     * Display a listing of resource for tadatables
     * @return \Iluminate\Http\Response
     */
    public function datatable()
    {
        return DataTables::of(ExpenseReport::with('user:id,firstname,surname,sex,avatar')
                ->with('approvalUser:id,firstname,surname,sex,avatar')
                ->latest())
                ->searchPane(
                    'user',ExpenseReport::select([
                        'user_id as value',
                        DB::raw("concat(users.firstname,' ',users.surname) as label"),
                        DB::raw('count(*) as total')])
                        ->join('users', 'users.id','=','expense_reports.user_id')
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
                    'approval_user',ExpenseReport::select([
                        'approval_user_id as value',
                        DB::raw("concat(users.firstname,' ',users.surname) as label"),
                        DB::raw('count(*) as total')])
                        ->join('users', 'users.id','=','expense_reports.approval_user_id')
                        ->groupBy('approval_user_id')
                        ->groupBy('users.firstname')
                        ->groupBy('users.surname')
                        ->get(),
                    function (Builder $query, array $values) {
                        return $query
                            ->whereIn(
                                'approval_user_id',
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
        return view('accounting.expense.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accounting.expense.edit');
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
            'user_id' => 'required|integer|exists:users,id',
            'approval_user_id' => 'required|integer|exists:users,id',
            'from_date' => 'required|date',
            'to_date' => 'required|date'
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
        $expenseReport = ExpenseReport::create($request->input());

        if($expenseReport){
            $out = [
                'data' => $expenseReport,
                'message' => 'Expense Report created successfully!',
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
     * @param  \App\Models\ExpenseReport  $expenses
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ExpenseReport $expenseReport)
    {
        //
        $data = [
            'expenseReport' => $expenseReport,
            'expense' => Expense::find($request->get('id'))
        ];
        return view('accounting.expense.details', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExpenseReport  $expenses
     * @return \Illuminate\Http\Response
     */
    public function edit(ExpenseReport $expenseReport)
    {
        $data = [
            'expenseReport' => $expenseReport,
        ];
        return view('accounting.expense.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExpenseReport  $expenses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExpenseReport $expenseReport)
    {
        $rules = [ 
            'user_id' => 'required|integer|exists:users,id',
            'approval_user_id' => 'required|integer|exists:users,id',
            'from_date' => 'required|date',
            'to_date' => 'required|date'
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

        if($expenseReport->fill($validator->safe()->except('stay'))->save()){
            $out = [
                'message' => 'Expense Report created successfully!',
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
     * @param  \App\Models\ExpenseReport  $expenseReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpenseReport $expenseReport)
    {
        $expenseReport->delete();
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
            foreach($request->input('data') as $expenseReport){
                array_push($ids, $expenseReport['id']);
            }
            if(ExpenseReport::destroy($ids)){
                $out = [
                    'message' => 'Expense Report deleted successfully!',
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
            foreach($request->input('data') as $expenseReport){
                array_push($ids, $expenseReport['id']);
            }
            if(ExpenseReport::whereIn('id', $ids)->update(['rstate'=>'close'])){
                $out = [
                    'message' => 'Expense Report closed successfully!',
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
            foreach($request->input('data') as $expenseReport){
                array_push($ids, $expenseReport['id']);
            }
            if(ExpenseReport::whereIn('id', $ids)->update(['rstate'=>'open'])){
                $out = [
                    'message' => 'ExpenseReport open successfully!',
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

            $expenses = ExpenseReport::select(['expense_reports.id', DB::raw("concat(classes.name,' ',expense_types.title,'@',amount)  as text")])
                        ->join('expense_types', 'expense_types.id', '=', 'expense_reports.expense_type_id')
                        ->join('classes', 'classes.id', '=', 'expense_reports.class_id')
                        ->where(DB::raw("concat(classes.name,' ',expense_types.title,'@',amount)"), 'LIKE',  "%$term%")
                        ->orderBy('name', 'asc')
                        ->get();
            $out = [
                'results' => $expenses,
                'pagination' => ['more' => false,]
            ];

            return Response::json($out);
        }

       return Response::json(['message' => 'Invalid request data']);
    }
}
