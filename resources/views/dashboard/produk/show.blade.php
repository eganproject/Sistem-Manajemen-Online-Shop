@extends('dashboard.layouts.main')


@section('container')

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <a href="/dashboard/produk" class="btn btn-primary mb-2"><span data-feather="arrow-left" class="align-text-bottom"></span>
             Kembali</a>
        </div>

        <h1>{{ $produk->namaproduk }}</h1>
        <hr>
        <p>{{ $produk->kategori_produk->namakategori }}</p>
        {{-- <p>{{ $produk->nonVariasiProduk->produk_slug }}</p> --}}

        @if (session()->has('success'))            
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="col-lg-10">
                <form action="/dashboard/produk/{{ $produk->id }}" method="post">
                        @method('put')
                    @csrf
                    <div class="mb-3">
                      <label for="namaproduk" class="form-label">Nama Produk</label>
                      <input type="text" class="form-control" id="namaproduk" name="namaproduk" value="{{ $produk->namaproduk }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Kategori</label>
                        <select class="form-select" id="kategori_produk_id" name="kategori_produk_id">
                                
                                @foreach ($kategoriproduk as $kp )
                                
                                <option <?php if($kp->id == $produk->kategori_produk_id){
                                        echo'selected';
                                } ?> value="{{ $kp->id }}">{{ $kp->namakategori }}</option>

                        @endforeach

                        </select>
                        </div>
                        <input type="hidden" name="id_produk" id="id_produk" value="{{ $produk->id }}">
                        <input type="hidden" name="is_variasi" id="is_variasi" value="{{ $produk->is_variasi }}">
                        
                        @if ($produk->is_variasi == 1)
                        <input type="hidden" name="id_variasi" value="{{ $produk->VariasiProduk->id }}">
                            
                        <div class="mb-3">
                        <label for="namavariasi" class="form-label">Nama Variasi</label>          
                        <input type="text" class="form-control" id="namavariasi" name="namavariasi" value="{{ $produk->VariasiProduk->namavariasi }}">
                        </div>
                        
                        </div>
                        <div class="row mb-3">
                          
                                @foreach ($produk->VariasiProduk->VariasiProdukOption as $c )

                                     <input type="hidden" name="id_variasioption[]" value="{{ $c->id }}">
                                     <input type="hidden" name="id_produkstok[]" value="{{ $c->ProdukStok->id }}">
                                <div class="col-lg-4">
                                        <label for="namavariasioption" class="form-label">Nama Variasi Option</label>          
                                        <input type="text" class="form-control" id="namavariasioption[]" name="namavariasioption[]" value="{{ $c->namavariasioption }}">
                                </div>
                                <div class="col-lg-2">
                                        <label for="stok[]" class="form-label">Stok</label>          
                                        <input type="number" class="form-control" id="stok[]" name="stok[]" value="{{ $c->ProdukStok->stok }}">
                                </div>
                                <div class="col-lg-4">
                                        <label for="hargapokok" class="form-label">Harga Pokok</label>          
                                        <input type="number" class="form-control" id="hargapokok[]" name="hargapokok[]" value="{{ $c->ProdukStok->hargapokok }}">
                                </div>
 
                                @endforeach

                                <div class="col-lg-2">
                                        <label class="form-label"><a class="btn btn-primary btn-sm " id="btnclicktambah"><span data-feather="plus-circle" class="align-text-bottom"></span></a></label>
                           </div>
                         </div>
                
                        <div class="row" id="tambahvariasioption"></div>
               
                 @else
                                <input type="hidden" name="id_nonvariasi" value="{{ $produk->nonVariasiProduk->id }}">
                                <input type="hidden" name="id_produkstok" value="{{ $produk->nonVariasiProduk->ProdukStok->id }}">
                                <div class="row mb-3">
                                        <div class="col-lg-2">
                                        <label for="stok" class="form-label">Stok</label>          
                                        <input type="number" class="form-control" id="stok" name="stok" value="{{ $produk->nonVariasiProduk->ProdukStok->stok }}">
                                        </div>
                                        <div class="col-lg-4">
                                        <label for="hargapokok" class="form-label">Harga Pokok</label>          
                                        <input type="number" class="form-control" id="hargapokok" name="hargapokok" value="{{ $produk->nonVariasiProduk->ProdukStok->hargapokok }}">
                                        </div>
                                </div>
                                
                                @endif
                                
                                <div class="mb-4">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                        </form>
                </div>
@endsection