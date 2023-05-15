<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Care</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>
    <h2 class="title-table">Data</h2>
<div style="display: flex; justify-content: center; margin-bottom: 30px">
    <a href="/logout" style="text-align: center">Logout</a> 
    <div style="margin: 0 10px"> | </div>
    <a href="/" style="text-align: center">Home</a>
</div>

<div style="display: flex; justify-content: flex-end; align-items: center;">
    {{-- menggunakan method get karena route untuk masuk kedalam halaman data ini menggunakan::get --}}
    <form action="" method="GET">
        @csrf
        <input type="text" name="search" placeholder="cari berdasarkan nama....">
        <button type="submit" class= "btn-login" style="margin-top: -1px; margin-left:10px;">cari</button>
    </form>
    {{-- refresh balik lagi ke route data karna nanti pas di klik refresh bersihin riwayat
    pencaharian sebelumnya dan balikin lagi  nya kehalaman awal lagi  --}}
    <a href="{{route('data')}}" style= "margin-buttom: 10px; margin-left:10px;">refresh</a>
    <a href="{{route('export-pdf')}}" style="margin-buttom: 10px" margin-left:20px;>cetak pdf</a>

</div>

<div style="padding: 0 30px">
    <table>
        <thead>
        <tr>
            <th width="5%">No</th>
          <th>Name</th>
          <th>Age</th>
          <th>Weight</th>
          <th>Email</th>
          <th>Telp</th>
          <th>Blood Type</th>
          <th>Image</th>
          <th>Status</th>
          <th>Pesan</th>
          <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
            @php
            $no = 1;
            @endphp
            @foreach ($donor as $donor)
            <tr>
                {{-- menambahkan angka dari 1 dari $no di php tiap baris nya  --}}
                <td>{{$no++}}</td> 
                <td>{{ $donor['name'] }}</td>
                <td>{{ $donor['age'] }}</td>
                <td>{{ $donor['weight'] }}</td>
                <td>{{ $donor['email'] }}</td>
                {{-- mengganti format no yg 08 menjadi 628 --}}
                @php
                //substr_replace: mengubah karakter string
                //punya 3 argumen . argumen ke -11 : data yg mau di  masukan string 
                //argumen ke-2 : mulawi dari index mana ubahnya 
                //argumen ke-3 : samppai index mana diubahnya 
                $phoneNumber = substr_replace($donor->phoneNumber, "62", 0, 1);
                @endphp

                {{-- yg ditampilkan tag a dengan $phoneNumber(data no_telp  yg udah diubah jadi format 628) --}}
                @php
                $pesanWA = '';
                // kalau uda di response data reportnya, cht wa nya data dr response di tampilkan
                if(!is_null($donor->response)) {
                $pesanWA = 'Hallo'. $donor->name . '! pengaduan anda di ' . $donor->response['status'] . '.Berikut pesan untuk anda 
                 :' . $donor->response['jadwal'];
                }
                // kalau belum di response pengaduannya, cht wa nya kaya gini 
                else {
                    $pesanWa = 'Belum ada data response';
                }
                @endphp
                <td><a href="https://wa.me/{{$phoneNumber}}?text={{$pesanWA}}" target="_blank">{{ $phoneNumber }}</a></td>

                <td>{{ $donor['bloodType'] }}</td>
                <td>
                    {{-- untuk menampilkan gambar full layar di tab baru  --}}
                    <a href="../assets/img/{{ $donor->file }}" target="_blank">
                      <img src="{{ asset('assets/img/'.$donor->file)}}" width="120">
                    </a>
                </td>
                
                <td>
                @if ($donor->response)
                        {{$donor->response ['status'] }}
                    @else
                    -
                    @endif
                </td>
                  <td>
                    {{-- cek apakah data report in sudah memmiliki relasi dengan data dr with ('response') --}}
                    @if ($donor->response)
                      {{-- kalau ada hasil relasinya sampaikan pesan  --}}
                      {{ $donor->response['jadwal'] }}
                    @else
                    {{-- kalau tidak tampilkan tanda ini --}}
                    -
                    @endif
                  </td>
                  
                <td>
                    <form action="{{ route('destroy', $donor->id) }}"method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"style="margin-left: 10px;" class="btn-delete">Hapus</button>
                    </form>     
                    <div>
                        <form action="{{ route('created.pdf',$donor->id)}}" method="GET">
                        <button class="submit" style="margin-left: 10px; margin-top:10ipx;">print</button>
                        </form>
                    </div>
                    <div>
                        <form action="{{ route('export-excel', $donor->id) }}" method="get" style="margin-left: 10px; margin-top:10ipx;">
                            @csrf
                            <button type="submit">Cetak Excel</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>