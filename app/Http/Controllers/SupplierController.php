<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\SupplierLog;
use DB;
use Validator;

class SupplierController extends Controller
{
  public function grid()
	{
		$results = $this->responses;
		$results['data'] = Supplier::all();
		$results['state_code'] = 200;
		$results['success'] = true;

		return response()->json($results, $results['state_code']);
	}

	public function show($id)
	{
		$results = $this->responses;
		$results['data'] = Supplier::find($id);
		$results['state_code'] = 200;
		$results['success'] = true;

		return response()->json($results, $results['state_code']);
	}

	public function store(Request $request)
	{
		$results = $this->responses;
		$inputs = $request->all();
		
		$rules = array(
      'nama_supplier' => 'required',
		);

		$validator = Validator::make($inputs, $rules);
		// Validation fails?
		if ($validator->fails()){
      $results['messages'] = Array($validator->messages()->first());
      return response()->json($results, 200);
    }
		
    $supplier = Supplier::create([
      // 'bidang_id' => $inputs['bidang_id'],
      'nama_supplier' => $inputs['nama_supplier'],
      'perusahaan' => $inputs['perusahaan'],
      'kontak' => $inputs['kontak'],
      'alamat' => $inputs['alamat'],
      'created_by' => 1
    ]);

    $log = SupplierLog::create([
      'user_id' => auth('sanctum')->user()->id,
      'action' => 'insert',
      'reference_id' => $supplier->id,
      'value' => json_encode($inputs),
      'ip_address' => $request->ip()
    ]);


    array_push($results['messages'], 'Berhasil menambahkan Suppliers baru.');

    $results['success'] = true;
    $results['state_code'] = 200;

		return response()->json($results, $results['state_code']);
	}
	
	public function update(Request $request, $id)
	{
		$results = $this->responses;

		$inputs = $request->all();
		$rules = array(
      'nama_supplier' => 'required',
		);

		$validator = Validator::make($request->all(), $rules);
		// Validation fails?
		if ($validator->fails()){
      $results['messages'] = Array($validator->messages()->first());
      return response()->json($results, $results['state_code']);
    }
    
		$supplier = Supplier::find($id);

    $log = SupplierLog::create([
      'user_id' => auth('sanctum')->user()->id,
      'action' => 'update',
      'reference_id' => $id,
      'value' => json_encode($inputs),
      'old_value' => json_encode($supplier),
      'ip_address' => $request->ip()
    ]);

    $supplier->update([
      'nama_supplier' => $inputs['nama_supplier'],
      'perusahaan' => $inputs['perusahaan'],
      'kontak' => $inputs['kontak'],
      'alamat' => $inputs['alamat']
    ]);

    array_push($results['messages'], 'Berhasil mengubah Suppliers.');

    $results['success'] = true;
    $results['state_code'] = 200;

		return response()->json($results, $results['state_code']);
	}

	public function destroy(Request $request, $id)
	{
		$results = $this->responses;

    $supplier = Supplier::find($id);
    
    $log = SupplierLog::create([
      'user_id' => auth('sanctum')->user()->id,
      'action' => 'delete',
      'reference_id' => $supplier->id,
      'value' => json_encode($supplier),
      'ip_address' => $request->ip()
    ]);

    $supplier->delete();

		array_push($results['messages'], 'Berhasil menghapus Suppliers.');
		$results['state_code'] = 200;
		$results['success'] = true;

		return response()->json($results, $results['state_code']);
	}
}
