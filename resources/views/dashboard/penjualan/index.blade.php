@extends('dashboard.layouts.main')

@section('container')
<link href="/css/carddashboard.css" rel="stylesheet">
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Penjualan</h1>
    
</div>
<div class="row col-lg-10">
  <div class="col-lg-4">
    <form action="/dashboard/penjualan/index">
        @csrf
        <div class="input-group mb-3">
            <input type="date" class="form-control" name="start_date">
            <input type="date" class="form-control" name="end_date">
            <button class="btn btn-secondary" type="submit">Pilih</button>
        </div>
    </form>
  </div>
  <div class="col-lg-8 d-flex flex-row-reverse mb-3">
    <a class="btn btn-success btn-sm" href="/dashboard/database/penjualan">
      Tambah Penjualan
    </a>
  </div>
</div>

<div class="row">
  <div class="col-lg-10">
  
    <table class="table table-bordered" id="tablePenjualan">
        <thead class="table-light">
            
          <tr>
            <th scope="col" class="text-center">#</th>
            <th scope="col" class="text-center">Tanggal</th>
            <th scope="col" class="text-center">Produk</th>
            <th scope="col" class="text-center">Kategori</th>
            <th scope="col" class="text-center">Nama</th>
            <th scope="col" class="text-center bg-warning">Jumlah</th>
            <th scope="col" class="text-center">Jumlah Harga</th>
          </tr>
        </thead>
        <tbody>
            @php
              $jumlahterjual = null;
              $totalpenjualan = null;
              $hpp = null;
            @endphp
            @foreach ($penjualans as $key => $penjualan )
           @php
             $jumlahterjual += $penjualan->jumlah;
             if ($penjualan->VariasiProdukOption == null){
              $hrgjual =  \App\Models\HargaJual::where('slugkategoripenjualan',$penjualan->KategoriPenjualan->slugkategoripenjualan)->where('produk_stok_slug', $penjualan->nonVariasiProduk->produk_stok_slug)->first();
              $jumlahharganya = $hrgjual->hargajual * $penjualan->jumlah;
              $totalpenjualan += $jumlahharganya;
              $hpp += $penjualan->jumlah * $penjualan->nonVariasiProduk->ProdukStok->hargapokok;
            }else{
              $hrgjual = \App\Models\HargaJual::where('slugkategoripenjualan',$penjualan->KategoriPenjualan->slugkategoripenjualan)->where('produk_stok_slug', $penjualan->VariasiProdukOption->produk_stok_slug)->first();
              $jumlahharganya = $hrgjual->hargajual * $penjualan->jumlah;
              $totalpenjualan += $jumlahharganya;
              $hpp += $penjualan->jumlah * $penjualan->VariasiProdukOption->ProdukStok->hargapokok;
             }
           @endphp
            <tr>
                <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                <td style="width: 10%">{{ date('d-m-Y', strtotime($penjualan->created_at)) }}</td>
                <td>
                    @if ($penjualan->VariasiProdukOption == null)
                   {{ $penjualan->nonVariasiProduk->Produk->namaproduk }} <a href="/dashboard/penjualan/showpenjualanproduk/{{ $penjualan->id }}" class="text-decoration-none">  <span data-feather="eye" class="align-text-bottom"></span></a>
                    @else
                   {{ $penjualan->VariasiProdukOption->VariasiProduk->Produk->namaproduk .' - '. $penjualan->VariasiProdukOption->namavariasioption }} <a href="/dashboard/penjualan/showpenjualanproduk/{{ $penjualan->id }}" class="text-decoration-none">  <span data-feather="eye" class="align-text-bottom"></span></a>
                    @endif
                </td>
                <td 
                @if ($penjualan->KategoriPenjualan->kategori == 'Lazada')
                class="bg-primary text-white"  style="font-weight: bold;"
                @elseif($penjualan->KategoriPenjualan->kategori == 'Shopee')
                class="text-white" style="background-color:orange; font-weight: bold;"
                @endif
                >{{ $penjualan->KategoriPenjualan->kategori }}</td>
                <td>{{ $penjualan->KategoriPenjualan->namakategoripenjualan }} <a href="/dashboard/penjualan/showpenjualannamakategoripenjualan/{{ $penjualan->id }}" class="text-decoration-none">  <span data-feather="eye" class="align-text-bottom"></span></a></td>
                <td class="text-center bg-warning">{{ $penjualan->jumlah }}</td>
                <td class="text-center">@currency($jumlahharganya)</td>
            </tr>
            @endforeach
        </tbody>
        <tr>
          <th colspan="5" class="text-center">Jumlah/Total</th>
          <th class="text-center">{{ $jumlahterjual }} pcs </th>
          <th class="text-end">@currency($totalpenjualan)</th>
        </tr>
      </table>
  </div>
  <div class="col-lg-2">
    <div class="card l-bg-cherry">
      <div class="card-statistic-3 p-4">
          <div class="card-icon card-icon-large"><i class="fas fa-shopping-cart"></i></div>
          <div class="mb-4">
              <h5 class="card-title mb-0">Penjualan</h5>
              <p>{{ $jumlahterjual }} Pcs</p>
            </div>
            <div class="row align-items-center mb-2 d-flex">
              <div class="col-12">
                  <h4 class="d-flex align-items-center mb-0">
                   @currency($totalpenjualan)
                  </h4>
              </div>
          </div>
      </div>
  </div>

  <div class="card l-bg-orange-dark">
    <div class="card-statistic-3 p-4">
        <div class="card-icon card-icon-large"><i class="fas fa-dollar-sign"></i></div>
        <div class="mb-4">
            <h5 class="card-title mb-0">Profit</h5>
        </div>
        <div class="row align-items-center mb-2 d-flex">
            <div class="col-8">
                <h4 class="d-flex align-items-center mb-0">
                  <?php $profit = $totalpenjualan - $hpp; ?>
                    @currency($profit)
                </h4>
            </div>
            {{-- <div class="col-4 text-right">
                <span>2.5% <i class="fa fa-arrow-up"></i></span>
            </div> --}}
        </div>
    </div>
</div>

  </div>
</div>


@endsection


@section('containerjavascript')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>


    <script>
        $(document).ready( function () {
            
        $('#tablePenjualan').DataTable({
          
          dom: 'Bfrtip',
          lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
          ],
          buttons: [
            'pageLength', 'excel', 'pdf', 
          ]
        });
    });
    </script>
@endsection