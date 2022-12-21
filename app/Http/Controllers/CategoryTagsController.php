<?php

namespace App\Http\Controllers;

use App\Models\CategoryTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\MentorCategory;

class CategoryTagsController extends Controller
{
    
    /* Список */
    public function index(Request $request)
    {
        
        $filters = [
            'category_id' => null,
            'applied' => false,
        ];
        if ($request->input('filters')) {
            
            $filters['category_id'] = $request->input('filters')['category_id'];
            $filters['applied'] = true;
            
        }
        
        if (!$filters['category_id']) {
            $list = CategoryTag::orderBy('id', 'desc')
                ->get();
        } else {
            $list = CategoryTag::where(['category_id' => $filters['category_id']])
                ->orderBy('id', 'desc')
                ->get();
        }
        
        $categories = MentorCategory::orderBy('name', 'asc')
            ->get();
        
        $page_title = 'Типы задач';
        
        return view('admin.category_tags.task_type_list', compact('list', 'filters', 'categories', 'page_title'));
        
    }
    
    /* Форма */
    public function form($id, Request $request)
    {
        $parent_categories = MentorCategory::where('parent_id', null)->get();
        $list = MentorCategory::orderBy('name', 'asc')->where('parent_id','!=', null)
            ->get();
        
        /* Добавление или редактирование */
        if (!$id) {
            
            $rec = new CategoryTag;
            $page_title = 'Добавить тип задач';
            
        } else {
            
            $rec = CategoryTag::find($id);
            $page_title = 'Редактировать тип задач';
            if (!$rec) {
                return redirect()
                    ->back()
                    ->with('error', 'Тип задач не найден!');
            }
            
        }
        
        /* POST */
        if ($request->isMethod('post')) {
            
            /* Правила валидации */
            $rules = [
                
                'category_id' => 'required',
                'name' => 'required',
            
            ];
            
            if (!$id) {
                $rules['name'] .= '|unique:category_tags';
            }
            
            $valid = Validator::make($request->all(), $rules);
            
            /* Показываем сообщения. Не прошла валидация */
            if ($valid->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($valid)
                    ->withInput();
            }
            
            /* Сохраняем информацию и редирект */
            
            $rec->fill($request->only('category_id','name','is_filter'));
            $rec->save();
            return redirect(route('admin_task_type_list'))->with('success', 'Тип задач сохранен!');
            
        }
        
        return view('admin.category_tags.task_type_form', compact('id', 'rec', 'page_title', 'list', 'parent_categories'));
        
    }
    
}
