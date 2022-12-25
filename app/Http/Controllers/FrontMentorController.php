<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Mentor;
use App\Models\Company;
use App\Models\Country;
use App\Models\City;
use App\Models\Currency;
use App\Models\Language;
use App\Models\MentorTag;
use App\Models\MentorMeta;
use App\Models\MentorService;
use App\Models\MentorCategory;
use App\Models\MentorSingleCategory;
use App\Models\MentorSingleEducation;
use App\Models\MentorSingleExperience;
use App\Models\MentorSingleService;
use App\Models\TaskType;
use App\Models\CategoryTag;
use App\Models\Review;

class FrontMentorController extends Controller {
    /* Карточка */

    public function card($id, Request $request) {

        $rec = Mentor::find($id);
        if (!$rec) {
            return redirect('/');
        }

        /* Страна и город */
        $country = $city = false;
        $this_country = Country::find($rec->country_id);
        $this_city = City::find($rec->city_id);

        if ($this_country) {
            $country = $this_country->name;
        }
        if ($this_city) {
            $city = $this_city->name;
        }

        /* Теги ментора */
        $tags = [];
        $this_tags = MentorTag::where(['mentor_id' => $id])->get();
        if ($this_tags) {
            foreach ($this_tags as $tt) {
                $tags[] = $tt->tag_id;
            }
        }

        $tags = CategoryTag::whereIn('id', $tags)->get();

        /* "Ментор сделает за вас". Услуги ментора */
        $for_you = false;
        $this_services = MentorSingleService::where(['mentor_id' => $id])->get();
        if ($this_services) {
            foreach ($this_services as $serv) {

                $this_s = MentorService::find($serv->service_id);

                if ($serv->currency_id == 2) {

                    $for_you = true;
                    break;
                }
            }
        }

        /* Первая услуга */
        $first_service = MentorSingleService::where(['mentor_id' => $id])->orderBy('id', 'desc')->first();
        if ($first_service) {

            $this_s = MentorService::find($first_service->service_id);
            if ($this_s) {
                $first_service->service = $this_s->name;
            }
            if ($first_service->discount) {

                $diff = $first_service->price * $first_service->discount / 100;
                $new_price = $first_service->price - $diff;
                $first_service->new_price = number_format($new_price, 0, '.', '');
                $first_service->old_price = $first_service->price;
            }
        }

        /* Отзывы ментора */
        $this_reviews = Review::where(['mentor_id' => $id])->get();

        /* Образование */
        $this_edu = MentorSingleEducation::where(['mentor_id' => $id])->get();

        /* Опыт работы */
        $this_exp = MentorSingleExperience::where(['mentor_id' => $id])->get();
        if ($this_exp) {
            foreach ($this_exp as $exp) {

                $this_company = Company::find($exp->company_id);
                $exp->company = $this_company;
            }
        }

        return view('front/mentor', compact('rec', 'tags', 'country', 'city', 'for_you', 'this_services', 'first_service', 'this_reviews', 'this_edu', 'this_exp'));
    }

    /* Список */

