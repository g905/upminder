@extends('layouts/front/front')

@section('content')
<div class="dark_block_head">
    <div class="search_block">
        <h1>Выбираем ментора</h1>
        <form id="mentorSearch">
            <input type="hidden" class="cat" name="cat" value="">
            <input type="hidden" class="sort" name="sort" value="">
            <input type="hidden" id="page" name="page" value="1">
            <div class="d-none d-sm-block">
                <div class="row" >
                    <div class="col-xs-6 col-md-8 col-lg-10 keysList position-relative" style="border:0px solid red">
                        <input id="searchKey" name="searchInput" class="def search" placeholder="Какой нужен специалист?">
                        <div class="search-hint"></div>
                        <div class="right">
                            <a href="#" class="resetFilters kill">Сбросить <img src="/verstka/images/close_white.svg"></a></div>
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

            <div class="tags_block"></div>
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

    </div>
</div>

<div class="preloader"></div>

@endsection

@section('scripts')

<script>

    /******* by g905 tg://@g9051 ********/

    $(document).ready(() => {



        $('body').on('click', '.form-check-input', function () {
            $(this).val($(this).prop("checked") ? "1" : "0");
        });

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
                    $('.listing_block').fadeOut(200);
                    $('.search-hint').fadeOut(200, function () {
                        $('.search-hint').html("");
                    });
                },
                success: (data) => {
                    console.log(data);
                    $('.search-hint').fadeIn(200, function () {
                        $('.search-hint').append(data);
                    });
                    sendForm();

                },
                error: (err) => {
                    console.log(err);
                    if (err.status === 404) {
                        $('.listing_block').html(JSON.parse(err.responseText).html);
                        $('.listing_block').fadeIn(200);
                    }
                }
            });
        };

        /**
         * Поиск по вводу */
        $(input).keyup($.debounce(550, function (e) {
            if ($(this).val().trim() === "") {
                $('.search-hint').html("");
                return false;
            }
            let toSend = {
                type: "cats",
                val: $(this).val()
            };
            searchCats(toSend);
        }));

        $(input).focusout(function () {
            $('.search-hint').fadeOut(200);
        });

        $(input).focus(function (e) {
            $(input).val("");
            //if ($(this).val().trim() === "") {
            //  $('.search-hint').html("");
            // return false;
            //}
            //let toSend = {
            //    val: $(this).val()
            //};
            //searchCats(toSend);
        });






        /********************* SEARCH TAGS BY CAT ID ************************/

        const searchTagsByCatId = (id, active_id = null) => {
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
                    $('.mentors_list').html("");
                    $('.tags_block').html("");
                    $('.tags_block').fadeOut(200, () => {

                    });
                },
                success: (data) => {
                    console.log(data);
                    $('.tags_block').append(data);
                    $('label.tag[data-id="' + active_id + '"]').find('[type="checkbox"]').attr('checked', true);
                    $('label.tag[data-id="' + active_id + '"]').addClass('checked');
                    $('.tags_block').fadeIn(200);
                    sendForm();
                },
                error: (err) => {
                    console.log(err);
                }

            });


        };



        $('body').on('click', '.cat.child', function (e) {
            //console.log($(this).attr("id"));
            $(input).val($(this).text());
            $('input.cat').val($(this).attr("id"));
            searchTagsByCatId($(this).attr("id"));
        });



        $('body').on('click', '.tagSearch.child', function (e) {
            $(input).val(/*$(this).prev().text() + " / " + */$(this).text());
            let parent_id = $(this).prev().attr("id");
            $('input.cat').val(parent_id);
            searchTagsByCatId(parent_id, $(this).attr("id"));
        });




        function sendForm() {
            let form = $('#mentorSearch');

            let data = $(form).serializeArray();
            console.log(data);
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
                    $('.preloader').fadeIn(200);
                    $('.listing_block').fadeOut(200);
                    $('.listing_block').html("");
                },
                success: (data) => {
                    $('.preloader').fadeOut(200);
                    //console.log(data);
                    $('.listing_block').fadeIn(200, function () {
                        $('.listing_block').append(data);
                    });

                },
                error: (err) => {
                    console.log(err);
                }

            });
        }



        $('body').on('click', 'button.def.search', function (e) {
            e.preventDefault(e);
            sendForm();

        });



        $('body').on("change", '#mentorSearch :input:not(#searchKey)', function (e) {
            e.preventDefault(e);
            sendForm();
        });



        function clearForm() {
            $('#mentorSearch :input').val("");
            $('.tags_block').html("");
            $('#mentorSearch label').removeClass("checked");
            $('#mentorSearch :input[type=checkbox]').prop("checked", false);

        }

        $('.kill').click(function (e) {
            e.preventDefault(e);
            clearForm();
            $('.sort').trigger('change');
        });





        $('body').on('change', '.sortList', function () {
            $('#mentorSearch').find('.sort').val($(this).val());
            $('#mentorSearch').find('.sort').trigger('change');
        });


        sendForm();
    });








</script>


<style>
    #searchKey {
        color: #666;
    }
    .search-hint {
        position: absolute;
        top: 70px;
        background: #fff;
        color: #666;
        display: block;
        border-radius: 16px;
        z-index: 999;
        width: 98%;

        padding:0px;
        padding-top: 16px;
        padding-bottom: 16px;
        }
    .parent {
        color: black;
        padding: 0 20px;
    }
    .child {
  color: black;
padding:10px;
        padding-left: 40px;
    }
    .child:hover {

        cursor: pointer;
        background: #37E45E;
        color: black;
    }
    .cats-tree {
    }

    label.tag {
        position: relative;
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

    .tag-close {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        right: -10px;
        top: -10px;
        background: white;
        border-radius: 10px;
        width: 20px;
        height: 20px;
        font-size: 20px;
        border: 2px solid #666;
        transition: opacity .2s ease-in-out;
    }

    .tag-close:hover {
        opacity: .8;
    }

    label.tag .tag-close {
        opacity: 0;
    }

    label.tag.checked .tag-close {
        color: #666;
        opacity: 1;
    }

    .preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: none;
        align-content: center;
        justify-content: center;
        background: rgba(255,255,255,.0);
        backdrop-filter: blur(1px) grayscale(.5);
    }

</style>

@endsection
