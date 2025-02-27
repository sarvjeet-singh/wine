@extends('admin.layouts.app')
@section('content')
    <div class="container">
        <h2>Error Logs</h2>

        <form method="GET">
            <select name="level" class="form-control" onchange="this.form.submit()">
                <option value="">All Levels</option>
                @foreach ($levels as $level)
                    <option value="{{ $level }}" {{ request('level') == $level ? 'selected' : '' }}>
                        {{ ucfirst($level) }}
                    </option>
                @endforeach
            </select>
        </form>

        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Level</th>
                    <th>Message</th>
                    <th>File</th>
                    <th>Line</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                    <tr>
                        <td>{{ strtoupper($log->level) }}</td>
                        <td>{{ $log->message }}</td>
                        <td>{{ $log->file ?? 'N/A' }}</td>
                        <td>{{ $log->line ?? 'N/A' }}</td>
                        <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $logs->links() }}
    </div>
@endsection
