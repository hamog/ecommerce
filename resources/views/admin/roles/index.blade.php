@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Roles</h1>
            <div class="section-header-button">
                <a href="{{ route('admin.roles.create') }}"
                   class="btn btn-primary">Create New</a>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.home.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></div>
                <div class="breadcrumb-item">Roles</div>
            </div>
        </div>

        <div class="section-body">

            <h2 class="section-title">Roles</h2>
            <p class="section-lead">
                You can manage all roles, such as editing, deleting and assigning permissions.
            </p>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <h4>All Roles</h4>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">

                                <table class="table table-borderless rounded-md">

                                    <tr class="">
                                        <th>Name</th>
                                        <th>Guard</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>

                                    @foreach ($roles as $role)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.roles.edit', $role) }}"
                                                   class="btn btn-link text-decoration-none text-bg-dark">
                                                    {{ $role->name }}
                                                </a>
                                            </td>

                                            <td>{{ $role->guard }}</td>
                                            <td>{{ $role->created_at->diffForHumans() }}</td>
                                            <td>
                                                <button data-bs-target="#deleteRoleModal{{ $role->id }}"
                                                        data-bs-toggle="modal"
                                                        type="submit"
                                                        class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                    Delete
                                                </button>
                                            </td>

                                        </tr>
                                        @push('modals')
                                            <div class="modal fade"
                                                 tabindex="-1"
                                                 id="deleteRoleModal{{ $role->id }}">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirm</h5>
                                                            <button type="button"
                                                                    class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>
                                                                Once this action is done some users may lose access to some
                                                                parts of the application. Are you sure you want to continue?
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button"
                                                                    class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                            <a href="{{ route('admin.roles.destroy', $role) }}"
                                                               data-turbo-method="delete"
                                                               class="btn btn-danger">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endpush

                                    @endforeach

                                </table>
                            </div>

                            <div class="float-right">
                                {{ $roles->links('vendor.pagination.bootstrap-5') }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
