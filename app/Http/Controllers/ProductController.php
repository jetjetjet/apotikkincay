<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductLog;
use DB;
use Validator;

use function GuzzleHttp\json_encode;

class ProductController extends Controller
{
  public function grid()
	{
		$results = $this->responses;
		$results['data'] = Product::all();
		$results['state_code'] = 200;
		$results['success'] = true;

		return response()->json($results, $results['state_code']);
	}

	public function show($id)
	{
		$results = $this->responses;
		$results['data'] = Product::find($id);
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
      'nama_produk' => 'required',
      'ppn' => 'required',
      'harga_jual' => 'required',
		);

		$validator = Validator::make($inputs, $rules);
		// Validation fails?
		if ($validator->fails()){
      $results['messages'] = Array($validator->messages()->first());
      return response()->json($results, 200);
    }
		
    $product = Product::create([
      // 'bidang_id' => $inputs['bidang_id'],
      'merk_id' => $inputs['merk_id'],
      'kategori_id' => $inputs['kategori_id'],
      'nama_produk' => $inputs['nama_produk'],
      'detail' => $inputs['detail'],
      'ppn' => $inputs['ppn'],
      'harga_modal' => $inputs['harga_modal'],
      'harga_jual'=> $inputs['harga_jual'],
      'no_rak' => $inputs['no_rak'],
      'img_path' => $inputs['img_path'],
      'is_active' => $inputs['is_active'],
      'created_by' => 1
    ]);

    $log = ProductLog::create([
      'user_id' => auth('sanctum')->user()->id,
      'action' => 'insert',
      'reference_id' => $product->id,
      'value' => json_encode($inputs),
      'ip_address' => $request->ip()
    ]);

    array_push($results['messages'], 'Berhasil menambahkan Product baru.');

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
      'nama_produk' => 'required',
      'ppn' => 'required',
      'harga_jual' => 'required',
		);

		$validator = Validator::make($request->all(), $rules);
		// Validation fails?
		if ($validator->fails()){
      $results['messages'] = Array($validator->messages()->first());
      return response()->json($results, $results['state_code']);
    }
    
		$product = Product::find($id);

    $log = ProductLog::create([
      'user_id' => auth('sanctum')->user()->id,
      'action' => 'update',
      'reference_id' => $id,
      'value' => json_encode($inputs),
      'old_value' => json_encode($product),
      'ip_address' => $request->ip()
    ]);

    $product->update([
      'merk_id' => $inputs['merk_id'],
      'kategori_id' => $inputs['kategori_id'],
      'nama_produk' => $inputs['nama_produk'],
      'detail' => $inputs['detail'],
      'ppn' => $inputs['ppn'],
      'harga_modal' => $inputs['harga_modal'],
      'harga_jual'=> $inputs['harga_jual'],
      'no_rak' => $inputs['no_rak'],
      'img_path' => $inputs['img_path'],
      'is_active' => $inputs['is_active'],
      'created_by' => 1
    ]);

    array_push($results['messages'], 'Berhasil mengubah Product.');

    $results['success'] = true;
    $results['state_code'] = 200;

		return response()->json($results, $results['state_code']);
	}

	public function destroy(Request $request, $id)
	{
		$results = $this->responses;

    $product = Product::find($id);
    
    $log = ProductLog::create([
      'user_id' => auth('sanctum')->user()->id,
      'action' => 'delete',
      'reference_id' => $product->id,
      'value' => json_encode($product),
      'ip_address' => $request->ip()
    ]);

    $product->delete();

		array_push($results['messages'], 'Berhasil menghapus Product.');
		$results['state_code'] = 200;
		$results['success'] = true;

		return response()->json($results, $results['state_code']);
	}
}
