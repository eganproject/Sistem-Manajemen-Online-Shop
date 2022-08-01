@extends('dashboard.layouts.main')


@section('container')

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Master Data</h1>
        </div>
        @if (session()->has('success'))            
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @error('namasumber')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
            @enderror
        <div class="row mb-4">
           {{-- table kategori produk --}}
            
           <div class="col-lg-6">
            <div class="mb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 border-bottom">
                    <h5>Penjualan Kategori</h5>
                   <!-- Button trigger modal -->
                   <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#kategoripenjualanModal"><span data-feather="menu" class="align-text-bottom"></span> Tambah Kategori</button>
                </div>
            </div>
            
            <table class="table" id="tableKategoriPenjualan">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach ($kategoripenjualan as $key => $kp)
                            
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $kp->kategori }}</td>
                          <td>{{ $kp->namakategoripenjualan }}</td>
                          
                          <td>
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#kategoripenjualanModal{{ $kp->id }}"><span data-feather="edit" class="align-text-bottom"></span></button>
                            <form action="/dashboard/masterdata/deletekategoripenjualan/{{ $kp->id }}" method="post" class="d-inline">
                              {{-- @method('delete') --}}
                              @csrf
                              <button class="btn btn-danger btn-sm border-0" onclick="return confirm('Delete it ?')">
                                <span data-feather="delete"></span>
                              </button>
                            </form>
                          </td>
                        </tr>
                        @endforeach
                </tbody>
          </table>
        </div>

            <div class="col-lg-6">
                <div class="mb-2">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 border-bottom">
                        <h5>Sumber Barang</h5>
                       <!-- Button trigger modal -->
                       <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#sumberBarangModal"><span data-feather="menu" class="align-text-bottom"></span> Tambah Sumber</button>
                    </div>
                </div>
                <table class="table" id="tableSumberBarang">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Jenis Sumber</th>
                            <th scope="col">Nama Sumber</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($sumberbarang as $key => $sb)
                                
                            <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $sb->jenissumber }}</td>
                              <td>{{ $sb->namasumber }}</td>
                              
                              <td>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#sumberBarangModal{{ $sb->id }}"><span data-feather="edit" class="align-text-bottom"></span></button>
                                <form action="/dashboard/masterdata/sumberbarang/{{ $sb->id }}" method="post" class="d-inline">
                                  @method('delete')
                                  @csrf
                                  <button class="btn btn-danger btn-sm border-0" onclick="return confirm('Delete it ?')">
                                    <span data-feather="delete"></span>
                                  </button>
                                </form>
                              </td>
                            </tr>
                            @endforeach
                    </tbody>
             </table>
            </div>
            
            <div class="col-lg-8">
              <div class="mb-2">
                  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 border-bottom">
                      <h5>Manajemen Produksi/Pemasok</h5>
                     <!-- Button trigger modal -->
                     <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#hargajahitModal"><span data-feather="menu" class="align-text-bottom"></span> Tambah Harga</button>
                  </div>
              </div>
              
              <table class="table" id="tableHargaJahit">
                  <thead class="table-dark">
                      <tr>
                          <th scope="col">#</th>
                          <th scope="col">Sumber</th>
                          <th scope="col">Produk</th>
                          <th scope="col">Harga Jahit</th>
                          <th scope="col">Action</th>
                      </tr>
                  </thead>
                  <tbody>
                          @foreach ($hargajahit as $key => $hrgjht)
                              
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $hrgjht->SumberBarang->namasumber . "-" . $hrgjht->SumberBarang->jenissumber }}</td>
                            <td>{{ $hrgjht->Produk->namaproduk }}</td>
                            <td>@currency($hrgjht->harga)</td>
                            
                            <td>
                              <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#edithargajahitModal{{ $hrgjht->id }}"><span data-feather="edit" class="align-text-bottom"></span></button>
                              <form action="/dashboard/masterdata/deletehargajahit/{{ $hrgjht->id }}" method="post" class="d-inline">
                                {{-- @method('delete') --}}
                                @csrf
                                <button class="btn btn-danger btn-sm border-0" onclick="return confirm('Delete it ?')">
                                  <span data-feather="delete"></span>
                                </button>
                              </form>
                            </td>
                          </tr>
                          @endforeach
                  </tbody>
           </table>
          </div>

          <div class="col-lg-4">
            <div class="mb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 border-bottom">
                    <h5>Produk Kategori</h5>
                   <!-- Button trigger modal -->
                   <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#kategoriProdukModal"><span data-feather="menu" class="align-text-bottom"></span> Tambah Kategori</button>
                </div>
            </div>
            
            <table class="table" id="tableKategoriProduk">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kategoriproduk as $key => $kp )
                        
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $kp->namakategori }}</td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#kategoriProdukModal{{ $kp->id }}"><span data-feather="edit"></span></button>
                            <form action="/dashboard/masterdata/{{ $kp->id }}" method="post" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="btn btn-danger btn-sm border-0" onclick="return confirm('Delete it ?')">
                                    <span data-feather="delete"></span>
                                </button>
                            </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
         </table>
        </div>


            

            <div class="col-lg-12 mt-3">
                <div class="mb-2">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 border-bottom">
                        <h5>Harga Jual</h5>
                       <!-- Button trigger modal -->
                       <a  class="btn btn-success" href="/dashboard/tambahhargajual"><span data-feather="menu" class="align-text-bottom"></span> Tambah Harga Jual</a>
                    </div>
                </div>
                
                <table class="table" id="tableHargaJual">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Produk</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Harga Jual</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($hargajual as $key => $hrgjual )
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>
                          @if($hrgjual->nonVariasiProduk == null)
                          {{ $hrgjual->VariasiProdukOption->VariasiProduk->Produk->namaproduk.' - '.$hrgjual->VariasiProdukOption->namavariasioption }}
                          @else
                          {{ $hrgjual->nonVariasiProduk->Produk->namaproduk }}
                          @endif
                          </td>
                          <td>{{ $hrgjual->KategoriPenjualan->kategori }}</td>
                          <td>{{ $hrgjual->KategoriPenjualan->namakategoripenjualan }}</td>
                          <td>@currency( $hrgjual->hargajual)</td>
                          <td><button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#edithargajualModal{{ $hrgjual->id }}"><span data-feather="edit" class="align-text-bottom"></span></button></td>
                        </tr>
                      @endforeach
                            
                    </tbody>
             </table>
            </div>

    
        
        
        


  
 
  
  <!-- Modal Kategori Produk -->
  <div class="modal fade" id="kategoriProdukModal" tabindex="-1" aria-labelledby="kategoriProdukModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="kategoriProdukModalLabel">Kategori Produk</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/dashboard/masterdata" method="post">
                @csrf
                <div class="mb-3">
                  <label for="namakategori" class="form-label">Nama Kategori</label>
                  <input type="text" class="form-control" id="namakategori" name="namakategori" required>
                </div>
                
                </div>

                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
      </div>
    </div>
  </div>
  {{-- Sumber Barang --}}
  <div class="modal fade" id="sumberBarangModal" tabindex="-1" aria-labelledby="sumberBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="sumberBarangModalLabel">Sumber Barang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/dashboard/masterdata/sumberbarang" method="post">
                @csrf
                <div class="mb-3">
                  <label for="">Jenis</label>
                <select name="jenissumber" id="jenissumber" class="form-select">
                  <option value="Penjahit" >Penjahit</option>
                  <option value="Pemasok" >Pemasok</option>
                </select>
                </div>
                
                <div class="mb-3">
                  <label for="namasumber" class="form-label">Nama Sumber</label>
                  <input type="text" class="form-control" id="namasumber" name="namasumber" required>
                </div>
                <div class="mb-3">
                  <label for="slugsumber" class="form-label">Slug Sumber</label>
                  <input type="text" class="form-control" id="slugsumber" name="slugsumber" readonly required>
                </div>
                
                </div>

                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
      </div>
    </div>
  </div>

