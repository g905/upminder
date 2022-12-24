
<div class="cats-tree">
    @foreach($catsTree as $ct)
    <div class="parent" id = "{{ $ct["pc"]["id"] }}">{{ $ct["pc"]["name"] }}</div>
    @foreach($ct["cs"] as $cc)
    <div class="child" id = "{{ $cc["id"] }}">{{ $cc["name"] }}</div>
    @endforeach


    @endforeach
</div>