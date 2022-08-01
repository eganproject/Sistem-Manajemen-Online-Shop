@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Riwayat Transaksi</h1>
    
</div>
      <table class="table table-bordered" id="tableRiwayat">
        <thead class="table-light">
            
          <tr>
            <th scope="col" class="text-center">#</th>
            <th scope="col" class="text-center">Tanggal</th>
            <th scope="col" class="text-center">Keterangan</th>
            <th scope="col" class="text-center">Jenis</th>
            <th scope="col" class="text-center">Sumber</th>
            <th scope="col" class="text-center">Debit</th>
            <th scope="col" class="text-center">Kredit</th>
            <th scope="col" class="text-center">Jumlah</th>
          </tr>
        </thead>
        <tbody>
          
            @foreach ($transaksi as $key => $tran )
                
            <tr>
                <th scope="row" class="text-center {{ $tran->jumlah_bayar !== null ? "bg-primary" : "" }}">{{ $loop->iteration }}</th>
                <td style="width: 10%">{{ date('d-m-Y', strtotime($tran->created_at)) }}</td>
                <td>{{ $tran->keterangan }}</td>
                <td>
                  @if ($tran->SumberBarang == null)
                  {{ $tran->KategoriPenjualan->kategori }}
                @else
                  {{ $tran->SumberBarang->jenissumber }}
                @endif
                </td>
                <td>
                  @if ($tran->SumberBarang == null)
                    {{ $tran->KategoriPenjualan->namakategoripenjualan }}
                  @else
                    {{ $tran->SumberBarang->namasumber }}
                  @endif
                </td>
                <td class="text-end">@currency($tran->jumlah_bayar)</td>
                <td class="text-end {{ $tran->jumlah_tagihan != null ? "bg-danger text-white" : ""; }}">@currency($tran->jumlah_tagihan)</td>
                <td class="text-end">@currency($tran->sisa)</td>
            </tr>
            
            @endforeach
           
        </tbody>
      </table>

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
            
        $('#tableRiwayat').DataTable({
          
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