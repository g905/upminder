<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\TaskType;

use App\Models\MentorCategory;

class TaskTypeController extends Controller {
    
	/* Список */
	public function index(Request $request) {
		
		$filters = ['category_id' => null, 'applied' => false];
		if ($request->input('filters')) {
			
			$filters['category_id'] = $request->input('filters')['category_id'];
			$filters['applied'] = true;
			
		}
		
		if (!$filters['category_id']) {
			$list = TaskType::orderBy('id', 'desc')->get();
		}
		else {
			$list = TaskType::where(['category_id' => $filters['category_id']])->orderBy('id', 'desc')->get();
		}
		
		$categories = MentorCategory::orderBy('name', 'asc')->get();
	
		$page_title = 'Типы задач';
		
		return view('admin/task_type_list', compact('list', 'filters', 'categories', 'page_title'));
		
	}
	
	/* Форма */
	public function form($id, Request $request) {
		
		$list = MentorCategory::orderBy('name', 'asc')->get();
		
		/* Добавление или редактирование */
		if (!$id) {
			
			$rec = new TaskType;
			$page_title = 'Добавить тип задач';
			
		}
		else {
			
			$rec = TaskType::find($id);
			$page_title = 'Редактировать тип задач';
			if (!$rec) {
				return redirect()->back()->with('error', 'Тип задач не найден!');
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
				$rules['name'] .= '|unique:task_types';
			}
			
			$valid = Validator::make($request->all(), $rules);
			
			/* Показываем сообщения. Не прошла валидация */
			if ($valid->fails()) {
				return redirect()->back()->withErrors($valid)->withInput();
			}
			
			/* Сохраняем информацию и редирект */
			$data = [
			
				'category_id' => $request->input('category_id'),
				'name' => $request->input('name'),
			
			];
			
			$rec->fill($data);
			$rec->save();
			return redirect(route('admin_task_type_list'))->with('success', 'Тип задач сохранен!');
			
		}
	
		return view('admin/task_type_form', compact('id', 'rec', 'page_title', 'list'));
		
	}
	
}
