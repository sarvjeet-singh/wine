@extends('VendorDashboard.layouts.vendorapp')

@section('title', 'Wine Country Weekends - Vendor Dashboard')

@section('css')
    <link rel="stylesheet" href="{{ asset('asset/css/select2.min.css') }}">
@endsection
@section('content')
    <div class="col right-side">
        <div class="accordion" id="accordionExample">
            @foreach ($faqs as $sectionIndex => $section)
                <div class="accordion-item custom-item">
                    <h2 class="accordion-header">
                        <button
                            class="accordion-button custom-accordion-button theme-color theme-light-background {{ $sectionIndex == 0 ? '' : 'collapsed' }}"
                            type="button" data-bs-toggle="collapse" data-bs-target="#collapseSection{{ $sectionIndex }}"
                            aria-expanded="{{ $sectionIndex == 0 ? 'true' : 'false' }}"
                            aria-controls="collapseSection{{ $sectionIndex }}">
                            {{ $section['section_name'] }}
                        </button>
                    </h2>
                    <div id="collapseSection{{ $sectionIndex }}"
                        class="accordion-collapse collapse {{ $sectionIndex == 0 ? 'show' : '' }}"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="accordion" id="nestedAccordion{{ $sectionIndex }}">
                                @foreach ($section['questions'] as $faqIndex => $faq)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button {{ $faqIndex == 0 ? '' : 'collapsed' }}"
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#nestedCollapse{{ $sectionIndex }}{{ $faqIndex }}"
                                                aria-expanded="{{ $faqIndex == 0 ? 'true' : 'false' }}"
                                                aria-controls="nestedCollapse{{ $sectionIndex }}{{ $faqIndex }}">
                                                {{ $faq['question'] }}
                                            </button>
                                        </h2>
                                        <div id="nestedCollapse{{ $sectionIndex }}{{ $faqIndex }}"
                                            class="accordion-collapse collapse {{ $faqIndex == 0 ? 'show' : '' }}"
                                            data-bs-parent="#nestedAccordion{{ $sectionIndex }}">
                                            <div class="accordion-body custom-body">
                                                {{ $faq['answer'] }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
