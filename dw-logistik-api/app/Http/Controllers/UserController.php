<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        //QUERY UNTUK MENGAMBIL DATA DARI TABLE USERS DAN DI-LOAD 10 DATA PER HALAMAN
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        //KEMBALIKAN RESPONSE BERUPA JSON DENGAN FORMAT
        //STATUS = SUCCESS
        //DATA = DATA USERS DARI HASIL QUERY
        return response()->json(['status' => 'success', 'data' => $users]);
    }

    public function store(Request $request)
    {
        //DEFAULTNYA FILENAME ADALAH NULL KARENA USER YANG TIPENYA BUKAN DRIVER, BISA MENGOSONGKAN FOTO DIRI
        $filaname = null;
        //KEMUDIAN CEK JIKA ADA FILE YANG DIKIRIMKAN
        if ($request->hasFile('photo')) {
            //MAKA GENERATE NAMA UNTUK FILE TERSEBUT DENGAN FORMAT STRING RANDOM + EMAIL
            $filaname = Str::random(5) . $request->email . '.jpg';
            $file = $request->file('photo');
            $file->move(base_path('public/images'), $filaname); //SIMPAN FILE TERSEBUT KE DALAM FOLDER PUBLIC/IMAGES
        }

        //SIMPAN DATA USER KE DALAM TABLE USERS MENGGUNAKAN MODEL USER
        User::create([
            'name' => $request->name,
            'identity_id' => $request->identity_id,
            'gender' => $request->gender,
            'address' => $request->address,
            'photo' => $filaname, //UNTUK FOTO KITA GUNAKAN VALUE DARI VARIABLE FILENAME
            'email' => $request->email,
            'password' => app('hash')->make($request->password), //PASSWORDNYA KITA ENCRYPT
            'phone_number' => $request->phone_number,
            // 'api_token' => 'test', //BAGIAN INI HARUSNYA KOSONG KARENA AKAN TERISI JIKA USER LOGIN
            'role' => $request->role,
            'status' => $request->status
        ]);
        return response()->json(['status' => 'success']);
    }

    public function edit($id)
    {
        //MENGAMBIL DATA BERDASARKAN ID
        $user = User::find($id);
        //KEMUDIAN KIRIM DATANYA DALAM BENTUL JSON.
        return response()->json(['status' => 'success', 'data' => $user]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id); //GET DATA USER

        //JIKA PASSWORD YANG DIKIRIMKAN USER KOSONG, BERARTI DIA TIDAK INGIN MENGGANTI PASSWORD, MAKA KITA AKAN MENGAMBIL PASSWORD SAAT INI UNTUK DISIMPAN KEMBALI
        //JIKA TIDAK KOSONG, MAKA KITA ENCRYPT PASSWORD YANG BARU
        $password = $request->password != '' ? app('hash')->make($request->password) : $user->password;

        //LOGIC YANG SAMA ADALAH DEFAULT DARI $FILENAME ADALAH NAMA FILE DARI DATABASE
        $filaname = $user->photo;
        //JIKA ADA FILE GAMBAR YANG DIKIRIM
        if ($request->hasFile('photo')) {
            //MAKA KITA GENERATE NAMA DAN SIMPAN FILE BARU TERSEBUT
            $filaname = Str::random(5) . $user->email . '.jpg';
            $file = $request->file('photo');
            $file->move(base_path('public/images'), $filaname); //
            //HAPUS FILE LAMA
            unlink(base_path('public/images/' . $user->photo));
        }

        //KEMUDIAN PERBAHARUI DATA USERS
        $user->update([
            'name' => $request->name,
            'identity_id' => $request->identity_id,
            'gender' => $request->gender,
            'address' => $request->address,
            'photo' => $filaname,
            'password' => $password,
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'status' => $request->status
        ]);
        return response()->json(['status' => 'success']);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        unlink(base_path('public/images/' . $user->photo));
        $user->delete();
        return response()->json(['status' => 'success']);
    }
}
