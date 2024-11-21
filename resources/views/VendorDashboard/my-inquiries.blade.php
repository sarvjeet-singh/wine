@extends('VendorDashboard.layouts.vendorapp')

@section('title', 'Wine Country Weekends - Guest Registry')

@section('content')
    <div class="col right-side">
        <table id="my-inquiries" class="display stripe cell-border table-custom" style="width:100%">
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
                @if (count($inquiries) > 0)
                    @foreach ($inquiries as $inquiry)
                        <tr>
                            <td>#{{ $inquiry->id }}</td>
                            <td>{{ $inquiry->guest_name ?? 'N/A' }}</td>
                            <td>{{ $inquiry->created_at->format('m/d/Y') ?? 'N/A' }}</td>
                            <td>${{ $inquiry->order_total ?? 'N/A' }}</td>
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
                                <a href="{{ route('vendor.inquiryDetail', ['id' => $inquiry->id, 'vendorid' => $inquiry->vendor->id]) }}"
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
            let table = new DataTable('#my-inquiries', {
                language: {
                    emptyTable: "No inquiries available at the moment"
                }
            });
        })
    </script>
@endsection
