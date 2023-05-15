<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Medical Care</title>
        <link rel="stylesheet" href="asset{{'assets/css/style.css'}}">
    </head>
    <body>
        <form action="{{route('response.update', $donorId)}}" method="POST"style="width: 500px; margin: 50px auto; display: block;">
            @csrf
            @method('PATCH')
            <div class="input-card">
                <label for="status">Status :</label>
                @if ($donor)
                <select name="status" id="status">
                    {{-- kalau ada  --}}
                    <option value="ditolak"{{ $donor['status']=='ditolak' ? 'selected' : ''  }}>ditolak</option>
                    <option value="proses"{{ $donor['status']=='proses' ? 'selected' : '' }}>proses</option>
                    <option value="diterima"{{ $donor['status']=='diterima' ?  'selected' : '' }}>diterima</option>
                </select>
                @else
                <select name="status" id="status">
                    <option selected hidden disabled>pilih status</option>
                    <option value="ditolak">ditolak</option>
                    <option value="proses">proses</option>
                    <option value="diterima">diterima</option>
                </select>
                @endif
            </div>


            <div class="input-card">
                <p>Tanggal:</p>
            <input type="date" name="jadwal" id="jadwal">
            </div>

            @if ($errors->any())
              <ul style="width: 100%; background: red; padding: 10px">
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
              </ul>
              @endif
  
              @if (Session::get('success'))
              <div style="width: 100%; background: green; padding: 5px">
                  {{ Session::get('success') }}
              </div>
              @endif
              
            <button type="submit">Send</button>
        </form>
    </body>
</html>