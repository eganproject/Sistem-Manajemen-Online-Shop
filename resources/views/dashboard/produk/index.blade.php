@extends('dashboard.layouts.main')


@section('container')

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">List Produk</h1>
        </div>
        @if (session()->has('success'))            
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="row">
            {{-- table produk --}}
                <div class="mb-2">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 border-bottom">
                        <h5>Produk</h5>
                        <div class="mb-2">
                            <a type="button" class="btn btn-success" href="/dashboard/produk/create"><span data-feather="menu" class="align-text-bottom"></span> Tambah Produk</a>
                        </div>
                    </div>
                </div>
                
                <table class="table" id="tableProduk">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">
                                <div class="row">
                                    <div class="col-lg-4">Variasi</div>
                                    <div class="col-lg-4">Stok</div>
                                    <div class="col-lg-4">Harga Pokok</div>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($produk as $p )
                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <td>{{ $p->namaproduk }}</td>
                        <td>{{ $p->kategori_produk->namakategori }}</td>
                        <td>
                            @if ($p->nonVariasiProduk == true)
                            <div class="row">
                                <div class="col-lg-4 mb-2"><span class="text-muted font-italic">none</span> </div>
                                <div class="col-lg-4 mb-2"><span>{{ $p->nonVariasiProduk->ProdukStok->stok }}</span> </div>
                                <div class="col-lg-4 mb-2"><span >@currency($p->nonVariasiProduk->ProdukStok->hargapokok)</span> </div>
                            </div>
                            @else
                                @foreach ($p->VariasiProduk->VariasiProdukOption as $vpo )
                                    
                                <div class="row">
                                    <div class="col-lg-4 mb-2">{{ $vpo->namavariasioption }}</div>
                                    <div class="col-lg-4 mb-2">{{ $vpo->ProdukStok->stok }}</div>
                                    <div class="col-lg-4 mb-2">@currency($vpo->ProdukStok->hargapokok)</div>
                                </div>
                                @endforeach
                            
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
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
            
        $('#tableProduk').DataTable({
          
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