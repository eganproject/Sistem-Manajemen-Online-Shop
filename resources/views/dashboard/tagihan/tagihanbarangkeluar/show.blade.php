@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tagihan {{ $tagihan->KategoriPenjualan->namakategoripenjualan }}</h1>
</div>
<div class="mb-3">

    <a href="/dashboard/tagihan/barangkeluar" class="btn btn-primary btn-sm">Kembali</a>
</div>


<div class="col-xl-3 col-sm-6 col-12"> 
    <div class="card">
      <div class="card-content">
        <div class="card-body">
          <div class="media d-flex">
            <div class="align-self-center">
              <i class="icon-pencil primary font-large-2 float-left"></i>
            </div>
            <div class="media-body text-right">
              <h3>@currency($tagihan->total_tagihan)</h3>
              <span>Total Kredit</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    <div class="col-lg-12 mt-3">
        <h2 class="text-center">Riwayat Transaksi</h2>
    
  <table class="table table-bordered" id="myTableTransaksi">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col" class="text-center">Tanggal</th>
        <th scope="col" class="text-center">Keterangan</th>
        <th scope="col" class="text-center">Debit</th>
        <th scope="col" class="text-center">Kredit</th>
        <th scope="col" class="text-center">Jumlah</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($transaksi as $key => $trnsks )
        <tr>
            <th scope="row" class="{{ $trnsks->jumlah_bayar != null ? "bg-primary" : ""; }}">{{ $loop->iteration }}</th>
            <td>{{ date('d-m-Y', strtotime($trnsks->created_at)) }}</td>
            <td>{{ $trnsks->keterangan }}</td>
            <td class="text-end">@currency($trnsks->jumlah_bayar)</td>
            <td class="text-end">@currency($trnsks->jumlah_tagihan)</td>
            <td class="text-end">@currency($trnsks->sisa) </td>
        </tr>
        @endforeach
    </tbody>
  </table>


    </div>

    <div class="row mt-5">
  <div class="col-lg-6">
        <h2 class="text-center">Riwayat Penjualan</h2>
    
  <table class="table table-bordered" id="tablePenjualan">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col" class="text-center">Tanggal</th>
        <th scope="col" class="text-center">Produk</th>
        <th scope="col" class="text-center">Jumlah</th>
        <th scope="col" class="text-center">Jumlah Harga</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($penjualan as $key => $pnjln )
      @php
          $totalnya = $pnjln->ProdukStok->hargapokok * $pnjln->jumlah
      @endphp
        <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ date('d-m-Y', strtotime($pnjln->created_at)) }}</td>
            <td>@if ($pnjln->VariasiProdukOption == null)
                {{ $pnjln->nonVariasiProduk->Produk->namaproduk }}
                @else
                {{ $pnjln->VariasiProdukOption->VariasiProduk->Produk->namaproduk .' - '. $pnjln->VariasiProdukOption->namavariasioption }}
                @endif</td>
            <td class="text-center">{{ $pnjln->jumlah }}</td>
            <td class="text-end">@currency($totalnya)</td>
        </tr>
        @endforeach
    </tbody>
  </table>
    </div>


  <div class="col-lg-6">
        <h2 class="text-center">Riwayat Pembayaran</h2>
   
  <table class="table table-bordered" id="myTablePembayaran">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col" class="text-center">Tanggal</th>
        <th scope="col" class="text-center">Keterangan</th>
        <th scope="col" class="text-center">Jumlah Bayar</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($pembayaran as $key => $pmbyr )
      <tr>
        <th>{{ $loop->iteration }}</th>
        <td>{{ date('d-m-Y', strtotime($pmbyr->created_at)) }}</td>
        <td>{{ $pmbyr->keterangan }}</td>
        <td class="text-end">@currency($pmbyr->jumlahbayar)</td>
      </tr>
      @endforeach
    </tbody>
  </table>


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
        $('#myTableTransaksi').DataTable({
          
          dom: 'Bfrtip',
          lengthMenu: [
            [ 5, 10, 25, 50 ],
            [ '5 rows', '10 rows', '25 rows', '50 rows' ]
          ],
          buttons: [
            'pageLength', 'excel', 'pdf', 
          ]
        });
    });
        $(document).ready( function () {
        $('#myTablePembayaran').DataTable({
          
          dom: 'Bfrtip',
          lengthMenu: [
            [ 5, 10, 25, 50 ],
            [ '5 rows', '10 rows', '25 rows', '50 rows' ]
          ],
          buttons: [
            'pageLength', 'excel', 'pdf', 
          ]
        });
    });
        $(document).ready( function () {
        $('#tablePenjualan').DataTable({
          
          dom: 'Bfrtip',
          lengthMenu: [
            [ 5, 10, 25, 50 ],
            [ '5 rows', '10 rows', '25 rows', '50 rows' ]
          ],
          buttons: [
            'pageLength', 'excel', 'pdf', 
          ]
        });
    });
    </script>
@endsection