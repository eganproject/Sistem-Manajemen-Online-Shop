@extends('dashboard.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Barang Masuk</h1>
</div>
@if (session()->has('success'))            
<div class="alert alert-success alert-dismissible fade show" role="alert">
{{ session('success') }}
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if (session()->has('danger'))            
<div class="alert alert-danger alert-dismissible fade show" role="alert">
{{ session('danger') }}
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

    @error('slugsumber')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
    @enderror


<div>
    <a href="/dashboard/barangmasuk" class="btn btn-primary mb-2"><span data-feather="arrow-left" class="align-text-bottom"></span>
     Kembali</a>
  </div>

<form action="/dashboard/database/tambahsessionbarang">
    @csrf   
    <div class="row">

        <div class="col-lg-8 mb-2">
            <select name="id" class="form-control">
                @foreach ($produk as $p )
                <option value="{{ $p->id }}">{{ $p->namaproduk }}</option>    
                @endforeach
            </select>       
        </div>
        <div class="col-lg-2"> 
            <button class="btn btn-primary" type="submit">Tambah</button>
        </div>
    </div>
</form>

{{-- FORM --}}
<form action="/dashboard/database/tambahbarang" method="post">
   @csrf
<div class="row">
<div class="col-lg-8">

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nama</th>
            <th scope="col">Barang Masuk</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        {{-- <?php dd(Session::get('barangmasuk')) ?> --}}
       
        @if (Session::get('barangmasuk'))
            <?php 
            $i=0; ;
            ?>
        
        @foreach (Session::get('barangmasuk') as $c )
            
        <tr>
            <td class="align-middle text-center" style="width: 10%">{{ $loop->iteration }}</td>
            <td class="align-middle"><p class="fw-bold">{{ $c['namabarang'] }}</p></td>
            <td style="width: 30%" class="align-middle">
                @foreach ($c['variasi'] as $v )
                <input type="hidden" name="produk_stok_slug[]" value="{{ $v['produk_stok_slug'] }}">
                <input type="hidden" name="is_variasi[]" value="{{ $c['is_variasi'] }}">
                <label for="">{{ $v['namavariasioption'] }} <br> Stok :  {{ $v['oldstok'] }}</label>
                <input type="number" name="stok[]" value="0" class="form-control">
                @endforeach
            </td>
            <td class="align-middle text-center" style="width: 20%">
                <a href="/dashboard/database/hapussessionbarangmasuk/{{ $c['id_array'] }}">Hapus</a>
            </td>
        </tr>
        @endforeach
        @endif

    </tbody>
</table>


        <div class="d-flex flex-row-reverse mb-4 mt-4">
                
                <button type="submit" class="btn btn-primary">Tambah</button>
                <a href="/dashboard/database/hapussessiontambahsemua" class="btn btn-danger">Hapus</a>
            </div>

   
        </div>
        <div class="col-lg-4 justify-content-centered">
            <div class="bg-dark">

                <h1 class="h2 text-white align-middle text-center">Sumber Barang</h1>
            </div>
            <hr>

                    <div class="form-check form-check-inline align-middle">
                        <input class="form-check-input" type="radio" id="btnpenjahit" value="Penjahit" name="jenissumber">
                        <label class="form-check-label" for="Penjahit">Penjahit</label>
                    </div>
                    <div class="form-check form-check-inline align-middle">
                        <input class="form-check-input" type="radio" id="btnpemasok" value="Pemasok" name="jenissumber">
                        <label class="form-check-label" for="Pemasok">Pemasok</label>
                    </div>
                    <hr>
                  
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Jenis</th>
                                <th scope="col">Nama Penjahit</th>
                                <th scope="col">Pilih</th>
                            </tr>
                        </thead>
                        <tbody id="tampillist">
                            
                          
                    
                        </tbody>
                    </table>
                  
                    {{-- <div class="form-check form-check-inline align-middle"><input class="form-check-input" type="radio" id="namasumber" value="'+namasumber+'" name="namasumber"><label class="form-check-label" for="namasumber">'+namasumber+'</label></div></td> --}}
                </div>
            </form>
        </div>      {{-- END FORM  --}}
</div>

<script>
const marketplace = document.querySelector('#btnpenjahit')
document.getElementById("btnpenjahit").addEventListener("click", tampilFormmarketplace);

function tampilFormmarketplace(){
        fetch('/dashboard/database/checkJenisSumber?jenissumber=' + btnpenjahit.value).then(response => response.json()).then(data => {
            for (let i = 0; i < data.sumber.length; i++) {
                            let jenissumber = data.sumber[i].jenissumber;
                            let namasumber = data.sumber[i].namasumber;
                            let slugsumber = data.sumber[i].slugsumber;

                            let isi = '<tr id="penjahit"><td>'+jenissumber+'</td><td>'+namasumber+'</td><td><div class="form-check form-check-inline align-middle"><input class="form-check-input" type="radio" id="slugsumber" value="'+slugsumber+'" name="slugsumber"><label class="form-check-label" for="slugsumber">'+slugsumber+'</label></div></td></tr>';
                            
                            document.getElementById("tampillist").insertAdjacentHTML('afterend',isi)
                        }
        });
    }

    const pemasok = document.querySelector('#Pemasok')
    document.getElementById("btnpemasok").addEventListener("click", tampilFormPemasok);

    function tampilFormPemasok(){
        fetch('/dashboard/database/checkJenisSumber?jenissumber=' + btnpemasok.value).then(response => response.json()).then(data => {
            for (let i = 0; i < data.sumber.length; i++) {
                            let jenissumber = data.sumber[i].jenissumber;
                            let namasumber = data.sumber[i].namasumber;
                            let slugsumber = data.sumber[i].slugsumber;

                            let isi = '<tr id="pemasoktr"><td>'+jenissumber+'</td><td>'+namasumber+'</td><td><div class="form-check form-check-inline align-middle"><input class="form-check-input" type="radio" id="slugsumber" value="'+slugsumber+'" name="slugsumber"><label class="form-check-label" for="slugsumber">'+slugsumber+'</label></div></td></tr>';
                            
                            document.getElementById("tampillist").insertAdjacentHTML('afterend',isi)
                        }
        });
    }
</script>
@endsection