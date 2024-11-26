@extends('admin.layouts.app')
@section('content')
    <div class="main-content-inner">
        <div class="main-head mb-4">
            <h2 class="mb-0">Manage Modules</h2>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="top-card d-flex align-items-center justify-content-between p-3">
                        <div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="#"
                                            class="text-decoration-none text-black">Module Management</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Manage Modules</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- Table Start -->
                    <div class="table-users">
                        <div class="table-responsive w-100">
                            <table class="table w-100">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                                @foreach ($modules as $module)
                                    <tr>
                                        <td>{{ $module->id }}</td>
                                        <td>{{ $module->name }}</td>
                                        <td>
                                            <a href="{{ route('admin.modules.edit', $module) }}">Edit</a>
                                            <form method="POST" action="{{ route('admin.modules.destroy', $module) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>

                            <div class="d-flex justify-content-end">
                                {{ $modules->links() }}
                            </div>
                        </div>
                    </div>
                    <!-- Table End -->
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
