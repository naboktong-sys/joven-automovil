<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function data()
    {
        $user = User::orderBy('id', 'desc')->get();

        return datatables()
            ->of($user)
            ->addIndexColumn()
            ->addColumn('level_badge', function ($user) {
                return $user->isAdmin()
                    ? '<span class="label label-danger">Admin</span>'
                    : '<span class="label label-info">Sales</span>';
            })
            ->addColumn('aksi', function ($user) {
                $hapus = auth()->id() === $user->id
                    ? ''
                    : '<button type="button" onclick="deleteData(`'. route('user.destroy', $user->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>';

                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`'. route('user.update', $user->id) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    ' . $hapus . '
                </div>
                ';
            })
            ->rawColumns(['aksi', 'level_badge'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'level'    => ['nullable', Rule::in([User::LEVEL_ADMIN, User::LEVEL_SALES])],
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->level = $request->input('level', User::LEVEL_SALES);
        $user->foto = '/img/user.svg';
        $user->save();

        return response()->json('Data berhasil disimpan', 200);
    }

    public function show($id)
    {
        return response()->json(User::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => 'nullable|string|min:6|confirmed',
            'level'    => ['nullable', Rule::in([User::LEVEL_ADMIN, User::LEVEL_SALES])],
        ]);

        $level = $request->input('level', $user->level);

        // Jangan biarkan admin terakhir diturunkan levelnya
        if ($user->isAdmin() && (int) $level !== User::LEVEL_ADMIN
            && User::where('level', User::LEVEL_ADMIN)->count() <= 1) {
            return response()->json(['message' => 'Minimal harus ada satu admin'], 422);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->level = $level;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return response()->json('Data berhasil disimpan', 200);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return response()->json(['message' => 'Tidak dapat menghapus akun yang sedang digunakan'], 422);
        }

        if ($user->isAdmin() && User::where('level', User::LEVEL_ADMIN)->count() <= 1) {
            return response()->json(['message' => 'Minimal harus ada satu admin'], 422);
        }

        $user->delete();

        return response(null, 204);
    }

    public function profil()
    {
        $profil = auth()->user();
        return view('user.profil', compact('profil'));
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'foto' => 'nullable|image|max:2048',
        ]);

        $user = auth()->user();
        $user->name = $request->name;

        if ($request->filled('password')) {
            if (!Hash::check($request->old_password, $user->password)) {
                return response()->json(['message' => 'Password lama tidak sesuai'], 422);
            }
            if ($request->password !== $request->password_confirmation) {
                return response()->json(['message' => 'Konfirmasi password tidak sesuai'], 422);
            }
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nama = 'user-' . $user->id . '-' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/img'), $nama);

            $user->foto = "/img/$nama";
        }

        $user->save();

        return response()->json($user, 200);
    }
}
