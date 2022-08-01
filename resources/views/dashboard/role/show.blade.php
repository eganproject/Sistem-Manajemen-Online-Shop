@extends('dashboard.layouts.main')


@section('container')

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">{{ $role->role }} : Role Akses Menu</h1>
        </div>

        <div>
            <a href="/dashboard/administrator/role" class="btn btn-primary mb-2"><span data-feather="arrow-left" class="align-text-bottom"></span>
             Kembali</a>
        </div>

        <div class="mb-3">

            <form class="row row-cols-lg-auto g-3 align-items-center" method="post" action="/dashboard/administrator/roleaccess">
                @csrf
                <input type="hidden" name="role_id" id="role_id" value="{{ $role->id }}">
                <div class="col-12">
                    <select class="form-select" id="menu_id" name="menu_id">
                        <option selected class="text-white bg-secondary">Tambah Akses ke {{ $role->role }}</option>
                        @foreach ($dmenu as $m )
                            
                        <option value="{{ $m->id }}">{{ $m->nama }}</option>
                        @endforeach
                    </select>
                </div>
                
          
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
    </div>


        @if (session()->has('success'))            
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="col-lg-8">
<h3>{{ $role->role }}</h3>
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Menu Access</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $acm = DB::select("select a.id, b.nama from dashboard_role_accesses as a join dashboard_menus as b on a.menu_id = b.id where a.dashboard_role_id = $role->id");
                    @endphp
                        @foreach ( $acm as $acm )
                        
                        <tr>
                            <th scope="row"></th>
                            <td>{{ $acm->nama }}</td>
                            <td>
                                <a href="/dashboard/administrator/roleaccess/delete/{{ $acm->id }}" class="badge bg-info" onclick="return confirm('Delete it ?')"><span data-feather="delete"></span></a>
                            </td>
                        </tr>
                        @endforeach
                </tbody>
            </table>
        </div>



@endsection