{{-- Kategori Penjualan --}}
  <div class="modal fade" id="kategoripenjualanModal" tabindex="-1" aria-labelledby="kategoripenjualanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="kategoripenjualanModalLabel">Kategori Penjualan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/dashboard/masterdata/storekategoripenjualan" method="post">
                @csrf
                <div class="mb-3">
                  <label for="">Kategori</label>
                <select name="kategori" id="kategori" class="form-select">
                  <option value="Lazada">Lazada</option>
                  <option value="Shopee">Shopee</option>
                  <option value="Facebook">Facebook</option>
                  <option value="Reseller">Reseller</option>
                  <option value="Lainnya">Lainnya</option>
                </select>
                </div>
                
                <div class="mb-3">
                  <label for="nama" class="form-label">Nama</label>
                  <input type="text" class="form-control" id="namakategoripenjualan" name="namakategoripenjualan" required>
                </div>
                <div class="mb-3">
                  <label for="slugkategoripenjualan" class="form-label">Slug Penjualan</label>
                  <input type="text" class="form-control" id="slugkategoripenjualan" name="slugkategoripenjualan" readonly required>
                </div>
                
                
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
              </form>
            </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="hargajahitModal" tabindex="-1" aria-labelledby="hargajahitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="hargajahitModalLabel">Tambah Harga Produksi/Pemasok</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/dashboard/masterdata/storehargajahit" method="post">
                @csrf
                <div class="mb-3" id="divsumbernya">
                  <label for="">Sumber</label>
                <select name="slugsumber" id="sumber" class="form-select" onchange="checkProduk(this.value)">
                  <option>Pilih Sumber</option>
                  @foreach ($sumberbarang as $smbr )
                    <option value="{{ $smbr->slugsumber }}">{{ $smbr->namasumber }} - {{ $smbr->jenissumber }}</option>
                  @endforeach
                  
                </select>
                </div>
                <div class="mb-3" id="tampilketerangan"></div>
                <div class="mb-3" id="tampilProduknya">
                  {{-- <label for="">Produk</label>
                <select name="produk_slug" id="produk_slug" class="form-select">
                  @foreach ($produk as $prdk )
                    <option value="{{ $prdk->slug }}">{{ $prdk->namaproduk }}</option>
                  @endforeach
                </select> --}}
                </div>
                
                <div class="mb-3">
                  <label for="nama" class="form-label">Harga Jahit</label>
                  <input type="number" class="form-control" id="harga" name="harga" required>
                </div>
                
                
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
              </form>
            </div>
      </div>
    </div>
  </div>

