@extends('FrontEnd.layouts.mainapp')

@section('content')
    <style>
        @ .detail-form-sec .sub-type-radio {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 30px 10px;
        }

        a.book-btn {
            background-color: #c0a144 !important;
            color: #fff;
            padding: 10px 20px;
            border: 1px solid #c0a144;
            border-radius: 12px;
            position: relative;
            overflow: hidden;
            z-index: 9;
        }
    </style>
    <div class="main-container">
        <!--========== Business/Vendor Detail Form Start ==========-->
        <section class="detail-form-sec mt-5 mb-md-5 mb-4">
            <div class="container">
                <div class="row g-sm-3 g-2 mb-3">
                    <div class="col-md-12 col-12">
                        <div class="sec-form px-md-5 px-4 py-4">
                            <div class="row g-sm-3 g-2 mb-3">
                                <div class="col-lg-12 col-md-12 col-12 sec-content">
                                    <h1>Vendor Entity</h1>
                                </div>
                            </div>
                            <div class="row g-sm-3 g-2 mb-3">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <a href="{{ route('create-accommodation') }}" class="btn book-btn">Create
                                        Accommodation</a>
                                </div>
                            </div>
                            <div class="row g-sm-3 g-2 mb-3">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <a href="{{ route('create-excursion') }}" class="btn book-btn">Create Excursion</a>
                                </div>
                            </div>
                            <div class="row g-sm-3 g-2 mb-3">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <a href="{{ route('create-winery') }}" class="btn book-btn">Create Winery</a>
                                </div>
                            </div>
                            <div class="row g-sm-3 g-2 mb-3">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <a href="{{ route('create-licensedvendor') }}" class="btn book-btn">Create Licensed
                                        Vendor</a>
                                </div>
                            </div>
                            <div class="row g-sm-3 g-2 mb-3">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <a href="{{ route('create-nonlicensedvendor') }}" class="btn book-btn">Create
                                        Non-Licensed Vendor</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