    public function list(Request $request) {

        /* Ищем подкатегории */
        if ($request->isMethod('post')) {

            $post_key = $request->input('key');
            $post_key1 = $request->input('key1');
            $post_cat = $request->input('cat');
            $post_tags = $request->input('tags');
            $post_astag = $request->input('astag');
            $post_sort = $request->input('sort');

            if (empty($post_key) && !empty($post_key1)) {
                $post_key = $post_key1;
            }

            $cats = [];
            $tags = [];

            if (empty($post_key)) {
                $post_key = 'all';
            }

            if (!empty($post_key)) {

                if ($post_key !== 'all') {
                    $categories = MentorCategory::where('name', 'LIKE', '%' . $post_key . '%')->orderBy('name', 'asc')->get();
                } else {
                    $categories = MentorCategory::orderBy('id', 'desc')->get();
                }

                if ($categories->count()) {
                    foreach ($categories as $cat) {

                        $this_parent = null;
                        if ($cat->parent_id > 0) {

                            $this_parent = MentorCategory::find($cat->parent_id);
                            if (!$this_parent) {
                                continue;
                            }
                        }

                        if ($this_parent) {
                            $cats[$this_parent->name][] = $cat;
                        }
                    }
                }

                $cats_by_tags = CategoryTag::where('name', 'LIKE', '%' . $post_key . '%')->orderBy('name', 'asc')->get();
                if ($cats_by_tags) {
                    foreach ($cats_by_tags as $cbt) {

                        $this_c = MentorCategory::find($cbt->category_id);
                        if (!$this_c) {
                            continue;
                        }

                        if ($this_c->parent_id > 0) {

                            $this_par = MentorCategory::find($this_c->parent_id);
                            if (!$this_par) {
                                continue;
                            }

                            $this_cname = $this_par->name . ' / ' . $this_c->name;
                        } else {
                            $this_cname = $this_c->name;
                        }

                        $tags[$this_cname][] = $cbt;
                    }
                }
            }

            $result = '<div class="list_results">';
            $result .= '<ul>';

            foreach ($cats as $parent => $childs) {

                $result .= '<li>';

                $result .= '<p>' . $parent . '</p>';
                $result .= '<ul>';

                foreach ($childs as $ch) {

                    $result .= '<li>';
                    $result .= '<a href="javascript:void(0);" data-id="' . $ch->id . '" class="selectCat">';
                    $result .= $ch->name;
                    $result .= '</a>';
                    $result .= '</li>';
                }

                $result .= '</ul>';

                $result .= '</li>';
            }

            foreach ($tags as $parent => $tag) {

                $result .= '<li>';

                $result .= '<p>' . $parent . '</p>';
                $result .= '<ul>';

                foreach ($tag as $t) {

                    $ttc = MentorCategory::find($t->category_id);
                    if (!$ttc) {
                        continue;
                    }

                    $result .= '<li>';
                    $result .= '<a href="javascript:void(0);" data-id="' . $ttc->id . '" data-cat="' . $ttc->name . '" data-tag="' . $t->id . '" class="selectCat asTag">';
                    $result .= $t->name;
                    $result .= '</a>';
                    $result .= '</li>';
                }

                $result .= '</ul>';

                $result .= '</li>';
            }

            $result .= '</ul>';
            $result .= '</div>';

            /* Подгрузка тегов */
            $result_tags = '';
            $h2_text = '';

            if ($post_cat > 0) {

                $this_cat = MentorCategory::find($post_cat);
                if (!$this_cat) {
                    die(json_encode(['status' => 'error', 'msg' => 'Category does not exist!']));
                }

                $h2_text = 'С чем нужно помочь?';

                $ids[] = $post_cat;

                if ($this_cat->parent_id > 0) {

                    $h2_text = 'Выберите задачу из подкатегории ' . $this_cat->name;
                    $ids[] = $this_cat->parent_id;
                }

                $list = CategoryTag::whereIn('category_id', $ids)->orderBy('name', 'asc')->get();
                $result_tags = '';

                foreach ($list as $tag) {

                    $checked = '';
                    if ($post_astag > 0) {
                        if ($tag->id == $post_astag) {
                            $checked = ' checked';
                        }
                    }
                    if ($post_tags) {
                        if (in_array($tag->id, $post_tags)) {
                            //$checked = ' checked';
                        }
                    }

                    $result_tags .= '<div data-id="' . $tag->id . '" class="selectTag sTag">';
                    $result_tags .= '<input' . $checked . ' id="rt_' . $tag->id . '" type="checkbox" name="tags[]" value="' . $tag->id . '" class="sTagInput" style="display: none;">';
                    $result_tags .= '<label for="rt_' . $tag->id . '">' . $tag->name;
                    $result_tags .= '&nbsp;<a href="javascript:void(0);" class="removeTag"></a>';
                    $result_tags .= '</label>';
                    //$result_tags .= '<p>13</p>';

                    $result_tags .= '</div>';
                }
            }

            /* Менторы */
            $result_mentors = '';
            $mentors_count = 0;

            if (!$post_cat) {
                $mentor_ids = MentorSingleCategory::get();
            } else {
                $mentor_ids = MentorSingleCategory::where(['category_id' => $post_cat])->get();
            }

            $mentor_ids_list = [];

            if ($mentor_ids) {
                foreach ($mentor_ids as $m) {
                    $mentor_ids_list[] = $m->mentor_id;
                }
            }

            $post_tags_ids = [];
            if (is_array($post_tags)) {
                foreach ($post_tags as $pt) {

                    if (!is_numeric($pt)) {
                        continue;
                    }

                    $post_tags_ids[] = $pt;
                }

                $mentor_ids_list = array_flip($mentor_ids_list);
                $mentor_tag_ids = MentorTag::whereIn('tag_id', $post_tags_ids)->get();
                $mti_list = [];

                if ($mentor_tag_ids) {
                    foreach ($mentor_tag_ids as $mti) {
                        $mti_list[] = $mti->mentor_id;
                    }
                }

                $new_ids = [];

                foreach ($mentor_ids_list as $k => $v) {

                    if (!in_array($k, $mti_list)) {
                        continue;
                    }

                    $new_ids[] = $k;
                }

                $mentor_ids_list = $new_ids;
            }


            /* Получаем менторов */
            $result_mentors = [];
            $mentors = Mentor::whereIn('id', $mentor_ids_list)->get();
            $count = 0;

            foreach ($mentors as $m) {

                if (!$m->is_active) {
                    continue;
                }

                if ($request->input('vip')) {
                    if (!$m->vip_status) {
                        continue;
                    }
                }

                $count++;

                $this_country = Country::find($m->country_id);
                $this_city = City::find($m->city_id);

                $langs = [];
                $langs = ['English', 'Русский'];
                $langs = implode(', ', $langs);

                $this_cats = MentorSingleCategory::where(['mentor_id' => $m->id])->get();
                $this_cats_ids = [];
                foreach ($this_cats as $tc) {
                    $this_cats_ids[] = $tc->category_id;
                }

                $this_cats = MentorCategory::whereIn('id', $this_cats_ids)->get();

                $this_exp = MentorSingleExperience::where(['mentor_id' => $m->id])->orderBy('id', 'desc')->first();
                if ($this_exp) {
                    $this_company = Company::find($this_exp->company_id);
                }

                $this_service = MentorSingleService::where(['mentor_id' => $m->id])->orderBy('id', 'desc')->first();
                $mentor_img = route('get.avatar', $m->avatar);

                $rmk = $m->id;

                if ($post_sort !== 'id') {

                    if ($post_sort == 'price_asc' && $this_service) {
                        $rmk = $this_service->price;
                    } elseif ($post_sort == 'price_desc' && $this_service) {
                        $rmk = $this_service->price;
                    }

                    if ($this_service) {
                        if ($this_service->discount) {
                            $diff = $rmk * $this_service->discount / 100;
                            $rmk = $this_service->price - $diff;
                        }
                    }
                }

                $result_mentors[$rmk][] = '<div class="cart_block">';
                $result_mentors[$rmk][] = '<div class="row">';
                $result_mentors[$rmk][] = '<div class="col-lg-2 col-md-3  d-none d-md-block">';
                $result_mentors[$rmk][] = '<div style="text-align: center; position: relative">';
                $result_mentors[$rmk][] = '<a href="' . route('front.mentor', $m->id) . '">';
                $result_mentors[$rmk][] = '<div class="ava_block" style="background-image: url(' . $mentor_img . ');"></div>';
                $result_mentors[$rmk][] = '<span class="mentorday">Ментор дня</span>';

                //$result_mentors .= '<img src="'.$mentor_img.'" class="img-fluid">';
                $result_mentors[$rmk][] = '</a>';
                $result_mentors[$rmk][] = '</div>';
                $result_mentors[$rmk][] = '</div>';
                $result_mentors[$rmk][] = '<div class="col-lg-7 col-md-5">';
                $result_mentors[$rmk][] = '<div class="d-block d-md-none" style="float:left; width: 30%; border:0px solid red; margin-right: 8px; margin-top: 20px;">';
                $result_mentors[$rmk][] = '<a href="' . route('front.mentor', $m->id) . '">';
                $result_mentors[$rmk][] = '<span class="mentorday">Ментор дня</span><img src="/verstka/images/mentors/02.jpg" class="img-fluid">';
                $result_mentors[$rmk][] = '</a>';
                $result_mentors[$rmk][] = '</div>';
                $result_mentors[$rmk][] = '<h3>';
                $result_mentors[$rmk][] = '<a href="' . route('front.mentor', $m->id) . '">' . $m->first_name . ' ' . $m->last_name . '</a>';

                if ($m->verified) {
                    $result_mentors[$rmk][] = '<span class="verified"></span>';
                }

                $result_mentors[$rmk][] = '</h3>';

                if ($this_exp) {
                    $result_mentors[$rmk][] = '<div class="prof">' . $this_exp->position;
                }

                if ($this_company) {
                    $result_mentors[$rmk][] = ' в <a href="javascript:void(0);" class="company">' . $this_company->name . '</a>';
                }

                if ($this_exp) {
                    $result_mentors[$rmk][] = '</div>';
                }

                if ($this_city) {
                    $result_mentors[$rmk][] = '<span class="address"><img src="/verstka/images/geo.svg"> ' . $this_city->name . ', ';
                } else {
                    $result_mentors[$rmk][] = '<span class="address">';
                }

                if ($this_country) {
                    $result_mentors[$rmk][] = $this_country->name . ' </span>';
                }

                $result_mentors[$rmk][] = '<span class="language"><img src="/verstka/images/lang.svg"> ' . $langs . '</span>';
                $result_mentors[$rmk][] = '<div class="desc d-none d-md-block">' . $m->description . '</div>';
                $result_mentors[$rmk][] = '<div class="clearfix"></div>';
                $result_mentors[$rmk][] = '<div class="tag_block_mentor">';

                $dop = false;
                $dop_check = MentorSingleService::where(['mentor_id' => $m->id, 'currency_id' => 2])->count();
                if ($dop_check > 0) {
                    $dop = true;
                }

                if ($dop) {
                    $result_mentors[$rmk][] = '<a href="javascript:void(0);" class="tag spectag">Ментор сделает за вас&nbsp;<img src="/verstka/images/force.svg"></a>';
                }

                if ($m->vip_status) {
                    $result_mentors[$rmk][] = '<a href=# class="tag spectag">VIP-ментор&nbsp;<img src="/verstka/images/smile.svg"></a>';
                }

                $this_tags = MentorTag::where(['mentor_id' => $m->id])->get();
                $tags_ids = [];

                if ($this_tags) {
                    foreach ($this_tags as $tt) {
                        $tags_ids[] = $tt->tag_id;
                    }
                }

                $this_tags = CategoryTag::whereIn('id', $tags_ids)->get();

                foreach ($this_tags as $tc) {
                    $result_mentors[$rmk][] = '<a href="javascript:void(0);" class="tag">' . $tc->name . '</a>';
                }

                $result_mentors[$rmk][] = '</div>';
                $result_mentors[$rmk][] = '</div>';
                $result_mentors[$rmk][] = '<div class="col-lg-3 col-md-4">';
                $result_mentors[$rmk][] = '<div class="static_price_block">';

                if ($this_service) {

                    if ($this_service->discount > 0) {

                        $diff = $this_service->price * $this_service->discount / 100;
                        $old_price = round($this_service->price - $diff);
                        $result_mentors[$rmk][] = '<span class="active_price">' . $old_price . ' <span class="rub">$</span></span><span class="old_price">' . $this_service->price . '<span class="rub">$</span></span><span class="active_price"></span>';
                    } else {
                        $result_mentors[$rmk][] = '<span class="active_price">' . $this_service->price . ' <span class="rub">$</span></span>';
                    }

                    $ts = MentorService::find($this_service->service_id);
                    if ($ts) {

                        $result_mentors[$rmk][] = '<div class="sale">' . $ts->name;
                        if ($this_service->discount) {
                            $result_mentors[$rmk][] = ' (-' . $this_service->discount . '%)';
                        }

                        $result_mentors[$rmk][] = '</div>';
                    }
                }

                $result_mentors[$rmk][] = '<div class="btn_block">';
                $result_mentors[$rmk][] = '<a href="/mentor/' . $m->id . '" class="enter">Подробнее</a>';
                $result_mentors[$rmk][] = '<a href="javascript:void(0);" class="request" data-bs-toggle="modal" data-bs-target="#personalmentormodal" data-id="' . $m->id . '" >Оставить заявку</a> </div>';
                $result_mentors[$rmk][] = '</div>';
                $result_mentors[$rmk][] = '</div>';
                $result_mentors[$rmk][] = '</div>';
                $result_mentors[$rmk][] = '</div>';
            }

            if ($post_sort !== 'id') {

                if ($post_sort == 'price_asc') {
                    ksort($result_mentors);
                } elseif ($post_sort == 'price_desc') {
                    krsort($result_mentors);
                }
            }

            $rm_html = '';
            foreach ($result_mentors as $ms) {
                foreach ($ms as $m) {
                    $rm_html .= $m;
                }
            }

            $result_mentors = $rm_html;

            //}

            die(json_encode(['status' => 'ok', 'h2' => $h2_text, 'list' => $result, 'tags' => $result_tags, 'mentors' => $result_mentors, 'count' => $count]));
            die(json_encode(['status' => 'ok', 'list' => $result]));
        }

        return view('front/mentor_list');
    }

