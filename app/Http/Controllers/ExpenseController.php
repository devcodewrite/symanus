<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseType;
use Carbon\Carbon;
use DataTables;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Response;
use Validator;

class ExpenseController extends Controller
{
     /**
     * Display a listing of resource for tadatables
     * @return \Iluminate\Http\Response
     */
    public function datatable()
    {
        return DataTables::of(Expense::with('expenseType:id,title')
                ->with('user:id,firstname,surname,sex,avatar')
                ->latest())
                ->searchPane(
                    'user',Expense::select([
                        'user_id as value',
                        DB::raw("concat(users.firstname,' ',users.surname) as label"),
                        DB::raw('count(*) as total')])
                        ->join('users', 'users.id','=','expenses.user_id')
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
                    'expense_type',Expense::select([
                        'expense_type_id as value',
                        'expense_types.title as label',
                        DB::raw('count(*) as total')])
                        ->join('expense_types', 'expense_types.id','=','expenses.expense_type_id')
                        ->groupBy('expense_type_id')
                        ->groupBy('expense_types.title')
                        ->get(),
                    function (Builder $query, array $values) {
                        return $query
                            ->whereIn(
                                'expense_type_id',
                                $values
                            );
                    }
                )
                ->searchPane(
                    'edate',
                    fn () => Expense::query()
                        ->select('edate as value', 'edate as label', DB::raw('count(*) as total'))
                        ->groupBy('edate')
                        ->get(),
                    function (Builder $query, array $values) {
                        return $query
                            ->whereIn(
                                'edate',
                                $values
                            );
                    }
                )
                ->make(true);
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
            'amount' => 'required|numeric',
            'description' => 'required|string|max:500',
            'expense_type_id' => 'required|integer|exists:expense_types,id',
            'expense_report_id' => 'required|integer|exists:expense_reports,id',
            'user_id' => 'required|integer|exists:users,id',
            'edate' => 'required|date'
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
        $expense = Expense::create($request->input());

        if($expense){
            $out = [
                'message' => 'Expense added successfully!',
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
     * @param  \App\Models\Expense  $expenses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        $rules = [ 
            'amount' => 'nullable|numeric',
            'description' => 'nullable|string|max:500',
            'expense_type_id' => 'nullable|integer|exists:expense_types,id',
            'expense_report_id' => 'nullable|integer|exists:expense_reports,id',
            'user_id' => 'nullable|integer|exists:users,id',
            'edate' => 'nullable|date'
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

        if($expense->fill($validator->safe()->except('stay'))->save()){
            $out = [
                'message' => 'Expense(s) created successfully!',
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
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();
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
            foreach($request->input('data') as $expense){
                array_push($ids, $expense['id']);
            }
            if(Expense::destroy($ids)){
                $out = [
                    'message' => 'Expense deleted successfully!',
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
            foreach($request->input('data') as $expense){
                array_push($ids, $expense['id']);
            }
            if(Expense::whereIn('id', $ids)->update(['rstate'=>'close'])){
                $out = [
                    'message' => 'Expense(es) closed successfully!',
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
            foreach($request->input('data') as $expense){
                array_push($ids, $expense['id']);
            }
            if(Expense::whereIn('id', $ids)->update(['rstate'=>'open'])){
                $out = [
                    'message' => 'Expense open successfully!',
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

            $expenses = Expense::select(['expenses.id', DB::raw("concat(classes.name,' ',expense_types.title,'@',amount)  as text")])
                        ->join('expense_types', 'expense_types.id', '=', 'expenses.expense_type_id')
                        ->join('classes', 'classes.id', '=', 'expenses.class_id')
                        ->where(DB::raw("concat(classes.name,' ',expense_types.title,'@',amount)"), 'LIKE',  "%$term%")
                        ->orderBy('name', 'asc')
                        ->get();
            $out = [
                'results' => $expenses,
                'pagination' => [
                   'more' => false,]
            ];

            return Response::json($out);
        }

       return Response::json(['message' => 'Invalid request data']);
    }
}
