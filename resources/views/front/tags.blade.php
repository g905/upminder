@if($tags)
<h2 class="hc">Уточните задачу в категории "{{ $catName }}"</h2>
@foreach($tags["tags"] as $tag)
<label class="tag" data-id="{{ $tag["id"] }}">{{ $tag["name"] }}
    <span class="tag-close">&times;</span>
    <input type="checkbox" name="tag" value="{{ $tag['id'] }}">
</label>
@endforeach
@endif