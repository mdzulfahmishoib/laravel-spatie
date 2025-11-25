<?php

namespace App\Http\Controllers\Management_user;

use App\Http\Controllers\Controller;
use App\Models\informasi\kantor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller implements HasMiddleware
{

    public static function middleware(): array 
    {
        return [
            new Middleware('permission:view_management_user', only: ['index']),
            new Middleware('permission:create_management_user', only: ['create']),
            new Middleware('permission:create_management_user', only: ['store']),
            new Middleware('permission:update_management_user', only: ['edit']),
            new Middleware('permission:update_management_user', only: ['update']),
            new Middleware('permission:delete_management_user', only: ['destroy']),
        ];
    }

    public function index(){
        $data["users"] = User::get();

        return view('management_user.user.index', $data);
    }

    public function create(){
        $data["roles"] = Role::pluck('name', 'id')->all();

        return view('management_user.user.create', $data);
    }

    public function store(Request $request){
        
        $request->validate([
            'name' => 'required|string|min:3|max:255|unique:users',
            'username' => 'required|string|min:3|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|max:20',
            'roles' => 'required',
            'file' => 'mimes:jpeg,png,jpg|max:10240',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->hashName();
            $file->storeAs('public/management_user/foto_profil', $fileName);
    
            // Simpan hanya satu file terakhir
            $user->update(['foto' => $fileName]);
        }
    
        $user->syncRoles($request->roles);
    
        return redirect('management_user/users')->with('success', 'User Berhasil Dibuat');
    }
    

    public function edit(User $user){
        $data["user"] = $user;
        $data["roles"] = Role::pluck('name', 'name')->all();
        $data["userRoles"] = $user->roles->pluck('name', 'name')->all();

        return view('management_user.user.edit', $data);
    }

    public function update(Request $request, User $user){
       
        $request->validate([
            'name' => 'sometimes|string|min:3|max:255',
            'username' => 'sometimes|string|min:3|max:255',
            'email' => 'sometimes|email|max:255',
            'password' => 'nullable|string|min:8|max:20',
            'roles' => 'sometimes',
            'file' => 'sometimes|mimes:jpeg,png,jpg|max:10240',
        ]);
    
        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ];

        if (!empty($request->password)) {  
            $data['password'] = Hash::make($request->password);
        }
    
        $user->update($data); 
        $user->syncRoles($request->roles);
    
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($user->foto) {
                Storage::delete('public/management_user/foto_profil/' . $user->foto);
            }
    
            // Simpan file baru
            $file = $request->file('file');
            $fileName = $file->hashName();
            $file->storeAs('public/management_user/foto_profil', $fileName);
    
            // Update database dengan file baru
            $user->update(['foto' => $fileName]);
        }
    
        return redirect('management_user/users')->with('success', 'User Berhasil Diperbarui');
    }


    public function userProfile()
    {
        $data["user"] = Auth::user();
        return view('layouts.profil', $data);
    }


    public function updateProfile(Request $request)
    {
        // Validasi input (nama dan email opsional)
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'nullable|string|min:8|confirmed',
            'name' => 'nullable|string|max:255', // Nama opsional
            'username' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . Auth::id(), // Email opsional, harus unik
            'foto' => 'nullable|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        // Verifikasi password saat ini
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        // Update password baru (jika ada)
        if (!empty($request->new_password)) {
            $user->password = Hash::make($request->new_password);
        }

        // Update nama (jika diisi)
        if (!empty($request->name)) {
            $user->name = $request->name;
        }
        
        // Update username (jika diisi)
        if (!empty($request->username)) {
            $user->username = $request->username;
        }

        // Update email (jika diisi)
        if (!empty($request->email)) {
            $user->email = $request->email;
        }

        // Update foto profil (jika ada)
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto) {
                Storage::delete('public/management_user/foto_profil/' . $user->foto);
            }

            // Simpan foto baru
            $file = $request->file('foto');
            $fileName = $file->hashName();
            $file->storeAs('public/management_user/foto_profil', $fileName);
            $user->foto = $fileName;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil Berhasil Diperbarui');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        return redirect()->back()->with('success', 'Status akun berhasil diubah.');
    }

    public function destroy($userId){
        $user = User::findOrFail($userId);

        if ($user->foto) {
            $files = explode(',', $user->foto);
            foreach ($files as $file) {
                Storage::delete('public/management_user/foto_profil/' . $file);
            }
        }

        $user->delete();

        return redirect('management_user/users')->with('success', 'User Berhasil Dihapus');

    }
}
