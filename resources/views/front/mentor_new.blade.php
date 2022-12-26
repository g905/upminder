@extends('layouts.front.front')

@section('content')

<div class=dark_block_head>
    <!-- начинается карточка -->
    <div class=dark_mentor_block>
        <a href="{{ route('front.mentors') }}" class=backtolisting><img src="{{ asset('assets/images/back.svg') }}"> Вернуться к списку менторов</a>
        <div class=cart_min_block>
            <div class="row">
                <div class="col-lg-3 ">
                    <div style="width: 100%; height: 250px; background: #f1f1f1; border-radius: 15px; background-image: url({{ Storage::disk('public')->url('avatar/' . $mentor->avatar) }}); background-size: cover;">
                        <img src="{{ Storage::disk('public')->url('avatar/' . $mentor->avatar) }}" class=img-fluid style="width:100%; display: none;">
                    </div>
                    <div class="d-flex justify-content-center">
                       <!--- <span class=mentorday>Ментор дня</span>  -->
                    </div>
                </div>
                <div class="col-lg-6 ">
                    <h1>{{ $mentor->first_name }} {{ $mentor->last_name }}
                        @if($mentor->verified)
                        <span class='verified'>
                            <img src='{{ asset("assets/images/cart_icon/verify.svg") }}' alt="verify-icon">
                        </span>
                        @endif
                    </h1>
                    @if($mentor->getLastJob())
                    <div class="prof">{{ $mentor->getLastJob()->position }} в <a href="#" class="company">{{ $mentor->getLastJob()->company->name }}</a></div>

                    <div class=company_desc>{{ $mentor->getLastJob()->description }}</div>
                    @endif
                    <div class=tag_block>
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
                    <div class=feature>
                        @if($mentor->experience)
                        <div class="d-none d-lg-block"> <img src="{{ asset('assets/images/cart_icon/rocket.svg') }}"> Опыт {{ $mentor->experience }} </div>
                        @endif
                        <div class="d-none d-lg-block" ><img src="{{ asset('assets/images/cart_icon/bookmark.svg') }}"> Проведено {{ count($mentor->lessons) }} {{ trans_choice('занятие|занятия|занятий', count($mentor->lessons)) }}</div>
                        @if($mentor->isLocation())
                        <div><img src="{{ asset('assets/images/cart_icon/geo2.svg') }}"> {{ $mentor->getLocationString() }}</div>
                        @endif
                        @if(count($mentor->languages))
                        <div><img src="{{ asset('assets/images/cart_icon/globe.svg') }}"> {{ $mentor->getLanguagesString() }}</div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-3 ">
                    <div class="float_price_block">

                        @if($mentor->getDefaultService())
                        <span class="active_price">{{ $mentor->getActivePrice() }}  @if($mentor->getDefaultCurrency()->code === "rub") <span class='rub'>Р</span> @else <span>$</span> @endif</span>
                        <span class="old_price">{{ $mentor->getDefaultService()->price }} @if($mentor->getDefaultCurrency()->code === "rub") <span class='rub'>Р</span> @else <span>$</span> @endif</span>
                        <span class="active_price">/час</span>
                        <div class="sale">1-ое занятие - 100%</div>
                        @else
                        <div class="sale">Цена по запросу</div>
                        @endif
                        <div style="margin-top:50px;"><a href=# class=request  data-bs-toggle="modal" data-bs-target="#personalmentormodal">Записаться</a> <a href=#more class=enter>Подробнее</a>  </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- черная часть кончилась -->
