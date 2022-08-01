@extends('dashboard.layouts.main')


@section('container')

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Daftar Role</h1>
        </div>
        @if (session()->has('success'))            
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="col-lg-8">
                <div class="mb-2">
                    <a href="/dashboard/administrator/role/create" class="btn btn-success"><span data-feather="users" class="align-text-bottom"></span> Buat Role</a>
                </div>

            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Role</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($role as $r )
                        
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $r->role }}</td>
                        <td>
                            <a href="/dashboard/administrator/role/{{ $r['id'] }}" class="badge bg-info"><span data-feather="eye"></span></a>
                            <a href="/dashboard/administrator/role/{{ $r->id }}/edit" class="badge bg-warning "><span data-feather="edit"></span></a>
                                <form action="/dashboard/administrator/role/{{ $r->id }}" method="post" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button class="badge bg-danger  border-0" onclick="return confirm('Delete it ?')">
                                    <span data-feather="delete"></span>
                                    </button>
                                </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>



@endsection