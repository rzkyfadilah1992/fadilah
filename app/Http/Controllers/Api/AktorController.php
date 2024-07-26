<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aktor;
use Illuminate\Http\Request;
use Validator;

class AktorController extends Controller
{
    public function index()
    {
        $aktor = aktor::latest()->get();
        $response = [
            'success' => true,
            'message' => 'Data aktor',
            'data' => $aktor,
        ];

        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        // validast data
        $validator = Validator::make($request->all(), [
            'nama_aktor' => 'required|unique:aktors',
            'biodata' => 'required|unique:aktors',
        ], [
            'nama_aktor.required' => 'Masukan aktor',
            'biodata.unique' => 'biodata Sudah digunakan!',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan isi dengan benar',
                'data' => $validator->errors(),
            ], 400);
        } else {
            $aktor = new aktor;
            $aktor->nama_aktor = $request->nama_aktor;
            $aktor->biodata = $request->biodata;
            $aktor->save();
        }

        if ($aktor) {
            return response()->json([
                'success' => true,
                'message' => 'data berhasil disimpan',
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'data gagal disimpan',
            ], 400);
        }
    }

    public function show($id)
    {
        $aktor = aktor::find($id);

        if ($aktor) {
            return response()->json([
                'success' => true,
                'message' => 'Detail aktor',
                'data' => $aktor,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'aktor tidak ditemukan',
                'data' => '',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        // validast data
        $validator = Validator::make($request->all(), [
            'nama_aktor' => 'required',
            'biodata' => 'required',
        ], [
            'nama_aktor.required' => 'Masukan aktor',
            'biodata' => 'Masukan aktor',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan isi dengan benar',
                'data' => $validator->errors(),
            ], 400);
        } else {
            $aktor = aktor::find($id);
            $aktor->nama_aktor = $request->nama_aktor;
            $aktor->biodata = $request->biodata;
            $aktor->save();
        }

        if ($aktor) {
            return response()->json([
                'success' => true,
                'message' => 'data berhasil diperbarui',
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'data gagal diperbarui',
            ], 400);
        }
    }

    public function destroy($id)
    {
        $aktor = aktor::find($id);
        $aktor->delete();
        return response()->json([
            'success' => true,
            'message' => 'data ' . $aktor->nama_aktor . 'berhasil dihapus',
            'message' => 'data ' . $aktor->biodata . 'berhasil dihapus']);
    }
}
