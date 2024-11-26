@extends('VendorDashboard.layouts.vendorapp')

@section('title', 'Wine Country Weekends - Vendor Dashboard')


@section('content')
    <div class="col right-side">

        <table id="referrals" class="table display stripe cell-border table-custom" style="width:100%">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Username</th>
                    <th>Email Verified</th>
                    <th>City/Town</th>
                    <th>State/Province</th>
                </tr>
            </thead>
            <tbody>
                @if (count($referrals) > 0)
                    @foreach ($referrals as $key => $referral)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $referral->firstname ?? '' }} {{ $referral->lastname ?? '' }}</td>
                            <td>{{ !empty($referral->email_verified_at) ? 'Yes' : 'No' }}</td>
                            <td>{{ $referral->city ?? '-' }}</td>
                            <td>{{ $referral->state ?? '-' }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">No referrals available at the moment</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function(e) {

            let table = new DataTable('#referrals', {

                language: {

                    emptyTable: "No referrals available at the moment"

                },

            });

        })
    </script>
@endsection
