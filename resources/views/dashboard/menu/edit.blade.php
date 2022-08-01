@extends('dashboard.layouts.main')


   @section('container')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Edit Menu {{ $menu->nama }}</h1>
  </div>
  
  <div>
    <a href="/dashboard/administrator/menu" class="btn btn-primary mb-2"><span data-feather="arrow-left" class="align-text-bottom"></span>
     Kembali</a>
  </div>

  
  <div class="col-lg-8">
    <form action="/dashboard/administrator/menu/{{ $menu->id }}" method="post">
        @method('put')
      @csrf
@if ($menu->is_submenu == 1)
<input type="hidden" class="form-control" id="id" name="id" value="{{ $menu['id'] }}">
<input type="hidden" class="form-control" id="is_submenu" name="is_submenu" value="{{ $menu['is_submenu'] }}">
<div class="mb-3">
  <label for="nama" class="form-label">Nama Menu</label>
  <input type="text" class="form-control" id="nama" name="nama" value="{{ $menu['nama'] }}">
</div>
<div class="mb-3">
  <label for="icon" class="form-label">Icon</label>
  <span data-feather="{{ $menu->icon }}" class="align-text-bottom"></span>
  <input type="text" class="form-control" id="icon" name="icon" value="{{ $menu->icon }}">
</div>
<div class="d-flex flex-row-reverse">
  <a class="btn btn-primary btn-sm" id="btntambahsubmenu">+</a>
</div>
@foreach ($menu->DashboardSubmenu as $sb)
<div class="row mb-3">
  <div class="col">
    <input type="hidden" name="id_submenu[]" value="{{ $sb->id }}">
    <label for="namasubmenu" class="form-label">Nama Submenu</label>
    <input type="text" class="form-control" id="namasubmenu[]" name="namasubmenu[]" value="{{ $sb->namasubmenu }}">
  </div>
    <div class="col">
      <label for="urlsubmenu" class="form-label">URL Submenu</label>
      <input type="text" class="form-control" id="urlsubmenu[]" name="urlsubmenu[]" value="{{ $sb->urlsubmenu }}">
    </div>
</div>
@endforeach

@else

      <input type="hidden" class="form-control" id="id" name="id" value="{{ $menu['id'] }}">
      <div class="mb-3">
        <label for="nama" class="form-label">Nama Menu</label>
        <input type="text" class="form-control" id="nama" name="nama" value="{{ $menu['nama'] }}">
      </div>
      <div class="mb-3">
        <label for="url" class="form-label">URL</label>
        <input type="text" class="form-control" id="url" name="url" value="{{ $menu->url }}">
      </div>
      <div class="mb-3">
        <label for="icon" class="form-label">Icon</label>
        <span data-feather="{{ $menu->icon }}" class="align-text-bottom"></span>
        <input type="text" class="form-control" id="icon" name="icon" value="{{ $menu->icon }}">
      </div>
    @endif
    <div id="tampiltambahsub">

    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>


  <script>
  document.getElementById("btntambahsubmenu").addEventListener("click", tambahMember);
function tambahMember(){
   
   let isi = '<div class="row mb-3"><div class="col"><label for="namasubmenu[]" class="form-label">Nama Submenu</label><input type="text" class="form-control" id="namasubmenu[]" name="namasubmenu[]"></div><div class="col"><label for="urlsubmenu[]" class="form-label">URL Submenu</label><input type="text" class="form-control" id="urlsubmenu[]" name="urlsubmenu[]"></div></div>';
   document.getElementById("tampiltambahsub").insertAdjacentHTML('afterend',isi);
   // document.getElementById("tambahvariasioption").slideDown('medium');  
}
  </script>
  @endsection