<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stok;
use App\Models\StokLog;
use DB;
use Validator;

class StokController extends Controller
{
  public function grid()
	{
		$results = $this->responses;
		$results['data'] = Stok::all();
		$results['state_code'] = 200;
		$results['success'] = true;

		return response()->json($results, $results['state_code']);
	}

	public function show($id)
	{
		$results = $this->responses;
		$results['data'] = Stok::find($id);
		$results['state_code'] = 200;
		$results['success'] = true;

		return response()->json($results, $results['state_code']);
	}

	public function store(Request $request)
	{
		$results = $this->responses;
		$inputs = $request->all();
		
		$rules = array(
      'product_id' => 'required',
      'reference_id' => 'required',
      'type' => 'required',
      'qty' => 'required',
      'tgl_stok' => 'required',
		);

		$validator = Validator::make($inputs, $rules);
		// Validation fails?
		if ($validator->fails()){
      $results['messages'] = Array($validator->messages()->first());
      return response()->json($results, 200);
    }
		
    $stok = Stok::create([
      // 'bidang_id' => $inputs['bidang_id'],
      'product_id' => $inputs['product_id'],
      'reference_id' => $inputs['reference_id'],
      'type' => $inputs['type'],
      'qty' => $inputs['qty'],
      'tgl_stok' => $inputs['tgl_stok'],
    ]);

    $log = StokLog::create([
      'user_id' => auth('sanctum')->user()->id,
      'action' => 'insert',
      'reference_id' => $stok->id,
      'value' => json_encode($inputs),
      'ip_address' => $request->ip()
    ]);

    array_push($results['messages'], 'Berhasil menambahkan Stok baru.');

    $results['success'] = true;
    $results['state_code'] = 200;

		return response()->json($results, $results['state_code']);
	}
	
	public function update(Request $request, $id)
	{
		$results = $this->responses;

		$inputs = $request->all();
		$rules = array(
      'product_id' => 'required',
      'reference_id' => 'required',
      'type' => 'required',
      'qty' => 'required',
      'tgl_stok' => 'required',
		);

		$validator = Validator::make($request->all(), $rules);
		// Validation fails?
		if ($validator->fails()){
      $results['messages'] = Array($validator->messages()->first());
      return response()->json($results, $results['state_code']);
    }
    
		$stok = Stok::find($id);

    $log = StokLog::create([
      'user_id' => auth('sanctum')->user()->id,
      'action' => 'update',
      'reference_id' => $id,
      'value' => json_encode($inputs),
      'old_value' => json_encode($stok),
      'ip_address' => $request->ip()
    ]);

    $stok->update([
      'product_id' => $inputs['product_id'],
      'reference_id' => $inputs['reference_id'],
      'type' => $inputs['type'],
      'qty' => $inputs['qty'],
      'tgl_stok' => $inputs['tgl_stok'],
    ]);

    array_push($results['messages'], 'Berhasil mengubah Stok.');

    $results['success'] = true;
    $results['state_code'] = 200;

		return response()->json($results, $results['state_code']);
	}

	public function destroy(Request $request, $id)
	{
		$results = $this->responses;
    
    $stok = Stok::find($id);
    
    $log = StokLog::create([
      'user_id' => auth('sanctum')->user()->id,
      'action' => 'delete',
      'reference_id' => $stok->id,
      'value' => json_encode($stok),
      'ip_address' => $request->ip()
    ]);

    $stok->delete();

		array_push($results['messages'], 'Berhasil menghapus Stok.');
		$results['state_code'] = 200;
		$results['success'] = true;

		return response()->json($results, $results['state_code']);
	}
}
