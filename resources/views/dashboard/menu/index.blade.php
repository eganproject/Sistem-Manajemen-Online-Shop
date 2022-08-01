@extends('dashboard.layouts.main')


@section('container')

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Daftar Menu</h1>
        </div>
        @if (session()->has('success'))            
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="col-lg-8">
                <div class="mb-2">
                    <a href="/dashboard/administrator/menu/create" class="btn btn-success"><span data-feather="menu" class="align-text-bottom"></span> Buat Menu</a>
                </div>

            <table class="table" id="tableMenu">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Url</th>
                        <th scope="col">Icon</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($menu as $key => $m )
                        
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $m->nama }}</td>
                        <td>{{ $m->url }}</td>
                        <td><span data-feather="{{ $m->icon }}" class="align-text-bottom"></span></td>
                        <td>
                                <a href="/dashboard/administrator/menu/{{ $m->id }}/edit" class="btn btn-warning btn-sm"><span data-feather="edit"></span></a>
                                <form action="/dashboard/administrator/menu/{{ $m->id }}" method="post" class="d-inline">
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
@endsection

@section('containerjavascript')

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready( function () {
            
        $('#tableMenu').DataTable({
            "lengthMenu": [5, 10, 20, 50, 100],
        });
    } );
    </script>
@endsection