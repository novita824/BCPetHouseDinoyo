<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
   function index()
   {
      return view("sesi.index");
   }
   function login(Request $request)
   {
      $request->validate([
         'username' => 'required',
         'password' => 'required'
      ], [
         'username.required' => 'Username wajib diisi',
         'password.required' => 'Password wajib diisi',
      ]);

      $infologin = [
         'username' => $request->username,
         'password' => $request->password,
      ];

      if (Auth::attempt($infologin)) {
         return redirect('welcome')->with('succes', 'Berhasil login');
      } else {
         return redirect('sesi')->withErrors('username dan password yang dimasukkan tidak valid');
      }
   }
}
