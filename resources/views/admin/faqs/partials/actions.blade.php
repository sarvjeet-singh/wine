<!-- resources/views/admin/faqs/partials/actions.blade.php -->
<a href="javascript:void(0)" data-modal-size='modal-lg' class="open-modal-btn" data-url="{{ route('admin.faqs.create-question', $faq->id) }}">
    <i class="fa-solid fa-plus"></i>
</a>
<a href="javascript:void(0)" data-modal-size='' class="open-modal-btn" data-url="{{ route('admin.faqs.edit-section', $faq->id) }}">
    <i class="fa-regular fa-pen-to-square"></i>
</a>
<a href="javascript:void(0)" class="btn-delete" data-id="{{ $faq->id }}">
    <i class="fa-solid fa-trash-can"></i>
</a>
<!-- Add more actions as needed, e.g., delete, view details, etc. -->