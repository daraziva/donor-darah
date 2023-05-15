<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use Excel;
use App\Exports\ReportsExport;
use App\Models\Response;


class DonorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportPDF()
    {
        //ambil data yang akan di tampilkan pada pdf, bisa juga dengan where atau
        //eloquent lainnya dan jangan gunakan pagination
        //jangan lupa konvert data jadi Array dengan toArray()
        $data = Donor::with('response')->get()->toArray();
        //kirim data yang diambil kepada viewyg akan di tampilkan kirim dengan inisial 
        view()->share('donor', $data);
        //panggil view blade yang akan di cetak pdf serta data y g akan digunakan 
        $pdf = PDF::loadView('print', $data)->setPaper('a4', 'landscape');
        //dowlaod PDF file dengan nama tertentu 
        return $pdf->download('data_donor.pdf');  
    }

        public function createdPDF($id)
        {
        //ambil data yang akan di tampilkan pada pdf, bisa juga dengan where atau
        //eloquent lainnya dan jangan gunakan pagination
        //jangan lupa konvert data jadi Array dengan toArray()
        $data = Donor::with('response')->where('id',$id)->get()->toArray();
        //kirim data yang diambil kepada viewyg akan di tampilkan kirim dengan inisial 
        view()->share('donor', $data);
        //panggil view blade yang akan di cetak pdf serta data y g akan digunakan 
        $pdf = PDF::loadView('print', $data)->setPaper('a4', 'landscape');
        //dowlaod PDF file dengan nama tertentu 
        return $pdf->download('data_donor.pdf'); 
        }
        
        public function exportExcel()
        {
            //nama file yang akan terdownload 
            $file_name = 'data_keseluruhan_pengaduan.xlsx';
            //memanggill file Reportsexport dann mendowload dengan nama seperti 
            return Excel::download(new ReportsExport, $file_name);
        }

    public function index()
    {
        $donors= Donor::orderBy('created_at', 'DESC')->simplePaginate(2);
        return view('index', compact('donors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function dataPetugas(Request $request)
    {
        $search = $request->search;
        // with : ambil relasi  (nama fungsi hasOne/hasMany/belongsTo di modelnya),
        $donors = Donor::with('response')->where('name', 'LIKE', '%' . $search . '%')->orderBy('created_at', 'DESC')->get();
        return view('data_petugas', compact('donors'));
    }

    public function data(Request $request)
    {
        //ambil data di input ke data yang name nya search
        $search = $request->search;
        //where akan mencari data berdasarkan column nama 
        //data yang di ambil merupakan data yg 'LIKE' terdapat  teks yang di maksud ke input search 
        //contoh : ngisi input search dengan 'fema'
        //bakal nyaari ke db yg column nya di isi 'fema'  nya
        $donor = Donor:: with ('response')->where('name','like','%'. $search. '%')->orderBy
        ('created_at', 'DESC')->get();
        return view('data', compact('donor'));
    }

     public function auth(Request $request)
     {
         //validasi
         $request->validate([
             'email' => 'required|email:dns',
             'password' => 'required',
         ]);
         //ambil data dan simpan di variable 
         $user = $request->only('email', 'password');
         //simpan data ke auth dengawn Auth::attemp
         //cek proses penyimpanan ke auth berhasil atau tidak lewat if else
         if (Auth::attempt($user)){
             //nesting if, if bersarang, if di dalam if 
             //kalo data login ada masuk kedalam fitur Auth, di cek lagi pake if else 
             //kalau data Auth tersebut role  nya admin maka masuk ke route data
             //kalau data Auth role nya petugas maka masuk ke route data.petugas
             if (Auth::user()->role == 'admin') {
                 return redirect()->route ('data');
             }elseif(Auth::user()->role == 'petugas') {
               return redirect()->route('data_petugas');
             }
             
             return redirect ()->route('data');
         }else {
             return redirect ()->back()->with('gagal', 'gagal login!');
         }
     }
 
     public function logout ()
     {
         Auth::logout();
         return redirect ()->route('login');
     }
 
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   //validasi data
        $request->validate([
            'name'=>'required',
            'age'=>'required|max:2',
            'weight'=>'required|min:2',
            'email'=>'required',
            'phoneNumber'=>'required|max:13',
            'bloodType'=>'required',
            'file'=>'required|image|mimes:jpg,jpeg,png,svg',
        ]);

        //     //pindah foto ke folder public
        // $path = public_path('assets/img/');
        // $image =$request->file('foto');
        // $imgName =rand() . '.' . $image->extension(); 
        // //foto.jpg :1234.jpg
        // $image->move($path, $imgName);

        $path = public_path('assets/img/');
        $image =$request->file('file');
        $imgName =rand() . '.' . $image->extension();//foto.jpg :1234.jpg
        $image->move($path, $imgName);

        //tambah data ke db 
        Donor::create([
                'name' =>$request->name,
                'age'=>$request->age,
                'weight'=>$request->weight,
                'email'=>$request->email,
                'phoneNumber'=>$request->phoneNumber,
                'bloodType'=>$request->bloodType,
                'file'=>$imgName,
        ]);
        return redirect()->back()->with('succes', 'berhasil menambahkan pengaduan!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Donor  $donor
     * @return \Illuminate\Http\Response
     */
    public function show(Donor $donor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Donor  $donor
     * @return \Illuminate\Http\Response
     */
    public function edit(Donor $donor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Donor  $donor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Donor $donor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Donor  $donor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   //cari data yang dimaksud
        $data = Donor::where('id',$id)->firstOrfail();
        //$data isinya -> nik sampe foto dr pengaduan 
        //hapus data foto dari folder publick:path . nama  fotonya
        //nama fotonya diambil dari $data yang diatas terus ngambil dari column 'foto'
        unlink ('assets/image/'.$data['foto']); 
        //hapus data dari data base 
        $data -> delete();
        Response::where('donor_id', $id)->delete();
        //setelahnya dikembalikanlagi ke halaman awal 
        return redirect ()->back();

    }
}
