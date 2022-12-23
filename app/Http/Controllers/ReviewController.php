<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Review;

use App\Models\Mentor;

class ReviewController extends Controller {
	
	/* Список */
	public function index(Request $request) {
		
		$order_by = 'id';
		$order_by_asc = 'desc';
		
		$filters = ['mentor_id' => null, 'applied' => false, 'keyword' => null];
		if ($request->input('filters')) {
			
			$filters['mentor_id'] = $request->input('filters')['mentor_id'];
			$filters['applied'] = true;
		
		}
		if ($request->input('keyword')) {
			$filters['keyword'] = $request->input('keyword');
		}
		
		$mentors = Mentor::orderBy('last_name', 'asc')->get();
		
		if (!$filters['keyword']) {

			if (!$filters['mentor_id']) {
				$list = Review::orderBy('id', 'desc')->get();
			}
			else {
				$list = Review::where('mentor_id', '=', $filters['mentor_id'])->orderBy('id', 'desc')->get();
			}
			
		}
		else {
			$list = Review::where('text', 'LIKE', '%'.$filters['keyword'].'%')->orderBy('id', 'desc')->get();
		}
		
		if ($list->count()) {
			foreach ($list as $rec) {
				
				$this_mentor = Mentor::find($rec->mentor_id);
				$rec->mentor = '&mdash;';
				if ($this_mentor) {
					$rec->mentor = $this_mentor->last_name.' '.$this_mentor->first_name.' '.$this_mentor->surname;
				}
				
				$rec->short = mb_substr($rec->text, 0, 200).'...';
				
			}
		}
		$page_title = 'Отзывы';
		
		return view('admin.review_list', compact('list', 'filters', 'order_by', 'order_by_asc', 'mentors', 'page_title'));
		
	}
	
	/* Форма */
	public function form($id, Request $request) {
		
		/* Список менторов */
		$list = Mentor::orderBy('last_name', 'asc')->get();
		
		/* Добавление или редактирование */
		if (!$id) {
			
			$rec = new Review;
			$page_title = 'Добавить отзыв';
			
		}
		else {
			
			$rec = Review::find($id);
			$page_title = 'Редактировать отзыв';
			if (!$rec) {
				return redirect()->back()->with('error', 'Отзыв не найден!');
			}
			
		}
		
		/* POST */
		if ($request->isMethod('post')) {
			
			/* Правила валидации */
			$rules = [
			
				'mentor_id' => 'required',
				'author' => 'required',
				'text' => 'required',
				'type' => 'required',
				'active' => 'required',
				
			];
			
			$valid = Validator::make($request->all(), $rules);
			
			/* Показываем сообщения. Не прошла валидация */
			if ($valid->fails()) {
				return redirect()->back()->withErrors($valid)->withInput();
			}
			
			/* Сохраняем информацию и редирект */
			$data = [
			
				'mentor_id' => $request->input('mentor_id'),
				'author' => $request->input('author'),
				'text' => $request->input('text'),
				'type' => $request->input('type'),
				'active' => $request->input('active'),
			
			];
			
			$rec->fill($data);
			$rec->save();
			return redirect(route('admin_rev_list'))->with('success', 'Отзыв сохранен!');
			
		}
	
		return view('admin/review_form', compact('id', 'rec', 'page_title', 'list'));
		
	}
	
}
