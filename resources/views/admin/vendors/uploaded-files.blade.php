@extends('admin.layouts.app')

@section('content')
    <div class="main-content-inner">
        <div class="main-head mb-4">
            <h2 class="mb-0">Vendor Uploaded Files</h2>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="top-card d-flex align-items-center justify-content-between p-3">
                        <div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.vendors') }}"
                                            class="text-decoration-none text-black">Vendor Management</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Vendor Uploaded Files</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <!-- Table Start -->
                    <div class="table-users">
                        <div class="table-responsive w-100">
                            <table class="table w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>File Name</th>
                                        <th>File Type</th>
                                        <th>File Size</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($files->isNotEmpty())
                                        @foreach ($files as $file)
                                            <tr>
                                                @if ($files instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                                    <td>{{ ($files->currentPage() - 1) * $files->perPage() + $loop->iteration }}
                                                    </td>
                                                @else
                                                    <td>{{ $loop->iteration }}</td>
                                                @endif
                                                <td>{{ $file->file_name }}</td>
                                                <td>{{ $file->mime_type ?? 'N/A' }}</td>
                                                <td>{{ $file->file_size ? round($file->file_size / 1024, 2) . ' KB' : 'N/A' }}
                                                </td>
                                                <td>{{ optional($file->created_at)->format('Y-m-d H:i:s') }}</td>
                                                <td>
                                                    <a href="{{ Storage::url($file->file_path) }}" download="{{ $file->file_name }}" class="btn btn-sm btn-default">
                                                        <i class="fa fa-download"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">No files found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            <div class="d-flex justify-content-end">
                                {{ $files->links() }}
                            </div>
                        </div>
                    </div>
                    <!-- Table End -->
                </div>
            </div>
        </div>
    </div>
@endsection
