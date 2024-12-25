@extends('VendorDashboard.layouts.vendorapp')

@section('title', 'Wine Country Weekends - Vendor Dashboard')

@section('css')
@endsection
@section('content')
    <div class="col right-side">
        @if (trim(strtolower($vendor->vendor_type)) == 'accommodation' ||
                trim(strtolower($vendor->vendor_type)) == 'winery' ||
                trim(strtolower($vendor->vendor_type)) == 'excursion')
            @if (count($questionnaires))
                <div class="row">
                    <div class="col-sm-12">
                        <div class="information-box">
                            <div class="information-box-head">
                                <div class="box-head-heading d-flex">
                                    <span class="box-head-label theme-color">Questionnaire</span>
                                </div>
                            </div>
                            <div class="information-box-body">
                                @if (session('questionnaire-success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('questionnaire-success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                                <form action="{{ route('vendor-questionnaire-update', ['vendorid' => $vendor->id]) }}"
                                    method="post">
                                    @csrf
                                    @foreach ($questionnaires as $key => $questionnaire)
                                        <div class="row mt-3">
                                            <div class="col-12">

                                                <label class="form-label">{{ $key + 1 }}.
                                                    {{ $questionnaire->question }}</label>

                                                @php
                                                    $vendorQuestionnaire = $questionnaire->vendorQuestionnaires->firstWhere(
                                                        'vendor_id',
                                                        $vendor->id,
                                                    );
                                                    $answers = $vendorQuestionnaire
                                                        ? json_decode($vendorQuestionnaire->answer, true)
                                                        : [];
                                                    $options = json_decode($questionnaire->options, true);
                                                @endphp

                                                @if ($questionnaire->question_type === 'radio')
                                                    <!-- Single choice (Radio buttons) -->
                                                    <div class="row g-3 mt-3">
                                                        @foreach ($options as $key => $option)
                                                            <div class="col-lg-4 col-md-6">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="answer[{{ $questionnaire->id }}]"
                                                                        id="question_{{ $questionnaire->id }}_{{ $key }}"
                                                                        value="{{ $key }}"
                                                                        {{ old('answer.' . $questionnaire->id, $vendorQuestionnaire->answer ?? '') == $key ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="question_{{ $questionnaire->id }}_{{ $key }}">
                                                                        {!! $option !!}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @elseif($questionnaire->question_type === 'checkbox')
                                                    <!-- Multiple choice (Checkboxes) -->
                                                    @foreach ($options as $key => $option)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="answer[{{ $questionnaire->id }}][]"
                                                                id="question_{{ $questionnaire->id }}_{{ $key }}"
                                                                value="{{ $option }}"
                                                                {{ in_array($option, $answers) ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="question_{{ $questionnaire->id }}_{{ $key }}">
                                                                {!! $option !!}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <!-- Default: Text input -->
                                                    <textarea class="form-control @error('answer.' . $questionnaire->id) is-invalid @enderror"
                                                        name="answer[{{ $questionnaire->id }}]" placeholder="Answer">{{ old('answer.' . $questionnaire->id, $vendorQuestionnaire->answer ?? '') }}</textarea>
                                                @endif

                                                @error('answer.' . $questionnaire->id)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    @endforeach

                                    @error('answer')
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            </div>
                                        </div>
                                    @enderror

                                    <div class="row mt-5">
                                        <div class="col-sm-12 text-center">
                                            <button type="submit" class="btn wine-btn">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
@endsection
