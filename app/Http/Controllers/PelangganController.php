<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\PelangganLog;
use DB;
use Validator;

class PelangganController extends Controller
{
  public function grid()
	{
		$results = $this->responses;
		$results['data'] = Pelanggan::all();
		$results['state_code'] = 200;
		$results['success'] = true;

		return response()->json($results, $results['state_code']);
	}

	public function show($id)
	{
		$results = $this->responses;
		$results['data'] = Pelanggan::find($id);
		$results['state_code'] = 200;
		$results['success'] = true;

		return response()->json($results, $results['state_code']);
	}

	public function store(Request $request)
	{
		$results = $this->responses;
		$inputs = $request->all();
		
		$rules = array(
      'kode_pelanggan' => 'required',
      'nama_pelanggan' => 'required',
		);

		$validator = Validator::make($inputs, $rules);
		// Validation fails?
		if ($validator->fails()){
      $results['messages'] = Array($validator->messages()->first());
      return response()->json($results, 200);
    }
		
    $pelanggan = Pelanggan::create([
      // 'bidang_id' => $inputs['bidang_id'],
      'kode_pelanggan' => $inputs['kode_pelanggan'],
      'nama_pelanggan' => $inputs['nama_pelanggan'],
      'alamat' => $inputs['alamat'],
      'kontak' => $inputs['kontak'],
      'jen_kel' => $inputs['jen_kel'],
      'tgl_lahir' => $inputs['tgl_lahir'],
      'created_by' => 1
    ]);

    $log = PelangganLog::create([
      'user_id' => auth('sanctum')->user()->id,
      'action' => 'insert',
      'reference_id' => $pelanggan->id,
      'value' => json_encode($inputs),
      'ip_address' => $request->ip()
    ]);

    array_push($results['messages'], 'Berhasil menambahkan Pelanggan baru.');

    $results['success'] = true;
    $results['state_code'] = 200;

		return response()->json($results, $results['state_code']);
	}
	
	public function update(Request $request, $id)
	{
		$results = $this->responses;

		$inputs = $request->all();
		$rules = array(
      'kode_pelanggan' => 'required',
      'nama_pelanggan' => 'required',
		);

		$validator = Validator::make($request->all(), $rules);
		// Validation fails?
		if ($validator->fails()){
      $results['messages'] = Array($validator->messages()->first());
      return response()->json($results, $results['state_code']);
    }
    
		$pelanggan = Pelanggan::find($id);

    $log = PelangganLog::create([
      'user_id' => auth('sanctum')->user()->id,
      'action' => 'update',
      'reference_id' => $id,
      'value' => json_encode($inputs),
      'old_value' => json_encode($pelanggan),
      'ip_address' => $request->ip()
    ]);

    $pelanggan->update([
      'kode_pelanggan' => $inputs['kode_pelanggan'],
      'nama_pelanggan' => $inputs['nama_pelanggan'],
      'alamat' => $inputs['alamat'],
      'kontak' => $inputs['kontak'],
      'jen_kel' => $inputs['jen_kel'],
      'tgl_lahir' => $inputs['tgl_lahir'],
      'created_by' => 1
    ]);

    array_push($results['messages'], 'Berhasil mengubah Pelanggan.');

    $results['success'] = true;
    $results['state_code'] = 200;

		return response()->json($results, $results['state_code']);
	}

	public function destroy(Request $request, $id)
	{
		$results = $this->responses;

    $pelanggan = Pelanggan::find($id);
    
    $log = PelangganLog::create([
      'user_id' => auth('sanctum')->user()->id,
      'action' => 'delete',
      'reference_id' => $pelanggan->id,
      'value' => json_encode($pelanggan),
      'ip_address' => $request->ip()
    ]);

    $pelanggan->delete();

		array_push($results['messages'], 'Berhasil menghapus Pelanggan.');
		$results['state_code'] = 200;
		$results['success'] = true;

		return response()->json($results, $results['state_code']);
	}
}