<div class="cart_white_block">
    <a name=more></a>
    <div class="row" style="margin-top: 60px;">
        <div class="col-lg-8">
            <div class=tab_block>
                <div class=mentor_desc_tab_block>
                    <nav class=mentor_tabs >
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Описание</button>
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">С чем могу помочь</button>
                            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Образование</button>
                            <button class="nav-link" id="nav-cv-tab" data-bs-toggle="tab" data-bs-target="#nav-cv" type="button" role="tab" aria-controls="nav-cv" aria-selected="false">Резюме</button>
                            <button class="nav-link" id="nav-rev-tab" data-bs-toggle="tab" data-bs-target="#nav-rev" type="button" role="tab" aria-controls="nav-rev" aria-selected="false">Отзывы</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">{!! $mentor->description !!}</div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">{!! $mentor->help_text !!}</div>
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                            @if (count($mentor->educations))
                            @foreach ($mentor->educations as $edu)
                            <p>С {{ date('d.m.Y', strtotime($edu->date_start)); }} по {{ date('d.m.Y', strtotime($edu->date_end)); }}</p>
                            <p><strong>{{ $edu->course }} в "{{ $edu->school }}"</strong></p>
                            @if ($edu->present)
                            <p><i>Продолжает обучение</i></p>
                            @endif
                            @endforeach
                            @endif
                        </div>
                        <div class="tab-pane fade" id="nav-cv" role="tabpanel" aria-labelledby="nav-contact-tab">

                            <div class=exp>Опыт работы: {{ $mentor->experience }} </div>

                            @if (count($mentor->jobs))

                            @foreach ($mentor->jobs as $exp)

                            <table class=exp_table>

                                <tr>
                                    <td style="width:0%" >
                                        @if ($exp->company->logo)
                                        <img src="{{ route('get.avatar', $exp->company->logo) }}" class=exp_logo>
                                        @endif</td>
                                    <td>


                                        <p class=exp_note>@if ($exp->position) {{ $exp->position }} @else Должность не указана  @endif, {{ $exp->company->name }}</p>

                                        <p>С {{ date('d.m.Y', strtotime($exp->date_start)); }} по {{ date('d.m.Y', strtotime($exp->date_end)) }}</p>
                                        @if ($exp->present)
                                        <p>По настоящее время</p>
                                        @endif


                                    </td>
                                </tr>


                            </table>

                            @endforeach
                            @endif
                        </div>
                        <div class="tab-pane fade" id="nav-rev" role="tabpanel" aria-labelledby="nav-contact-tab">
                            @if(count($mentor->reviews))
                            @foreach($mentor->reviews as $review)
                            <div>{{ $review->author }}</div>
                            <div>{{ $review->email }}</div>
                            <div>{{ $review->text }}</div>
                            @endforeach
                            @else
                            <div>Отзывов пока нет.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <h2 class=stz>Стоимость занятий</h2>
            <div class=service_block>
                <!-- тут надо придумать цикл  который будет выстраивать по три блока в строку -->
                @if (count($mentor->services))
                @foreach ($mentor->services as $serv)

                @if ($serv->service->type_service !== 1)
                @continue
                @endif

                <div class=white_block >
                    <div>{{ $serv->service->name }}</div>
                    <span class=active_price>{{ $serv->price }} @if($mentor->getDefaultCurrency()->code === "rub") <span class='rub'>Р</span> @else <span>$</span> @endif</span><span class=active_price>/час</span>
                    @if ($serv->discount > 0)
                    <div class=sale>Скидка - {{ $serv->discount }}%</div>
                    @endif
                </div>

                @endforeach
                @endif
            </div>
            <h2>Дополнительные услуги</h2>
            <div class=service_block>
                <!-- тут надо придумать цикл  который будет выстраивать по три блока в строку -->
                @if (count($mentor->services))
                @foreach ($mentor->services as $serv)



                @if ($serv->service->type_service !== 2)
                @continue
                @endif

                <div class=white_block >
                    <div>{{ $serv->service->name }}</div>
                    <span class=active_price>{{ $serv->price }} @if($mentor->getDefaultCurrency()->code === "rub") <span class='rub'>Р</span> @else <span>$</span> @endif</span><span class=active_price>/час</span>
                    @if ($serv->discount > 0)
                    <div class=sale>Скидка - {{ $serv->discount }}%</div>
                    @endif
                </div>

                @endforeach
                @endif
            </div>
            <div class="dark_block why">
                <img src="/verstka/images/why.svg">
                <h2>Почему стоит записаться через Upminder</h2>
                <p>У наших менторов есть:</p>
                <div><img src="/verstka/images/cart_icon/graduation-hat-02.svg"><span>Высшее и дополнительное образование</span></div>
                <div> <img src="/verstka/images/cart_icon/briefcase.svg"><span>Опыт работы от 3-х лет в сфере, которую они представляют</span></div>
                <div><img src="/verstka/images/cart_icon/passport.svg"><span>Успешные кейсы по указанным направлениям</span></div>
                <div><img src="/verstka/images/cart_icon/award.svg"><span>Необходимый уровень знаний о работе с людьми</span></div>
                <br>
                <p>Мы создаём максимально комфортную среду общения с клиентами, учениками и менторами. </p>
                <p>Если вы с нами — наша команда будет внимательно наблюдать за прогрессом в процессе обучения и за решением ваших вопросов</p>
            </div>
            <div class="guarantee_block why">
                <img src="/verstka/images/garanty.svg">
                <h2>Наши гарантии</h2>
                <div>  <img src="/verstka/images/cart_icon/shield-tick.svg"><span>Ваши данные остаются в безопасности и не передаются третьим лицам</span></div>
                <div><img src="/verstka/images/cart_icon/refresh-cw.svg"><span>Вы сможете отменить запись не позднее, чем за 24 часа до встречи, деньги вернуться вам на карту</span></div>
                <div><img src="/verstka/images/cart_icon/credit-card-check.svg"><span>Если услуга не будет оказана качественно, мы вернем вам полную стоимость занятия и поможем подобрать другого специалиста</span></div>
                <br>
                <p>Мы создаём безопасную среду и отвечаем за сохранность ваших данных. Для этого ментор подписывает с нами дополнительное соглашение</p>
            </div>
            <p style="margin-top: 80px; margin-bottom: 0px;"><a href="{{ route('front.mentors') }}" class=backtolisting style="color:black;"><img src="/verstka/images/back.svg"> Вернуться к списку менторов</a>
            </p>
            <!-- конец левого блока -->
        </div>
    </div>
    <div class=cart_faq_block>
        <h2>Вопросы и ответы</h2>
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Как получить консультацию?
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        Наши менторы помогут вам тщательно разобрать каждый шаг на пути развития вашего дела. Изучите все важные моменты с профильными специалистами: юридические стороны, бухгалтерский учет, маркетинг и другие направления. Оставляйте заявку, и мы свяжемся с вами в течение часа, чтобы подобрать нужного специалиста.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Как выбрать ментора?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        Наши менторы помогут вам тщательно разобрать каждый шаг на пути развития вашего дела. Изучите все важные моменты с профильными специалистами: юридические стороны, бухгалтерский учет, маркетинг и другие направления. Оставляйте заявку, и мы свяжемся с вами в течение часа, чтобы подобрать нужного специалиста.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        let block = $('.float_price_block');
        let faq_block = $('.cart_faq_block');
        $(window).scroll(function () {

            if ($(window).scrollTop() < 400) {
                $(block).css('position', 'fixed');
            } else
            if ($(window).scrollTop() > ($(faq_block).offset().top - 600)) {
                $(block).css('position', 'absolute');
                $(block).css('top', ($(faq_block).offset().top - 300) + "px");
            } else if ($(window).scrollTop() < ($(faq_block).offset().top - 300)) {
                $(block).css('position', 'fixed');
                $(block).css('top', (300) + "px");
            }
        })

    })
</script>

<style>
    .float_price_block {
        width: 400px;
    }
</style>
@endsection
