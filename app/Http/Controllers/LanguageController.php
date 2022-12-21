<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Language;

class LanguageController extends Controller {
    
	/* Список */
	public function index(Request $request) {
		
		$list = Language::orderBy('id', 'desc')->get();
		$page_title = 'Языки общения';
		
		return view('admin/language_list', compact('list', 'page_title'));
		
	}
	
	/* Форма */
	public function form($id, Request $request) {
		
		/* Добавление или редактирование */
		if (!$id) {
			
			$rec = new Language;
			$page_title = 'Добавить язык';
			
		}
		else {
			
			$rec = Language::find($id);
			$page_title = 'Редактировать язык';
			if (!$rec) {
				return redirect()->back()->with('error', 'Язык не найден!');
			}
			
		}
		
		/* POST */
		if ($request->isMethod('post')) {
			
			/* Правила валидации */
			$rules = [
			
				'name' => 'required',
				
			];
			
			if (!$id) {
				$rules['name'] .= '|unique:languages';
			}
			
			$valid = Validator::make($request->all(), $rules);
			
			/* Показываем сообщения. Не прошла валидация */
			if ($valid->fails()) {
				return redirect()->back()->withErrors($valid)->withInput();
			}
			
			/* Сохраняем информацию и редирект */
			$data = [
			
				'name' => $request->input('name'),
			
			];
			
			$rec->fill($data);
			$rec->save();
			return redirect(route('admin_language_list'))->with('success', 'Язык сохранен!');
			
		}
	
		return view('admin/language_form', compact('id', 'rec', 'page_title'));
		
	}
	
}
