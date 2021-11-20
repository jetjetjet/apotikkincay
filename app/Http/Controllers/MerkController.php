<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Merk;
use App\Models\MerkLog;
use DB;
use Validator;

class MerkController extends Controller
{
  public function grid()
	{
		$results = $this->responses;
		$results['data'] = Merk::all();
		$results['state_code'] = 200;
		$results['success'] = true;

		return response()->json($results, $results['state_code']);
	}

	public function show($id)
	{
		$results = $this->responses;
		$results['data'] = Merk::find($id);
		$results['state_code'] = 200;
		$results['success'] = true;

		return response()->json($results, $results['state_code']);
	}

	public function store(Request $request)
	{
		$results = $this->responses;
		$inputs = $request->all();
		
		$rules = array(
      'name' => 'required'
		);

		$validator = Validator::make($inputs, $rules);
		// Validation fails?
		if ($validator->fails()){
      $results['messages'] = Array($validator->messages()->first());
      return response()->json($results, 200);
    }
		
    $merk = Merk::create([
      // 'bidang_id' => $inputs['bidang_id'],
      'name' => $inputs['name']
    ]);

    $log = MerkLog::create([
      'user_id' => auth('sanctum')->user()->id,
      'action' => 'insert',
      'reference_id' => $merk->id,
      'value' => json_encode($inputs),
      'ip_address' => $request->ip()
    ]);

    array_push($results['messages'], 'Berhasil menambahkan Merk baru.');

    $results['success'] = true;
    $results['state_code'] = 200;

		return response()->json($results, $results['state_code']);
	}
	
	public function update(Request $request, $id)
	{
		$results = $this->responses;

		$inputs = $request->all();
		$rules = array(
      'name' => 'required'
		);

		$validator = Validator::make($request->all(), $rules);
		// Validation fails?
		if ($validator->fails()){
      $results['messages'] = Array($validator->messages()->first());
      return response()->json($results, $results['state_code']);
    }
    
		$merk = Merk::find($id);

    $log = MerkLog::create([
      'user_id' => auth('sanctum')->user()->id,
      'action' => 'update',
      'reference_id' => $id,
      'value' => json_encode($inputs),
      'old_value' => json_encode($merk),
      'ip_address' => $request->ip()
    ]);

    $merk->update([
      'name' => $inputs['name']
    ]);

    array_push($results['messages'], 'Berhasil mengubah Merk.');

    $results['success'] = true;
    $results['state_code'] = 200;

		return response()->json($results, $results['state_code']);
	}

	public function destroy(Request $request, $id)
	{
		$results = $this->responses;

    $merk = Merk::find($id);
    
    $log = MerkLog::create([
      'user_id' => auth('sanctum')->user()->id,
      'action' => 'delete',
      'reference_id' => $merk->id,
      'value' => json_encode($merk),
      'ip_address' => $request->ip()
    ]);

    $merk->delete();

		array_push($results['messages'], 'Berhasil menghapus Merk.');
		$results['state_code'] = 200;
		$results['success'] = true;

		return response()->json($results, $results['state_code']);
	}
}
