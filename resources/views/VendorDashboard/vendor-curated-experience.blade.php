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
                            <a href="#" class="btn wine-btn px-4">Create</a>
                        </div>
                    </div>
                    <div class="information-box-body py-4">
                        <table id="" class="table curated-exp-listing table-custom text-center" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Experience Type</th>
                                    <th>Admittance</th>
                                    <th>Extension</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($experiences->count() > 0)
                                    @foreach ($experiences as $experience)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ optional($experience->category)->name ?? 'N/A' }}</td>
                                            <td>{{ $experience->admittance ?? 'N/A' }}</td>
                                            <td>{{ $experience->extension ?? 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('curative-experiences.edit', $experience->id) }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </a>
                                                <form action="{{ route('curative-experiences.destroy', $experience->id) }}"
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
                                @endif
                            </tbody>
                        </table>



                        <!-- Success Message -->
                        <!-- @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-message">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
    @endif
                                <form action="{{ route('update.CuratedExperience', ['vendorid' => $vendorid]) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="vendor_id" value="{{ $vendorid }}">
                                    @for ($i = 0; $i < 3; $i++)
    @if (isset($experiences[$i]->id))
    <input type="hidden" name="experience[{{ $i }}][id]" value="{{ $experiences[$i]->id }}">
    @endif
                                        <div class="row mt-3">
                                        <div class="col-sm-4 col-12">
                                            <label class="form-label">Experience {{ $i + 1 }}</label>
                                            <input type="text" class="form-control @error('experience.' . $i . '.title') is-invalid @enderror" value="{{ old('experience.' . $i . '.title', $experiences[$i]->title ?? '') }}" name="experience[{{ $i }}][title]" placeholder="Enter Experience name">
                                            @error("experience.$i.title")
        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
    @enderror
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <label class="form-label">Upgrade Fee</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="text" class="form-control currency-field @error('experience.' . $i . '.upgradefee') is-invalid @enderror" value="{{ old('experience.' . $i . '.upgradefee', $experiences[$i]->upgradefee ?? '') }}" name="experience[{{ $i }}][upgradefee]" placeholder="Enter Upgrade fee">
                                            </div>

                                            @error("experience.$i.upgradefee")
        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
    @enderror
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <label class="form-label">Extension</label>
                                            <select name="experience[{{ $i }}][currenttype]" class="form-control @error('experience.' . $i . '.currenttype') is-invalid @enderror" placeholder="Select an option">
                                                <option value="+" {{ old('experience.' . $i . '.currenttype', $experiences[$i]->currenttype ?? '') == '+' ? 'selected' : '' }}>+</option>
                                                <option value="/Hr" {{ old('experience.' . $i . '.currenttype', $experiences[$i]->currenttype ?? '') == '/Hr' ? 'selected' : '' }}>/Hr</option>
                                                <option value="/Person" {{ old('experience.' . $i . '.currenttype', $experiences[$i]->currenttype ?? '') == '/Person' ? 'selected' : '' }}>/Person</option>
                                                <option value="/Night" {{ old('experience.' . $i . '.currenttype', $experiences[$i]->currenttype ?? '') == '/Night' ? 'selected' : '' }}>/Night</option>
                                                <option value="/Session" {{ old('experience.' . $i . '.currenttype', $experiences[$i]->currenttype ?? '') == '/Session' ? 'selected' : '' }}>/Session</option>
                                            </select>

                                            @error("experience.$i.currenttype")
        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
    @enderror
                                        </div>
                                        <div class="col-12 mt-3">
                                            <label class="form-label">Description <span class="theme-color">( Maximum character allowed 250 )</span></label>
                                            <textarea class="form-control @error('experience.' . $i . '.description') is-invalid @enderror"
                                                name="experience[{{ $i }}][description]" rows="3" id="description"
                                                placeholder="Please enter Description">{{ old('experience.' . $i . '.description', $experiences[$i]->description ?? '') }}</textarea>
                                            @error("experience.$i.description")
        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
    @enderror
                                        </div>
                                    </div>
    @endfor
                                    <div class="row mt-5">
                                        <div class="col-sm-12 text-center">
                                            <button type="submit" class="btn wine-btn">Update</button>
                                        </div>
                                    </div>
                                </form> -->

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
