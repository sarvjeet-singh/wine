<div class="event-filters">

    <div class="search-bar position-relative d-flex  justify-content-between align-items-start gap-3">
        <div class="w-100">
            <input type="search" class="form-control rounded-5 py-2" id="searchInput" placeholder="Search" name="search" autocomplete="off">
            <button type="submit" class="btn event-search-btn border-0 p-0">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <div id="autocomplete-results" class="autocomplete-dropdown"></div>
            <div class="clear-btn text-end">
                <a href="#" id="clearSearchFilters">Clear</a>
            </div>
        </div>
        <div class="filter-mob-box d-lg-none d-block mt-2">
            <button class="filter-icon"><i class="fa-solid fa-sliders"></i></button>
        </div>
    </div>

    <div class="accordion mt-lg-3" id="accordionPanelsStayOpenExample">
        <div class="filter-close text-end d-lg-none d-block">
            <button class="filter-icon"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="accordion-item">

            <h2 class="accordion-header" id="flush-headingOne">

                <button class="accordion-button" type="button" data-bs-toggle="collapse"

                    data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne">

                    Date

                </button>

            </h2>

            <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne">

                <div class="accordion-body pb-2">

                    <div class="form-check mb-2">

                        <input class="form-check-input date-filter event-filter-action" type="checkbox"

                            name="date_filter[]" value="today" id="today">

                        <label class="form-check-label" for="today">Today</label>

                    </div>

                    <div class="form-check mb-2">

                        <input class="form-check-input date-filter event-filter-action" type="checkbox"

                            name="date_filter[]" value="tomorrow" id="tomorrow">

                        <label class="form-check-label" for="tomorrow">Tomorrow</label>

                    </div>

                    <div class="form-check mb-2">

                        <input class="form-check-input date-filter event-filter-action" type="checkbox"

                            name="date_filter[]" value="upcoming" id="upcoming">

                        <label class="form-check-label" for="upcoming">Upcoming</label>

                    </div>

                    <div class="form-check mb-2">

                        <input class="form-check-input date-filter event-filter-action" type="checkbox"

                            name="date_filter[]" value="date_range" id="date_range">

                        <label class="form-check-label" for="date_range">Date Range</label>

                    </div>



                    <!-- Date Range Picker (Initially Hidden) -->

                    <div id="dateRangePickerContainer" class="mt-2" style="display: none;">

                        <input type="text" id="dateRangePicker" class="form-control" placeholder="Select date range">

                    </div>

                    <div class="clear-btn text-end">

                        <a href="#" id="clearDateFilters">Clear</a>

                    </div>

                </div>

            </div>

        </div>

        <div class="accordion-item">

            <h2 class="accordion-header" id="flush-headingTwo">

                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"

                    data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">

                    Experience Type

                </button>

            </h2>

            <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo">

                <div class="accordion-body pb-2">

                    @foreach (getExperienceCurativeCategories() as $category)

                        <div class="form-check mb-2">

                            <input class="form-check-input category-filter" name="category" type="checkbox"

                                value="{{ $category->id }}" id="category-{{ $category->id }}">

                            <label class="form-check-label" for="category-{{ $category->id }}">

                                {{ $category->name }}

                            </label>

                        </div>

                    @endforeach

                    <div class="clear-btn text-end">

                        <a href="javaScript:void(0)" id="clearCategories">Clear</a>

                    </div>

                </div>

            </div>

        </div>

        
        <div class="accordion-item">

            <h2 class="accordion-header" id="flush-headingFour">

                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"

                    data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">

                    Genre

                </button>

            </h2>

            <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour">

                <div class="accordion-body pb-2">

                    @foreach (getCurativeExperienceGenres() as $genre)

                        <div class="form-check mb-2">

                            <input class="form-check-input genre-filter" name="genre" type="checkbox"

                                value="{{ $genre->id }}" id="genre-{{ $genre->id }}">

                            <label class="form-check-label" for="genre-{{ $genre->id }}">

                                {{ $genre->name }}

                            </label>

                        </div>

                    @endforeach

                    <div class="clear-btn text-end">

                        <a href="javaScript:void(0)" id="clearGenres">Clear</a>

                    </div>

                </div>

            </div>

        </div>

        <div class="accordion-item">

            <h2 class="accordion-header" id="flush-headingFive">

                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"

                    data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">

                    Event Rating

                </button>

            </h2>

            <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive">

                <div class="accordion-body pb-2">

                    

                    <div class="form-check mb-2">

                        <input class="form-check-input rating-filter" name="event_ratings" type="checkbox"

                            value="family" id="rating-family">

                        <label class="form-check-label" for="rating-family">

                            Family

                        </label>

                    </div>

                    <div class="form-check mb-2">

                        <input class="form-check-input rating-filter" name="event_ratings" type="checkbox"

                            value="19" id="rating-19">

                        <label class="form-check-label" for="rating-19">

                            19+

                        </label>

                    </div>

                    <div class="clear-btn text-end">

                        <a href="javaScript:void(0)" id="clearRatings">Clear</a>

                    </div>

                </div>

            </div>

        </div>

        <div class="accordion-item">

            <h2 class="accordion-header" id="flush-headingThree">

                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"

                    data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">

                    Price

                </button>

            </h2>

            <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree">

                <div class="accordion-body pb-2">

                    <div class="form-check mb-2">

                        <input class="form-check-input price-filter" type="checkbox" value="free" id="free-event">

                        <label class="form-check-label" for="free-event">Free</label>

                    </div>

                    <?php

                    $priceRange = getEventMinMaxPrice();

                    $minPrice = $priceRange['min_price'];

                    $maxPrice = $priceRange['max_price'];

                    ?>



                    <div class="slider-container">

                        <input type="range" class="form-range price-filter" id="priceRange" min="<?= $minPrice ?>"

                            max="<?= $maxPrice ?>" step="1" value="<?= $minPrice ?>">



                        <div class="slider-value clear-btn d-flex align-items-center justify-content-between gap-1">

                            <span id="minValue">$<?= $minPrice ?></span>

                            <a href="#" id="clearPriceFilter">Clear</a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Sidebar Filter on Mobile -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const filterIcon = document.querySelector(".filter-icon");
        const filterClose = document.querySelector(".filter-close");
        const sideFilter = document.querySelector(".event-filters .accordion");

        if (filterIcon && sideFilter) {
            // Toggle class on click of .filter-icon
            filterIcon.addEventListener("click", function() {
                sideFilter.classList.toggle("show-filter");
            });
        }

        if (filterClose && sideFilter) {
            // Remove class on click of .filter-close
            filterClose.addEventListener("click", function() {
                sideFilter.classList.remove("show-filter");
            });
        }
    });
</script>