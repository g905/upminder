@if($mentors->hasPages())
<div class="paginator">
    <ul class="nav justify-content-center">
        @for($i = 0; $i < ceil($mentors->total() / $mentors->perPage()); $i++)
        <li class="nav-item"> <a class="nav-link @if($mentors->currentPage() === $i+1) active @endif" data-page="{{ $i+1 }}" href="#">{{ $i+1 }}</a> </li>
        @endfor


    </ul>
</div>

<script>
    $('.paginator .nav .nav-item .nav-link').click(function (e) {
        e.preventDefault(e);
        let form = $('#mentorSearch');
        let page = $(this).data("page");
        $(form).find('#page').val(page);
        $('.sort').trigger('change');
    });
</script>

@endif

