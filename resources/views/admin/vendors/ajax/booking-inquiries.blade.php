<div class="tab-pane fade show active" id="tab-pane-booking-inquiries" role="tabpanel"
    aria-labelledby="tab-booking-inquiries" tabindex="0">
    <div class="information-box mb-5">
        <div class="info-head p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="text-white">Booking Inquiries</div>
            </div>
        </div>
        <div class="table-users">
            <div class="table-responsive">
                <table class="table table-custom vb-inquiry-table text-center" id="vbEnquiryTable">
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
                                    <td>{{ \Carbon\Carbon::parse($inquiry->check_in_at)->format('m/d/Y') ?? 'N/A' }}
                                    </td>
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
                </table>
            </div>
        </div>
    </div>
</div>
