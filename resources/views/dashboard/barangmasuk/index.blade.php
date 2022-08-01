@extends('dashboard.layouts.main')

@section('container')
<link href="/css/carddashboard.css" rel="stylesheet">
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Barang Masuk</h1>
   
</div>
<div class="row col-lg-10">
    <div class="col-lg-4">
      <form action="/dashboard/barangmasuk/index">
          @csrf
          <div class="input-group mb-3">
              <input type="date" class="form-control" name="start_date">
              <input type="date" class="form-control" name="end_date">
              <button class="btn btn-secondary" type="submit">Pilih</button>
          </div>
      </form>
  </div>
  
  <div class="col-lg-8 d-flex flex-row-reverse mb-3">
    <a class="btn btn-success btn-sm" href="/dashboard/database/barangmasuk">
      Tambah Barang
    </a>
  </div>
</div>

<div class="row">
<div class="col-lg-10">
    <table class="table table-bordered" id="myTable">
        <thead class="table-light">
            
          <tr>
            <th scope="col" class="text-center">#</th>
            <th scope="col" class="text-center">Tanggal</th>
            <th scope="col" class="text-center">Produk</th>
            <th scope="col" class="text-center">Jenis</th>
            <th scope="col" class="text-center">Pemasok</th>
            <th scope="col" class="text-center bg-warning">Jumlah</th>
            <th scope="col" class="text-center">Total Stok</th>
          </tr>
        </thead>
        <tbody>
          @php
              $jumlahmasuk = null;
              $totalhargabarangmasuk = null;
            @endphp
            @foreach ($barangmasuk as $key => $bm )
            
            @php
            $jumlahmasuk += $bm->jumlah;
            if ($bm->VariasiProdukOption == null){
             $mnjmnhrga =  \App\Models\ManajemenHarga::where('slugmain',$bm->SumberBarang->slugsumber)->where('produk_slug', $bm->nonVariasiProduk->produk_slug)->first();
             $jumlahharganya = $mnjmnhrga->harga * $bm->jumlah;
             $totalhargabarangmasuk += $jumlahharganya;
           }else{
             $mnjmnhrga = \App\Models\ManajemenHarga::where('slugmain',$bm->SumberBarang->slugsumber)->where('produk_slug', $bm->VariasiProdukOption->VariasiProduk->produk_slug)->first();
             $jumlahharganya = $mnjmnhrga->harga * $bm->jumlah;
             $totalhargabarangmasuk += $jumlahharganya;
            }
          @endphp
            <tr>
                <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                <td style="width: 10%">{{ date('d-m-Y', strtotime($bm->created_at)) }}</td>
                <td>
                    @if ($bm->VariasiProdukOption == null)
                    {{ $bm->nonVariasiProduk->Produk->namaproduk }} <a href="/dashboard/barangmasuk/showbarangmasukproduk/{{ $bm->id }}" class="text-decoration-none">  <span data-feather="eye" class="align-text-bottom"></span></a>
                    @else
                    {{ $bm->VariasiProdukOption->VariasiProduk->Produk->namaproduk .' - '. $bm->VariasiProdukOption->namavariasioption }} <a href="/dashboard/barangmasuk/showbarangmasukproduk/{{ $bm->id }}" class="text-decoration-none">  <span data-feather="eye" class="align-text-bottom"></span></a>
                    @endif
                </td>
                <td>{{ $bm->SumberBarang->jenissumber }}</td>
                <td>{{ $bm->SumberBarang->namasumber }} <a href="/dashboard/barangmasuk/showbarangmasuknamasumber/{{ $bm->id }}" class="text-decoration-none">  <span data-feather="eye" class="align-text-bottom"></span></a></td>
                <td class="text-center bg-warning">{{ $bm->jumlah }}</td>
                <td class="text-center">{{ $bm->ProdukStok->stok }}</td>
            </tr>
            @endforeach
        </tbody>
      </table>
</div>
<div class="col-lg-2">
  <div class="card-statistic-3 p-4">
    <div class="mb-4">
        <h5 class="card-title mb-0">BarangMasuk</h5>
        <p>{{ $jumlahmasuk }} Pcs</p>
      </div>
      <div class="row align-items-center mb-2 d-flex">
        <div class="col-12">
            <h4 class="d-flex align-items-center mb-0">
             @currency($totalhargabarangmasuk)
            </h4>
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
            
        $('#myTable').DataTable({
          
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