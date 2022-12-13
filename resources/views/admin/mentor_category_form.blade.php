@extends('layouts.admin.layout')

@section('content')
	<div class="page-header">
		<h3 class="page-title">
			<span class="page-title-icon bg-gradient-primary text-white me-2">
				<i class="mdi mdi-flag"></i>
			</span> 
			{{ $page_title }}
		</h3>
		<a href="{{ route('admin_mentor_cat_list') }}" class="btn btn-dark">Вернуться к списку</a>
	</div>
	<div class="row">
		<div class="col-md-12 grid-margin">
			@error('name')
				<div class="alert alert-warning">{{ $message }}</div>
			@endif
			@if (session('success'))
				<div class="alert alert-success">{{ session('success') }}</div>
			@endif
			<div class="card">
				<div class="card-body">
					<form action="{{ route('admin_mentor_cat_form', $id) }}" method="POST">
						@csrf
						<div class="form-group">
							<label>Родительская категория: *</label>
							<select name="parent_id" class="form-control-sm form-control">
								<option value="">Корневая</option>
								@if ($list->count())
									@foreach ($list as $rec_list)
										<option value="{{ $rec_list->id }}" @if ($rec_list->id == $parent_id) selected @endif @if ($rec_list->id == old('parent_id', $rec->parent_id)) selected @endif>{{ $rec_list->name }}</option>
									@endforeach
								@endif
							</select>
						</div>
						<div class="form-group">
							<label>Название: *</label>
							<input type="text" name="name" value="{{ old('name', $rec->name) }}" placeholder="Например: Россия" class="form-control-sm form-control" />
						</div>
						<div class="form-group">
							<button class="btn btn-success">Сохранить</button>
							<a href="{[ route('admin_mentor_cat_list') }}" class="btn btn-warning">Выйти без сохранения</a>
							@if ($rec->parent_id > 0)
								<a href="{[ route('admin_mentor_cat_form', 'parent_id', $rec->parent_id) }}" class="btn btn-warning">Создать ещё подкатегорию</a>
							@endif
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
