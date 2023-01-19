<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\FeeType;
use Carbon\Carbon;
use DataTables;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Response;
use Str;
use Validator;

class FeeController extends Controller
{
    /**
     * Display a listing of resource for tadatables
     * @return \Iluminate\Http\Response
     */
    public function datatable()
    {
        return DataTables::of(Fee::with('class:id,name,level')
                ->with('feeType:id,title')
                ->latest())
                ->searchPane(
                    'class',Fee::select([
                        'class_id as value',
                        'classes.name as label',
                        DB::raw('count(*) as total')])
                        ->join('classes', 'classes.id','=','fees.class_id')
                        ->groupBy('class_id')
                        ->groupBy('classes.name')
                        ->get(),
                    function (Builder $query, array $values) {
                        return $query
                            ->whereIn(
                                'class_id',
                                $values
                            );
                    }
                )
                ->searchPane(
                    'fee_type',Fee::select([
                        'fee_type_id as value',
                        'fee_types.title as label',
                        DB::raw('count(*) as total')])
                        ->join('fee_types', 'fee_types.id','=','fees.fee_type_id')
                        ->groupBy('fee_type_id')
                        ->groupBy('fee_types.title')
                        ->get(),
                    function (Builder $query, array $values) {
                        return $query
                            ->whereIn(
                                'fee_type_id',
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
        return view('accounting.fee.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'feetypes' => FeeType::all(),
        ];
        return view('accounting.fee.edit', $data);
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
            'rstatus' => 'required|in:open,close',
            'description' => 'nullable|string|max:100',
            'fee_type_id' => 'required|integer|exists:fee_types,id',
            'classes' => 'required|array',
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
        $fees  = [];
        foreach($request->input('classes', []) as $class){
            $class = array_merge($class, [
                'updated_at' => Carbon::now(),
                'created_at'=> Carbon::now(),
            ]);
            array_push($fees, $validator->safe()->merge($class)->except('stay','classes'));
        }

        $fee = Fee::insert($fees);

        if($fee){
            $out = [
                'message' => 'Fee(s) created successfully!',
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
     * @param  \App\Models\Fee  $fees
     * @return \Illuminate\Http\Response
     */
    public function show(Fee $fee)
    {
        //
        $data = [
            'fee' => $fee,
        ];
        return view('accounting.fee.details', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fee  $fees
     * @return \Illuminate\Http\Response
     */
    public function edit(Fee $fee)
    {
        $data = [
            'feetypes' => FeeType::all(),
            'fee' => $fee,
        ];
        return view('accounting.fee.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fee  $fees
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fee $fee)
    {
        $rules = [ 
            'amount' => 'required|numeric',
            'rstatus' => 'required|in:open,close',
            'description' => 'nullable|string|max:100',
            'fee_type_id' => 'required|integer|exists:fee_types,id',
            'class_id' => 'required|integer|exists:classes,id',
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

        if($fee->fill($validator->safe()->except('stay'))->save()){
            $out = [
                'message' => 'Fee(s) created successfully!',
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
     * @param  \App\Models\Fee  $fee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fee $fee)
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
            foreach($request->input('data') as $fee){
                array_push($ids, $fee['id']);
            }
            if(Fee::destroy($ids)){
                $out = [
                    'message' => 'Fee(es) deleted successfully!',
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
            foreach($request->input('data') as $fee){
                array_push($ids, $fee['id']);
            }
            if(Fee::whereIn('id', $ids)->update(['rstate'=>'close'])){
                $out = [
                    'message' => 'Fee(es) closed successfully!',
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
            foreach($request->input('data') as $fee){
                array_push($ids, $fee['id']);
            }
            if(Fee::whereIn('id', $ids)->update(['rstate'=>'open'])){
                $out = [
                    'message' => 'Fee(es) open successfully!',
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

            $fees = Fee::select(['fees.id', DB::raw("concat(classes.name,' ',fee_types.title,'@',amount)  as text")])
                        ->join('fee_types', 'fee_types.id', '=', 'fees.fee_type_id')
                        ->join('classes', 'classes.id', '=', 'fees.class_id')
                        ->where(DB::raw("concat(classes.name,' ',fee_types.title,'@',amount)"), 'LIKE',  "%$term%")
                        ->orderBy('name', 'asc')
                        ->get();
            $out = [
                'results' => $fees,
                'pagination' => [
                   'more' => false,]
            ];

            return Response::json($out);
        }

       return Response::json(['message' => 'Invalid request data']);
    }
}
