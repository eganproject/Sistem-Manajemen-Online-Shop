@extends('dashboard.layouts.main')


   @section('container')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Tambah Role</h1>
  </div>

  <div>
    <a href="/dashboard/administrator/role" class="btn btn-primary mb-2"><span data-feather="arrow-left" class="align-text-bottom"></span>
     Kembali</a>
  </div>

  <div class="col-lg-8">
    <form action="/dashboard/administrator/role" method="post">
      @csrf
      <div class="mb-3">
        <label for="role" class="form-label">Nama Role</label>
        <input type="text" class="form-control" id="role" name="role">
      </div>
     
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>

  @endsection