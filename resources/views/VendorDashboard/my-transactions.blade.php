@extends('VendorDashboard.layouts.vendorapp')

@section('title', 'Wine Country Weekends - Guest Registry')

@section('content')
    <div class="col right-side">
        <table id="transactions" class="display stripe cell-border table-custom" style="width:100%">
            <thead>
                <tr>
                    <th>Transaction #</th>
                    <th>Member </th>
                    <th>Receipt Date</th>
                    <th>Amount</th>
                    <th>Execution Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (count($orders) > 0)
                    @foreach ($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->guest_name ?? 'N/A' }}</td>
                            <td>{{ $order->created_at->format('m/d/Y') ?? 'N/A' }}</td>
                            <td>${{ $order->order_total ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->check_in_at)->format('m/d/Y') ?? 'N/A' }}</td>
                            <td><a href="{{ route('vendor.orderDetail', ['id' => $order->id, 'vendorid' => $order->vendor->id]) }}"
                                    class="btn btn-primary">View</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection
@section('js')
    <script>
        let table = new DataTable('#transactions', {
            language: {
                emptyTable: "No transactions available at the moment"
            }
        });
    </script>
@endsection
