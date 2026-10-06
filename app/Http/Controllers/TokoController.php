<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class TokoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('toko.index');
    }

    /**
     * Get data for DataTables
     */
    public function data()
    {
        $toko = Toko::orderBy('nama_toko', 'ASC')->get();

        return DataTables::of($toko)
            ->addIndexColumn()
            ->addColumn('foto_toko', function ($toko) {
                if ($toko->foto_toko && Storage::exists('public/toko/' . $toko->foto_toko)) {
                    return '<img src="'. asset('storage/toko/' . $toko->foto_toko) .'" alt="'. $toko->nama_toko .'" class="rounded" width="80">';
                }
                return '<div class="bg-gray-200 rounded flex items-center justify-center" style="width:80px;height:80px">
                            <i class="fa fa-store text-gray-400 text-2xl"></i>
                        </div>';
            })
            ->addColumn('kontak', function ($toko) {
                if ($toko->kontak) {
                    return '<a href="tel:'. $toko->kontak .'" class="text-blue-600 hover:text-blue-800">
                                <i class="fa fa-phone"></i> '. $toko->kontak .'
                            </a>';
                }
                return '<span class="text-gray-400">-</span>';
            })
            ->addColumn('alamat_short', function ($toko) {
                return \Str::limit($toko->alamat, 50);
            })
            ->addColumn('total_kunjungan', function ($toko) {
                $count = $toko->kunjungan()->count();
                return '<span class="badge badge-info">'. $count .' kunjungan</span>';
            })
            ->addColumn('aksi', function ($toko) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`'. route('toko.update', $toko->id) .'`)" class="btn btn-xs btn-warning btn-flat" title="Edit Toko">
                        <i class="fa fa-edit"></i> Edit
                    </button>
                    <button type="button" onclick="deleteData(`'. route('toko.destroy', $toko->id) .'`)" class="btn btn-xs btn-danger btn-flat" title="Hapus Toko">
                        <i class="fa fa-trash"></i> Hapus
                    </button>
                </div>
                ';
            })
            ->rawColumns(['foto_toko', 'kontak', 'total_kunjungan', 'aksi'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kontak' => 'nullable|string|max:50',
            'foto_toko' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'catatan' => 'nullable|string',
        ]);

        $data = $request->all();

        // Handle foto upload
        if ($request->hasFile('foto_toko')) {
            $file = $request->file('foto_toko');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/toko', $filename);
            $data['foto_toko'] = $filename;
        }

        Toko::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Data toko berhasil disimpan'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $toko = Toko::findOrFail($id);
        return response()->json($toko);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $toko = Toko::findOrFail($id);

        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kontak' => 'nullable|string|max:50',
            'foto_toko' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'catatan' => 'nullable|string',
        ]);

        $data = $request->all();

        // Handle foto upload
        if ($request->hasFile('foto_toko')) {
            // Delete old foto
            if ($toko->foto_toko && Storage::exists('public/toko/' . $toko->foto_toko)) {
                Storage::delete('public/toko/' . $toko->foto_toko);
            }

            $file = $request->file('foto_toko');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/toko', $filename);
            $data['foto_toko'] = $filename;
        }

        $toko->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data toko berhasil diperbarui'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $toko = Toko::findOrFail($id);

        // Check if toko has kunjungan
        if ($toko->kunjungan()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus toko yang memiliki histori kunjungan'
            ], 422);
        }

        // Delete foto if exists
        if ($toko->foto_toko && Storage::exists('public/toko/' . $toko->foto_toko)) {
            Storage::delete('public/toko/' . $toko->foto_toko);
        }

        $toko->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data toko berhasil dihapus'
        ]);
    }
}
