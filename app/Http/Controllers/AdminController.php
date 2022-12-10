<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Guru;
use App\Models\JadwalAbsen;
use App\Models\kelas;
use App\Models\mapel;
use App\Models\Siswa;
use App\Models\UserKelas;
use App\Models\UserMapel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class AdminController extends Controller
{

    public function index_admin()
    {
        // mengambil data guru
        $guru = Guru::all();

        // mengambil data mapel
        $mapel = mapel::all();
        
        // mengambil data kelas
        $kelas = kelas::all();

        // mengambil data siswa
        $siswa = Siswa::with(['kelas'])->get();

        // dump($guru);
        return view('admin.dashboard_admin', [
            "title" => "dashboard_admin",
            "gurus" =>  $guru,
            "mapels" => $mapel,
            "mapel" => [],
            "kelas" => $kelas,
            "siswas"=> $siswa,
            "no_guru" => 1,
            "no_siswa" => 1,
            "no_mapel" => 1,
            "no_kelas" => 1
        ]);
    }

    // menampilkan box
    public function box()
    {
        $siswa = Siswa::all();
        $kelas = kelas::all();
        $guru = Guru::all();
        $mapel = mapel::all();

        return view("admin.component.box", [
            "kelas"=>$kelas,
            "siswas"=>$siswa,
            "gurus"=>$guru,
            "mapels"=>$mapel,
        ]);
    }

    // menampilkan data dari table mapel
    public function table_mapel()
    {
        $data = mapel::all();

        return view("admin.component.table_mapel", [
            "mapels"=>$data,
            "no_mapel"=>1
        ]);
    }

    // menambahkan data mapel
    public function insert_mapel(Request $request)
    {
        $validasi = $request->validate([
            "pelajaran"=>"required"
        ],[
            "pelajaran.required"=> "Pelajaran tidak boleh kosong!"
        ]);

        mapel::create([
            "pelajaran"=>$validasi['pelajaran']
        ]);
        
        return "Mata Pelajaran Baru Berhasil Dibuat";
    }

    public function update_mapel($id)
    {
        $mapel = mapel::find($id);
        dd($mapel);
        return redirect("/admin")->with("mapel", $mapel);
    }

    // menghapus data mapel

    public function delete_mapel($id)
    {
        $mapel = mapel::find($id);
        $mapel->delete();

        return redirect("/admin")->with("success", "Mapel berhasil di hapus");

    }

    //  menampilkan data dari table kelas
    public function table_kelas()
    {
        $data = kelas::all();

        return view("admin.component.table_kelas", [
            "kelas"=>$data,
            "no_kelas"=>1
        ]);
    }

    // menghapus data kelas
    public function delete_kelas($id)
    {
        $kelas = kelas::find($id);
        $kelas->delete();

        return redirect('/admin')->with("success", "Kelas berhasil di hapus");
    }

    // menambahkan data guru
    public function guru()
    {
        return view("admin.tambah_guru", [
            "title"=>"dashboard_admin"
        ]);
    }

    // membuat akun guru
    public function tambah_guru(Request $request)
    {
        $validasi = $request->validate([
            "name" => "required",
            "nip" => "required|unique:gurus",
            "email" => "required|email:dns",
            "no_hp" => "required|max:13",
            "username" => "required|max:12",
            "password" => "required|min:5",
        ],[
            "name.required" => "Nama Guru Wajib di Isi!",
            "nip.required" => "Nomer Induk Pegawai Wajib di Wsi!",
            "nip.unique" => "Nomer Induk Pegawai Sudah Terpakai!",
            "email.required" => "Email Wajib di Isi!",
            "email.email" => "Email Harus Valid!",
            "no_hp.required" => "Nomor Handphone Wajib di Isi!",
            "no_hp.max" => "Nomor Handphone Maximal 13 Karakter!",
            "username.required" => "Username Wajib di Isi!",
            "username.max" => "Username Maximal 12 Karakter!",
            "password.required" => "Password wajib di isi!",
            "password.min" => "Password Minimal 5 Karakter!",
        ]);

        $data = Guru::create([
            "nip" => $validasi['nip'],
            "name" => $validasi['name'],
            "username" => $validasi['username'],
            "email" => $validasi['email'],
            "no_hp" => $validasi['no_hp'],
            "password" => Hash::make($validasi['password']),
        ]);

        return redirect('/admin')->with("success", "Akun Guru Berhasil Dibuat");
    }

    public function delete_guru($id)
    {

        $guru = Guru::find($id);
        $guru->delete();

        return redirect('/admin')->with("success", "Data Guru Berhasil di Hapus");
    }

    // view guru update
    public function update_guru($id)
    {
        $guru = Guru::find($id);

        return view("admin.edit_guru",[
            "title"=>"dashboard_admin",
            "gurus"=>$guru
        ]);
    }

    // update data guru
    public function edit_guru(Request $request, $id)
    {
        $validasi = $request->validate([
            "name" => "required",
            "nip" => "required",
            "email" => "required|email:dns",
            "no_hp" => "required|max:13",
            "username" => "required|max:12",
            "password" => "required|min:5",
        ],[
            "name.required" => "Nama Guru Wajib di Isi!",
            "nip.required" => "Nomer Induk Pegawai Wajib di Wsi!",
            "nip.unique" => "Nomer Induk Pegawai Sudah Terpakai!",
            "email.required" => "Email Wajib di Isi!",
            "email.email" => "Email Harus Valid!",
            "no_hp.required" => "Nomor Handphone Wajib di Isi!",
            "no_hp.max" => "Nomor Handphone Maximal 13 Karakter!",
            "username.required" => "Username Wajib di Isi!",
            "username.max" => "Username Maximal 12 Karakter!",
            "password.required" => "Password wajib di isi!",
            "password.min" => "Password Minimal 5 Karakter!",
        ]);

        $data = Guru::find($id);

        $data->update([
            "nip" => $validasi['nip'],
            "name" => $validasi['name'],
            "username" => $validasi['username'],
            "email" => $validasi['email'],
            "no_hp" => $validasi['no_hp'],
            "password" => Hash::make($validasi['password']),
        ]);

        // $data->save();

        return redirect("/admin")->with("success", "Data Guru Berhasil di Ubah");
    }
    

    // membuat mapel
    public function tambah_mapel(Request $request)
    {
        $validasi = $request->validate([
            "pelajaran" => "required|unique:mapels" 
        ],[
            "pelajaran.required"=>"Mata pelajaran tidak boleh kosong!",
            "pelajaran.unique"=>"Mata pelajaran tersebut sudah ada!"
        ]);

        mapel::dcreate([
            "pelajaran"=> $validasi['pelajaran']
        ]);

        return redirect("/admin")->with("success", "Mapel Baru Berhasil Dibuat");
    }

    // pino bot
    public function pino_bot()
    {
        $kelas = kelas::all();
        return view("admin.pino_bot", [
            "sub_title"=> "list_grup",
            "no_grup"=> 1,
            "title"=> "pino_bot",
            "data_grup_kelas" => $kelas,
        ]);
    }

    public function grup_kelas()
    {
        return view("admin.tambah_grup_kelas",[
            "title"=>"pino_bot"
        ]);
    }

    // menambahkan data pada table kelas
    public function insert_grup_kelas(Request $request)
    {
        $validasi = $request->validate([
            "kelas"=>"required|unique:kelas",
            "nama_grup"=>"required",
            "nama_walas"=>"required",
            "chat_id"=>"required|unique:kelas",
        ],[
            "kelas.required"=>"Kelas tidak boleh kosong!",
            "kelas.unique"=>"Kelas tidak boleh sama!",
            "nama_grup.required"=>"Nama grup tidak boleh kosong!",
            "nama_walas.required"=>"Nama wali kelas tidak boleh kosong!",
            "chat_id.required"=>"Chat ID grup kelas tidak boleh kosong!",
            "chat_id.unique"=>"Chat ID grup kelas tidak boleh sama!",
        ]);

        kelas::create([
            "kelas"=>$validasi['kelas'],
            "nama_grup"=>$validasi['nama_grup'],
            "nama_walas"=>$validasi['nama_walas'],
            "chat_id"=>$validasi['chat_id'],
        ]);

        return redirect("/admin/pino_bot")->with("success", "Group kelas berhasil di buat");
    }

    // tampilan edit data grup kelas
    public function update_grup_kelas($id)
    {
        $kelas = kelas::find($id);
        return view("admin.edit_grup_kelas", [
            "title"=>"pino_bot",
            "data_kelas" => $kelas
        ]);
    }

    // mengubah data grup kelas
    public function edit_grup_kelas(Request $request, $id)
    {
        $validasi = $request->validate([
            "kelas"=>"required",
            "nama_grup"=>"required",
            "nama_walas"=>"required",
            "chat_id"=>"required",
        ],[
            "kelas.required"=>"Kelas tidak boleh kosong!",
            "nama_grup.required"=>"Nama grup tidak boleh kosong!",
            "nama_walas.required"=>"Nama wali kelas tidak boleh kosong!",
            "chat_id.unique"=>"Chat ID grup kelas tidak boleh sama!",
        ]);

        $kelas = kelas::find($id);

        $kelas->update([
            "kelas"=>$validasi['kelas'],
            "nama_grup"=>$validasi['nama_grup'],
            "nama_walas"=>$validasi['nama_walas'],
            "chat_id"=>$validasi['chat_id'],
        ]);

        return redirect("/admin/pino_bot")->with("success", "Grup kelas berhasil di ubah");
    }

    // menghapus data grup kelas
    public function delete_grup_kelas($id)
    {
        $kelas = kelas::find($id);

        $kelas->delete();

        return redirect("/admin/pino_bot")->with("success", "Grup kelas berhasil di hapus");
    }

    // search grup kelas
    public function search_grup_kelas(Request $request)
    {

        $keyword = $request->search;

        // validasi 
        if($keyword != ''){

            $data = kelas::where("kelas", "like", "%".$keyword."%")->get();

        }else{
            $data = kelas::get();
        }

        $total_data = count($data);

        if($total_data < 1){
            return $data = "<center><h2>Data yang di cari tidak tersedia :(</h2></center>";
        }{
            return view("admin.component.box_grup_kelas", [
                "data_grup_kelas"=>$data,
                "no_grup"=>1,
            ]); 
        }

    }

    // search data guru
    public function search_guru(Request $request)
    {
        $keyword = $request->search_guru;

        if($keyword != ''){

            $data = Guru::where("name", "like", "".$keyword."%")->orderBy("name", "ASC")->get();

        }else{

            $data = Guru::orderBy("name", "ASC")->get();

        }

        $jumlah_data = count($data);

        if($jumlah_data < 1){
            return "<center><h2>Data yang di cari tidak di temukan :(</h2></center>";
        }else{
            return view("admin.component.table_guru", [
                "gurus"=>$data,
                "no_guru"=>1
            ]);
        }
    }

    // search data siswa
    public function search_siswa(Request $request)
    {
        $keyword = $request->search_siswa;
        
        if($keyword != ''){

            $data = Siswa::with(['kelas'])->where("nama_siswa", "like", "".$keyword."%")->get();

        }else{

            $data = Siswa::with(['kelas'])->get();

        }

        $jumlah_data = count($data);

        if($jumlah_data < 1){

            return "<center><h2>Data yang di cari tidak di temukan :(</h2></center>";

        }else{

            return view("admin.component.table_siswa", [
                "siswas"=>$data,
                "no_siswa"=>1,
            ]);

        }

        // return $keyword;

    }

    // tampilan edit
    public function update_siswa($id)
    {
        $siswa = Siswa::all()->where("id", $id);
        return view("admin.edit_siswa",[
            "title"=>"dashboard_admin",
            "siswa"=>$siswa
        ]);
    }

    // mengubah data siswa
    public function edit_siswa(Request $request, $id)
    {
        $validasi = $request->validate([
            "nama"=> "required",
            "jeniskelamin"=> "required",
            "tgllahir"=> "required",
        ],[
            "nama.required"=>"Nama Siswa tidak boleh kosong !",
            "jeniskelamin.required"=>"Jenis Kelamin tidak boleh kosong !",
            "tgllahir.required"=>"Tanggal Lahir tidak boleh kosong !",
        ]);

        $siswa = Siswa::find($id);

        $siswa->update([
            "nama_siswa" => $validasi['nama'],
            "jenis_kelamin"=> $validasi['jeniskelamin'],
            "tgl_lahir"=> $validasi['tgllahir'],
        ]);

        return redirect("/admin")->with("success", "Data Siswa Berhasil Di Ubah");
    }

    // menghapus data siswa
    public function delete_siswa($id)
    {
        $siswa = Siswa::find($id);

        $siswa->delete();

        return redirect("/admin")->with("success", "Data Siswa Berhasil Di Hapus");
    }
}
