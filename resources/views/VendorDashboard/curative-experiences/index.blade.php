@extends('VendorDashboard.layouts.vendorapp')

@section('title', 'Wine Country Weekends - Vendor Dashboard')

@section('content')

    <style>
        .curated-exp-listing tbody td {
            padding: 20px 8px;
            color: #757575;
        }

        .curated-exp-listing tbody td svg {
            width: 20px;
            height: 20px;
            margin-inline: 4px;
        }
    </style>

    <div class="col right-side">
        <div class="row">
            <div class="col-sm-12">
                <div class="information-box">
                    <div class="information-box-head">
                        <div class="box-head-heading d-flex align-items-center justify-content-between gap-2">
                            <span class="box-head-label theme-color">Curated Experience</span>
                            <a href="{{ route('curative-experiences.create', $vendor->id) }}"
                                class="btn wine-btn px-4">Create</a>
                        </div>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="information-box-body py-4">
                        <table id="" class="table curated-exp-listing table-custom text-center" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Experience Type</th>
                                    <th>Name</th>
                                    <th>Admittance</th>
                                    <th>Extension</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($experiences->count() > 0)
                                    @foreach ($experiences as $key => $experience)
                                        <tr>
                                            <td>{{ ($experiences->currentPage() - 1) * $experiences->perPage() + $loop->iteration }}</td>
                                            <td>{{ optional($experience->category)->name ?? 'N/A' }}</td>
                                            <td>{{ $experience->name ?? 'N/A' }}</td>
                                            <td>{{ $experience->admittance ?? 'N/A' }}</td>
                                            <td>{{ $experience->extension ?? 'N/A' }}</td>
                                            <td>
                                                <a
                                                    href="{{ route('curative-experiences.edit', [$experience->id, $vendor->id]) }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </a>
                                                <form
                                                    action="{{ route('curative-experiences.destroy', [$experience->id, $vendor->id]) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Are you sure?')"
                                                        class="btn btn-link p-0">
                                                        <i class="fa-regular fa-trash-can text-danger"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">No experiences found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="pagination justify-content-end">{{ $experiences->links() }}></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
