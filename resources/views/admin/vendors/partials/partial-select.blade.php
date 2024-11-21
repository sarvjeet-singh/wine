@if(empty($vendor))
<div class="d-flex align-items-center gap-3">
    <select class="form-select" aria-label="Default select" id="categorySelect">
        @foreach (getCategories() as $category)
            <option value="{{ $category['slug'] }}">{{ $category['name'] }}</option>
        @endforeach
    </select>
</div>
@endif
@push('js')
    <script>
        // Function to extract the category from the URL
        function getCategoryFromUrl() {
            const url = window.location.href;
            const urlParts = url.split('/');
            return urlParts[urlParts.length - 1]; // Get the last part of the URL
        }

        // Pre-select the dropdown based on the URL
        const selectedCategory = getCategoryFromUrl();
        const selectElement = document.getElementById('categorySelect');

        // Set the selected value if it matches one of the options
        if (selectedCategory) {
            const optionExists = [...selectElement.options].some(option => option.value === selectedCategory);
            if (optionExists) {
                selectElement.value = selectedCategory;
            }
        }

        // Handle change event to update the URL
        selectElement.addEventListener('change', function() {
            const selectedValue = this.value;
            const baseUrl = "{{ route('admin.vendors.create', ['type' => '']) }}";
            window.location.href = baseUrl + '/' + selectedValue;
        });
    </script>
@endpush
