<div class="col-xl-2 col-md-3 col-sm-4">
  <div class="fixed-sidebar mb-sm-0 mb-4">
    <div class="head pt-3">
      {{-- <h2>Accommodations</h2> --}}
    </div>


    <!-- Filter Search Box -->
    <div class="filter-search-box d-flex align-items-center gap-3 mb-3">
      <div class="input-group flex-nowrap">
        <div class="form-outline w-100 search-container" data-mdb-input-init>
          <input type="search" id="search" placeholder="Search" class="form-control search-filter" />
          <span class="search-clear">
            <i class="fas fa-times"></i>
          </span>
        </div>
        <button type="button" class="btn btn-primary search-button" data-mdb-ripple-init>
          <i class="fa-solid fa-magnifying-glass"></i>
        </button>
      </div>
      <div class="filter-mob-box d-sm-none d-block">
            <button class="filter-icon"><i class="fa-solid fa-filter"></i></button>
      </div>
    </div>
    <!-- /Filter Search Box -->


    <div class="side-filter border rounded-3 p-sm-3">
      <div class="filter-close text-end d-sm-none d-block">
          <button class="filter-icon"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="filter-box mb-3">
        <h6>Sub-Category</h6> @if (count($subCategories) > 0) @foreach ($subCategories as $subCategory) <div class="form-check">
          <input class="form-check-input filter" type="checkbox" name="vendor_sub_category" value="{{ $subCategory->id }}" id="{{ $subCategory->slug }}">
          <label class="form-check-label" for="{{ $subCategory->slug }}">{{ $subCategory->name }}</label>
        </div> @endforeach @endif
      </div> @if (isset($establishments) && count($establishments) > 0 && $vendor_type == 'excursion') <div class="filter-box mb-3">
        <h6>Establishment/Facility</h6> @foreach ($establishments as $establishment) <div class="form-check">
          <input class="form-check-input filter" type="checkbox" name="establishment" value="{{ $establishment->id }}" id="{{ $establishment->slug }}">
          <label class="form-check-label" for="{{ $establishment->slug }}">
            {{ $establishment->name }}
          </label>
        </div> @endforeach
      </div> @endif @if ($vendor_type == 'winery') @if (count($farmingPractices) > 0) <div class="filter-box mb-3">
        <h6>Farming Practices</h6> @foreach ($farmingPractices as $farmingPractice) <div class="form-check">
          <input class="form-check-input filter" type="checkbox" name="farming_practices" value="{{ $farmingPractice->id }}" id="{{ $farmingPractice->slug }}">
          <label class="form-check-label" for="{{ $farmingPractice->slug }}">
            {{ $farmingPractice->name }}
          </label>
        </div> @endforeach
      </div> @endif @endif @if ($vendor_type != 'licensed' && $vendor_type != 'non-licensed') <div class="filter-box mb-3">
        <h6>Sub-Region</h6> @if (count($subRegions) > 0) @foreach ($subRegions as $subRegion) <div class="form-check">
          <input class="form-check-input filter" type="checkbox" name="sub_region" value="{{ $subRegion->id }}" id="{{ $subRegion->slug }}">
          <label class="form-check-label" for="{{ $subRegion->slug }}">
            {{ $subRegion->name }}
          </label>
        </div> @endforeach @endif
      </div> @endif <div class="filter-box mb-3">
        <h6>City/Town </h6> @foreach ($cities as $city) <div class="form-check">
          <input class="form-check-input filter" type="checkbox" name="city" value="{{ $city }}" id="{{ $city }}">
          <label class="form-check-label" for="{{ $city }}">
            {{ $city }}
          </label>
        </div> @endforeach
      </div> @if ($vendor_type == 'winery') @if (count($tastingOptions) > 0) <div class="filter-box mb-3">
        <h6>Tastings</h6> @foreach ($tastingOptions as $tastingOption) <div class="form-check">
          <input class="form-check-input filter" type="checkbox" name="tasting_options" value="{{ $tastingOption->id }}" id="{{ $tastingOption->slug }}">
          <label class="form-check-label" for="{{ $tastingOption->slug }}">
            {{ $tastingOption->name }}
          </label>
        </div> @endforeach
      </div> @endif @endif @if ($vendor_type == 'accommodation') <div class="filter-box mb-3">
        <h6>Bedrooms</h6>
        <div class="form-check">
          <input class="form-check-input filter" type="checkbox" value="1" name="bedrooms" id="1Bedroom">
          <label class="form-check-label" for="1Bedroom"> 1 Bedroom(s) </label>
        </div>
        <div class="form-check">
          <input class="form-check-input filter" type="checkbox" value="2" name="bedrooms" id="2Bedrooms">
          <label class="form-check-label" for="2Bedrooms"> 2 Bedroom(s) </label>
        </div>
        <div class="form-check">
          <input class="form-check-input filter" type="checkbox" value="3" name="bedrooms" id="3Bedrooms">
          <label class="form-check-label" for="3Bedrooms"> 3 Bedroom(s) </label>
        </div>
        <div class="form-check">
          <input class="form-check-input filter" type="checkbox" value="4+" name="bedrooms" id="4Bedrooms">
          <label class="form-check-label" for="4Bedrooms"> 4+ Bedroom(s) </label>
        </div>
      </div>
      <div class="filter-box mb-3">
        <h6>Beds / Sleeps</h6>
        <div class="form-check">
          <input class="form-check-input filter" type="checkbox" value="2" name="person" id="1Person">
          <label class="form-check-label" for="1Persons"> 1 Bed / Sleeps 2 </label>
        </div>
        <div class="form-check">
          <input class="form-check-input filter" type="checkbox" value="4" name="person" id="4Persons">
          <label class="form-check-label" for="4Persons"> 2 Beds / Sleeps 4 </label>
        </div>
        <div class="form-check">
          <input class="form-check-input filter" type="checkbox" value="6" name="person" id="6Persons">
          <label class="form-check-label" for="6Persons"> 3 Beds / Sleeps 6 </label>
        </div>
        <div class="form-check">
          <input class="form-check-input filter" type="checkbox" value="8+" name="person" id="8Persons">
          <label class="form-check-label" for="8Persons"> 4+ Beds / Sleeps 8+ </label>
        </div>
      </div> @endif @if ($vendor_type != 'winery' && $vendor_type != 'accommodation') <div class="filter-box mb-3">
        <h6>Cuisine</h6> @if (count($cuisines) > 0) @foreach ($cuisines as $cuisine) <div class="form-check">
          <input class="form-check-input filter" type="checkbox" name="cuisines" value="{{ $cuisine->id }}" id="{{ $cuisine->slug }}">
          <label class="form-check-label" for="{{ $cuisine->slug }}">
            {{ $cuisine->name }}
          </label>
        </div> @endforeach @endif
      </div> @endif @if ($vendor_type != 'accommodation') <div class="filter-box mb-3">
        <h6>Hours of Operation</h6> @php $daysOfWeek = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']; @endphp @foreach ($daysOfWeek as $day) <div class="form-check">
          <input class="form-check-input filter" type="checkbox" name="days" value="{{ $day }}" id="{{ $day }}">
          <label class="form-check-label" for="{{ $day }}">
            {{ ucfirst($day) }}
          </label>
        </div> @endforeach
      </div> @endif <div class="filter-box mb-3">
        <h6>Star Rating </h6>
        <div class="form-check">
          <input class="form-check-input filter" type="checkbox" name="rating" value="1" id="1star">
          <label class="form-check-label" for="1star"> * </label>
        </div>
        <div class="form-check">
          <input class="form-check-input filter" type="checkbox" name="rating" value="2" id="2star">
          <label class="form-check-label" for="2star"> ** </label>
        </div>
        <div class="form-check">
          <input class="form-check-input filter" type="checkbox" name="rating" value="3" id="3star">
          <label class="form-check-label" for="3star"> *** </label>
        </div>
        <div class="form-check">
          <input class="form-check-input filter" type="checkbox" name="rating" value="4" id="4star">
          <label class="form-check-label" for="4star"> **** </label>
        </div>
        <div class="form-check">
          <input class="form-check-input filter" type="checkbox" name="rating" value="5" id="5star">
          <label class="form-check-label" for="5star"> ***** </label>
        </div>
      </div>
      <div class="filter-box mb-3">
        <h6>Price Point</h6>
        <div class="form-check">
          <input class="form-check-input filter" type="checkbox" value="least" name="price_point" id="Least">
          <label class="form-check-label" for="Least"> $ Least </label>
        </div>
        <div class="form-check">
          <input name="price_point" class="form-check-input filter" type="checkbox" value="low" id="LowModerately">
          <label class="form-check-label" for="LowModerately"> $$ Low Moderately </label>
        </div>
        <div class="form-check">
          <input name="price_point" class="form-check-input filter" type="checkbox" value="high" id="ModeratelyHigh">
          <label class="form-check-label" for="ModeratelyHigh"> $$$ Moderately High </label>
        </div>
        <div class="form-check">
          <input name="price_point" class="form-check-input filter" type="checkbox" value="expensive" id="MostExpensive">
          <label class="form-check-label" for="MostExpensive"> $$$$ Most Expensive </label>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
  $(document).ready(function() {
    // Function to update the URL based on selected checkboxes and search field with URL encoding
    function updateURL() {
      var params = new URLSearchParams(window.location.search);
      // Clear existing filter params before updating
      params.delete('search');
      params.delete('vendor_sub_category');
      params.delete('establishment');
      params.delete('farming_practices');
      params.delete('sub_region');
      params.delete('city');
      params.delete('tasting_options');
      params.delete('bedrooms');
      params.delete('person');
      params.delete('cuisines');
      params.delete('days');
      params.delete('rating');
      params.delete('price_point');
      // Add search field value if not empty
      var searchValue = $('#search').val();
      if (searchValue) {
        params.set('search', searchValue); // No need for `encodeURIComponent` here as URLSearchParams does it.
      }
      // Iterate over all checked checkboxes and add their values to the URL
      $('.filter:checked').each(function() {
        var filterName = $(this).attr('name');
        var filterValue = $(this).val();
        // Append each selected filter to the URL (URLSearchParams auto-encodes values)
        params.append(filterName, filterValue);
      });
      // Update the URL without reloading the page
      var newUrl = window.location.pathname + '?' + params.toString();
      window.history.pushState({
        path: newUrl
      }, '', newUrl);
    }
    // Function to pre-select checkboxes and populate search field based on URL params
    function preselectFilters() {
      var params = new URLSearchParams(window.location.search);
      // Set search field value based on URL params
      if (params.get('search')) {
        $('#search').val(params.get('search')); // URLSearchParams decodes the value automatically
      }
      // Iterate over all checkboxes and check if they should be selected
      $('.filter').each(function() {
        console.log(params.getAll($(this).attr('name')));
        var filterName = $(this).attr('name');
        var filterValue = $(this).val();
        // If the URL contains the filter with this value, check the box
        if (params.getAll(filterName).includes(filterValue)) {
          $(this).prop('checked', true);
        }
      });
    }
    // Add event listener for when checkboxes or search field are changed
    $('.filter').on('change', function() {
      updateURL(); // Update URL when a checkbox is changed
    });
    $('#search').on('input', function() {
      updateURL(); // Update URL when the search field is changed
    });
    // Preselect checkboxes and populate the search field based on the URL on page load
    preselectFilters();
  });
</script>

<!-- Sidebar Filter on Mobile -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const filterIcon = document.querySelector(".filter-icon");
    const filterClose = document.querySelector(".filter-close");
    const sideFilter = document.querySelector(".side-filter");

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