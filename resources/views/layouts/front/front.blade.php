<!doctype html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="/verstka/css/bootstrap.min.css" rel="stylesheet">
        <link href="/verstka/less/main.css?v=2" rel="stylesheet" >
        <script src="/verstka/js/bootstrap.bundle.min.js"></script>
        <title>Каталог менторов</title>
    </head>
    <body style="overflow-x: hidden;">
        <div class="container100 pb-5 position-relative" style="z-index: 2; background: #f8f8f8;">
            <div class="head">
                <div class="row">
                    <div class="col-md-3">
                        <a href="/">
                            <img src="/verstka/images/logo.svg" class="logo" style="width:100%;">
                        </a>
                    </div>
                    <div class="col-md-9" >
                        <div class="d-flex justify-content-end " >
                            <nav class="navbar navbar-expand-md navbar-dark" aria-label="Fourth navbar example"  >
                                <div class="collapse navbar-collapse" id="navbarsExample04"  >
                                    <ul class="navbar-nav mb-2 mb-md-0">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="{{ route('front.mentors') }}">Каталог менторов</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="mentors.html">Как стать ментором</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="about.html">Как это работает</a>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            @yield('content')
        </div>
        <div class="dark position-relative" id="questBlock" style="overflow: hidden;">
            <div class="cart_block nospec2" style="padding-top: 150px; padding-bottom: 150px;">
                <div>
                    <h2>Остался вопрос?</h2>
                    <div class="desc">Мы рядом</div>
                    <button class="def form" >Напишите нам <img src="/verstka/images/telegram.svg"> </button>
                </div>
            </div>
            <div class="position-absolute border rounded-circle d-flex justify-content-center align-items-center questions text-center" style="width: calc(0.25rem + 10vw); height: calc(0.25rem + 10vw); top: 0; left: 5%;">Дизайн</div>
            <div class="position-absolute border rounded-circle d-flex justify-content-center align-items-center questions text-center" style="width: calc(0.25rem + 8vw); height: calc(0.25rem + 8vw); top: 0; left: 45%;">UI</div>
            <div class="position-absolute border rounded-circle d-flex justify-content-center align-items-center questions text-center" style="width: calc(0.25rem + 15vw); height: calc(0.25rem + 15vw); top: -5%; right: 15%;">Программирование</div>
            <div class="position-absolute border rounded-circle d-flex justify-content-center align-items-center questions text-center" style="width: calc(0.25rem + 10vw); height: calc(0.25rem + 10vw); bottom: 10%; left: -2%;">Product менджмент</div>
            <div class="position-absolute border rounded-circle d-flex justify-content-center align-items-center questions text-center" style="width: calc(0.25rem + 8vw); height: calc(0.25rem + 8vw); bottom: 5%; left: 20%;">UX</div>
            <div class="position-absolute border rounded-circle d-flex justify-content-center align-items-center questions text-center" style="width: calc(0.25rem + 10vw); height: calc(0.25rem + 10vw); bottom: -4%; right: 25%;">Back-end</div>
            <div class="position-absolute border rounded-circle d-flex justify-content-center align-items-center questions text-center" style="width: calc(0.25rem + 10vw); height: calc(0.25rem + 10vw); bottom: -3%; right: 5%;">JavaScript</div>
            <div class="position-absolute border rounded-circle d-flex justify-content-center align-items-center questions text-center" style="width: calc(0.25rem + 10vw); height: calc(0.25rem + 10vw); bottom: 30%; right: -3%;">Маркетинг</div>
        </div>









            <div class=bottom_block >


              <div class=bottom_logo style="width:100%; position:absolute; bottom:0px;" >
              <div style="position:relative;">

                  <div class=greencycle><img id="circle" src="/verstka/images/greencycle.svg"></div>
                <img src="/verstka/images/upminder.svg" class=logos>

              </div>


               </div>


        <div class=container-fluid>

              <div class="row bottom_link_block" >
                <div class="col-lg-6 col-md-6" id="targetCircle">
                  <div class=bottom_menu>
                    <p class="pb-3" style="width: fit-content;"><a href=# class="d-inline-block">О сервисе</a></p>
                    <p class="pb-3" style="width: fit-content;"><a href=# class="d-inline-block">Стать ментором</a></p>
                    <p class="pb-3" style="width: fit-content;"><a href=# class="d-inline-block">Каталог менторов</a></p>
                  </div>
                  <div class="bottom_link d-none d-xs-none d-sm-block d-lg-none">
                    <p style="width: fit-content;"><a href=# class="d-inline-block">Политика конфиденциальности</a></p>
                    <p  style="width: fit-content;"><a href=# class="d-inline-block"> Пользовательское соглашение</a></p>
                    <p  style="width: fit-content;"><a href=# class="d-inline-block">Управление cookie</a></p>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 right">
                  <div class=" justify-content-end "> <button href=# class=support nowrap>Написать в поддержку&nbsp;<span></span></button>



                       <div class="bottom_link d-block d-xs-block d-sm-none d-lg-block">
                    <p class="pb-3" ><a href=#  class="d-inline-block">Политика конфиденциальности</a></p>
                    <p class="pb-3" ><a href=# class="d-inline-block"> Пользовательское соглашение</a></p>
                    <p class="pb-3" ><a href=# class="d-inline-block">Управление cookie</a></p>
                  </div>

                       <div class=bottom_link>


          			<p>© Upminder 2022</p>
                      <p> Дизайн сайта @lena_zakharian</p>

          				 </div>

                    </div>
                  </div>
                </div>

                </div>



            </div>












    <script>
