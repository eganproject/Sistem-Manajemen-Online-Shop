@extends('dashboard.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Daftar Pengguna</h1>
  </div>

  
  <div>
    <a href="/dashboard/administrator/adduser" class="btn btn-primary mb-2"><span data-feather="arrow-left" class="align-text-bottom"></span>
     Kembali</a>
  </div>

  
  <div class="col-lg-8">
    <form action="/dashboard/administrator/adduser/{{ $usr->id }}" method="post">
        @method('put')
      @csrf
      <input type="hidden" class="form-control" id="id" name="id" value="{{ $usr['id'] }}">
      <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama',$usr['nama']) }}">
        @error('nama')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
      </div>
      <div class="mb-3">
        <label for="username" class="form-label ">Username</label>
        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username',$usr->username) }}">
        @error('username')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email',$usr->email) }}">
        @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
      </div>
      <div class="mb-3">
        <label for="dashboard_role_id" class="form-label">Role</label>
        <select class="form-select" id="dashboard_role_id" name="dashboard_role_id">
            @foreach ($role as $role )
                @if ($usr->dashboard_role_id == $role->id)
                <option value="{{ $role->id }}" selected>{{ $role->role }}</option>
                @else
                <option value="{{ $role->id }}">{{ $role->role }}</option>
                @endif
            @endforeach
        </select>
      </div>
     
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>

@endsection