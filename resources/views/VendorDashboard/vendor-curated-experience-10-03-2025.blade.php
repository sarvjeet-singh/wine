@extends('VendorDashboard.layouts.vendorapp')

@section('title', 'Wine Country Weekends - Vendor Dashboard')

@section('content')
    <div class="col right-side">
        <div class="row">
            <div class="col-sm-12">
                <div class="information-box">
                    <div class="information-box-head">
                        <div class="box-head-heading d-flex">
                            <span class="box-head-label theme-color">Curated Experience</span>
                        </div>
                    </div>
                    <div class="information-box-body">
                        <!-- Success Message -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-message">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <form action="{{route('update.CuratedExperience', ['vendorid' => $vendorid])}}" method="post">
                            @csrf
                            <input type="hidden" name="vendor_id" value="{{ $vendorid }}">
                            @for($i = 0; $i < 3; $i++)
                                @if(isset($experiences[$i]->id))
                                    <input type="hidden" name="experience[{{$i}}][id]" value="{{ $experiences[$i]->id }}">
                                @endif
                                <div class="row mt-3">
                                <div class="col-sm-4 col-12">
                                    <label class="form-label">Experience {{ $i+1 }}</label>
                                    <input type="text" class="form-control @error('experience.'.$i.'.title') is-invalid @enderror" value="{{ old('experience.'.$i.'.title', $experiences[$i]->title ?? '') }}" name="experience[{{$i}}][title]" placeholder="Enter Experience name">
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
                                        <input type="text" class="form-control currency-field @error('experience.'.$i.'.upgradefee') is-invalid @enderror" value="{{ old('experience.'.$i.'.upgradefee', $experiences[$i]->upgradefee ?? '') }}" name="experience[{{$i}}][upgradefee]" placeholder="Enter Upgrade fee">
                                    </div>

                                    @error("experience.$i.upgradefee")
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-sm-4 col-12">
                                    <label class="form-label">Extension</label>
                                    <select name="experience[{{$i}}][currenttype]" class="form-control @error('experience.'.$i.'.currenttype') is-invalid @enderror" placeholder="Select an option">
                                        <option value="+" {{ old('experience.'.$i.'.currenttype', $experiences[$i]->currenttype ?? '') == "+" ? "selected" : '' }}>+</option>
                                        <option value="/Hr" {{ old('experience.'.$i.'.currenttype', $experiences[$i]->currenttype ?? '') == "/Hr" ? "selected" : '' }}>/Hr</option>
                                        <option value="/Person" {{ old('experience.'.$i.'.currenttype', $experiences[$i]->currenttype ?? '') == "/Person" ? "selected" : '' }}>/Person</option>
                                        <option value="/Night" {{ old('experience.'.$i.'.currenttype', $experiences[$i]->currenttype ?? '') == "/Night" ? "selected" : '' }}>/Night</option>
                                        <option value="/Session" {{ old('experience.'.$i.'.currenttype', $experiences[$i]->currenttype ?? '') == "/Session" ? "selected" : '' }}>/Session</option>
                                    </select>

                                    @error("experience.$i.currenttype")
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-12 mt-3">
                                    <label class="form-label">Description <span class="theme-color">( Maximum character allowed 250 )</span></label>
                                    <textarea class="form-control @error('experience.'.$i.'.description') is-invalid @enderror" name="experience[{{$i}}][description]" rows="3" id="description" placeholder="Please enter Description">{{ old('experience.'.$i.'.description', $experiences[$i]->description ?? '') }}</textarea>
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
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
<script>
        document.addEventListener('DOMContentLoaded', function () {
            var currencyFields = document.querySelectorAll('.currency-field');
            currencyFields.forEach(function (currencyField) {
                currencyField.addEventListener('input', function (e) {
                    var value = e.target.value;
                    var regex = /^\d+(\.\d{0,2})?$/;
                    if (!regex.test(value)) {
                        e.target.value = value.slice(0, -1);
                    }
                });
            });
        });

</script>