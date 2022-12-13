@extends('layouts.admin.layout')

@section('content')
	<div class="page-header">
		<h3 class="page-title">
			<span class="page-title-icon bg-gradient-primary text-white me-2">
				<i class="mdi mdi-flag"></i>
			</span> 
			{{ $page_title }}
		</h3>
		<a href="{{ route('admin_page_list') }}" class="btn btn-dark">Вернуться к списку</a>
	</div>
	<div class="row">
		<div class="col-md-12 grid-margin">
			@error('title')
				<div class="alert alert-warning">{{ $message }}</div>
			@endif
			@error('slug')
				<div class="alert alert-warning">{{ $message }}</div>
			@endif
			@error('content')
				<div class="alert alert-warning">{{ $message }}</div>
			@endif
			@if (session('success'))
				<div class="alert alert-success">{{ session('success') }}</div>
			@endif
			<div class="card">
				<div class="card-body">
					<form action="{{ route('admin_page_form', $id) }}" method="POST">
						@csrf
						<div class="form-group">
							<label>Заголовок: *</label>
							<input type="text" name="title" value="{{ old('title', $rec->title) }}" placeholder="Например: О нас" class="form-control-sm form-control" />
						</div>
						<div class="form-group">
							<label>URL: *</label>
							<input type="text" name="slug" value="{{ old('slug', $rec->slug) }}" placeholder="/example" class="form-control-sm form-control" />
						</div>
						<div class="form-group">
							<label>Краткое содержание страницы:</label>
							<textarea name="excerpt" rows="8" class="form-control">{{ old('excerpt', $rec->excerpt) }}</textarea>
						</div>
						<div class="form-group">
							<label>Контент: *</label>
							<textarea name="content" rows="12" class="visual form-control">{{ old('content', $rec->content) }}</textarea>
						</div>
						<div class="form-group">
							<label>Страница доступна?</label>
							<div class="form-check">
								<label class="form-check-label">
									<input @if (old('active', $rec->active) == 1) checked @endif id="active1" type="radio" name="active" value="1" class="form-check-input" />
									Да, доступна
									<i class="input-helper"></i>
								</label>
							</div>
							<div class="form-check">
								<label class="form-check-label">
									<input @if (old('active', $rec->active) == 0) checked @endif id="active0" type="radio" name="active" value="0" class="form-check-input" />
									Нет, недоступна
									<i class="input-helper"></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<button class="btn btn-success">Сохранить</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