@foreach ($hargajahit as $hrgjht )
  <div class="modal fade" id="edithargajahitModal{{ $hrgjht->id }}" tabindex="-1" aria-labelledby="edithargajahitModal{{ $hrgjht->id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="edithargajahitModal{{ $hrgjht->id }}Label">Edit Harga Jahit</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/dashboard/masterdata/edithargajahit" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $hrgjht->id }}">
                
                <div class="mb-3">
                  <label for="nama" class="form-label">Harga Jahit</label>
                  <input type="number" class="form-control" id="harga" name="harga" required value="{{ $hrgjht->harga }}">
                </div>
                
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
              </form>
            </div>
      </div>
    </div>
  </div>
@endforeach

@foreach ($hargajual as $hrgjual )
  <div class="modal fade" id="edithargajualModal{{ $hrgjual->id }}" tabindex="-1" aria-labelledby="edithargajualModal{{ $hrgjual->id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title  text-muted" id="edithargajualModal{{ $hrgjual->id }}Label">
            {{ $hrgjual->KategoriPenjualan->kategori }} - {{ $hrgjual->KategoriPenjualan->namakategoripenjualan }}
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h5 class="text-center">@if($hrgjual->nonVariasiProduk == null)
            {{ $hrgjual->VariasiProdukOption->VariasiProduk->Produk->namaproduk.' - '.$hrgjual->VariasiProdukOption->namavariasioption }}
            @else
            {{ $hrgjual->nonVariasiProduk->Produk->namaproduk }}
            @endif</h5>
            <form action="/dashboard/masterdata/edithargajual" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $hrgjual->id }}">
                
                <div class="mb-3">
                  <label for="nama" class="form-label">Harga Jual</label>
                  <input type="number" class="form-control" id="harga" name="hargajual" required value="{{ $hrgjual->hargajual }}">
                </div>
                
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
              </form>
            </div>
      </div>
    </div>
  </div>
@endforeach

  @foreach ($sumberbarang as $sb )
  <div class="modal fade" id="sumberBarangModal{{ $sb->id }}" tabindex="-1" aria-labelledby="sumberBarangModal{{ $sb->id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="sumberBarangModal{{ $sb->id }}Label">Sumber Barang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/dashboard/masterdata/sumberbarang/{{ $sb->id }}" method="post">
              @method('PUT')
                @csrf
                <div class="mb-3">
                  <label for="">Jenis</label>
                <select name="jenissumber" id="jenissumber" class="form-select">
                  <option value="Penjahit" @if ($sb->jenissumber == "Penjahit")
                    selected
                  @endif >Penjahit</option>
                  <option value="Pemasok" @if ($sb->jenissumber == "Pemasok")
                    selected
                  @endif >Pemasok</option>
                </select>
                </div>
                
                <div class="mb-3">
                  <label for="namasumber" class="form-label">Nama Sumber</label>
                  <input type="text" class="form-control" id="namasumber" name="namasumber" value="{{ $sb->namasumber }}" required>
                  <input type="hidden" class="form-control" id="id" name="id" value="{{ $sb->id }}" required>
                </div>
                
                
                </div>

                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
      </div>
    </div>
  </div>
