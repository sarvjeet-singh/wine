@extends('VendorDashboard.layouts.vendorapp')

@section('title', 'Wine Country Weekends - Guest Registry')

@section('content')
    <div class="col right-side">
        <table id="my-orders" class="display stripe cell-border table-custom" style="width:100%">
            <thead>
                <tr>
                    <th>S. No</th>
                    <th>Order No #</th>
                    <th>Vendor Name </th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Ordered on</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (count($orders) > 0)
                    @foreach ($orders as $key => $order)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->vendorBuyer->vendor_name ?? 'N/A' }}</td>
                            <td>${{ $order->total_price ?? 'N/A' }}</td>
                            @switch($order->status)
                                @case(0)
                                    <td class="pending-text">Pending</td>
                                @break

                                @case(1)
                                    <td class="approve-text">In Progress</td>
                                @break

                                @case(2)
                                    <td class="reject-text">Delivered</td>
                                @break

                                @default
                                    <td class="pending-text">Pending</td>
                            @endswitch
                            <td>{{ $order->created_at->format('m/d/Y') ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('winery.shop.order.detail', ['orderid' => $order->id, 'vendorid' => $vendorid]) }}"
                                    class="btn btn-primary">
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function(e) {
            let table = new DataTable('#my-orders', {
                language: {
                    emptyTable: "No orders available at the moment"
                },
            });
        })
    </script>
@endsection
