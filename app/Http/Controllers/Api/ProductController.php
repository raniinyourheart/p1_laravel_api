<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // GET /api/products - Menampilkan semua produk
    public function index()
    {
        $products = Product::all();
        
        return response()->json([
            'status' => true,
            'data' => $products
        ]);
    }
    
    // GET /api/products/{id} - Menampilkan detail satu produk
    public function show($id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }
        
        return response()->json([
            'status' => true,
            'data' => $product
        ]);
    }
    
    // POST /api/products - Menambah produk baru
    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required',
        'deskripsi' => 'required',
        'harga' => 'required|numeric'
    ]);
    
    $product = Product::create($request->all());
    
    return response()->json([
        'status' => true,
        'message' => 'Produk berhasil ditambahkan',
        'data' => $product  // ← $product sudah termasuk id
    ], 201);
}
    
    // PUT /api/products/{id} - Mengupdate produk
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }
        
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric'
        ]);
        
        $product->update($request->all());
        
        return response()->json([
            'status' => true,
            'message' => 'Produk berhasil diupdate',
            'data' => $product
        ]);
    }
    
    // DELETE /api/products/{id} - Menghapus produk
    public function destroy($id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }
        
        $product->delete();
        
        return response()->json([
            'status' => true,
            'message' => 'Produk berhasil dihapus'
        ]);
    }
}