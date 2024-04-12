@extends('back.layouts.admin')

@push('css_before')
@endpush

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-header-title">
                        <h2 class="mb-0">Users</h2>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('users.create') }}" class="btn btn-primary m-l-20">
                        <i class="ti ti-plus f-18"></i> Add New User
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @include('back.layouts.partials.session')

        <div class="col-sm-12">
            <div class="card table-card">
                <div class="card-body">
                    <div class="text-end p-4">
                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-4 text-end">
                                <form action="{{ route('users') }}" method="GET">
                                    <input type="text" class="form-control" id="search-input" name="search" placeholder="{{ __('Pretraži korisnike') }}" value="{{ request()->query('search') }}">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="pc-dt-simple">
                            <thead>
                            <tr>
                                <th style="width: 5%;">ID</th>
                                <th>Title</th>
                                <th>Email</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Role</th>
                                <th class="text-end" style="width: 10%;">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <h6><a class="font-w600" href="{{ route('users.edit', ['user' => $user]) }}">{{ $user->name }}</a></h6>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td class="text-center">
                                        @include('back.layouts.partials.status', ['status' => $user->detail->status])
                                    </td>
                                    <td class="text-center">
                                        {{ $user->role }}
                                    </td>
                                    <td class="text-end">
                                        <ul class="list-inline me-auto mb-0">
                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Edit">
                                                <a href="{{ route('users.edit', ['user' => $user]) }}" class="avtar avtar-xs btn-link-success btn-pc-default">
                                                    <i class="ti ti-edit-circle f-18"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="6">Nema upisanih korisnika...</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js_after')
    <script>
        $(() => {

        })
    </script>
    <script>
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>

@endpush
