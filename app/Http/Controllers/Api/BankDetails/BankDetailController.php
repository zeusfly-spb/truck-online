<?php

namespace App\Http\Controllers\Api\BankDetails;

use App\Models\BankDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\BankDetails\BankDetailResource;
use App\Http\Requests\BankDetailRequest;
use Auth;

class BankDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      try {
        $bankDetails = BankDetail::orderBy('created_at', 'desc')->where('company_id', Auth::user()->company_id)->get();
        return response()->json(BankDetailResource::collection($bankDetails));
      } catch (\Exception $exception) {
        return response()->json(['error' => $exception->getMessage()], 500);
      }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BankDetailRequest $request)
    {
      try {
        $bankDetail = BankDetail::create([
          'company_id' => Auth::user()->company_id,
          'bik' => $request->bik,
          'bank_name' => $request->bank_name,
          'account' => $request->account,
          'k_account'=>$request->k_account
        ]);
        return response()->json(BankDetailResource::make($bankDetail));
      }catch (\Exception $exception) {
        return response()->json(['error' => $exception->getMessage()], 500);
      }

    }

    /**
     * Display the specified resource.
     */
    public function show(BankDetail $bankDetail)
    {
      return response()->json(BankDetailResource::make($bankDetail));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BankDetail $bankDetail)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BankDetailRequest $request, BankDetail $bankDetail)
    {
      $bankDetail->update($request->all());
      return response()->json(BankDetailResource::make($bankDetail));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BankDetail $bankDetail)
    {
      try {
        $bankDetail->delete();
        return response()->json(['success' => true]);
      } catch (\Exception $exception) {
        return response()->json(['error' => $exception->getMessage()], 500);
      }
    }
}
