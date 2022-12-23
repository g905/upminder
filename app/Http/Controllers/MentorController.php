<?php

namespace App\Http\Controllers;

use App\Models\MentorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Mentor;
use App\Models\Company;
use App\Models\Country;
use App\Models\City;
use App\Models\Currency;
use App\Models\Language;
use App\Models\MentorMeta;
use App\Models\MentorCategory;
use App\Models\MentorSingleCategory;
use App\Models\MentorSingleEducation;
use App\Models\MentorSingleExperience;
use App\Models\MentorSingleService;

class MentorController extends Controller {

    public function getAvatar($path) {
        return response(Storage::disk('public')
                        ->get('avatar/' . $path));
    }

    /* Список */

    public function index(Request $request) {

        /* Сортировка */
        $order_by = 'id';
        $order_by_asc = 'desc';

        if ($request->input('order_by')) {

            $order_by = $request->input('order_by');
            $order_by_asc = $request->input('order_by_asc');
        }

        /* Страны */
        $countries = Country::orderBy('name', 'asc')
                ->get();

        /* Категории */
        $categories = MentorCategory::orderBy('name', 'asc')
                ->get();

        /* Фильтры */
        $filters = [
            'country_id' => null,
            'city_id' => null,
            'category_id' => null,
            'applied' => false,
            'keyword' => false,
        ];
        if ($request->input('filters')) {

            if (isset($request->input('filters')['country_id'])) {
                $filters['country_id'] = $request->input('filters')['country_id'];
            }
            if (isset($request->input('filters')['city_id'])) {
                $filters['city_id'] = $request->input('filters')['city_id'];
            }
            if (isset($request->input('filters')['category_id'])) {
                $filters['category_id'] = $request->input('filters')['category_id'];
            }
            $filters['applied'] = true;
        }
        if ($request->input('keyword')) {
            $filters['keyword'] = $request->input('keyword');
        }

        $categories = MentorCategory::orderBy('name', 'asc')
                ->get();

        if (!$filters['keyword']) {

            if ($filters['country_id']) {
                $list = Mentor::where(['country_id' => $filters['country_id']]);
            }
            if ($filters['city_id']) {

                if (isset($list)) {
                    $list = $list->where(['city_id' => $filters['city_id']]);
                } else {
                    $list = Mentor::where(['city_id' => $filters['city_id']]);
                }
            }
            if ($filters['category_id']) {

                $mentor_ids = MentorSingleCategory::where(['category_id' => $filters['category_id']])
                        ->get();
                $ids = [];
                if ($mentor_ids->count()) {
                    foreach ($mentor_ids as $mentor_id) {
                        $ids[] = $mentor_id->mentor_id;
                    }
                }

                if (isset($list)) {
                    $list = $list->whereIn('id', $ids);
                } else {
                    $list = Mentor::whereIn('id', $ids);
                }
            }
        } else {

            $list = Mentor::where('last_name', 'LIKE', '%' . $filters['keyword'] . '%')
                    ->orWhere('first_name', 'LIKE', '%' . $filters['keyword'] . '%')
                    ->orWhere('surname', 'LIKE', '%' . $filters['keyword'] . '%');
        }

        if (isset($list)) {
            $list = $list->orderBy($order_by, $order_by_asc)
                    ->get();
        } else {
            $list = Mentor::orderBy($order_by, $order_by_asc)
                    ->get();
        }

        if ($list->count()) {
            foreach ($list as $rec) {

                $this_country = Country::find($rec->country_id);
                $rec->country = '&mdash;';
                if ($this_country) {
                    $rec->country = '<a href="' . route("admin.mentor.index", 'filters[country_id]=' . $this_country->id) . '">' . $this_country->name . '</a>';
                }

                $this_city = City::find($rec->city_id);
                $rec->city = '&mdash;';
                if ($this_city) {
                    $rec->city = '<a href="' . route("admin.mentor.index", 'filters[city_id]=' . $this_city->id) . '">' . $this_city->name . '</a>';
                }

                $this->categories = '';
                $this_categories = MentorSingleCategory::where(['mentor_id' => $rec->id])
                        ->get();
                if ($this_categories->count()) {

                    $this->categories = '<p class="small">Всего: <span>' . $this_categories->count() . '</span></p>';
                    foreach ($this_categories as $this_cat) {

                        $this_cat = MentorCategory::find($this_cat->category_id);
                        if (!$this_cat) {
                            continue;
                        }

                        $badge_class = 'info';
                        if ($this_cat->parent_id > 0) {
                            $badge_class = 'warning';
                        }

                        $rec->mentor_categories .= '<p><a href="' . route("admin.mentor.index", 'filters[category_id]=' . $this_cat->id) . '" class="badge badge-' . $badge_class . '">' . $this_cat->name . '</a></p>';
                    }
                }
            }
        }
        $page_title = 'Все менторы';

        return view('admin.mentor.mentor_list', compact('list', 'countries', 'categories', 'categories', 'filters', 'order_by', 'order_by_asc', 'page_title'));
    }

