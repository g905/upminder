<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Панель администратора</title>
    <link rel="stylesheet" href="/admin/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/admin/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/admin/assets/css/style.css">
    <link rel="shortcut icon" href="/admin/assets/images/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
            right: 5px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            height: 36px;
            line-height: 35px;
        }

        .select2-container {
            display: block;
            border: none !important;
            outline: none !important;
            color: #c9c8c8;
            height: 36px;
        }

        .select2-container--default .select2-selection--single {
            height: 100%;
            border: 1px solid #cdcdcd !important;
        }

        .badge {
            border: 1px solid transparent !important;
        }

        .tabs_shown.print .minus_button {
            width: 100% !important;
        }

        .tabs_shown.print input, .tabs_shown.print select, .tabs_show.print textarea {
            background: #f1f1f1 !important;
            border: none !important;
            color: black !important;
            appearance: none !important;
            outline: none !important;
        }

        .tabs_shown.print .minus_button + * {
            display: none;
        }

        .tabs_shown.print h3 {
            text-transform: uppercase !important;
            font-weight: 700 !important;
            display: block;
            margin-bottom: 6px;
        }

        .tabs_shown.print .add_row {
            display: none !important;
        }

        .tabs_shown .card-body.dynamic {
            display: block !important;
        }

        .row_tpl {
            display: none;
        }

        .overflow_ p {
            margin: 0;
        }

        .ava {
            width: 36px;
            height: 36px;
            border-radius: 18px;
            background: white;
            display: inline-block;
            border: 1px solid #cdcdcd;
        }

        .minus_button {
            width: calc(100% - 40px) !important;
        }

        .btn_row {
            top: 22px;
            right: 0;
            position: absolute;
            height: 36px !important;
            line-height: 24px !important;
            font-size: 17px !important;
        }

        .btn_row:hover {
            color: white !important;
        }

        .form-group {
            position: relative;
        }

        .form_group_margin .card-body.dynamic .form-group {
            margin-bottom: 1.5rem !important;
        }

        textarea.form-control {
            min-height: 120px !important;
            padding: 15px !important;
            box-sizing: border-box !important;
        }

        select.multiple {
            height: auto !important;
            padding: 15px !important;
        }

        *[align=center] {
            text-align: center !important;
        }

        *[align=right] {
            text-align: right !important;
        }

        .badge {
            text-decoration: none !important;
        }

        * {
            border-radius: 0 !important;
        }

        .page-title .page-title-icon {
            box-shadow: none !important;
            background: #383838 !important;
        }

        .btn {
            padding: 10px 25px !important;
        }

        .card-body.table {
            padding: 0 !important;
        }

        .card-body.filter {
            padding: 25px !important;
            border: 1px solid #cdcdcd !important;
            border-top: none !important;
        }

        .card-body.filter .form-group {
            margin: 0;
        }

        .grid-margin {
            margin-bottom: 25px !important;
        }

        .content-wrapper {
            min-height: 100vh;
        }

        .form-control {
            min-height: auto !important;
            border: 1px solid #cdcdcd !important;
            box-shadow: none !important;
            padding: 0 15px !important;
            height: 36px !important;
            appearance: auto !important;
            outline: none !important;
        }

        .btn.form-control {
            background: #383838 !important;
            border-color: #fff !important;
            color: #fff !important;
        }

        .btn-tabs {
            background: #cdcdcd !important;
            color: #383838 !important;
            border-color: #cdcdcd !important;
            font-weight: normal;
        }

        .btn-tabs.active, .btn-tabs:hover {
            background: #fff !important;
            border-color: white !important;
        }

        .filter_hide {
            display: none;
        }

        .card-body.dynamic {
            display: none;
            padding: 22px 25px !important;
        }

        .card-body.dynamic.shown {
            display: block;
        }

        .card-body.dynamic .form-group {
            margin: 0 !important;
        }

        .card-body .form-group:last-child {
            margin-bottom: 0 !important;
        }

        table .badge {
            font-weight: normal;
        }

        table .badge i {
            font-size: 18px;
            font-weight: normal;
        }

        table .badge:hover, table .badge:hover i {
            color: white !important;
        }

        p.small {
            margin: 0;
            color: #cdcdcd;
        }

        .card-body.dynamic .form-group {
            margin-bottom: 1.5rem !important;
        }
    </style>
  </head>
  <body>
    @if (Auth::check())
      <div class="container-scroller">
        <div class="container-fluid page-body-wrapper" style="padding-top: 0;">
          <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
              <li class="nav-item nav-profile">
                <a href="#" class="nav-link">
                  <div class="nav-profile-image">
                    <img src="/admin/assets/images/faces/face1.jpg" alt="profile">
                    <span class="login-status online"></span>
                  </div>
                  <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">{{ Auth::user()->name }}</span>
                    <span class="text-secondary text-small">Суперадмин</span>
                  </div>
                  <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin') }}" class="nav-link">
                  <span class="menu-title">Главная</span>
                  <i class="mdi mdi-home menu-icon"></i>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin') }}" class="nav-link">
                  <span class="menu-title">Статистика</span>
                  <i class="mdi mdi-chart-bar menu-icon"></i>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                  <span class="menu-title">Заявки</span>
                  <i class="menu-arrow"></i>
                  <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                </a>
                <div class="collapse" id="ui-basic">
                  <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('admin.applications.index') }}" class="nav-link">Все заявки</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('admin.applications.add') }}" class="nav-link">Добавить заявку</a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a href="#admin_lessons" data-bs-toggle="collapse" class="nav-link" aria-expanded="false" aria-controls="admin_lessons">
                  <span class="menu-title">Занятия</span>
                  <i class="menu-arrow"></i>
                  <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                </a>
                <div class="collapse" id="admin_lessons">
                  <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                      <a href="{{ route('admin.lessons.index') }}" class="nav-link">Все занятия</a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ route('admin.lessons.add') }}" class="nav-link">Добавить занятие</a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item @if (Route::current()->getName() == 'admin_company_list' or Route::current()->getName() == 'admin_company_form' or Route::current()->getName() == 'admin_company_cat_list' or Route::current()->getName() == 'admin_company_cat_form') active @endif">
                <a href="#admin_companies" data-bs-toggle="collapse" class="nav-link @if (Route::current()->getName() == 'admin_company_list' or Route::current()->getName() == 'admin_company_form' or Route::current()->getName() == 'admin_company_cat_list' or Route::current()->getName() == 'admin_company_cat_form') @else collapsed @endif" aria-expanded="false" aria-controls="admin_companies">
                  <span class="menu-title">Компании</span>
                  <i class="menu-arrow"></i>
                  <i class="mdi mdi-contacts menu-icon"></i>
                </a>
                <div id="admin_companies" class="collapse @if (Route::current()->getName() == 'admin_company_list' or Route::current()->getName() == 'admin_company_form' or Route::current()->getName() == 'admin_company_cat_list' or Route::current()->getName() == 'admin_company_cat_form') show @endif">
                  <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                      <a href="{{ route('admin_company_list') }}" class="nav-link @if (Route::current()->getName() == 'admin_company_list') active @endif">Все компании</a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ route('admin_company_form', 0) }}" class="nav-link @if (Route::current()->getName() == 'admin_company_form') active @endif">Добавить компанию</a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ route('admin_company_cat_list') }}" class="nav-link @if (Route::current()->getName() == 'admin_company_cat_list') active @endif">Категории</a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ route('admin_company_cat_form', 0) }}" class="nav-link @if (Route::current()->getName() == 'admin_company_cat_form') active @endif">Добавить категорию</a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item @if (Route::current()->getName() == 'admin.mentor.index' or Route::current()->getName() == 'admin_mentor_form' or Route::current()->getName() == 'admin_mentor_cat_list' or Route::current()->getName() == 'admin_mentor_cat_form' or Route::current()->getName() == 'admin.mentor_services.index' or Route::current()->getName() == 'admin.mentor_services.add') active @endif">
                <a href="#admin_mentors" data-bs-toggle="collapse" class="nav-link @if (Route::current()->getName() == 'admin.mentor.index' or Route::current()->getName() == 'admin_mentor_form' or Route::current()->getName() == 'admin_mentor_cat_list' or Route::current()->getName() == 'admin_mentor_cat_form' or Route::current()->getName() == 'admin.mentor_services.index' or Route::current()->getName() == 'admin.mentor_services.add') @else collapsed @endif" aria-expanded="false" aria-controls="admin_mentors">
                  <span class="menu-title">Менторы</span>
                  <i class="menu-arrow"></i>
                  <i class="mdi mdi-contacts menu-icon"></i>
                </a>
                <div id="admin_mentors" class="collapse @if (Route::current()->getName() == 'admin.mentor.index' or Route::current()->getName() == 'admin_mentor_form' or Route::current()->getName() == 'admin_mentor_cat_list' or Route::current()->getName() == 'admin_mentor_cat_form' or Route::current()->getName() == 'admin.mentor_services.index' or Route::current()->getName() == 'admin.mentor_services.add') show @endif">
                  <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                      <a href="{{ route('admin.mentor.index') }}" class="nav-link @if (Route::current()->getName() == 'admin.mentor.index') active @endif">Все менторы</a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ route('admin_mentor_form', 0) }}" class="nav-link @if (Route::current()->getName() == 'admin_mentor_form') active @endif">Добавить ментора</a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ route('admin_mentor_cat_list') }}" class="nav-link @if (Route::current()->getName() == 'admin_mentor_cat_list') active @endif">Категории и подкатегории</a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ route('admin_mentor_cat_form', 0) }}" class="nav-link @if (Route::current()->getName() == 'admin_mentor_cat_form') active @endif">Добавить категорию</a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ route('admin.mentor_services.index') }}" class="nav-link @if (Route::current()->getName() == 'admin.mentor_services.index') active @endif">Список услуг</a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ route('admin.mentor_services.add', 0) }}" class="nav-link @if (Route::current()->getName() == 'admin.mentor_services.add') active @endif">Добавить услугу</a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item @if (Route::current()->getName() == 'admin_page_list' or Route::current()->getName() == 'admin_page_form') active @endif">
                <a href="#admin_pages" data-bs-toggle="collapse" class="nav-link @if (Route::current()->getName() == 'admin_page_list' or Route::current()->getName() == 'admin_page_form') @else collapsed @endif" aria-expanded="false" aria-controls="admin_data">
                  <span class="menu-title">Страницы сайта</span>
                  <i class="menu-arrow"></i>
                  <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                </a>
                <div id="admin_pages" class="collapse @if (Route::current()->getName() == 'admin_page_list' or Route::current()->getName() == 'admin_page_form') show @endif">
                  <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                      <a href="{{ route('admin_page_list') }}" class="nav-link @if (Route::current()->getName() == 'admin_page_list') active @endif">Все страницы</a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ route('admin_page_form', 0) }}" class="nav-link @if (Route::current()->getName() == 'admin_page_form') active @endif">Добавить страницу</a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item @if (Route::current()->getName() == 'admin_rev_list' or Route::current()->getName() == 'admin_rev_form') active @endif">
                <a href="#admin_reviews" data-bs-toggle="collapse" class="nav-link @if (Route::current()->getName() == 'admin_rev_list' or Route::current()->getName() == 'admin_rev_form') @else collapsed @endif" aria-expanded="false" aria-controls="admin_data">
                  <span class="menu-title">Отзывы</span>
                  <i class="menu-arrow"></i>
                  <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                </a>
                <div id="admin_reviews" class="collapse @if (Route::current()->getName() == 'admin_rev_list' or Route::current()->getName() == 'admin_rev_form') show @endif">
                  <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                      <a href="{{ route('admin_rev_list') }}" class="nav-link @if (Route::current()->getName() == 'admin_rev_list') active @endif">Все отзывы</a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ route('admin_rev_form', 0) }}" class="nav-link @if (Route::current()->getName() == 'admin_rev_form') active @endif">Добавить отзыв</a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item @if (Route::current()->getName() == 'admin_country_list' or Route::current()->getName() == 'admin_city_list' or Route::current()->getName() == 'admin_country_form' or Route::current()->getName() == 'admin_city_form' or Route::current()->getName() == 'admin_language_list' or Route::current()->getName() == 'admin_language_form' or Route::current()->getName() == 'admin_task_type_list' or Route::current()->getName() == 'admin_task_type_form') active @endif">
                <a href="#admin_data" data-bs-toggle="collapse" class="nav-link @if (Route::current()->getName() == 'admin_country_list' or Route::current()->getName() == 'admin_city_list' or Route::current()->getName() == 'admin_country_form' or Route::current()->getName() == 'admin_city_form' or Route::current()->getName() == 'admin_language_list' or Route::current()->getName() == 'admin_language_form' or Route::current()->getName() == 'admin_task_type_list' or Route::current()->getName() == 'admin_task_type_form') @else collapsed @endif" aria-expanded="false" aria-controls="admin_data">
                  <span class="menu-title">Справочник</span>
                  <i class="menu-arrow"></i>
                  <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                </a>
                <div id="admin_data" class="collapse @if (Route::current()->getName() == 'admin_country_list' or Route::current()->getName() == 'admin_city_list' or Route::current()->getName() == 'admin_country_form' or Route::current()->getName() == 'admin_city_form' or Route::current()->getName() == 'admin_language_list' or Route::current()->getName() == 'admin_language_form' or Route::current()->getName() == 'admin_task_type_list' or Route::current()->getName() == 'admin_task_type_form') show @endif">
                  <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                      <a href="{{ route('admin_country_list') }}" class="nav-link @if (Route::current()->getName() == 'admin_country_list' or Route::current()->getName() == 'admin_country_form') active @endif">Страны</a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ route('admin_city_list') }}" class="nav-link @if (Route::current()->getName() == 'admin_city_list' or Route::current()->getName() == 'admin_city_form') active @endif">Города</a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ route('admin_language_list') }}" class="nav-link @if (Route::current()->getName() == 'admin_language_list' or Route::current()->getName() == 'admin_language_form') active @endif">Языки общения</a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ route('admin_task_type_list') }}" class="nav-link @if (Route::current()->getName() == 'admin_task_type_list' or Route::current()->getName() == 'admin_task_type_form') active @endif">Типы задач</a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ route('admin.mentor_week.index') }}" class="nav-link
