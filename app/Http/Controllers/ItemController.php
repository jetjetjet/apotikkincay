<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ItemLog;
use DB;
use Validator;

class ItemController extends Controller
{
  public function grid()
	{
		$results = $this->responses;
		$results['data'] = Item::all();
		$results['state_code'] = 200;
		$results['success'] = true;

		return response()->json($results, $results['state_code']);
	}

	public function show($id)
	{
		$results = $this->responses;
		$results['data'] = Item::find($id);
		$results['state_code'] = 200;
		$results['success'] = true;

		return response()->json($results, $results['state_code']);
	}

	public function store(Request $request)
	{
		$results = $this->responses;
		$inputs = $request->all();
		
		$rules = array(
      'merk_id' => 'required',
      'kategori_id' => 'required',
      'nama_item' => 'required',
      'qty' => 'required',
      'ppn' => 'required',
      'harga_modal' => 'required',
      'harga_jual' => 'required',
      'status_item' => 'required'
		);

		$validator = Validator::make($inputs, $rules);
		// Validation fails?
		if ($validator->fails()){
      $results['messages'] = Array($validator->messages()->first());
      return response()->json($results, 200);
    }
		
    $item = Item::create([
      // 'bidang_id' => $inputs['bidang_id'],
      'merk_id' => $inputs['merk_id'],
      'kategori_id' => $inputs['kategori_id'],
      'nama_item' => $inputs['nama_item'],
      'detail' => $inputs['detail'],
      'qty' => $inputs['qty'],
      'ppn' => $inputs['ppn'],
      'harga_modal' => $inputs['harga_modal'],
      'harga_jual' => $inputs['harga_jual'],
      'no_rak' => $inputs['no_rak'],
      // 'path_file' => $inputs['path_file'],
      'status_item' => $inputs['status_item']
    ]);

    $log = ItemLog::create([
      'user_id' => auth('sanctum')->user()->id,
      'action' => 'insert',
      'reference_id' => $item->id,
      'value' => json_encode($inputs),
      'ip_address' => $request->ip()
    ]);

    array_push($results['messages'], 'Berhasil menambahkan Items baru.');

    $results['success'] = true;
    $results['state_code'] = 200;

		return response()->json($results, $results['state_code']);
	}
	
	public function update(Request $request, $id)
	{
		$results = $this->responses;

		$inputs = $request->all();
		$rules = array(
      'merk_id' => 'required',
      'kategori_id' => 'required',
      'nama_item' => 'required',
      'qty' => 'required',
      'ppn' => 'required',
      'harga_modal' => 'required',
      'harga_jual' => 'required',
      'status_item' => 'required'
		);

		$validator = Validator::make($request->all(), $rules);
		// Validation fails?
		if ($validator->fails()){
      $results['messages'] = Array($validator->messages()->first());
      return response()->json($results, $results['state_code']);
    }
    
		$item = Item::find($id);

    $log = ItemLog::create([
      'user_id' => auth('sanctum')->user()->id,
      'action' => 'update',
      'reference_id' => $id,
      'value' => json_encode($inputs),
      'old_value' => json_encode($item),
      'ip_address' => $request->ip()
    ]);


    $item->update([
      'merk_id' => $inputs['merk_id'],
      'kategori_id' => $inputs['kategori_id'],
      'nama_item' => $inputs['nama_item'],
      'detail' => $inputs['detail'],
      'qty' => $inputs['qty'],
      'ppn' => $inputs['ppn'],
      'harga_modal' => $inputs['harga_modal'],
      'harga_jual' => $inputs['harga_jual'],
      'no_rak' => $inputs['no_rak'],
      // 'path_file' => $inputs['path_file'],
      'status_item' => $inputs['status_item']
    ]);

    array_push($results['messages'], 'Berhasil mengubah Items.');

    $results['success'] = true;
    $results['state_code'] = 200;

		return response()->json($results, $results['state_code']);
	}

	public function destroy(Request $request, $id)
	{
		$results = $this->responses;

    $item = Item::find($id);
    
    $log = ItemLog::create([
      'user_id' => auth('sanctum')->user()->id,
      'action' => 'delete',
      'reference_id' => $item->id,
      'value' => json_encode($item),
      'ip_address' => $request->ip()
    ]);

    $item->delete();

		array_push($results['messages'], 'Berhasil menghapus Items.');
		$results['state_code'] = 200;
		$results['success'] = true;

		return response()->json($results, $results['state_code']);
	}
}
