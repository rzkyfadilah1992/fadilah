<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\genre;
use Illuminate\Http\Request;
use Validator;

class genreController extends Controller
{
    public function index()
    {
        $genre = genre::latest()->get();
        $response = [
            'success' => true,
            'message' => 'Data genre',
            'data' => $genre,
        ];

        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        // validast data
        $validator = Validator::make($request->all(), [
            'nama_genre' => 'required|unique:genres',
        ], [
            'nama_genre.required' => 'Masukan genre',
            'nama_genre.unique' => 'genre Sudah digunakan!',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan isi dengan benar',
                'data' => $validator->errors(),
            ], 400);
        } else {
            $genre = new genre;
            $genre->nama_genre = $request->nama_genre;
            $genre->save();
        }

        if ($genre) {
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
        $genre = genre::find($id);

        if ($genre) {
            return response()->json([
                'success' => true,
                'message' => 'Detail genre',
                'data' => $genre,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'genre tidak ditemukan',
                'data' => '',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        // validast data
        $validator = Validator::make($request->all(), [
            'nama_genre' => 'required',
        ], [
            'nama_genre.required' => 'Masukan genre',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan isi dengan benar',
                'data' => $validator->errors(),
            ], 400);
        } else {
            $genre = genre::find($id);
            $genre->nama_genre = $request->nama_genre;
            $genre->save();
        }

        if ($genre) {
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
        $genre = genre::find($id);
        $genre->delete();
        return response()->json([
            'success' => true,
            'message' => 'data ' . $genre->nama_genre . 'berhasil dihapus']);
    }
}
