@extends('dashboard.layouts.main')


   @section('container')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Tambah Menu</h1>
  </div>

  <div>
    <a href="/dashboard/administrator/menu" class="btn btn-primary mb-2"><span data-feather="arrow-left" class="align-text-bottom"></span>
     Kembali</a>
  </div>

  <div class="col-lg-8">
    <form action="/dashboard/administrator/menu" method="post">
      @csrf
      <div class="mb-3">
        <label for="nama" class="form-label">Nama Menu</label>
        <input type="text" class="form-control" id="nama" name="nama">
        @error('nama')
          <p style="color: red;">{{ $message }}</p>
        @enderror
      </div>
      <div class="mb-3">
        <label for="slugmenu" class="form-label">Slug Menu</label>
        <input type="text" class="form-control" id="slugmenu" name="slugmenu" readonly>
        @error('slugmenu')
        <p style="color: red;">{{ $message }}</p>
      @enderror
      </div>
      <div class="mb-3">
        <label for="is_submenu" class="form-label">Submenu ?</label>
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" role="switch" id="is_submenu" name="is_submenu" value="1">
          <label class="form-check-label" for="flexSwitchCheckDefault">Aktifkan Submenu</label>
        </div>
      </div>

      <div class="mb-3" id="urldiv">
        <label for="url" class="form-label">URL</label>
        <input type="text" class="form-control" id="url" name="url">
        @error('url')
        <p style="color: red;">{{ $message }}</p>
      @enderror
      </div>
      <div class="mb-3" id="icondiv">
        <label for="icon" class="form-label">Icon</label>
        <input type="text" class="form-control" id="icon" name="icon">
        @error('icon')
        <p style="color: red;">{{ $message }}</p>
      @enderror
      </div>

      <div class="mb-3" id="tampilsubmenu">

      </div>
      <div id="tampiltambahsub">

      </div>
     <div class="mt-3">

       <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>


  <script>

const nama = document.querySelector('#nama');
const slugmenu = document.querySelector('#slugmenu');

    nama.addEventListener('change', function(){
      fetch('/dashboard/administrator/menu/checkSlugMenu?nama=' + nama.value)
      .then(response => response.json())
      .then(data => slugmenu.value = data.slugmenu)
    });



const urldiv = document.querySelector('#urldiv');

document.getElementById('is_submenu').addEventListener('click', submenu);
function submenu(){
  urldiv.remove();

  let isi = '<div class="d-flex flex-row-reverse"><a class="btn btn-primary btn-sm" id="btntambahsubmenu">+</a></div><div class="row"><div class="col"><label for="namasubmenu" class="form-label">Nama Submenu</label><input type="text" class="form-control" id="namasubmenu[]" name="namasubmenu[]"></div><div class="col"><label for="urlsubmenu" class="form-label">URL Submenu</label><input type="text" class="form-control" id="urlsubmenu[]" name="urlsubmenu[]"></div></div>';

  document.querySelector('#tampilsubmenu').innerHTML = isi;
  document.getElementById("btntambahsubmenu").addEventListener("click", tambahMember);

}



function tambahMember(){
   
    let isi = '  <div class="row mb-3"><div class="col"><label for="namasubmenu" class="form-label">Nama Submenu</label><input type="text" class="form-control" id="namasubmenu[]" name="namasubmenu[]"></div><div class="col"><label for="urlsubmenu" class="form-label">URL Submenu</label><input type="text" class="form-control" id="urlsubmenu[]" name="urlsubmenu[]"></div></div>';
    document.getElementById("tampiltambahsub").insertAdjacentHTML('afterend',isi);
    // document.getElementById("tambahvariasioption").slideDown('medium');  
}


  </script>
  @endsection