    /* AJAX */

    public function ajax(Request $request) {

        if ($request->isMethod('post')) {

            /* AJAX */
            if ($request->input('action')) {

                $action = $request->input('action');

                /* Подгрузка списка городов по выбранной стране */
                if ($action == 'load_cities') {

                    /* ID выбранной страны */
                    $country_id = $request->input('country_id');

                    /* Подгружаем список городов выбранной страны, иначе отображаем ошибку в случае невыбранной страны */
                    if (!is_numeric($country_id) or empty($country_id)) {
                        die(json_encode(['status' => 'error', 'msg' => 'Не выбрана страна!']));
                    }

                    $cities = City::where('country_id', '=', $country_id)->orderBy('name', 'asc')->get();

                    /* Формируем HTML для выпадающего списка */
                    $html = '<option value="">Выберите город</option>';

                    if ($cities->count()) {
                        foreach ($cities as $city) {
                            $html .= '<option value="' . $city->id . '">' . $city->name . '</option>';
                        }
                    }

                    die(json_encode(['status' => 'ok', 'html' => $html]));
                }
            }
        }
    }

    /* Карточка ментора */

    public function view($id, Request $request) {

        /* Таб по умолчанию */
        $show_tab = 'general';

        /* Список категорий */
        $list_categories = MentorCategory::orderBy('name', 'asc')->get();

        /* Список стран */
        $list_countries = Country::orderBy('name', 'asc')->get();

        /* Список городов */
        $list_cities = City::orderBy('name', 'asc')->get();

        /* Список языков */
        $list_languages = Language::orderBy('name', 'asc')->get();

        /* Список валют */
        $list_currencies = Currency::orderBy('name', 'asc')->get();

        $cat_list = [];
        $lang_list = [];
        $exp_list = json_decode(json_encode([]));
        $edu_list = json_decode(json_encode([]));
        $services_list = json_decode(json_encode([]));

        /* Добавление или редактирование */
        if (!$id) {

            $rec = new Mentor;
            $page_title = 'Карточка ментора';
        } else {

            $rec = Mentor::find($id);
            $page_title = 'Карточка ментора';
            if (!$rec) {
                return redirect()->back()->with('error', 'Ментор не найден!');
            }

            $cat_list = [];
            $cat_list_db = MentorSingleCategory::where(['mentor_id' => $id])->get();
            if ($cat_list_db->count()) {
                foreach ($cat_list_db as $tc) {
                    $cat_list[] = $tc->category_id;
                }
            }

            $lang_list = [];

            $exp_list = MentorSingleExperience::where(['mentor_id' => $id])->orderBy('id', 'desc')->get();
            $edu_list = MentorSingleEducation::where(['mentor_id' => $id])->orderBy('id', 'desc')->get();
            $services_list = MentorSingleService::where(['mentor_id' => $id])->orderBy('id', 'desc')->get();
        }

        return view('admin/mentor_view', compact('id', 'rec', 'page_title', 'show_tab', 'list_categories', 'list_countries', 'list_cities', 'list_languages', 'list_currencies', 'cat_list', 'lang_list', 'exp_list', 'edu_list', 'services_list'));
    }

