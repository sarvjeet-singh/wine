<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.vendors') }}"
                    class="text-decoration-none text-black">Vendor Management</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ !empty($vendor) ? 'Edit' : 'Create'}} Vendor</li>
        </ol>
    </nav>
</div>