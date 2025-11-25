<?php

namespace App\Http\Controllers;

use App\Models\setup_app;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;

class setup_appController extends Controller implements HasMiddleware
{
    public static function middleware(): array 
    {
        return [
            new Middleware('permission:view_setup_app', only: ['index']),
            new Middleware('permission:update_setup_app', only: ['update']),
        ];
    }

    public function index()
    {
        return view('layouts.setup_app');
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'nama_aplikasi' => 'nullable|string|max:255',
            'deskripsi_aplikasi' => 'nullable|string|max:255',
            'nama_instansi' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'logo_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'logo_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $setup_app = setup_app::first();

        if ($request->hasFile('logo_1')) {
            $file2 = $request->file('logo_1');
            $filename2 = 'logo1_' . time() . '.' . $file2->getClientOriginalExtension();
            $file2->storeAs('public/uploads', $filename2);

            if ($setup_app->logo_koperasi && Storage::exists('public/uploads/' . $setup_app->logo_koperasi)) {
                Storage::delete('public/uploads/' . $setup_app->logo_koperasi);
            }

            $validatedData['logo_aplikasi'] = $filename2;
        }

        if ($request->hasFile('logo_2')) {
            $file1 = $request->file('logo_2');
            $filename1 = 'logo_' . time() . '.' . $file1->getClientOriginalExtension();
            $file1->storeAs('public/uploads', $filename1);

            if ($setup_app->logo_instansi && Storage::exists('public/uploads/' . $setup_app->logo_instansi)) {
                Storage::delete('public/uploads/' . $setup_app->logo_instansi);
            }

            $validatedData['logo_instansi'] = $filename1;
        }

        $setup_app->update($validatedData);

        return redirect()->route('setup_app.index')->with('success', 'Data berhasil disimpan.');
    }


}