document.addEventListener('DOMContentLoaded', function () {
    let textline = document.querySelectorAll('.right_block .textline');

    window.addEventListener('scroll', function () {
        textline.forEach(el => {
            let elTop = el.offsetTop - document.documentElement.clientHeight / 2;
            let elBottom = el.offsetTop + el.offsetHeight - document.documentElement.clientHeight / 2;
            if (window.pageYOffset <= elTop || window.pageYOffset > elBottom) {
                el.style.opacity = '';
            } else {
                el.style.opacity = '1';
            }
        });
    });

    if (document.documentElement.clientWidth >= 768) {
        let circle = document.querySelector('#circle');
        let links = document.querySelectorAll('#targetCircle p');
        let btnSupport = document.querySelector('button.support');

        links.forEach(el => {
            el.addEventListener('mouseover', function (e) {
                let x = Math.round(Math.random() * (500 - 20) + 20) * -1;
                let p = (document.documentElement.clientWidth - 160) / 2 - circle.offsetWidth / 2;
                p = Math.sign(x) === -1 ? -p : p;
                circle.style.transform = 'translateX(' + (Math.abs(x) > Math.abs(p) ? p : x) + 'px)';
            });
            el.addEventListener('mouseout', function () {
                circle.style.transform = '';
            });
        });

        btnSupport.addEventListener('mouseover', function (e) {
            let x = Math.round(Math.random() * (500 - 20) + 20);
            let p = (document.documentElement.clientWidth - 160) / 2 - circle.offsetWidth / 2;
            p = Math.sign(x) === -1 ? -p : p;
            circle.style.transform = 'translateX(' + (Math.abs(x) > Math.abs(p) ? p : x) + 'px)';
        });
        btnSupport.addEventListener('mouseout', function () {
            circle.style.transform = '';
        });
    }
});
    </script>
    <!-- Modal -->
    <div class="modal fade" id="mentorseekmodal" tabindex="-1" aria-labelledby="mentorseekmodal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h2>Подобрать эксперта</h2>
                    <p> Опишите ваш запрос, в течение дня мы свяжемся с вами и предложим подходящих экспертов</p>
                    <div class="mb-3">
                        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Ваше имя и фамилия">
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Телефон">
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Telegram аккаунт">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Выберите способ связи</label>
                        <select class="form-select" aria-label="Способ связи">
                            <option selected>Whatsapp</option>
                            <option value="1">Telegram</option>
                            <option value="2">Телефон</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Приоритетный язык общения</label>
                        <select class="form-select" aria-label="Способ связи">
                            <option selected>Русский</option>
                            <option value="1">Английский</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Укажите город проживания</label>
                        <select class="form-select" aria-label="Способ связи">
                            <option selected>Москва</option>
                            <option value="1">Новосибирск</option>
                            <option value="2">Владивосток</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Цель консультации</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Разрешаю обработку персональных данных
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="def2">Оставить заявку</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="personalmentormodal" tabindex="-1" aria-labelledby="mentorseekmodal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h2>Заявка на ментора: Анна Давыдова</h2>
                    <p> Опишите ваш запрос, в течение дня мы свяжемся с вами и предложим подходящих экспертов</p>
                    <div class="mb-3">
                        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Ваше имя и фамилия">
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Телефон">
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Telegram аккаунт">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Выберите способ связи</label>
                        <select class="form-select" aria-label="Способ связи">
                            <option selected>Whatsapp</option>
                            <option value="1">Telegram</option>
                            <option value="2">Телефон</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Приоритетный язык общения</label>
                        <select class="form-select" aria-label="Способ связи">
                            <option selected>Русский</option>
                            <option value="1">Английский</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Укажите город проживания</label>
                        <select class="form-select" aria-label="Способ связи">
                            <option selected>Москва</option>
                            <option value="1">Новосибирск</option>
                            <option value="2">Владивосток</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Цель консультации</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Выберите тип задачи</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Выберите услугу</label>
                        <select class="form-select" aria-label="Способ связи">
                            <option selected>Пробная консультация</option>
                            <option value="1">Одна консультация</option>
                            <option value="2">Пять консультаций</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Разрешаю обработку персональных данных
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="def2">Оставить заявку</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            let questions = document.querySelectorAll('.questions');
            let questBlock = document.querySelector('#questBlock');

            window.addEventListener('scroll', function () {
                questions.forEach(el => {
                    let x = Math.round(Math.random() * (15 - 1) + 1)
                    let y = Math.round(Math.random() * (15 - 1) + 1);
                    el.style.transform = 'translate(-' + x + 'px, -' + y + 'px)';
                });
            });

        });
    </script>

    <script src = "{{ asset('assets/lib/jquery-3.6.3.min.js') }}"></script>
    <script src = "{{ asset('assets/lib/jquery.ba-throttle-debounce.min.js') }}"></script> <!-- задержка на инпуте -->

    @yield('scripts')
</body>
</html>
