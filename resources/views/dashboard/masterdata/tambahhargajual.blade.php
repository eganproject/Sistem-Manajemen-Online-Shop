@extends('dashboard.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Harga Jual</h1>
</div>
@if (session()->has('success'))            
<div class="alert alert-success alert-dismissible fade show" role="alert">
{{ session('success') }}
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
    <a href="/dashboard/masterdata" class="btn btn-primary mb-2"><span data-feather="arrow-left" class="align-text-bottom"></span>
     Kembali</a>
  </div>

{{-- FORM --}}
<div class="row">
    <div class="col-lg-8">
    <form action="/dashboard/masterdata/storehargajual" method="post">
       @csrf

<table class="table table-bordered">
    <thead class="table-danger">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nama</th>
            <th scope="col">Penjualan</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody id="tampilbarang">
       
        @if (Session()->get('barang') !== null)
        {{-- <?php dd(session()->get('barang')) ?> --}}
        <tr>
            <?php $psd= Session()->get('keterangannya') ?>
            <td colspan="4" class="text-center"><h4>{{ $psd['kategoripenjualan'] . ' : ' . $psd['namakategoripenjualan'] }}</h4></td>
        </tr>
        <input type="hidden" name="slugkategoripenjualan" value="{{ $psd['slugkategoripenjualan'] }}">
            @foreach (Session()->get('barang') as $barang )
                
            
            <tr>
                <td class="align-middle text-center" style="width: 10%"></td>
                <td class="align-middle"><p class="fw-bold">{{ $barang['namaproduk'] }}</p></td>
                <td style="width: 30%" class="align-middle">
                    {{-- @if ($barang['is_variasi'] != null) --}}
                        @foreach ($barang['variasi'] as $v )
                        <input type="hidden" name="produk_stok_slug[]" value="{{ $v['produk_stok_slug'] }}">
                        <label for="">{{ $v['namavariasi'] }} <br> Harga Pokok :  @currency($v['hargapokok'])</label>
                        <input type="number" name="hargajual[]" value="0" class="form-control">
                        @endforeach
                    {{-- @else
                        <input type="hidden" name="produk_stok_slug[]" value="{{ $barang['produk_stok_slug'] }}">
                        <label for="">{{ $barang['namavariasi'] }} <br> Harga Pokok :  @currency($barang['hargapokok'])</label>
                        <input type="number" name="hargajual[]" value="0" class="form-control">
                    @endif --}}
                </td>
                <td class="align-middle text-center" style="width: 20%"></td>
            </tr>
            @endforeach
            
        </tbody>
    </table>
    <div class="d-flex flex-row-reverse mb-4 mt-4">
        
        <button type="submit" class="btn btn-primary">Tambah</button>
        <a href="/dashboard/masterdata/hapussessionsemuabaranghargajual" class="btn btn-danger">Hapus</a>
    </div>
</form>
</div>
@else

</tbody>
</table>
</div>
</form>
<div class="col-lg-4 justify-content-centered">
    <div class="bg-dark">
        <h1 class="h2 text-white align-middle text-center">Kategori</h1>
    </div>
    <hr>

    <form action="/dashboard/masterdata/tambahsessionbaranghargajual">
        @csrf   
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
                    <button class="btn btn-primary" type="submit">Pilih</button>
                </div>
                
            </div>      {{-- END FORM  --}}
        </div>
    </form>   
    @endif

    <script>
        const btnlazada = document.querySelector('#btnlazada')
    document.getElementById("btnlazada").addEventListener("click", tampilFormLazada);

    function tampilFormLazada(){
        fetch('/dashboard/masterdata/checkKategoriPenjualan?kategoripenjualan=' + btnlazada.value).then(response => response.json()).then(data => {
            for (let i = 0; i < data.kategorijual.length; i++) {
                            let kategoripenjualan = data.kategorijual[i].kategori;
                            let namakategoripenjualan = data.kategorijual[i].namakategoripenjualan;
                            let slugkategoripenjualan = data.kategorijual[i].slugkategoripenjualan;

                            let isi = '<tr id="lazada"><td>'+kategoripenjualan+'</td><td>'+namakategoripenjualan+'</td><td><div class="form-check form-check-inline align-middle"><input class="form-check-input" type="radio" id="btnslugkategoripenjualan" value="'+slugkategoripenjualan+'" name="slugkategoripenjualan"><label class="form-check-label" for="slugkategoripenjualan">'+slugkategoripenjualan+'</label></div></td></tr>';
                            
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

                            let isi = '<tr id="shopee"><td>'+kategoripenjualan+'</td><td>'+namakategoripenjualan+'</td><td><div class="form-check form-check-inline align-middle"><input class="form-check-input" type="radio" id="btnslugkategoripenjualan" value="'+slugkategoripenjualan+'" name="slugkategoripenjualan"><label class="form-check-label" for="slugkategoripenjualan">'+slugkategoripenjualan+'</label></div></td></tr>';
                            
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

                            let isi = '<tr id="reseller"><td>'+kategoripenjualan+'</td><td>'+namakategoripenjualan+'</td><td><div class="form-check form-check-inline align-middle"><input class="form-check-input" type="radio" id="btnslugkategoripenjualan" value="'+slugkategoripenjualan+'" name="slugkategoripenjualan"><label class="form-check-label" for="slugkategoripenjualan">'+slugkategoripenjualan+'</label></div></td></tr>';
                            
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