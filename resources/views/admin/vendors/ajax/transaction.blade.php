<div class="tab-pane fade show active" id="tab-pane-booking-transaction" role="tabpanel"
    aria-labelledby="tab-booking-transaction" tabindex="0">
    <div class="information-box mb-5">
        <div class="info-head p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="text-white">Booking Transaction</div>
            </div>
        </div>
        <div class="table-users m-3">
            <div class="table-responsive">
                <table id="transactions" class="table display stripe cell-border table-custom" style="width:100%">
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
        </div>
    </div>
</div>
