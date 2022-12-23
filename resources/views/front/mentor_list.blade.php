@extends('layouts/front/front')

@section('content')
<div class="dark_block_head">
    <div class="search_block">
        <h1>Выбираем ментора</h1>
        <form id="mentorSearch">
            <input type="hidden" class="cat" name="cat" value="">
            <div class="d-none d-sm-block">
                <div class="row" >
                    <div class="col-xs-6 col-md-8 col-lg-10 keysList position-relative" style="border:0px solid red">
                        <input id="searchKey" name="searchInput" class="def search" placeholder="Какой нужен специалист?">
                        <div class="search-hint"></div>
                        <div class="right">
                            <a href="javascript:void(0);" class="resetFilters kill">Сбросить <img src="/verstka/images/close_white.svg"></a></div>
                    </div>
                    <div class="col-xs-6 col-md-4 col-lg-2"  style="border:0px solid red">
                        <button class="def search">Подобрать</button>
                    </div>
                </div>
            </div>
            <div class="d-block d-sm-none keysList"  style=" position: relative">
                <input id="searchKey1" name="searchInputMobile" class="def search" placeholder="Какой нужен специалист?">
                <button class="def search" style="position: absolute; z-index: 2; margin: 0px; right:5px; top:6px; bottom:6px; padding: 0px; width: 41px; height: 41px; border-radius:10px "><img src="/verstka/images/search.svg"></button>
                <div class="right"><a href="{{ route('front.mentors') }}" class="kill">Сбросить <img src="/verstka/images/close_white.svg"></a></div>
            </div>
            <h2 class="hc">С чем нужно помочь?</h2>
            <div class="tag_block"></div>
            <div class="checkbox_block">
                <span><input class="form-check-input updateForm" type="checkbox" value="1" name="for_you" id="isForYou">
                    <label class="form-check-label" for="isForYou" > Ментор сделает за вас </label></span>
                <span > <input class="form-check-input updateForm" type="checkbox" value="1" name="vip" id="isVip">
                    <label class="form-check-label" for="isVip"> VIP-ментор </label></span>
            </div>
        </form>
    </div>
</div>
<div class="container">
    <div class="row listing_block" style="margin-top: 30px;" >
        <div class="col-lg-12 ">
            <div class="listing_block">
                <div class="result">Подобрали для вас <span id="count">0</span> наставников</div>
                <div class="sort">
                    <select class="sortList form-select form-select-lg mb-3 select-css" aria-label=".form-select-lg example">
                        <option value="id">По умолчанию</option>
                        <option value="lessons">По количеству занятий</option>
                        <option value="price_asc">По цене дешевле</option>
                        <option value="price_desc">По цене дороже</option>
                    </select>
                </div>
                <div class="clearfix"></div>
                <div class="mentors_list"></div>
                <!--<div class="cart_block nospec">
                    <div class="row align-items-center">
                        <div>
                            <img src="/verstka/images/hm_smile.svg">
                            <div class="desc">Ничего не найдено</div>
                            <div class="desc">Отправьте нам заявку и мы подберём вам ментора </div>
                            <button class="def form" >Отправить заявку <img src="/verstka/images/telegram.svg"> </button>
                        </div>
                    </div>
                </div>-->
            </div>
            <div class="paginator" style="display: none;">
                <ul class="nav justify-content-center">
                    <li class="nav-item"> <a class="nav-link" href="#">1</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="#">2</a> </li>
                    <li class="nav-item"> <a class="nav-link active">3</a> </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>

    /******* by g905 tg://@g9051 ********/

    $(document).ready(() => {


        $('body').on('click', '.tag input[type="checkbox"]', function () {
            $(this).parent().toggleClass('checked');
        });


        let input = $("#searchKey");
        let headers = {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        };


        /********* SEARCH BY INPUT *******/
        const searchCats = (toSend) => {
            $.ajax({
                headers: headers,
                data: toSend,
                method: "post",
                dataType: "html",
                url: "{{ route('front.mentors.cats') }}",
                beforeSend: () => {
                    $('.search-hint').fadeOut(200, function () {
                        $('.search-hint').html("");
                    });
                },
                success: (data) => {
                    console.log(data);

                    $('.search-hint').fadeIn(200, function () {
                        $('.search-hint').append(data);
                    });
                },
                error: (err) => {
                    console.log(err);
                }
            });
        };

        /**debounce - это ограничение частоты запросов, чтобы не каждую миллисекунду отправлялись, а с задержкой**/
        $(input).keyup($.debounce(550, function (e) {
            if ($(this).val().trim() === "") {
                $('.search-hint').html("");
                return false;
            }
            let toSend = {
                val: $(this).val()
            };
            searchCats(toSend);
        }));

        $(input).focusout(function () {
            $('.search-hint').fadeOut(200);
        });

        $(input).focus(function (e) {
            if ($(this).val().trim() === "") {
                $('.search-hint').html("");
                return false;
            }
            let toSend = {
                val: $(this).val()
            };
            searchCats(toSend);
        });






        /********************* SEARCH TAGS BY CAT ID ************************/

        const searchTagsByCatId = (id) => {
            console.log(id);
            $.ajax({
                headers: headers,
                data: {
                    type: "tags",
                    id: id
                },
                method: "post",
                dataType: "html",
                url: "{{ route('front.mentors.cats') }}",
                beforeSend: () => {
                    $('.tag_block').html("");
                    $('.tag_block').fadeOut(200, () => {

                    });
                },
                success: (data) => {
                    console.log(data);
                    $('.tag_block').append(data);
                    $('.tag_block').fadeIn(200);
                },
                error: (err) => {
                    console.log(err);
                }

            });


        };



        $('body').on('click', '.child', function (e) {
            //console.log($(this).attr("id"));
            $(input).val($(this).text());
            $('.cat').val($(this).attr("id"));
            searchTagsByCatId($(this).attr("id"));
        });




        $('body').on('click', '.def.search', function (e) {
            e.preventDefault(e);
            let form = $('#mentorSearch');

            let data = $(form).serializeArray();

            $.ajax({
                headers: headers,
                data: {
                    type: "mentors",
                    form: data
                },
                method: "post",
                dataType: "html",
                url: "{{ route('front.mentors.cats') }}",
                beforeSend: () => {
                    $('.mentors_list').html("");
                },
                success: (data) => {
                    $('.mentors_list').append(data);
                },
                error: (err) => {
                    console.log(err);
                }

            });

        });




        $('.kill').click(function () {
            $('#mentorSearch').find('input').each(function (idx, el) {
                $(el).val("");
            });
            $('.tag_block').html("");
        })


    });
</script>


<style>
    .search-hint {
        position: absolute;
        top: 70px;
        background: #fff;
        color: #666;
        display: none;
        border-radius: 5px;
        padding: 1rem 0;
    }
    .parent {
        color: #aaa;
        padding: 0 1rem;
    }
    .child {

        padding: 0 1rem;
    }
    .child:hover {
        opacity: .8;
        cursor: pointer;
        background: #37e45e;
        color: white;
    }
    .cats-tree {
    }

    label.tag:hover {
        opacity: .8;
        background: #fff !important;
        color: #000 !important;
        transition: background .5s ease-in-out;
    }

    label.tag.checked {
        background: #37e45e !important;
        color: #fff !important;
    }

    label.tag.checked:hover {
        background: #37e45e !important;
        color: #fff !important;
    }

    label.tag input[type="checkbox"] {
        display: none;
    }

</style>

@endsection