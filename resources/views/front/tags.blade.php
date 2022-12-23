@foreach($tags as $tag)
<!--<a href=# class=tag>{{ $tag["name"] }}</a>-->
<label class="tag">{{ $tag["name"] }}
    <input type="checkbox" name="tag" value="{{ $tag['id'] }}">
</label>
@endforeach