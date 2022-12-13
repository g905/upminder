<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Company;

use App\Models\CompanyCategory;

use App\Models\CompanySingleCategory;

use App\Models\Country;
use App\Models\City;

class CompanyController extends Controller
{

    /* Список */
    public function index(Request $request)
    {

        /* Сортировка */
        $order_by = 'id';
        $order_by_asc = 'desc';

        if ($request->input('order_by')) {

            $order_by = $request->input('order_by');
            $order_by_asc = $request->input('order_by_asc');

        }

        $filters = ['country_id' => null, 'city_id' => false, 'applied' => false, 'keyword' => false];
        if ($request->input('filters')) {

            $filters['country_id'] = $request->input('filters')['country_id'];
            $filters['applied'] = true;

        }
        if ($request->input('keyword')) {
            $filters['keyword'] = $request->input('keyword');
        }

        $countries = Country::orderBy('name', 'asc')->get();
        if (!$filters['country_id']) {
            $cities = City::orderBy('name', 'asc')->get();
        } else {
            $cities = City::where('country_id', '=', $filters['country_id'])->orderBy('name', 'asc')->get();
        }

        if (!$filters['keyword']) {

            if (!$filters['country_id']) {
                $list = Company::orderBy($order_by, $order_by_asc)->get();
            } else {
                $list = Company::where('country_id', '=', $filters['country_id'])->orderBy($order_by, $order_by_asc)->get();
            }

        } else {

            $list = Company::where('name', 'LIKE', '%' . $filters['keyword'] . '%')
                ->orWhere('law_name', 'LIKE', '%' . $filters['keyword'] . '%')
                ->orWhere('contact_name', 'LIKE', '%' . $filters['keyword'] . '%')
                ->orderBy('name', 'asc')->get();

        }

        if ($list->count()) {
            foreach ($list as $rec) {

                $this_country = Country::find($rec->country_id);
                $rec->country = '&mdash;';
                if ($this_country) {
                    $rec->country = '<a href="' . route("admin_company_list", 'filters[country_id]=' . $this_country->id) . '">' . $this_country->name . '</a>';
                }

                $this_city = City::find($rec->city_id);
                $rec->city = '&mdash;';
                if ($this_city) {

                    $rec->city = $this_city->name;
                    //$rec->city = '<a href="'.route("admin_company_list", 'filters[city_id]='.$this_city->id).'">'.$this_city->name.'</a>';

                }

            }
        }
        $page_title = 'Все компании';

        return view('admin/company_list', compact('list', 'filters', 'countries', 'cities', 'page_title'));

    }

    /* AJAX */
    public function ajax(Request $request)
    {

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

    /* Форма */
    public function form($id, Request $request)
    {

        /* Таб по умолчанию */
        $show_tab = 'general';

        /* Список категорий */
        $list_categories = CompanyCategory::orderBy('name', 'asc')->get();

        /* Список стран */
        $list_countries = Country::orderBy('name', 'asc')->get();

        /* Список городов */
        $list_cities = City::orderBy('name', 'asc')->get();

        $cat_list = [];
        $lang_list = [];
        $exp_list = json_decode(json_encode([]));
        $edu_list = json_decode(json_encode([]));
        $services_list = json_decode(json_encode([]));

        /* Добавление или редактирование */
        if (!$id) {

            $rec = new Company;
            $page_title = 'Добавить компанию';

        } else {

            $rec = Company::find($id);
            $page_title = 'Редактировать компанию';
            if (!$rec) {
                return redirect()->back()->with('error', 'Компания не найден!');
            }

            $cat_list = [];
            $cat_list_db = CompanySingleCategory::where(['company_id' => $id])->get();
            if ($cat_list_db->count()) {
                foreach ($cat_list_db as $tc) {
                    $cat_list[] = $tc->category_id;
                }
            }

        }

        return view('admin/company_form', compact('id', 'rec', 'page_title', 'show_tab', 'list_categories', 'list_countries', 'list_cities', 'cat_list'));

    }

    public function store(Request $request)
    {

        /* Сохраняем информацию и редирект */
        $data = [

            'name' => $request->input('name'),
            'law_name' => $request->input('law_name'),
            'inn' => $request->input('inn'),
            'country_id' => $request->input('country_id'),
            'city_id' => $request->input('city_id'),
            'contact_name' => $request->input('contact_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'website' => $request->input('website'),
            'description' => $request->input('description'),

        ];

        $newCompany = new Company();
        $newCompany->fill($data);
        $newCompany->save();


        /* Категории компании */
        foreach ($request->input('categories') as $cat_a => $cat_id) {

            /* Удаляем все предыдущие привязки к категориям */
            if ($cat_a == 0) {
                CompanySingleCategory::where(['company_id' => $newCompany->id])->delete();
            }

            /* Привязываем к новым категорям (выбранным) */
            $mentor_cat = new CompanySingleCategory;
            $mentor_cat->fill(['company_id' => $newCompany->id, 'category_id' => $cat_id]);
            $mentor_cat->save();

        }

        if ($request->input('redirect') == 'true') {
            return redirect(route('admin_company_list'))->with('success', 'Компания сохранена!');
        } else {
            return redirect()->back()->with('success', 'Компания сохранена!');
        }

    }
}
