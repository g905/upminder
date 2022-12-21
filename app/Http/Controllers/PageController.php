<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Page;

class PageController extends Controller {
	
	public function index(Request $request) {
	
		$order_by = 'id';
		$order_by_asc = 'desc';
		
		if ($request->input('order_by')) {
			
			$order_by = $request->input('order_by');
			$order_by_asc = $request->input('order_by_asc');
			
		}
		
		/* Список */
		$list = Page::orderBy($order_by, $order_by_asc)->get();

		$page_title = 'Страницы сайта';
			
		return view('admin/page_list', compact('list', 'order_by', 'order_by_asc', 'page_title'));
		
	}
	
	/* Форма */
	public function form($id, Request $request) {

		/* Добавление или редактирование */
		if (!$id) {
			
			$rec = new Page;
			$page_title = 'Добавить страницу';
			
		}
		else {
			
			$rec = Page::find($id);
			$page_title = 'Редактировать страницу';
			if (!$rec) {
				return redirect()->back()->with('error', 'Страница не найдена!');
			}
			
		}
		
		/* POST */
		if ($request->isMethod('post')) {
			
			/* Правила валидации */
			$rules = [
			
				'title' => 'required',
				'slug' => 'required',
				'content' => 'required',
				'active' => 'required',
				
			];
			
			if (!$id) {
				$rules['slug'] .= '|unique:pages';
			}
			
			$valid = Validator::make($request->all(), $rules);
			
			/* Показываем сообщения. Не прошла валидация */
			if ($valid->fails()) {
				return redirect()->back()->withErrors($valid)->withInput();
			}
			
			/* Сохраняем информацию и редирект */
			$data = [
			
				'title' => $request->input('title'),
				'slug' => $request->input('slug'),
				'excerpt' => $request->input('excerpt'),
				'content' => $request->input('content'),
				'active' => $request->input('active'),
			
			];
			
			$rec->fill($data);
			$rec->save();
			return redirect(route('admin_page_list'))->with('success', 'Страница сохранена!');
			
		}
			
		return view('admin/page_form', compact('id', 'rec', 'page_title'));
		
	}
	
}
