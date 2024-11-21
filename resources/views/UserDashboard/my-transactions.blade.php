@extends('FrontEnd.layouts.mainapp')

@section('title', 'Wine Country Weekends - Guest Registry')

@section('content')
    <div class="container main-container">
        <div class="row flex-lg-nowrap flex-wrap g-4">
            @include('UserDashboard.includes.leftNav')
            <div class="col right-side">
                <div class="table-responsive">
                    <table id="example" class="display stripe cell-border table-custom" style="width:100%">
                        <thead>
                            <tr>
                                <th>Transaction #</th>
                                <th>Vendor </th>
                                <th>Receipt Date</th>
                                <th>Amount</th>
                                <th>Execution Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->vendor->vendor_name }}</td>
                                    <td>{{ $order->created_at->format('m/d/Y') }}</td>
                                    <td>${{ $order->order_total }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->check_in_at)->format('m/d/Y') ?? 'N/A' }}</td>
                                    <td><a href="{{ route('user.orderDetail', $order->id) }}" class="btn btn-primary">View
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('UserDashboard.includes.logout_modal')
@endsection
@section('js')
    <script>
        $(document).ready(function(e) {
            let table = new DataTable('#example');
        });
    </script>
@endsection
