<?php

namespace App\Http\Controllers;

use App\Models\kelas;
use App\Models\mapel;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    
    // halaman login guru
    public function index()
    {
        return view("auth/login");
    }

    // halaman login admin
    public function index_admin(){
        return view("auth/admin");
    }

    // Login guru
    public function login(Request $request)
    {
        $validasi = $request->validate([
            "email"=>"required|email:dns",
            "password"=>"required|min:5"
        ],[
            "email.required"=>"Email wajib di isi!",
            "email.email"=>"Email harus valid!",
            "password.required"=>"Password wajib di isi!",
            "password.min"=>"Password minimal terdiri dari 5 karakter!"
        ]);
        
        if(Auth::guard("user")->attempt([
            "email" => $validasi['email'],
            "password" => $validasi['password'],
        ])){
            return redirect("/")->with("success", 'Anda berhasil login');
        }
        
        return redirect('/login')->with("wrong", "Email atau password tidak cocok!");
        
    }

    public function login_admin(Request $request){
        $validasi = $request->validate([
            "username" => "required|max:12",
            "password" => "required|min:5"
        ],[
            "username.required" => "Username tidak boleh kosong!",
            "username.max" => "Username tidak boleh lebih dari 12 karakter!",
            "password.required" => "Password tidak boleh kosong!",
            "password.min" => "Password harus terdiri minimal dari 5 karakter!"
        ]);

        if(Auth::guard("admin")->attempt([
            "username" => $validasi['username'],
            "password" => $validasi['password']
        ])){
            
            // $request->session()->regenerate();
            return redirect()->intended("admin")->with('success', "Anda Berhasil Login");
            
        }
        
        return redirect("/login_admin")->with("wrong", "Username atau password tidak cocok ! ");
    }

    public function logout()
    {
        if(Auth::guard("user")->check()){
            
            Auth::guard("user")->logout();

            return redirect("/login")->with("success", "Anda Berhasil Logout");
            
        }

            Auth::guard("admin")->logout();

            // request()->session()->invalidate();
 
            // request()->session()->regenerateToken();

            return redirect("/login_admin")->with("success", "Anda Berhasil Logout");
        
        
    }
}
