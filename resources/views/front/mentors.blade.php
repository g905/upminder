<div class="cart_block">
    <div class="row">
        <div class="col-lg-2 col-md-3  d-none d-md-block">
            <div style="text-align: center; position: relative">
                <a href="{{ route('front.mentor', ['id' => $mentor->id]) }}">
                    @if($mentor->isMentorOfTheDay($catId))
                    <span class="mentorday">Ментор дня</span>
                    @endif
                    <img src="{{ Storage::disk('public')->url('avatar/' . $mentor->avatar) }}" class="img-fluid">
                </a>
            </div>
        </div>
        <div class="col-lg-7 col-md-5">
            <div class="d-block d-md-none" style="float:left; width: 30%; border:0px solid red; margin-right: 8px; margin-top: 20px;">
                <a href="{{ route('front.mentor', ['id' => $mentor->id]) }}">
                    <span class="mentorday">Ментор дня</span><img src="{{ Storage::disk('public')->url('avatar/' . $mentor->avatar) }}" class="img-fluid">
                </a>
            </div>
            <h3>
                <a href="{{ route('front.mentor', ['id' => $mentor->id]) }}">{{ $mentor->first_name }} {{ $mentor->last_name }}</a>
                @if($mentor->verified)
                <span class='verified'>
                    <img src='{{ asset("assets/images/cart_icon/verify.svg") }}' alt="verify-icon">
                </span>
                @endif
            </h3>
            @if($mentor->getLastJob())
            <div class="prof">{{ $mentor->getLastJob()->position }} в <a href="#" class="company">{{ $mentor->getLastJob()->company->name }}</a></div>
            @endif
            @if($mentor->timezone)
            <span class="address"><img src="{{ asset('assets/images/geo.svg') }}"> {{ $mentor->timezone }}</span>
            @endif
            @if(count($mentor->languages))
            <span class="language"><img src="{{ asset('assets/images/lang.svg') }}"> {{ $mentor->getLanguagesString() }}</span>
            @endif
            <div class="desc d-none d-md-block">{{ $mentor->description }}</div>
            <div class="clearfix"></div>
            <div class="tag_block">
                <!-- специальные теги  -->
                @if(count($mentor->getAdditionalServices()))
                <a href="#" class="tag spectag">Ментор сделает за вас&nbsp;<img src="{{ asset('assets/images/force.svg') }}"></a>
                @endif
                @if($mentor->vip_status)
                <a href=# class="tag spectag">VIP-ментор&nbsp;<img src="{{ asset('assets/images/smile.svg') }}"></a>
                @endif
                <!-- конец блока -->
                @foreach($mentor->tags as $tag)
                <a href="#" class="tag">{{ $tag->name }}</a>
                @endforeach
            </div>
        </div>
        <div class="col-lg-3 col-md-4" >
            <div class="static_price_block">
                @if($mentor->getDefaultService())
                <span class="active_price">{{ $mentor->getActivePrice() }}  <span class='rub'>{{ $mentor->getDefaultCurrency()->code === "rub" ? "Р" : "$" }}</span></span>
                <span class="old_price">{{ $mentor->getDefaultService()->price }} <span class='rub'>{{ $mentor->getDefaultCurrency()->code === "rub" ? "Р" : "$" }}</span></span>
                <span class="active_price">/час</span>
                <div class="sale">1-ое занятие - 100%</div>
                @else
                <div class="sale">Цена по запросу</div>
                @endif
                <div class="btn_block">
                    <a href="{{ route('front.mentor', ['id' => $mentor->id]) }}" class="enter">Подробнее</a>
                    <a href="#" class="request" data-bs-toggle="modal" data-bs-target="#personalmentormodal">Оставить заявку</a>
                </div>
            </div>
        </div>
    </div>
</div>