    /* Карточка ментора */

    public function view($id, Request $request) {

        /* Таб по умолчанию */
        $show_tab = 'general';

        /* Список категорий */
        $list_categories = MentorCategory::where('parent_id', null)
                ->orderBy('name', 'asc')
                ->get();

        /* Список стран */
        $list_countries = Country::orderBy('name', 'asc')
                ->get();

        /* Список городов */
        $list_cities = City::orderBy('name', 'asc')
                ->get();

        /* Список языков */
        $list_languages = Language::orderBy('name', 'asc')
                ->get();

        /* Список валют */
        $list_currencies = Currency::orderBy('name', 'asc')
                ->get();

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
                return redirect()
                                ->back()
                                ->with('error', 'Ментор не найден!');
            }

            $cat_list = [];
            $cat_list_db = MentorSingleCategory::where(['mentor_id' => $id])
                    ->get();
            if ($cat_list_db->count()) {
                foreach ($cat_list_db as $tc) {
                    $cat_list[] = $tc->category_id;
                }
            }

            $lang_list = [];

            $exp_list = MentorSingleExperience::where(['mentor_id' => $id])
                    ->orderBy('id', 'desc')
                    ->get();
            $edu_list = MentorSingleEducation::where(['mentor_id' => $id])
                    ->orderBy('id', 'desc')
                    ->get();
            $services_list = MentorSingleService::where(['mentor_id' => $id])
                    ->orderBy('created_at', 'asc')
                    ->get();
        }
        $mentor_categories = MentorCategory::where('parent_id', '!=', null)
                ->get();

        return view('admin.mentor.mentor_view', compact('id', 'rec', 'page_title', 'show_tab', 'list_categories', 'list_countries', 'list_cities', 'list_languages', 'list_currencies', 'cat_list', 'lang_list', 'exp_list', 'edu_list', 'services_list', 'mentor_categories'));
    }

    /* Форма */

    public function form($id, Request $request) {

        /* Таб по умолчанию */
        $show_tab = 'general';

        /* Список компаний */
        $list_companies = Company::orderBy('name', 'asc')->get();

        /* Список категорий */
        $list_categories = MentorCategory::where('parent_id', null)
                ->orderBy('name', 'asc')
                ->get();

        /* Список стран */
        $list_countries = Country::orderBy('name', 'asc')
                ->get();

        /* Список городов */
        $list_cities = City::orderBy('name', 'asc')
                ->get();

        /* Список языков */
        $list_languages = Language::orderBy('name', 'asc')
                ->get();

        /* Список валют */
        $list_currencies = Currency::orderBy('name', 'asc')
                ->get();

        $cat_list = [];
        $lang_list = [];
        $exp_list = [];
        $edu_list = [];
        $services_main_list = [];
        $services_additional_list = [];

        /* Добавление или редактирование */
        if (!$id) {

            $rec = new Mentor;
            $page_title = 'Добавить ментора';
        } else {

            $rec = Mentor::find($id);
            $page_title = 'Редактировать ментора';
            if (!$rec) {
                return redirect()
                                ->back()
                                ->with('error', 'Ментор не найден!');
            }


            $cat_list = [];
            $cat_list_db = MentorSingleCategory::where(['mentor_id' => $id])
                    ->get();
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

            $exp_list = MentorSingleExperience::where(['mentor_id' => $id])
                    ->orderBy('id', 'desc')
                    ->get();
            $edu_list = MentorSingleEducation::where(['mentor_id' => $id])
                    ->orderBy('id', 'desc')
                    ->get();
            $services_main_list = MentorSingleService::where(['mentor_id' => $id])
                    ->whereHas('service', function ($query) {
                        $query->where('type_service', array_search('main', MentorService::getTypes()));
                    })
                    ->orderBy('id', 'desc')
                    ->get();
            $services_additional_list = MentorSingleService::where(['mentor_id' => $id])
                    ->whereHas('service', function ($query) {
                        $query->where('type_service', array_search('additional', MentorService::getTypes()));
                    })
                    ->orderBy('id', 'desc')
                    ->get();
        }

        /* POST */
        if ($request->isMethod('post')) {

            /* Правила валидации */
            $rules = [
                'avatar' => 'file|nullable|max:1024',
                'categories' => 'required',
                'last_name' => 'required',
                'first_name' => 'required',
                'description' => 'required',
                'help_text' => 'required',
            ];

            $valid = Validator::make($request->all(), $rules);

            /* Показываем сообщения. Не прошла валидация */
            if ($valid->fails()) {
                return redirect()
                                ->back()
                                ->withErrors($valid)
                                ->withInput();
            }

            if ($request->file('avatar') && !$id) {
                $fileName = 'avatar_' . uniqid(time()) . '.' . $request->avatar->extension();
                $uploadedFile = $request->file('avatar');
                $file_name = Storage::disk('public')
                        ->putFileAs('avatar', $uploadedFile, $fileName);
                if ($file_name)
                    $rec->avatar = $fileName;
            }
            if ($request->file('avatar') && $id) {
                $old_file = $rec->avatar;
                $fileName = 'avatar_' . uniqid(time()) . '.' . $request->avatar->extension();
                $uploadedFile = $request->file('avatar');
                $file_name = Storage::disk('public')
                        ->putFileAs('avatar', $uploadedFile, $fileName);
                if ($file_name) {
                    $rec->avatar = $fileName;
                    Storage::delete('avatar/' . $old_file);
                }
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
                'is_active' => $request->input('is_active'),
            ];

            $rec->fill($data);
            $rec->save();

            /* Категории ментора */
            foreach ($request->input('categories') as $cat_a => $cat_id) {

                /* Удаляем все предыдущие привязки к категориям */
                if ($cat_a == 0) {
                    MentorSingleCategory::where(['mentor_id' => $rec->id])
                            ->delete();
                }

                /* Привязываем к новым категорям (выбранным) */
                $mentor_cat = new MentorSingleCategory;
                $mentor_cat->fill([
                    'mentor_id' => $rec->id,
                    'category_id' => intval($cat_id),
                ]);
                $mentor_cat->save();
            }

            /* Образование ментора */
            for ($a = 0; $a < sizeof($request->input('education_date_start')); $a++) {

                /* Удаляем все предыдущие данные об образовании */
                if ($a == 0) {

                    MentorSingleEducation::where(['mentor_id' => $rec->id])
                            ->delete();
                    continue;
                }

                $this_date_start = $request->input('education_date_start')[$a];
                $this_date_end = $request->input('education_date_end')[$a];
                $this_school = $request->input('education_school')[$a];
                $this_course = $request->input('education_course')[$a];

                $mentor_edu = new MentorSingleEducation;
                $mentor_edu->fill([
                    'mentor_id' => $rec->id,
                    'date_start' => $this_date_start,
                    'date_end' => $this_date_end,
                    'school' => $this_school,
                    'course' => $this_course,
                ]);
                $mentor_edu->save();
            }

            /* Опыт ментора */
            for ($a = 0; $a < sizeof($request->input('experience_date_start')); $a++) {

                /* Удаляем все предыдущие данные об образовании */
                if ($a == 0) {

                    MentorSingleExperience::where(['mentor_id' => $rec->id])
                            ->delete();
                    continue;
                }

                $this_date_start = $request->input('experience_date_start')[$a];
                $this_date_end = $request->input('experience_date_end')[$a];
                $this_company = $request->input('experience_company')[$a];
                $this_position = $request->input('experience_position')[$a];

                $mentor_exp = new MentorSingleExperience;
                $mentor_exp->fill([
                    'mentor_id' => $rec->id,
                    'date_start' => $this_date_start,
                    'date_end' => $this_date_end,
                    'company_id' => $this_company,
                    'position' => $this_position,
                ]);
                $mentor_exp->save();
            }

            /* Услуги ментора */
            $exist_ids = [];
            for ($a = 0; $a < sizeof($request->input('service_service')); $a++) {

                /* Удаляем все предыдущие данные об образовании */
                if ($a == 0) {

                    MentorSingleService::where(['mentor_id' => $rec->id])
                            ->delete();
                    continue;
                }

                $this_service = $request->input('service_service')[$a];
                $this_currency = array_key_exists($a, $request->get('service_currency_id')) ? $request->get('service_currency_id')[$a] : 0;
                $this_price = $request->input('service_price')[$a] ?? 0;
                $this_discount = array_key_exists($a, $request->get('service_discount')) ? $request->get('service_discount')[$a] : null;

                $mentor_service = new MentorSingleService;
                $mentor_service->fill([
                    'mentor_id' => $rec->id,
                    'currency_id' => $this_currency,
                    'service_id' => $this_service,
                    'price' => $this_price,
                    'discount' => $this_discount,
                ]);
                if (in_array($mentor_service->service_id, $exist_ids)) {
                    $mentor_service->delete();
                    continue;
                }
                $mentor_service->save();
                $exist_ids[] = $mentor_service->service_id;
            }

            /* Доп услуги ментора */
            if ($request->input('additional_service_service')) {
                for ($a = 0; $a < sizeof($request->input('additional_service_service')); $a++) {

                    /* Пропускаем 0 */
                    if ($a == 0) {
                        continue;
                    }
                    $this_service = $request->input('additional_service_service')[$a];
                    $this_currency = array_key_exists($a, $request->get('additional_service_currency_id')) ? $request->get('additional_service_currency_id')[$a] : 0;
                    $this_price = $request->input('additional_service_price')[$a] ?? 0;
                    $this_discount = array_key_exists($a, $request->get('additional_service_discount')) ? $request->get('additional_service_discount')[$a] : null;

                    $mentor_service = new MentorSingleService;
                    $mentor_service->fill([
                        'mentor_id' => $rec->id,
                        'currency_id' => $this_currency,
                        'service_id' => $this_service,
                        'price' => $this_price,
                        'discount' => $this_discount,
                    ]);
                    if (in_array($mentor_service->service_id, $exist_ids)) {
                        $mentor_service->delete();
                        continue;
                    }
                    $mentor_service->save();
                    $exist_ids[] = $mentor_service->service_id;
                }
            }


            $rec->tags()
                    ->sync($request->get('tag_id'));

            if ($request->input('redirect') == 'true') {
                return redirect(route('admin.mentor.index'))->with('success', 'Ментор сохранен!');
            } else {
                return redirect()
                                ->back()
                                ->with('success', 'Ментор сохранен!');
            }
        }
        $mentor_main_services = MentorService::where('type_service', array_search('main', MentorService::getTypes()))
                ->get();
        $mentor_additional_services = MentorService::where('type_service', array_search('additional', MentorService::getTypes()))
                ->get();

        if ($id) {
            $mentor_categories = $rec->categories;
        } else {
            $mentor_categories = MentorCategory::where('parent_id', '!=', null)
                    ->get();
        }
        return view('admin.mentor.mentor_form', compact('id', 'rec', 'page_title', 'show_tab', 'list_companies', 'list_categories', 'list_countries', 'list_cities', 'list_languages', 'list_currencies', 'cat_list', 'lang_list', 'exp_list', 'edu_list', 'services_main_list', 'services_additional_list', 'mentor_main_services', 'mentor_additional_services', 'mentor_categories'));
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
                        die(json_encode([
                            'status' => 'error',
                            'msg' => 'Не выбрана страна!',
                        ]));
                    }

                    $cities = City::where('country_id', '=', $country_id)
                            ->orderBy('name', 'asc')
                            ->get();

                    /* Формируем HTML для выпадающего списка */
                    $html = '<option value="">Выберите город</option>';

                    if ($cities->count()) {
                        foreach ($cities as $city) {
                            $html .= '<option value="' . $city->id . '">' . $city->name . '</option>';
                        }
                    }

                    die(json_encode([
                        'status' => 'ok',
                        'html' => $html,
                    ]));
                }
            }
        }
    }

    public function deleteMany(Request $request) {
        $ids = $request->get('ids');
        $mentors = Mentor::whereIn('id', $ids)
                ->get();
        foreach ($mentors as $mentor) {
            $mentor->tags()
                    ->detach();
            $mentor->categories()
                    ->detach();
            $mentor->services()
                    ->delete();

            $mentor->delete();
        }
        return redirect()
                        ->back()
                        ->with('success', 'Менторы успешно удалены');
    }

    public function ajaxGetCategoryTags(Request $request) {
        if ($request->ajax()) {
            $category_ids = $request->categories ?? false;
            $tags = [];
            if ($category_ids) {
                $categories = MentorCategory::whereIn('id', $category_ids)
                        ->get();
            } else {
                $categories = MentorCategory::where('parent_id', '!=', null)
                        ->get();
            }
            $categories = $categories->each(function ($category) {
                return $category->tags;
            });
            return response()->json(array_merge($categories->toArray(), ['status' => 'success']));
        }
        return response([
            'status' => 'Ошибка',
                ], 403);
    }

}
