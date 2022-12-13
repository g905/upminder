@extends('layouts.admin.layout')

@section('content')
	<div class="page-header">
		<h3 class="page-title">
			<span class="page-title-icon bg-gradient-primary text-white me-2">
				<i class="mdi mdi-flag"></i>
			</span> 
			{{ $page_title }}
		</h3>
		<a href="{{ route('admin_rev_list') }}" class="btn btn-dark">Вернуться к списку</a>
	</div>
	<div class="row">
		<div class="col-md-12 grid-margin">
			@error('mentor_id')
				<div class="alert alert-warning">{{ $message }}</div>
			@endif
			@error('author')
				<div class="alert alert-warning">{{ $author }}</div>
			@endif
			@error('text')
				<div class="alert alert-warning">{{ $text }}</div>
			@endif
			@if (session('success'))
				<div class="alert alert-success">{{ session('success') }}</div>
			@endif
			<div class="card">
				<div class="card-body">
					<form action="{{ route('admin_rev_form', $id) }}" method="POST">
						@csrf
						<div class="form-group">
							<label>Для ментора: *</label>
							<select name="mentor_id" class="select2 form-control-sm form-control">
								<option value="">Выберите</option>
								@if ($list->count())
									@foreach ($list as $rec_list)
										<option value="{{ $rec_list->id }}" @if ($rec_list->id == old('mentor_id', $rec->mentor_id)) selected @endif>{{ $rec_list->last_name }} {{ $rec_list->first_name }} {{ $rec_list->surname }}</option>
									@endforeach
								@endif
							</select>
						</div>
						<div class="form-group">
							<label>Автор: *</label>
							<input type="text" name="author" value="{{ old('author', $rec->author) }}" placeholder="Например: Иван" class="form-control-sm form-control" />
						</div>
						<div class="form-group">
							<label>Текст отзыва: *</label>
							<textarea name="text" rows="8" class="visual form-control">{{ old('text', $rec->text) }}</textarea>
						</div>
						<div class="form-group">
							<label>Тип отзыва:</label>
							<div class="form-check">
								<label class="form-check-label">
									<input @if (old('type', $rec->type) == 1) checked @endif id="type1" type="radio" name="type" value="1" class="form-check-input" />
									Положительный
									<i class="input-helper"></i>
								</label>
							</div>
							<div class="form-check">
								<label class="form-check-label">
									<input @if (old('type', $rec->type) == 2) checked @endif id="type0" type="radio" name="type" value="2" class="form-check-input" />
									Негативный
									<i class="input-helper"></i>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label>Отображается на сайте?</label>
							<div class="form-check">
								<label class="form-check-label">
									<input @if (old('active', $rec->active) == 1) checked @endif id="active1" type="radio" name="active" value="1" class="form-check-input" />
									Да, отображается
									<i class="input-helper"></i>
								</label>
							</div>
							<div class="form-check">
								<label class="form-check-label">
									<input @if (old('active', $rec->active) == 0) checked @endif id="active0" type="radio" name="active" value="0" class="form-check-input" />
									Нет, не отображается
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
