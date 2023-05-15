<!DOCTYPE html>
 <html lang="en">
 <head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Medical Care</title>
   <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
 </head>
<body>
  <h2 class="title-table">Data</h2>
  <div style="display: flex; justify-content: center; margin-bottom: 30px">
  <a href="/logout" style="text-align: center">Logout</a>
  <div style="margin: 0 10px"> | </div>
  <a href="/" style="text-align: center">Home</a>
  </div>
  <div style="display: flex; justify-content: flex-end;align-items: center;">
  {{--menggunakan method get karena route untuk masuk ke halaman data ini menggunakan::get--}}
    <from action=""method="GET">
      <input type="text" name="search"placholder="Search by name...">
      <button type="sumbit"class="btn-login"
      style="margin-top: -1px">Search</button>
    </from>
      <a href="{{route('data')}}" style="margin-left: 10px; margin-top: -2px">Refresh</a>
  </div>
  <div style="padding: 0 30px">
  <table>
  <thead>
      <tr>
          <th width="5%">No</th>
          <th>Name</th>
          <th>Age</th>`
          <th>Weight</th>
          <th>Email</th>
          <th>Telp</th>
          <th>Blood Type</th>
          <th>Image</th>
          <th>Status</th>
          <th>Jadwal</th>
          <th>Aksi</th>
      </tr>
  </thead>
  @php
  $no = 1;
  @endphp
  <tbody>
  @foreach($donors  as $donor)
  <tr>
  <td>{{$no++}}</td>
  <td>{{$donor['name']}}</td>
  <td>{{$donor['age']}}</td>
  <td>{{$donor['weight']}}</td>
  <td>{{$donor['email']}}</td>
  <td>{{$donor['phoneNumber']}}</td>
  <td>{{$donor['bloodType']}}</td>
  <td>
  <img src="{{asset('assets/img/'.$donor->file)}}"width='120'>
  </td>
  <td>
    {{-- cek apakah data report ini sudah memiliki relasi dengan data dr with ('response') --}}
    @if ($donor->response)
      {{-- kalau ada hasil relasiny, tampilkan bagian status --}}
        {{$donor->response ['status'] }}
    @else
    {{-- kalau engga ada tampilkan tanda ini  --}}
    -
    @endif
  </td>
  <td>
    {{-- cek apakah data report in sudah memmiliki relasi dengan data dr with ('response') --}}
    @if ($donor->response)
      {{-- kalau ada hasil relasinya sampaikan pesan  --}}
      {{ $donor->response['jadwal'] }}
    @else
     <!-- kalau tidak tampilkan tanda ini  -->
    -
    @endif
  </td>
  <td style="display: flex; justify-content: center;">
    {{-- kirim data id dari foreach report ke path dinamis punya nya route response.edit --}}
   <a href="{{route('response.edit',$donor->id) }}"class="back-btn">send response</a>
  </td>

  <td>
  </td>
  </tr>
  @endforeach
  </tbody>
  </table>
  </div>
</body>
</htm