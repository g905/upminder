@if(!count($mentors))

@include('front.empty')

@else
<div class="col-lg-12 ">
    <div class="listing_block">
        <div class="result">Подобрали для вас <span id="count">{{ $mentors->total() }}</span> {{ trans_choice('наставника|наставников|наставников', $mentors->total()) }}</div>
        <div class="sort">
            <select class="sortList form-select form-select-lg mb-3 select-css" aria-label=".form-select-lg example">
                <option value="id">По умолчанию</option>
                <option value="lessons">По количеству занятий</option>
                <option value="price_asc">По цене дешевле</option>
                <option value="price_desc">По цене дороже</option>
            </select>
        </div>
        <div class="clearfix"></div>
        <div class="mentors_list">
            @foreach($mentors as $mentor)
            @include('front.mentors', ['mentor' => App\Models\Mentor::find($mentor->id)])
            @endforeach
        </div>

    </div>
    {{ $mentors->links('front.pagination', ['mentors' => $mentors]) }}

</div>

@endif