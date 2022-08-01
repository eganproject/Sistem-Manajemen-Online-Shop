@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tagihan Barang Masuk</h1>
    
</div>
@if (session()->has('success'))            
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
@endif

  <div class="row mt-4">
    <table class="table table-bordered" id="myTable">
        <thead class="table">
          <tr>
            <th scope="col" class="text-center">#</th>
            <th scope="col" class="text-center">Tanggal</th>
            <th scope="col" class="text-center">Jenis</th>
            <th scope="col" class="text-center">Nama</th>
            <th scope="col" class="text-center">Total Tagihan</th>
            <th scope="col" class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
            @php
                $jumlahnya = null;
            @endphp
            @foreach ($tagihan as $key => $tagih )
                
            <tr>
                <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                <td style="width: 10%">{{ date('d-m-Y', strtotime($tagih->updated_at)) }}</td>
                <td>{{ $tagih->SumberBarang->jenissumber }}</td>
                <td>{{ $tagih->SumberBarang->namasumber }}</td>
                <td class="text-end">@currency($tagih->total_tagihan)</td>
                <td class="text-center">
                  <a href="/dashboard/tagihan/barangmasuk/{{ $tagih->id }}" class="btn btn-primary btn-sm"><span data-feather="eye"></span> </a>
                  <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#bayarModal{{ $tagih->id }}"><span data-feather="archive"></span> Bayar</button>
                </td>
            </tr>
            @php
                $jumlahnya += $tagih->total_tagihan
            @endphp
            @endforeach
          </tbody>
          <tr>
              <th colspan="4" class="text-center">Total Tagihan</th>
              <th class="bg-danger">@currency($jumlahnya)</th>
          </tr>
        </table>
  </div>

@foreach ($tagihan as $key => $tagih )
<div class="modal fade" id="bayarModal{{ $tagih->id }}" tabindex="-1" aria-labelledby="bayarModal{{ $tagih->id }}Label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bayarModal{{ $tagih->id }}Label">Pembayaran pada {{ $tagih->SumberBarang->namasumber }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h5>Tagihan : @currency($tagih->total_tagihan)</h5>
          <form action="/dashboard/tagihan/bayarbarangmasuk" method="post">
              @csrf
              <input type="hidden" name="id" value="{{ $tagih->id }}">
              <input type="hidden" name="slugsumber" value="{{ $tagih->slugsumber }}">
              <div class="mb-3 mt-3">
                <label for="keterangan">Keterangan</label>
                <input type="text" name="keterangan" class="form-control" value="Pembayaran tagihan kepada {{ $tagih->SumberBarang->namasumber }}" required>
              </div>

              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Rp.</span>
                <input type="number" class="form-control" name="jumlahbayar" required>
              </div>
              
              </div>

              <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Bayar</button>
              </div>
          </form>
    </div>
  </div>
</div>
@endforeach

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