@endforeach


  @foreach ($kategoripenjualan as $kp )
  <div class="modal fade" id="kategoripenjualanModal{{ $kp->id }}" tabindex="-1" aria-labelledby="kategoripenjualanModal{{ $kp->id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="kategoripenjualanModal{{ $kp->id }}Label">Sumber Barang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/dashboard/masterdata/updatekategoripenjualan/{{ $kp->id }}" method="post">
              {{-- @method('PUT') --}}
                @csrf
                <input type="hidden" name="idkategoripenjualan" value="{{ $kp->id }}">
                <div class="mb-3">
                  <label for="">Kategori</label>
                <select name="kategori" id="kategori" class="form-select">
                  <option value="Lazada" {{ $kp->kategori == "Lazada" ? "selected" : "" }}>Lazada</option>
                  <option value="Shopee" {{ $kp->kategori == "Shopee" ? "selected" : "" }}>Shopee</option>
                  <option value="Facebook" {{ $kp->kategori == "Facebook" ? "selected" : "" }}>Facebook</option>
                  <option value="Reseller" {{ $kp->kategori == "Reseller" ? "selected" : "" }}>Reseller</option>
                  <option value="Lainnya" {{ $kp->kategori == "Lainnya" ? "selected" : "" }}>Lainnya</option>
                </select>
                </div>
                
                <div class="mb-3">
                  <label for="nama" class="form-label">Nama</label>
                  <input type="text" class="form-control" id="namakategoripenjualan" name="namakategoripenjualan" value="{{ $kp->namakategoripenjualan }}" required>
                </div>
                

                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
      </div>
    </div>
  </div>
  </div>
@endforeach


@foreach ($kategoriproduk as $kp )
<div class="modal fade" id="kategoriProdukModal{{ $kp->id }}" tabindex="-1" aria-labelledby="kategoriProdukModal{{ $kp->id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="kategoriProdukModal{{ $kp->id }}Label">Kategori Produk</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/dashboard/masterdata/{{ $kp->id }}" method="post">
                @method('put')
                @csrf
                <div class="mb-3">
                  <label for="namakategori" class="form-label">Nama Kategori</label>
                  <input type="text" class="form-control" id="namakategori" name="namakategori" value="{{ $kp->namakategori }}" required>
                </div>
                
                </div>

                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
      </div>
    </div>
  </div>
    
@endforeach

<script>
  const namasumber = document.querySelector('#namasumber');
      const slugsumber = document.querySelector('#slugsumber');
      
          namasumber.addEventListener('change', function(){
            fetch('/dashboard/masterdata/sumberbarang/checkSlugSumber?namasumber=' + namasumber.value)
            .then(response => response.json())
            .then(data => slugsumber.value = data.slugsumber)
          });


  const namakategoripenjualan = document.querySelector('#namakategoripenjualan');
      const slugkategoripenjualan = document.querySelector('#slugkategoripenjualan');
      
          namakategoripenjualan.addEventListener('change', function(){
            fetch('/dashboard/masterdata/checkSlugKategoriPenjualan?namakategoripenjualan=' + namakategoripenjualan.value)
            .then(response => response.json())
            .then(data => slugkategoripenjualan.value = data.slugkategoripenjualan)
          });
          
          function checkProduk(e){
            const slug = e;
            
            document.getElementById('divsumbernya').remove();
            let keterangan = '<h5 class="text-center">'+slug+'</h5><a onclick="window.location.reload(true);">Hapus</a><input type="hidden" name="slugsumber" value="'+slug+'">';
              document.getElementById('tampilketerangan').insertAdjacentHTML('afterend', keterangan);
            let isi1 = '<label for="">Produk</label><select name="produk_slug" id="selectProduk" class="form-select">';
            document.getElementById('tampilProduknya').insertAdjacentHTML('afterend', isi1);

            fetch('/dashboard/masterdata/checkProduknya?slugsumber=' + slug).then(response => response.json())
            .then(data => {
              
              for(i=0; i < data.produk.length; i++){
                let namaproduk = data.produk[i].namaproduk
                let slugnya = data.produk[i].slug

                let isi2 = '<option value="'+ slugnya +'">'+ namaproduk +'</option>';
                document.getElementById('selectProduk').insertAdjacentHTML('afterbegin', isi2);

              }
            });
            let isi3 = '</select>'
              document.getElementById('selectProduk').insertAdjacentHTML('afterend', isi3);
          }
          </script>
@endsection

@section('containerjavascript')

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready( function () {
            
        $('#tableHargaJahit').DataTable({
            "lengthMenu": [5, 10, 20, 50],
        });
        } );

        $(document).ready( function () {
            
        $('#tableHargaJual').DataTable({
            "lengthMenu": [10, 20, 50],
        });
        } );

        $(document).ready( function () {
            
        $('#tableKategoriPenjualan').DataTable({
            "lengthMenu": [5, 10, 20],
        });
        });

        $(document).ready( function () {
            
        $('#tableSumberBarang').DataTable({
            "lengthMenu": [5, 10, 20],
        });
        });

        $(document).ready( function () {
            
        $('#tableKategoriProduk').DataTable({
          "searching" : false,
            "lengthMenu": [5, 10, 20],
        });
        });
    </script>
@endsection