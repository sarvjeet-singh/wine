@extends('FrontEnd.layouts.mainapp')

@section('title', 'Wine Country Weekends - Guest Registry')

@section('content')
    <div class="container main-container">
        <div class="row flex-lg-nowrap flex-wrap g-4">
            @include('UserDashboard.includes.leftNav')
            <div class="col right-side">
                <div class="table-responsive">
                    <table id="orders" class="display stripe cell-border table-custom" style="width:100%">
                        <thead>
                            <tr>
                                <th>Transaction #</th>
                                <th>Event Name</th>
                                <th>Receipt Date</th>
                                <th>Amount</th>
                                <th>Execution Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->eventOrderDetail->name }}</td>
                                    <td>{{ toLocalTimezone($order->created_at, getUserTimezone()) }}</td>
                                    <td>${{ $order->total }}</td>
                                    <td>{{ toLocalTimezone($order->eventOrderDetail->start_date, getUserTimezone()) ?? 'N/A' }}
                                        -
                                        {{ toLocalTimezone($order->eventOrderDetail->end_date, getUserTimezone()) ?? 'N/A' }}
                                    </td>
                                    <td><a href="{{ route('user.event-orderDetail', $order->id) }}"
                                            class="btn btn-primary">View
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
            let table = new DataTable('#orders', {
                order: [
                    [0, 'desc']
                ] // 0 = first column, 'desc' = descending
            });
        });
    </script>
@endsection
