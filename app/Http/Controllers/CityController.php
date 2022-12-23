<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\City;

use App\Models\Country;

class CityController extends Controller {
	
	/* Список */
	public function index(Request $request) {
		
		$filters = ['country_id' => null, 'applied' => false, 'keyword' => false];
		if ($request->input('filters')) {
			
			$filters['country_id'] = $request->input('filters')['country_id'];
			$filters['applied'] = true;
			
		}
		if ($request->input('keyword')) {
			$filters['keyword'] = $request->input('keyword');
		}
		
		$countries = Country::orderBy('name', 'asc')->get();
		
		if (!$filters['keyword']) {
			
			if (!$filters['country_id']) {
				$list = City::orderBy('name', 'asc')->get();
			}
			else {
				$list = City::where('country_id', '=', $filters['country_id'])->orderBy('name', 'asc')->get();
			}
			
		}
		else {
			$list = City::where('name', 'LIKE', '%'.$filters['keyword'].'%')->orderBy('name', 'asc')->get();
		}
		
		if ($list->count()) {
			foreach ($list as $rec) {
				
				$this_country = Country::find($rec->country_id);
				$rec->country = '&mdash;';
				if ($this_country) {
					$rec->country = $this_country->name;
				}
				
			}
		}
		$page_title = 'Города';
		
		return view('admin/city_list', compact('list', 'filters', 'countries', 'page_title'));
		
	}
	
	/* Форма */
	public function form($id, Request $request) {
		
		/* Список стран */
		$list = Country::orderBy('name', 'asc')->get();
		
		/* Добавление или редактирование */
		if (!$id) {
			
			$rec = new City;
			$page_title = 'Добавить город';
			
		}
		else {
			
			$rec = City::find($id);
			$page_title = 'Редактировать город';
			if (!$rec) {
				return redirect()->back()->with('error', 'Город не найден!');
			}
			
		}
		
		/* POST */
		if ($request->isMethod('post')) {
			
			/* Правила валидации */
			$rules = [
			
				'country_id' => 'required',
				'name' => 'required',
				
			];
			
			if (!$id) {
				$rules['name'] .= '|unique:cities';
			}
			
			$valid = Validator::make($request->all(), $rules);
			
			/* Показываем сообщения. Не прошла валидация */
			if ($valid->fails()) {
				return redirect()->back()->withErrors($valid)->withInput();
			}
			
			/* Сохраняем информацию и редирект */
			$data = [
			
				'country_id' => $request->input('country_id'),
				'name' => $request->input('name'),
			
			];
			
			$rec->fill($data);
			$rec->save();
			return redirect(route('admin_city_list'))->with('success', 'Город сохранен!');
			
		}
	
		return view('admin/city_form', compact('id', 'rec', 'page_title', 'list'));
		
	}
	
}
