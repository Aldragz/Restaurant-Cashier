<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    // daftar pegawai
    public function index()
    {
        $employees = User::where('role', 'kasir')->orderBy('created_at', 'desc')->paginate(5);
        return view('admin.employees.index', compact('employees'));
    }

    // form tambah pegawai
    public function create()
    {
        return view('admin.employees.create');
    }

    // simpan pegawai
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|min:3|unique:users,name',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ], [
            'name.required'  => 'Nama pegawai wajib diisi',
            'name.min'       => 'Nama pegawai minimal 3 karakter',
            'name.unique'    => 'Nama pegawai sudah digunakan',

            'email.required' => 'Email wajib diisi',
            'email.email'    => 'Format email tidak valid',
            'email.unique'   => 'Email sudah terdaftar',

            'password.required' => 'Password wajib diisi',
            'password.min'      => 'Password minimal 6 karakter',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'kasir',
        ]);

        return redirect('/admin/employees')
            ->with('success', 'Pegawai berhasil ditambahkan');
    }

    // form edit pegawai
    public function edit(User $employee)
    {
        return view('admin.employees.edit', compact('employee'));
    }

    // update pegawai
    public function update(Request $request, User $employee)
    {
        $request->validate([
            'name'  => 'required|string|min:3|unique:users,name,' . $employee->id,
            'email' => 'required|email|unique:users,email,' . $employee->id,
        ], [
            'name.required' => 'Nama pegawai wajib diisi',
            'name.min'      => 'Nama pegawai minimal 3 karakter',
            'name.unique'   => 'Nama pegawai sudah digunakan pegawai lain',

            'email.required' => 'Email wajib diisi',
            'email.email'    => 'Format email tidak valid',
            'email.unique'   => 'Email sudah digunakan pegawai lain',
        ]);

        $employee->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return redirect('/admin/employees')
            ->with('success', 'Data pegawai berhasil diupdate');
    }

    // hapus pegawai
    public function destroy(User $employee)
    {
        $employee->delete();

        return redirect('/admin/employees')
            ->with('success', 'Pegawai berhasil dihapus');
    }
}
