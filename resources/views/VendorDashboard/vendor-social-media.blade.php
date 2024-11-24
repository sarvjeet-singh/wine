@extends('VendorDashboard.layouts.vendorapp')

@section('title', 'Wine Country Weekends - Vendor Dashboard')

@section('css')
@endsection
@section('content')
    <div class="col right-side">
        <div class="row">
            <div class="col-sm-12">
                <div class="information-box">
                    <div class="information-box-head">
                        <div class="box-head-heading d-flex">
                            <span class="box-head-label theme-color">Social Media</span>
                        </div>
                    </div>
                    <div class="information-box-body">
                        @if (session('social-media-success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('social-media-success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <form action="{{ route('vendor-social-media-update', ['vendorid' => $vendor->id]) }}"
                            method="post">
                            @csrf
                            <div class="row mt-3">
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Facebook</label>
                                    <input type="text" class="form-control @error('facebook') is-invalid @enderror"
                                        name="facebook" value="{{ old('facebook', $vendor->socialMedia->facebook ?? '') }}"
                                        placeholder="Please enter Facebook link">
                                    @error('facebook')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Instagram</label>
                                    <input type="text" class="form-control @error('instagram') is-invalid @enderror"
                                        name="instagram"
                                        value="{{ old('instagram', $vendor->socialMedia->instagram ?? '') }}"
                                        placeholder="Please enter Instagram link">
                                    @error('instagram')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Twitter</label>
                                    <input type="text" class="form-control @error('twitter') is-invalid @enderror"
                                        name="twitter" value="{{ old('twitter', $vendor->socialMedia->twitter ?? '') }}"
                                        placeholder="Please enter Twitter link">
                                    @error('twitter')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">YouTube</label>
                                    <input type="text" class="form-control @error('youtube') is-invalid @enderror"
                                        name="youtube" value="{{ old('youtube', $vendor->socialMedia->youtube ?? '') }}"
                                        placeholder="Please enter YouTube link">
                                    @error('youtube')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">LinkedIn</label>
                                    <input type="text" class="form-control @error('linkedin') is-invalid @enderror"
                                        name="linkedin" value="{{ old('linkedin', $vendor->socialMedia->linkedin ?? '') }}"
                                        placeholder="Please enter LinkedIn link">
                                    @error('linkedin')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">TikTok</label>
                                    <input type="text" class="form-control @error('tiktok') is-invalid @enderror"
                                        name="tiktok" value="{{ old('tiktok', $vendor->socialMedia->tiktok ?? '') }}"
                                        placeholder="Please enter TikTok link">
                                    @error('tiktok')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
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
