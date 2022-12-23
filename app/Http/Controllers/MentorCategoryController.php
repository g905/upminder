<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\MentorCategory;
use App\Models\MentorSingleCategory;

class MentorCategoryController extends Controller {
    /* Список */

    public function index(Request $request) {

        $order_by = 'parent_id';
        $order_by_asc = 'desc';
        if ($request->input('order_by')) {

            $order_by = $request->input('order_by');
            $order_by_asc = $request->input('order_by_asc');
        }

        /* Фильтры */
        $filters = ['parent_id' => null, 'applied' => false, 'keyword' => false];
        if ($request->input('filters')) {

            $filters['parent_id'] = $request->input('filters')['parent_id'];
            $filters['applied'] = true;
        }
        if ($request->input('keyword')) {
            $filters['keyword'] = $request->input('keyword');
        }

        $parents = MentorCategory::orderBy($order_by, $order_by_asc)->get();

        if (!$filters['keyword']) {

            if ($filters['parent_id'] !== null) {
                $list = MentorCategory::where('parent_id', '=', $filters['parent_id'])->orderBy($order_by, $order_by_asc)->get();
            } else {
                $list = MentorCategory::orderBy($order_by, $order_by_asc)->get();
            }
        } else {
            $list = MentorCategory::where('name', 'LIKE', '%' . $filters['keyword'] . '%')->orderBy($order_by, $order_by_asc)->get();
        }

        if ($list->count()) {
            foreach ($list as $rec) {

                $this_parent = MentorCategory::find($rec->parent_id);
                $rec->parent = '&mdash;';
                if ($this_parent) {
                    $rec->parent = '<a href="' . route("admin_mentor_cat_list", 'filters[parent_id]=' . $this_parent->id) . '">' . $this_parent->name . '</a>';
                }

                $cat_ids = [];
                $cat_ids[] = $rec->id;

                $child_cats = MentorCategory::where(['parent_id' => $rec->id])->get();
                if ($child_cats->count()) {
                    foreach ($child_cats as $child) {
                        $cat_ids[] = $child->id;
                    }
                }

                $rec->mentors = MentorSingleCategory::whereIn('category_id', $cat_ids)->count();
            }
        }
        $page_title = 'Все категории';
        $parent_categories = MentorCategory::where('parent_id', null)->get();

        return view('admin.mentor.mentor_category_list', compact('list', 'parent_categories', 'parents', 'filters', 'order_by', 'order_by_asc', 'page_title'));
    }

    /* Форма */

    public function form($id, Request $request) {

        $parent_id = null;
        if ($request->input('parent_id')) {
            $parent_id = $request->input('parent_id');
        }

        /* Список категорий */
        $list = MentorCategory::where('parent_id', '=', null)->orderBy('name', 'asc')->get();

        /* Добавление или редактирование */
        if (!$id) {

            $rec = new MentorCategory;
            $page_title = 'Добавить категорию';
        } else {

            $rec = MentorCategory::find($id);
            $page_title = 'Редактировать категорию';
            if (!$rec) {
                return redirect()->back()->with('error', 'Категория не найдена!');
            }
        }

        /* POST */
        if ($request->isMethod('post')) {

            /* Правила валидации */
            $rules = [
                'name' => 'required',
            ];

            if (!$id) {
                $rules['name'] .= '|unique:mentor_categories';
            }

            $valid = Validator::make($request->all(), $rules);

            /* Показываем сообщения. Не прошла валидация */
            if ($valid->fails()) {
                return redirect()->back()->withErrors($valid)->withInput();
            }

            /* Сохраняем информацию и редирект */
            $data = [
                'parent_id' => $request->input('parent_id'),
                'name' => $request->input('name'),
            ];
            $rec->fill($data);
            $rec->save();

            if ($request->get('return')) {
                return redirect(route('admin_mentor_cat_list'))->with('success', 'Категория сохранена!');
            }
            return redirect()->back()->with('success', 'Категория сохранена!');
        }

        return view('admin.mentor.mentor_category_form', compact('id', 'rec', 'page_title', 'parent_id', 'list'));
    }

}
