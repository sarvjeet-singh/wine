@extends('FrontEnd.layouts.mainapp')

@section('title', 'Wine Country Weekends - Bottle Bucks History')

@section('content')
    <div class="container main-container">
        <div class="row flex-lg-nowrap flex-wrap g-4">
            @include('UserDashboard.includes.leftNav')
            <div class="col right-side">
                <div class="table-responsive">
                    <table id="example" class="display stripe cell-border table-custom" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID #</th>
                                <th>Amount</th>
                                <th>Transaction</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $key => $transaction)
                                <tr>
                                    <td>#{{ $key + 1 }}</td>
                                    <td>${{ $transaction->amount }}</td>
                                    <td>{{ $transaction->status }}</td>
                                    <td>{{ $transaction->description }}</td>
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
