@foreach($mentors as $mentor)

<div class="cart_block">
    <div class="row">
        <div class="col-lg-2 col-md-3  d-none d-md-block">
            <div style="text-align: center; position: relative">
                <a href="cart.html">
                    <span class="mentorday">Ментор дня</span><img src="{{ Storage::disk('public')->url('avatar/' . $mentor->avatar) }}" class="img-fluid">
                </a>
            </div>
        </div>
        <div class="col-lg-7 col-md-5">
            <div class="d-block d-md-none" style="float:left; width: 30%; border:0px solid red; margin-right: 8px; margin-top: 20px;">
                <a href="cart.html">
                    <span class="mentorday">Ментор дня</span><img src="{{ Storage::disk('public')->url('avatar/' . $mentor->avatar) }}" class="img-fluid">
                </a>
            </div>
            <h3><a href="cart.html">{{ $mentor->first_name }} {{ $mentor->last_name }}</a></h3>
            <div class="prof">Ведущий программист в <a href="#" class="company">Beeline</a></div>
            <span class="address"><img src="/verstka/images/geo.svg"> Moscow, Russia (+03:00 UTC)</span> <span class="language"><img src="/verstka/images/lang.svg"> Русский, English</span>
            <div class="desc d-none d-md-block">{{ $mentor->description }}</div>
            <div class="clearfix"></div>
            <div class="tag_block">
                <!-- специальные теги  -->
                <a href="#" class="tag spectag">Ментор сделает за вас&nbsp;<img src="/verstka/images/force.svg"></a>
                @if($mentor->vip_status)
                <a href=# class="tag spectag">VIP-ментор&nbsp;<img src="/verstka/images/smile.svg"></a>
                @endif
                <!-- конец блока -->
                @foreach($mentor->tags as $tag)
                <a href="#" class="tag">{{ $tag->name }}</a>
                @endforeach

                <!--<a href="#" class="tag">Юридические вопросы</a>
                <a href="#" class="tag">Аналитика</a>
                <a href="#" class="tag">Проектирование сайта</a>
                <a href="#" class="tag">Подготовка к собеседованию</a>
                <a href="#" class="tag">Маркетинговая стратегия</a>-->
            </div>
        </div>
        <div class="col-lg-3 col-md-4" >
            <div class="static_price_block">
                <span class="active_price">350 <span class="rub">Р</span></span>
                <span class="old_price">1500 <span class="rub">Р</span></span>
                <span class="active_price">/час</span>
                <div class="sale">1-ое занятие - 100%</div>
                <div class="btn_block">
                    <a href="cart.html" class="enter">Подробнее</a>
                    <a href="#" class="request" data-bs-toggle="modal" data-bs-target="#personalmentormodal">Оставить заявку</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endforeach