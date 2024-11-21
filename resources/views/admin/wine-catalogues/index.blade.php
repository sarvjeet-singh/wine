@extends('admin.layouts.app')
@section('content')
    <div class="main-content-inner">
        <div class="main-head mb-4">
            <h2 class="mb-0">Listing of Wines</h2>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <!-- Table Start -->
                    <div class="table-users text-center">
                        <div class="table-responsive w-100">
                            <table class="table w-100">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Winery</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>13 Street</td>
                                        <td>Partner</td>
                                        <td>
                                            <a href="#" class="btn theme-btn">View</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>13 Street</td>
                                        <td>Partner</td>
                                        <td>
                                            <a href="#" class="btn theme-btn">View</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>13 Street</td>
                                        <td>Partner</td>
                                        <td>
                                            <a href="#" class="btn theme-btn" data-bs-toggle="modal"
                                                data-bs-target="#addWineModal">View</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Table End -->
                </div>
            </div>
        </div>
    </div>
@endsection
