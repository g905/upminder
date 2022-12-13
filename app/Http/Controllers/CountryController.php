<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Country;

class CountryController extends Controller {
    
	/* Список */
	public function index(Request $request) {
		
		$list = Country::orderBy('id', 'desc')->get();
		$page_title = 'Страны';
		
		return view('admin/country_list', compact('list', 'page_title'));
		
	}
	
	/* Форма */
	public function form($id, Request $request) {
		
		/* Добавление или редактирование */
		if (!$id) {
			
			$rec = new Country;
			$page_title = 'Добавить страну';
			
		}
		else {
			
			$rec = Country::find($id);
			$page_title = 'Редактировать страну';
			if (!$rec) {
				return redirect()->back()->with('error', 'Страна не найдена!');
			}
			
		}
		
		/* POST */
		if ($request->isMethod('post')) {
			
			/* Правила валидации */
			$rules = [
			
				'name' => 'required',
				
			];
			
			if (!$id) {
				$rules['name'] .= '|unique:countries';
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
			return redirect(route('admin_country_list'))->with('success', 'Страна сохранена!');
			
		}
	
		return view('admin/country_form', compact('id', 'rec', 'page_title'));
		
	}
	
}
