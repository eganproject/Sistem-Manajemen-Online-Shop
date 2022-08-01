@extends('dashboard.layouts.main')


   @section('container')

      @php
      $omset = null;
      $jumlahterjual = null;
      $totaltagihan = null;
      $totaldiluar = null;
      $profit =null;
      $modalawal =null;

      @endphp
          @foreach ($penjualan as $item)
              @php
              $hargajual = \App\Models\HargaJual::where('produk_stok_slug', $item->produk_stok_slug)->where('slugkategoripenjualan', $item->slugkategoripenjualan)->first();
                $omset += $item->jumlah * $hargajual->hargajual;
                $jumlahterjual += $item->jumlah;
                $modalawal += $item->jumlah * $item->ProdukStok->hargapokok;
              @endphp
          @endforeach
          @foreach ($tagihanbarangmasuk as $item)
              @php
                $totaltagihan += $item->total_tagihan;
              @endphp
          @endforeach
          @foreach ($tagihanbarangkeluar as $item)
              @php
                $totaldiluar += $item->total_tagihan;
              @endphp
          @endforeach
 @php
     $profit = $omset - $modalawal
 @endphp
      
   <link href="/css/carddashboard.css" rel="stylesheet">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar" class="align-text-bottom"></span>
            This week
          </button>
        </div>
      </div>


      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />
      

<div class="col-md-10 ">
    <div class="row ">
        <div class="col-xl-3 col-lg-6">
            <div class="card l-bg-cherry">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"><i class="fas fa-shopping-cart"></i></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0">ORDER TODAY</h5>
                      </div>
                      <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h4 class="d-flex align-items-center mb-0">
                             @currency($omset)
                            </h4>
                        </div>
                        <div class="col-4 text-right">
                            <span>{{ $jumlahterjual }} Pcs</span>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card l-bg-orange-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"><i class="fas fa-dollar-sign"></i></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0">Profit</h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h4 class="d-flex align-items-center mb-0">
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
        <div class="col-xl-3 col-lg-6">
            <div class="card l-bg-blue-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0">BELUM DIBAYAR</h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h4 class="d-flex align-items-center mb-0">
                                @currency($totaltagihan)
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card l-bg-green-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"><i class="fas fa-ticket-alt"></i></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0">UANG DILUAR</h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h4 class="d-flex align-items-center mb-0">
                                @currency($totaldiluar)
                            </h4>
                        </div>
                      
                    </div>
                    
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection


