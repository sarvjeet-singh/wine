@extends('admin.layouts.app')

@section('content')
    <div class="main-content-inner">
        <div class="main-head mb-4">
            <h2 class="mb-0">Error Logs</h2>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="top-card d-flex align-items-center justify-content-between p-3">
                        <div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-black">System Logs</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Error Logs</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <!-- Filter Section -->
                    <div class="p-3">
                        <form method="GET">
                            <label for="level">Filter by Level:</label>
                            <select name="level" id="level" class="form-control w-auto d-inline" onchange="this.form.submit()">
                                <option value="">All Levels</option>
                                @foreach ($levels as $level)
                                    <option value="{{ $level }}" {{ request('level') == $level ? 'selected' : '' }}>
                                        {{ ucfirst($level) }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>

                    <!-- Table Start -->
                    <div class="table-users">
                        <div class="table-responsive w-100">
                            <table class="table w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Level</th>
                                        <th>Message</th>
                                        <th>File</th>
                                        <th>Line</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logs as $key => $log)
                                        <tr>
                                            <td>{{ ($logs->currentPage() - 1) * $logs->perPage() + $loop->iteration }}</td>
                                            <td><span class="badge bg-danger">{{ strtoupper($log->level) }}</span></td>
                                            <td>{{ $log->message }}</td>
                                            <td>{{ $log->file ?? 'N/A' }}</td>
                                            <td>{{ $log->line ?? 'N/A' }}</td>
                                            <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="d-flex justify-content-end">
                                {{ $logs->links() }}
                            </div>
                        </div>
                    </div>
                    <!-- Table End -->
                </div>
            </div>
        </div>
    </div>
@endsection
