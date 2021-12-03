<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\ShiftLog;
use DB;
use Validator;

class ShiftController extends Controller
{
  public function grid()
	{
		$results = $this->responses;
		$results['data'] = Shift::all();
		$results['state_code'] = 200;
		$results['success'] = true;

		return response()->json($results, $results['state_code']);
	}

	public function show($id)
	{
		$results = $this->responses;
		$results['data'] = Shift::find($id);
		$results['state_code'] = 200;
		$results['success'] = true;

		return response()->json($results, $results['state_code']);
	}

	public function store(Request $request)
	{
		$results = $this->responses;
		$inputs = $request->all();
		
		$rules = array(
      'user_id' => 'required',
      'index' => 'required',
      'shift_start' => 'required',
      'start_cash'  => 'required',
      'start_coin' => 'required'
		);

		$validator = Validator::make($inputs, $rules);
		// Validation fails?
		if ($validator->fails()){
      $results['messages'] = Array($validator->messages()->first());
      return response()->json($results, 200);
    }
		
    $shift = Shift::create([
      // 'bidang_id' => $inputs['bidang_id'],
      'user_id' => $inputs['user_id'],
      'index' => $inputs['index'],
      'shift_start' => $inputs['shift_start'],
      'shift_end' => $inputs['shift_end'],
      'start_cash' => $inputs['start_cash'],
      'start_coin' => $inputs['start_coin'],
      'end_cash' => $inputs['end_cash'],
      'end_coin' => $inputs['end_coin'],
      'remark' => $inputs['remark'],
      'created_by' => 1
    ]);

    $log = ShiftLog::create([
      'user_id' => auth('sanctum')->user()->id,
      'action' => 'insert',
      'reference_id' => $shift->id,
      'value' => json_encode($inputs),
      'ip_address' => $request->ip()
    ]);

    array_push($results['messages'], 'Berhasil menambahkan Shift baru.');

    $results['success'] = true;
    $results['state_code'] = 200;

		return response()->json($results, $results['state_code']);
	}
	
	public function update(Request $request, $id)
	{
		$results = $this->responses;

		$inputs = $request->all();
		$rules = array(
      'user_id' => 'required',
      'index' => 'required',
      'shift_start' => 'required',
      'start_cash'  => 'required',
      'start_coin' => 'required'
		);

		$validator = Validator::make($request->all(), $rules);
		// Validation fails?
		if ($validator->fails()){
      $results['messages'] = Array($validator->messages()->first());
      return response()->json($results, $results['state_code']);
    }
    
		$shift = Shift::find($id);

    $log = ShiftLog::create([
      'user_id' => auth('sanctum')->user()->id,
      'action' => 'update',
      'reference_id' => $id,
      'value' => json_encode($inputs),
      'old_value' => json_encode($shift),
      'ip_address' => $request->ip()
    ]);

    $shift->update([
      'user_id' => $inputs['user_id'],
      'index' => $inputs['index'],
      'shift_start' => $inputs['shift_start'],
      'shift_end' => $inputs['shift_end'],
      'start_cash' => $inputs['start_cash'],
      'start_coin' => $inputs['start_coin'],
      'end_cash' => $inputs['end_cash'],
      'end_coin' => $inputs['end_coin'],
      'remark' => $inputs['remark'],
      'created_by' => 1
    ]);

    array_push($results['messages'], 'Berhasil mengubah Shift.');

    $results['success'] = true;
    $results['state_code'] = 200;

		return response()->json($results, $results['state_code']);
	}

	public function destroy(Request $request, $id)
	{
		$results = $this->responses;

    $shift = Shift::find($id);
    
    $log = ShiftLog::create([
      'user_id' => auth('sanctum')->user()->id,
      'action' => 'delete',
      'reference_id' => $shift->id,
      'value' => json_encode($shift),
      'ip_address' => $request->ip()
    ]);

    $shift->delete();

		array_push($results['messages'], 'Berhasil menghapus Shift.');
		$results['state_code'] = 200;
		$results['success'] = true;

		return response()->json($results, $results['state_code']);
	}
}
