<div class="cats-tree">
    @foreach($catsTree["parents"] as $parent)
    <div class="cat parent" id = "{{ $parent->id }}">{{ $parent->name }}</div>

    @foreach($catsTree["cats"] as $cat)
    @if($cat->parent_id === $parent->id)
    <div class="cat child" id = "{{ $cat->id }}">{{ $cat->name }}</div>
    @endif
    @endforeach

    @endforeach
</div>