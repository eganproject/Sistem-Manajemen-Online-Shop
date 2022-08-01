@extends('dashboard.layouts.main')

@section('container')


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Database</h1>
</div>
@if (session()->has('success'))            
<div class="alert alert-success alert-dismissible fade show" role="alert">
{{ session('success') }}
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row d-flex flex-row-reverse">
    <div class="col-lg-4">
            <a href="/dashboard/database/barangmasuk" class="text-decoration-none">
            <div class="card bg-success" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title text-white">Barang Masuk</h5>
                    <hr class="card-title text-white">
                    <p class="card-text text-white">Menambahkan barang yang masuk berupa stok dan sebagainya</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-4">
            <a href="/dashboard/database/penjualan" class="text-decoration-none">
            <div class="card bg-danger" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title text-white">Penjualan</h5>
                    <hr class="card-title text-white">
                    <p class="card-text text-white">Menambahkan data penjualan atau yang berkaitan dengan barang keluar</p>
                </div>
            </div>
        </a>
    </div>
    
   
</div>

<div class="row">
    {{-- table produk --}}
        <div class="mb-2">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 border-bottom">
                <h5>Produk</h5>
               
            </div>
        </div>
        
        
        <table class="table" id="myTable">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Variasi</th>
                    <th scope="col">Nama Variasi</th>
                    <th scope="col">Stok</th>
                    <th scope="col">Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produk as $p )
                    <tr>
                        <th scope="row" class="align-middle">{{ $loop->iteration }}</th>
                        <td class="align-middle">{{ $p->namaproduk }}</td>
                        <td class="align-middle">{{ $p->kategori_produk->namakategori }}</td>
                        @if ($p->is_variasi == 1)
                        <td class="align-middle">{{ $p->VariasiProduk->namavariasi }}</td>
                        <td class="align-middle">
                            <?php $totalstok = 0; ?>
                            @foreach ( $p->VariasiProduk->VariasiProdukOption as $vop )
                            <li style="list-style:none;">{{ $vop->namavariasioption   }}</li>
                            <?php $totalstok+= $vop->produkstok->stok ?>
                            @endforeach
                        </td>
                      <td class="align-middle">
                        {{ $totalstok; }}
                      </td>
                        <td class="align-middle">
                            <?php

                            $query = DB::select("select hargapokok from produk_stoks as a join variasi_produk_options as b on a.stokslug = b.produk_stok_slug join variasi_produks as c on b.variasi_produk_slug  = c.slugvariasi where c.produk_slug = '$p->slug' ");

                            $x = collect($query)->min();
                            $y = collect($query)->max();

                            foreach($x as $x) {
                                echo "<p>" .$x . '<br>'  ;
                                
                            }; 
                            foreach($y as $y){
                                echo " - <br>".$y . "</p>";
                            };

                            ?>
                           
                        </td>
                            @else
                            <td class="text-muted">-</td>
                            <td class="text-muted">-</td>
                            <td>{{ $p->nonVariasiProduk->ProdukStok->stok }}</td>
                            <td>{{ $p->nonVariasiProduk->ProdukStok->hargapokok }}</td>
                        @endif
                        
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
