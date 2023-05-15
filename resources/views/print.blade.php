<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Data</title>
</head>
<body>
    <table>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Age</th>
            <th>Weight</th>
            <th>Email</th>
            <th>Telp</th>
            <th>Blood Type</th>
            <th>Status</th>
            <th>Jadwal</th>
        </tr>
        @php $no = 1;@endphp
        @foreach($donor as $donor)
        <tr>
            <td>{{$no++}}</td>
            <td>{{$donor['name']}}</td>
            <td>{{$donor ['age']}}</td>
            <td>{{$donor ['weight']}}</td>
            <td>{{$donor ['email']}}</td>
            <td>{{$donor ['phoneNumber']}}</td>
            <td>{{$donor ['bloodType']}}</td>
            <td><img src="assets/img/{{$donor['file']}}" width="80"></td>
            <td>{{ \Carbon\carbon::parse($donor['created_at'])->format('j F,Y')}}</td>
            <td>
                @if ($donor['response'])
                    {{$donor['response'] ['status'] }}
                @else
                {{-- kalau engga ada tampilkan tanda ini  --}}
                -
                @endif
              </td>
              <td>
                {{-- cek apakah data report in sudah memmiliki relasi dengan data dr with ('response') --}}
                @if ($donor['response'])
                  {{-- kalau ada hasil relasinya sampaikan jadwal  --}}
                  {{ $donor['response']['jadwal'] }}
                @else
                {{-- kalau tidak tampilkan tanda ini --}}
                -
                @endif
              </td>
              
        </tr>
        @endforeach
    </table>
</body>
</html>