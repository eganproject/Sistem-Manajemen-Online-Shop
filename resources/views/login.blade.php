@extends('layouts.main')

@section('container')


<h3 class="mb-4">Halaman Login</h3>

@if (session()->has('loginerror'))            
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  {{ session('loginerror') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<form method="post" action="/login">
  @csrf
    <div class="mb-3">
      <label for="email" class="form-label">Email address</label>
      <input type="email" class="form-control @error('email')
        is-invalid
      @enderror" id="email" name="email">
      @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control @error('password')
        is-invalid
      @enderror" id="password" name="password">
      @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
      @enderror
    </div>
   
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
  @endsection
</div>
