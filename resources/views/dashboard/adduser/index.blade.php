@extends('dashboard.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Daftar Pengguna</h1>
  </div>

  @if (session()->has('success'))            
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
  @endif

        <div class="table-responsive col-lg-8">
                <div class="mb-2">
                    <a href="/dashboard/administrator/adduser/create" class="btn btn-success"><span data-feather="User" class="align-text-bottom"></span> Tambah User</a>
                </div>

            <table class="table table-sm">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $u )
                        
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $u->nama }}</td>
                        <td>{{ $u->username }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->dashboardRole->role }}</td>
                        <td>
                                <a href="/dashboard/administrator/adduser/{{ $u->id }}/edit" class="btn btn-warning btn-sm"><span data-feather="edit">Edit</span></a>
                                <form action="/dashboard/administrator/adduser/{{ $u->id }}" method="post" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-danger btn-sm border-0" onclick="return confirm('Delete it ?')">
                                    <span data-feather="delete">Hapus</span>
                                    </button>
                                </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
@endsection