@if (Route::current()->getName() == 'admin.mentor_week.index' or Route::current()->getName() == 'admin.mentor_week.add' or Route::current()->getName() == 'admin.mentor_week.edit') active @endif">Ментор недели
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a href="#admin_settings" data-bs-toggle="collapse" class="nav-link" aria-expanded="false" aria-controls="admin_settings">
                  <span class="menu-title">Настройки</span>
                  <i class="menu-arrow"></i>
                  <i class="mdi mdi-settings menu-icon"></i>
                </a>
                <div id="admin_settings" class="collapse">
                  <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                      <a href="{{ route('admin.settings.index') }}" class="nav-link">Общий настройки</a>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
          </nav>
          <div class="main-panel">
            <div class="content-wrapper">
              @yield('content')
            </div>
          </div>
        </div>
      </div>
    @else
      @yield('content')
    @endif
    <script src="/admin/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="/admin/assets/js/off-canvas.js"></script>
    <script src="/admin/assets/js/hoverable-collapse.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('admin/assets/js/jquery.cookie.js') }}"></script>
    <script src="/admin/assets/js/misc.js"></script>
    <script>
      $(document).ready(function () {
        $('.sure').click(function (obj) {
          var confirm = window.confirm('{{ __('Вы уверены?') }}');
          
          if (!confirm)
          {
            obj.preventDefault();
          }
        });
      });
      
      function sureAndRedirect(obj, url) {
        var confirm = window.confirm('{{ __('Вы уверены?') }}');
        
        if (!confirm)
        {
          obj.preventDefault();
        } else
        {
          window.location.assign(url);
        }
      }
    </script>
    @stack('js')
  </body>
</html>