@extends('dashboard.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Penjualan</h1>
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
    <a href="/dashboard/penjualan" class="btn btn-primary mb-2"><span data-feather="arrow-left" class="align-text-bottom"></span>
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
<form action="/dashboard/database/storepenjualan" method="post">
   @csrf
<div class="row">
<div class="col-lg-8">

<table class="table table-bordered">
    <thead class="table-danger">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nama</th>
            <th scope="col">Penjualan</th>
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
                
                <button type="submit" class="btn btn-primary" onclick="printah()">Tambah</button>
                <a href="/dashboard/database/hapussessiontambahsemua" class="btn btn-danger">Hapus</a>
            </div>

   
        </div>
        <div class="col-lg-4 justify-content-centered">
            <div class="bg-dark">

                <h1 class="h2 text-white align-middle text-center">Penjualan</h1>
            </div>
            <hr>
        <div class="row">
            <div class="col">
                <div class="form-check form-check-inline align-middle">
                    <input class="form-check-input" type="radio" id="btnlazada" value="Lazada" name="kategoripenjualan">
                    <label class="form-check-label" for="Lazada">Lazada</label>
                </div>
                <div class="form-check form-check-inline align-middle">
                    <input class="form-check-input" type="radio" id="btnshopee" value="Shopee" name="kategoripenjualan">
                    <label class="form-check-label" for="Shopee">Shopee</label>
                </div>
            </div>
                <div class="col">
                    <div class="form-check form-check-inline align-middle">
                        <input class="form-check-input" type="radio" id="btnreseller" value="Reseller" name="kategoripenjualan">
                        <label class="form-check-label" for="reseller">Reseller</label>
                    </div>
                    <div class="form-check form-check-inline align-middle">
                        <input class="form-check-input" type="radio" id="btnlainnya" value="lainnya" name="kategoripenjualan">
                        <label class="form-check-label" for="lainnya">Lainnya</label>
                    </div>
            </div>
        </div>
    <hr>
                  
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Kategori</th>
                                <th scope="col">Nama</th>
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
        const btnlazada = document.querySelector('#btnlazada')
    document.getElementById("btnlazada").addEventListener("click", tampilFormLazada);

    function tampilFormLazada(){
        fetch('/dashboard/masterdata/checkKategoriPenjualan?kategoripenjualan=' + btnlazada.value).then(response => response.json()).then(data => {
            for (let i = 0; i < data.kategorijual.length; i++) {
                            let kategoripenjualan = data.kategorijual[i].kategori;
                            let namakategoripenjualan = data.kategorijual[i].namakategoripenjualan;
                            let slugkategoripenjualan = data.kategorijual[i].slugkategoripenjualan;

                            let isi = '<tr id="lazada"><td>'+kategoripenjualan+'</td><td>'+namakategoripenjualan+'</td><td><div class="form-check form-check-inline align-middle"><input class="form-check-input" type="radio" id="slugkategoripenjualan" value="'+slugkategoripenjualan+'" name="slugkategoripenjualan"><label class="form-check-label" for="slugkategoripenjualan">'+slugkategoripenjualan+'</label></div></td></tr>';
                            
                            document.getElementById("tampillist").insertAdjacentHTML('afterend',isi)
                        }
        });
    }

    const btnshopee = document.querySelector('#btnshopee')
    document.getElementById("btnshopee").addEventListener("click", tampilFormShopee);

    function tampilFormShopee(){
        fetch('/dashboard/masterdata/checkKategoriPenjualan?kategoripenjualan=' + btnshopee.value).then(response => response.json()).then(data => {
            for (let i = 0; i < data.kategorijual.length; i++) {
                            let kategoripenjualan = data.kategorijual[i].kategori;
                            let namakategoripenjualan = data.kategorijual[i].namakategoripenjualan;
                            let slugkategoripenjualan = data.kategorijual[i].slugkategoripenjualan;

                            let isi = '<tr id="shopee"><td>'+kategoripenjualan+'</td><td>'+namakategoripenjualan+'</td><td><div class="form-check form-check-inline align-middle"><input class="form-check-input" type="radio" id="slugkategoripenjualan" value="'+slugkategoripenjualan+'" name="slugkategoripenjualan"><label class="form-check-label" for="slugkategoripenjualan">'+slugkategoripenjualan+'</label></div></td></tr>';
                            
                            document.getElementById("tampillist").insertAdjacentHTML('afterend',isi)
                        }
        });
    }


    const btnreseller = document.querySelector('#btnreseller')
    document.getElementById("btnreseller").addEventListener("click", tampilFormReseller);

    function tampilFormReseller(){
        fetch('/dashboard/masterdata/checkKategoriPenjualan?kategoripenjualan=' + btnreseller.value).then(response => response.json()).then(data => {
            for (let i = 0; i < data.kategorijual.length; i++) {
                            let kategoripenjualan = data.kategorijual[i].kategori;
                            let namakategoripenjualan = data.kategorijual[i].namakategoripenjualan;
                            let slugkategoripenjualan = data.kategorijual[i].slugkategoripenjualan;

                            let isi = '<tr id="reseller"><td>'+kategoripenjualan+'</td><td>'+namakategoripenjualan+'</td><td><div class="form-check form-check-inline align-middle"><input class="form-check-input" type="radio" id="slugkategoripenjualan" value="'+slugkategoripenjualan+'" name="slugkategoripenjualan"><label class="form-check-label" for="slugkategoripenjualan">'+slugkategoripenjualan+'</label></div></td></tr>';
                            
                            document.getElementById("tampillist").insertAdjacentHTML('afterend',isi)
                        }
        });
    }
    const btnlainnya = document.querySelector('#btnlainnya')
    document.getElementById("btnlainnya").addEventListener("click", tampilFormLainnya);

    function tampilFormLainnya(){
        fetch('/dashboard/masterdata/checkKategoriPenjualan?kategoripenjualan=' + btnlainnya.value).then(response => response.json()).then(data => {
            for (let i = 0; i < data.kategorijual.length; i++) {
                            let kategoripenjualan = data.kategorijual[i].kategori;
                            let namakategoripenjualan = data.kategorijual[i].namakategoripenjualan;
                            let slugkategoripenjualan = data.kategorijual[i].slugkategoripenjualan;

                            let isi = '<tr id="lainnya"><td>'+kategoripenjualan+'</td><td>'+namakategoripenjualan+'</td><td><div class="form-check form-check-inline align-middle"><input class="form-check-input" type="radio" id="slugkategoripenjualan" value="'+slugkategoripenjualan+'" name="slugkategoripenjualan"><label class="form-check-label" for="slugkategoripenjualan">'+slugkategoripenjualan+'</label></div></td></tr>';
                            
                            document.getElementById("tampillist").insertAdjacentHTML('afterend',isi)
                        }
        });
    }

    </script>
@endsection