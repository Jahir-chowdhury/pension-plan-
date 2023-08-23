<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentMethodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paymentMethods = PaymentMethod::all();
        return view('admin.payment_methods.index', compact('paymentMethods'));
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
        // Validation Code


        $method= new PaymentMethod();
        $method->method_name = $request->method_name;
        $method->bank_name = $request->bank_name;
        $method->account_no = $request->account_no;
        $method->branch = $request->branch;
        $method->branch_routing_no = $request->branch_routing_no;
        $method->address = $request->address;
        $method->active_status = $request->active_status;
        $method->transaction_id_required = $request->transaction_id_required;
        $method->created_by = Auth::user()->id;
        $method->save();
        return back()->with('success', 'Payment method created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validation code 
        $paymentMethod=PaymentMethod::where('account_no',$request->account_no)->first();
        try {
            DB::beginTransaction();
            $paymentMethod->method_name = $request->method_name ?? $paymentMethod->method_name;
            $paymentMethod->bank_name = $request->bank_name ?? $paymentMethod->bank_name;
            $paymentMethod->account_no = $request->account_no ?? $paymentMethod->account_no;
            $paymentMethod->branch = $request->branch ?? $paymentMethod->branch;
            $paymentMethod->created_by = $paymentMethod->created_by??Auth::user()->id;
            $paymentMethod->branch_routing_no = $request->branch_routing_no ?? $paymentMethod->branch_routing_no;
            $paymentMethod->address = $request->address ?? $paymentMethod->address;
            $paymentMethod->transaction_id_required = $request->transaction_id_required;
            $paymentMethod->active_status = $request->active_status;
            $paymentMethod->updated_by = Auth::user()->id;
            //dd($paymentMethod->created_by);
            $paymentMethod->save();
            DB::commit();
            return back()->with('success', 'Payment method info updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
