<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = User::where('role' , '!=' , 'Sales')->orderBy('created_at' , 'ASC')->get();

        return view('admin.user.index' , compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|unique:users',
            'nama' => 'required',
         ]);

         $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
            'password' => bcrypt('123'),
         ]);

         return redirect()->route('user.index')->with('toast_success', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $data = $user;

        return view('admin.user.edit' , compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->nama = $request->nama; 
        $user->email = $request->email; 
        $user->status = $request->status; 
        $user->role = $request->role; 
        $user->save();

        return redirect()->route('user.index')->with('toast_success' , 'Data berhasil di ubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function postNewPassword(Request $request)
    {
        if($request->password_baru == $request->confirm_password_baru){
          if (Hash::check($request->password_lama, Auth::user()->password)) {
             auth()->user()->update([
                'password' => bcrypt($request->password_baru),
             ]);

             return redirect()->route('change_password.index')->with('toast_success', 'Password Anda Berhasil Di Ubah!!');
          }else{
             return back()->with('toast_error', 'Password Lama Anda Tidak Sama !!');
          }
        } else {
            return back()->with('toast_error', 'Confirmasi Password Tidak Sama !!');
        }
    }
}
