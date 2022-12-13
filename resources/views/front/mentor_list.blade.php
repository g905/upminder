@extends('layouts/front/front')

@section('content')
            <div class="dark_block_head">
                <div class="search_block">
                    <h1>Выбираем ментора</h1>
					<form id="mentorSearch">
						<input type="hidden" name="sort" value="id" />
						<input type="hidden" name="cat" value="" />
						<input type="hidden" name="astag" value="" />
						<div class="d-none d-sm-block">
							<div class="row" >
								<div class="col-xs-6 col-md-8 col-lg-10 keysList" style="border:0px solid red">
									<input id="searchKey" name="key" class="def search" placeholder="Какой нужен специалист?">
									<div class="right">
										<a href="javascript:void(0);" class="resetFilters kill">Сбросить <img src="/verstka/images/close_white.svg"></a></div>
								</div>
								<div class="col-xs-6 col-md-4 col-lg-2"  style="border:0px solid red">
									<button class="def search">Подобрать</button>
								</div>
							</div>
						</div>
						<div class="d-block d-sm-none"  style=" position: relative">
							<input class="def search" placeholder="Какой нужен специалист?">
							<button class="def search" style="position: absolute; z-index: 2; margin: 0px; right:5px; top:6px; bottom:6px; padding: 0px; width: 41px; height: 41px; border-radius:10px "><img src="images/search.svg"></button>
							<div class="right"><a href="{{ route('front.mentors') }}" class="kill">Сбросить <img src="/verstka/images/close_white.svg"></a></div>
						</div>
						<h2>С чем нужно помочь?</h2>
						<div class="tag_block" style="display: none;"></div>
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
							<div class="result_list"></div>
                            <div class="cart_block nospec">
                                <div class="row align-items-center">
                                    <div>
                                        <img src="/verstka/images/hm_smile.svg">
                                        <div class="desc">Ничего не найдено</div>
                                        <div class="desc">Отправьте нам заявку и мы подберём вам ментора </div>
                                        <button class="def form" >Отправить заявку <img src="/verstka/images/telegram.svg"> </button>
                                    </div>
                                </div>
                            </div>
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