    /* Форма */

    public function form($id, Request $request) {

        /* Таб по умолчанию */
        $show_tab = 'general';

        /* Компании */
        $list_companies = Company::orderBy('name', 'asc')->get();

        /* Список категорий */
        $list_categories = MentorCategory::orderBy('name', 'asc')->get();

        /* Список стран */
        $list_countries = Country::orderBy('name', 'asc')->get();

        /* Список городов */
        $list_cities = City::orderBy('name', 'asc')->get();

        /* Список языков */
        $list_languages = Language::orderBy('name', 'asc')->get();

        /* Список валют */
        $list_currencies = Currency::orderBy('name', 'asc')->get();

        $cat_list = [];
        $lang_list = [];
        $exp_list = json_decode(json_encode([]));
        $edu_list = json_decode(json_encode([]));
        $services_list = json_decode(json_encode([]));

        /* Добавление или редактирование */
        if (!$id) {

            $rec = new Mentor;
            $page_title = 'Добавить ментора';
        } else {

            $rec = Mentor::find($id);
            $page_title = 'Редактировать ментора';
            if (!$rec) {
                return redirect()->back()->with('error', 'Ментор не найден!');
            }

            $cat_list = [];
            $cat_list_db = MentorSingleCategory::where(['mentor_id' => $id])->get();
            if ($cat_list_db->count()) {
                foreach ($cat_list_db as $tc) {
                    $cat_list[] = $tc->category_id;
                }
            }

            $lang_list = [];
            /*
              $lang_list_db = MentorSingleLanguage::where(['mentor_d' => $id])->get();
              if ($lang_list_db->count()) {
              foreach ($lang_list_db as $tc) {
              $lang_list[] = $tc->language_id;
              }
              }
             */

            $exp_list = MentorSingleExperience::where(['mentor_id' => $id])->orderBy('id', 'desc')->get();
            $edu_list = MentorSingleEducation::where(['mentor_id' => $id])->orderBy('id', 'desc')->get();
            $services_list = MentorSingleService::where(['mentor_id' => $id])->orderBy('id', 'desc')->get();
        }

        /* POST */
        if ($request->isMethod('post')) {

            /* Правила валидации */
            $rules = [
                'categories' => 'required',
                'last_name' => 'required',
                'first_name' => 'required',
                'description' => 'required',
                'help_text' => 'required',
            ];

            $valid = Validator::make($request->all(), $rules);

            /* Показываем сообщения. Не прошла валидация */
            if ($valid->fails()) {
                return redirect()->back()->withErrors($valid)->withInput();
            }

            /* Сохраняем информацию и редирект */
            $data = [
                'last_name' => $request->input('last_name'),
                'first_name' => $request->input('first_name'),
                'surname' => $request->input('surname'),
                'country_id' => $request->input('country_id'),
                'city_id' => $request->input('city_id'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'telegram' => $request->input('telegram'),
                'description' => $request->input('description'),
                'help_text' => $request->input('help_text'),
                'experience' => $request->input('experience'),
                'verified' => $request->input('verified'),
                'vip_status' => $request->input('vip_status'),
            ];

            $rec->fill($data);
            $rec->save();

            /* Категории ментора */
            foreach ($request->input('categories') as $cat_a => $cat_id) {

                /* Удаляем все предыдущие привязки к категориям */
                if ($cat_a == 0) {
                    MentorSingleCategory::where(['mentor_id' => $rec->id])->delete();
                }

                /* Привязываем к новым категорям (выбранным) */
                $mentor_cat = new MentorSingleCategory;
                $mentor_cat->fill(['mentor_id' => $rec->id, 'category_id' => $cat_id]);
                $mentor_cat->save();
            }

            /* Образование ментора */
            for ($a = 0; $a < sizeof($request->input('education_date_start')); $a++) {

                /* Удаляем все предыдущие данные об образовании */
                if ($a == 0) {

                    MentorSingleEducation::where(['mentor_id' => $rec->id])->delete();
                    continue;
                }

                $this_date_start = $request->input('education_date_start')[$a];
                $this_date_end = $request->input('education_date_end')[$a];
                $this_school = $request->input('education_school')[$a];
                $this_course = $request->input('education_course')[$a];

                $mentor_edu = new MentorSingleEducation;
                $mentor_edu->fill(['mentor_id' => $rec->id, 'date_start' => $this_date_start, 'date_end' => $this_date_end, 'school' => $this_school, 'course' => $this_course]);
                $mentor_edu->save();
            }

            /* Опыт ментора */
            for ($a = 0; $a < sizeof($request->input('experience_date_start')); $a++) {

                /* Удаляем все предыдущие данные об образовании */
                if ($a == 0) {

                    MentorSingleExperience::where(['mentor_id' => $rec->id])->delete();
                    continue;
                }

                $this_date_start = $request->input('experience_date_start')[$a];
                $this_date_end = $request->input('experience_date_end')[$a];
                $this_company = $request->input('experience_company')[$a];
                $this_position = $request->input('experience_position')[$a];

                $mentor_exp = new MentorSingleExperience;
                $mentor_exp->fill(['mentor_id' => $rec->id, 'date_start' => $this_date_start, 'date_end' => $this_date_end, 'company_id' => $this_company, 'position' => $this_position]);
                $mentor_exp->save();
            }

            /* Услуги ментора */
            for ($a = 0; $a < sizeof($request->input('service_service')); $a++) {

                /* Удаляем все предыдущие данные об образовании */
                if ($a == 0) {

                    MentorSingleService::where(['mentor_id' => $rec->id])->delete();
                    continue;
                }

                $this_service = $request->input('service_service')[$a];
                $this_currency = $request->input('service_currency_id')[$a];
                $this_price = $request->input('service_price')[$a];
                $this_discount = $request->input('service_discount')[$a];

                $mentor_service = new MentorSingleService;
                $mentor_service->fill(['mentor_id' => $rec->id, 'currency_id' => $this_currency, 'service' => $this_service, 'price' => $this_price, 'discount' => $this_discount]);
                $mentor_service->save();
            }

            if ($request->input('add_company') == '1') {
                return redirect(route('admin_company_form', 0) . '?return=' . $rec->id);
            }

            if ($request->input('redirect') == 'true') {
                return redirect(route('admin_mentor_list'))->with('success', 'Ментор сохранен!');
            } else {
                return redirect()->back()->with('success', 'Ментор сохранен!');
            }
        }

        return view('admin/mentor_form', compact('id', 'rec', 'page_title', 'show_tab', 'list_companies', 'list_categories', 'list_countries', 'list_cities', 'list_languages', 'list_currencies', 'cat_list', 'lang_list', 'exp_list', 'edu_list', 'services_list'));
    }

    public function cats(Request $request) {
        if (!$request->ajax()) {
            return false;
        }
        if ($request->get("type") === "tags") {
            if (!$request->get("id")) {
                return false;
            }
            $catId = $request->get("id");
            $tags = Mentor::getTagsByCatId($catId);
            $tagsHtml = view('front.tags', ['tags' => $tags]);
            return $tagsHtml->render();
        }
        if ($request->get("type") === "mentors") {

            $form = $request->get('form');
            $mentors = Mentor::getByForm($form);

            $html = view('front.result', ['mentors' => $mentors]);
            return $html->render();
        }

        if ($request->get("type") === "cats") {
            $searchStr = $request->get("val");
            $cats = Mentor::findCats($searchStr);

            //если найдены категории, показываем их
            if ($cats) {
                $catHtml = view('front.cats', ['catsTree' => $cats]);
                return $catHtml->render();
            }

            //если не найдены категории, то ищем теги, показываем
            $tags = Mentor::findTagsByStr($searchStr);
            if ($tags) {
                $tagsHtml = view('front.tagHints', ['tagsTree' => $tags]);
                return $tagsHtml->render();
            }
            //ваще ниче не найдено, выдаем 404 ошибку
            return \Illuminate\Support\Facades\Response::json(['html' => view('front.empty')->render()], 404);
        }
        return false;
    }

}
