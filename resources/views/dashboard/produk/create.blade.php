@extends('dashboard.layouts.main')


   @section('container')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Tambah Produk</h1>
  </div>

  <div>
    <a href="/dashboard/produk" class="btn btn-primary mb-2"><span data-feather="arrow-left" class="align-text-bottom"></span>
     Kembali</a>
  </div>

  <div class="col-lg-10">
    <form action="/dashboard/produk" method="post">
        @csrf
        <div class="mb-3">
          <label for="namaproduk" class="form-label">Nama Produk</label>
          <input type="text" class="form-control" id="namaproduk" name="namaproduk">
        </div>
        <div class="mb-3">
          <label for="slug" class="form-label">Slug</label>
          <input type="text" class="form-control" id="slug" name="slug" readonly>
        </div>
        <div class="mb-3">
            <label for="kategori_id" class="form-label">Kategori</label>
            <select class="form-select" id="kategori_produk_id" name="kategori_produk_id">
                @foreach ($kategoriproduk as $kp )
                    
                <option value="{{ $kp->id }}">{{ $kp->namakategori }}</option>
                @endforeach
            </select>
        </div>
        

        <div class="row mb-3" id="nonVariasi">
          <div class="col-lg-2 ">
            <p style="font-size: 15px;" class="">Variasi : </p>
          </div>
          <div class="col-lg-10" onclick="remove(this)">

            <button class="btn btn-sm border col-lg-5" style="font-size: 18px;" id="aktifkanvariasi"><span data-feather="plus-circle" class="align-middle"></span> Aktifkan Variasi</button>
          </div>
          <div class="col-lg-2">
            <label for="stok" class="form-label">Stok</label>          
            <input type="number" class="form-control" id="stok" name="stok">
          </div>
          <div class="col-lg-4">
            <label for="hargapokok" class="form-label">Harga Pokok</label>          
            <input type="number" class="form-control" id="hargapokok" name="hargapokok">
          </div>
      </div>
<div class="mb-3" id="aktifVariasiProduk">

</div>

         {{-- <div class="mb-3">
          <label for="namavariasi" class="form-label">Nama Variasi</label>          
          <input type="text" class="form-control" id="namavariasi" name="namavariasi">
        </div>
        <div class="mb-3">
          <label for="slugvariasi" class="form-label">Slug Variasi</label>          
          <input type="text" class="form-control" id="slugvariasi" name="slugvariasi" readonly>
        </div>
        <div class="row mb-3">
            <div class="col-lg-4">
              <label for="namavariasioption" class="form-label">Nama Variasi Option</label>          
              <input type="text" class="form-control" id="namavariasioption[]" name="namavariasioption[]">
            </div>
            <div class="col-lg-2">
              <label for="stok[]" class="form-label">Stok</label>          
              <input type="number" class="form-control" id="stok[]" name="stok[]">
            </div>
            <div class="col-lg-4">
              <label for="hargapokok" class="form-label">Harga Pokok</label>          
              <input type="number" class="form-control" id="hargapokok[]" name="hargapokok[]">
            </div>
            
            <div class="col-lg-2">
              <label class="form-label"><a class="btn btn-primary btn-sm " id="btnclicktambah"><span data-feather="plus-circle" class="align-text-bottom"></span></a></label>
             
            </div>
        </div> --}}

        <div class="row" id="tambahvariasioption"></div>
            
        
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>

  {{-- <div class="row mb-3" id="member"><div class="col-lg-4"><label for="namavariasioption" class="form-label">Nama Variasi Option</label>  <input type="text" class="form-control" id="namavariasioption[]" name="namavariasioption[]"> </div><div class="col-lg-2"><label for="stok" class="form-label">Stok</label><input type="number" class="form-control" id="stok[]" name="stok[]"></div><div class="col-lg-4"><label for="hargapokok" class="form-label">Harga Pokok</label><input type="number" class="form-control" id="hargapokok[]" name="hargapokok[]"></div><div class="col-lg-2"><label class="form-label"><a class="btn btn-danger btn-sm" id="btnclickhapus">hapus</a></label></div> --}}

<script src="/js/event.js"></script>

<script>
  function remove(e){
  const element = e;
  e.parentElement.remove();
  let isian = '<input type="hidden" class="form-control" id="is_variasi" name="is_variasi" value="1"><label for="namavariasi" class="form-label">Nama Variasi</label><input type="text" class="form-control" id="namavariasi" name="namavariasi"></div><div class="mb-3"><label for="slugvariasi" class="form-label">Slug Variasi</label><input type="text" class="form-control" id="slugvariasi" name="slugvariasi" readonly></div><div class="row mb-3"><div class="col-lg-4"><label for="namavariasioption" class="form-label">Nama Variasi Option</label><input type="text" class="form-control" id="namavariasioption[]" name="namavariasioption[]"></div><div class="col-lg-2"><label for="stok[]" class="form-label">Stok</label><input type="number" class="form-control" id="stok[]" name="stok[]"></div><div class="col-lg-4"><label for="hargapokok" class="form-label">Harga Pokok</label> <input type="number" class="form-control" id="hargapokok[]" name="hargapokok[]"></div><div class="col-lg-2"><label class="form-label"><a class="btn btn-primary btn-sm " id="btnclicktambah">Tambah</a></label>';

    document.getElementById("aktifVariasiProduk").insertAdjacentHTML('afterend', isian);

    const namavariasi = document.querySelector('#namavariasi');
    const slugvariasi = document.querySelector('#slugvariasi');

    namavariasi.addEventListener('change', function(){
      fetch('/dashboard/produk/checkSlugVariasi?namavariasi=' + namavariasi.value)
      .then(response => response.json())
      .then(data => slugvariasi.value = data.slugvariasi)
    });

    document.getElementById("btnclicktambah").addEventListener("click", tambahMember);

    

}
function tambahMember(){
   
   let isi = ' <div class="row mb-3" id="member"><div class="col-lg-4"><label for="namavariasioption" class="form-label">Nama Variasi Option</label>  <input type="text" class="form-control" id="namavariasioption[]" name="namavariasioption[]"> </div><div class="col-lg-2"><label for="stok" class="form-label">Stok</label><input type="number" class="form-control" id="stok[]" name="stok[]"></div><div class="col-lg-4"><label for="hargapokok" class="form-label">Harga Pokok</label><input type="number" class="form-control" id="hargapokok[]" name="hargapokok[]"></div><div class="col-lg-2" onclick="remove(this)"><label class="form-label"><a class="btn btn-danger btn-sm" id="btnclickhapus" >Hapus</a></label></div>';
   document.getElementById("tambahvariasioption").insertAdjacentHTML('afterend',isi);
   
}
</script>


  

  @endsection


 