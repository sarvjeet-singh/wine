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
                                <th>Inquiry ID #</th>
                                <th>Member </th>
                                <th>Receipt Date</th>
                                <th>Amount</th>
                                <th>Execution Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inquiries as $inquiry)
                                <tr>
                                    <td>#{{ $inquiry->id }}</td>
                                    <td>{{ $inquiry->vendor->vendor_name }}</td>
                                    <td>{{ $inquiry->created_at->format('m/d/Y') }}</td>
                                    <td>${{ $inquiry->order_total }}</td>
                                    <td>{{ \Carbon\Carbon::parse($inquiry->check_in_at)->format('m/d/Y') ?? 'N/A' }}</td>
                                    @switch($inquiry->inquiry_status)
                                        @case(0)
                                            <td class="pending-text">Pending</td>
                                        @break

                                        @case(1)
                                            <td class="approve-text">Approved</td>
                                        @break

                                        @case(2)
                                            <td class="reject-text">Rejected</td>
                                        @break

                                        @case(3)
                                            <td class="paid-text">Paid</td>
                                        @break

                                        @default
                                            <td class="pending-text">Pending</td>
                                    @endswitch
                                    <td>
                                        @if (!empty($inquiry->apk) && $inquiry->inquiry_status == 1)
                                            <form action="{{ route('checkout.process') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="apk" value="{{ $inquiry->apk }}">
                                                <button type="submit" class="btn btn-primary">Pay Now</button>
                                            </form>
                                        @endif
                                        <a href="{{ route('user.inquiryDetail', ['id' => $inquiry->id]) }}"
                                            class="btn btn-primary">
                                            View
                                        </a>
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
            let table = new DataTable('#example', {
                language: {
                    emptyTable: "No inquiries available at the moment"
                }
            });
        });
    </script>
@endsection