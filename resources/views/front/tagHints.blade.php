
<div class="tags-tree">
    @foreach($tagsTree["parents"] as $parent)
    <div class="tagSearch parent" id = "{{ $parent->id }}">{{ $parent->name }}</div>

    @foreach($tagsTree["tags"] as $tag)
    @if($tag->category_id === $parent->id)
    <div class="tagSearch child" id = "{{ $tag->id }}">{{ $tag->name }}</div>
    @endif
    @endforeach

    @endforeach
</div>