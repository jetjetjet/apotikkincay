<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReturTransaksi;
use App\Models\ReturTransaksiLog;
use DB;
use Validator;

class ReturTransaksiController extends Controller
{
  public function grid()
	{
		$results = $this->responses;
		$results['data'] = ReturTransaksi::all();
		$results['state_code'] = 200;
		$results['success'] = true;

		return response()->json($results, $results['state_code']);
	}

	public function show($id)
	{
		$results = $this->responses;
		$results['data'] = ReturTransaksi::find($id);
		$results['state_code'] = 200;
		$results['success'] = true;

		return response()->json($results, $results['state_code']);
	}

	public function store(Request $request)
	{
		$results = $this->responses;
		$inputs = $request->all();
		
		$rules = array(
      'transaksi_id' => 'required',
      'product_id' => 'required',
      'qty_retur' => 'required',
      'satuan' => 'required',
      'tgl_retur' => 'required'
		);

		$validator = Validator::make($inputs, $rules);
		// Validation fails?
		if ($validator->fails()){
      $results['messages'] = Array($validator->messages()->first());
      return response()->json($results, 200);
    }
		
    $retur_transaksi = ReturTransaksi::create([
      // 'bidang_id' => $inputs['bidang_id'],
      'transaksi_id' => $inputs['transaksi_id'],
      'product_id' => $inputs['product_id'],
      'qty_retur' => $inputs['qty_retur'],
      'satuan' => $inputs['satuan'],
      'tgl_retur' => $inputs['tgl_retur']
    ]);

    $log = ReturTransaksiLog::create([
      'user_id' => auth('sanctum')->user()->id,
      'action' => 'insert',
      'reference_id' => $retur_transaksi->id,
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
      'transaksi_id' => 'required',
      'product_id' => 'required',
      'qty_retur' => 'required',
      'satuan' => 'required',
      'tgl_retur' => 'required'
		);

		$validator = Validator::make($request->all(), $rules);
		// Validation fails?
		if ($validator->fails()){
      $results['messages'] = Array($validator->messages()->first());
      return response()->json($results, $results['state_code']);
    }
    
		$retur_transaksi = ReturTransaksi::find($id);

    $log = ReturTransaksiLog::create([
      'user_id' => auth('sanctum')->user()->id,
      'action' => 'update',
      'reference_id' => $id,
      'value' => json_encode($inputs),
      'old_value' => json_encode($retur_transaksi),
      'ip_address' => $request->ip()
    ]);

    $retur_transaksi->update([
      'transaksi_id' => $inputs['transaksi_id'],
      'product_id' => $inputs['product_id'],
      'qty_retur' => $inputs['qty_retur'],
      'satuan' => $inputs['satuan'],
      'tgl_retur' => $inputs['tgl_retur']
    ]);

    array_push($results['messages'], 'Berhasil mengubah Retur Transaksi.');

    $results['success'] = true;
    $results['state_code'] = 200;

		return response()->json($results, $results['state_code']);
	}

	public function destroy(Request $request, $id)
	{
		$results = $this->responses;

    $retur_transaksi = ReturTransaksi::find($id);
    
    $log = ReturTransaksiLog::create([
      'user_id' => auth('sanctum')->user()->id,
      'action' => 'delete',
      'reference_id' => $retur_transaksi->id,
      'value' => json_encode($retur_transaksi),
      'ip_address' => $request->ip()
    ]);

    $retur_transaksi->delete();

		array_push($results['messages'], 'Berhasil menghapus Retur Transaksi.');
		$results['state_code'] = 200;
		$results['success'] = true;

		return response()->json($results, $results['state_code']);
	}
}
