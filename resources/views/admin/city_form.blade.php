@extends('layouts.admin.layout')

@section('content')
	<div class="page-header">
		<h3 class="page-title">
			<span class="page-title-icon bg-gradient-primary text-white me-2">
				<i class="mdi mdi-flag"></i>
			</span> 
			{{ $page_title }}
		</h3>
		<a href="{{ route('admin_city_list') }}" class="btn btn-dark">Вернуться к списку</a>
	</div>
	<div class="row">
		<div class="col-md-12 grid-margin">
			@error('country_id')
				<div class="alert alert-warning">{{ $message }}</div>
			@endif
			@error('name')
				<div class="alert alert-warning">{{ $message }}</div>
			@endif
			@if (session('success'))
				<div class="alert alert-success">{{ session('success') }}</div>
			@endif
			<div class="card">
				<div class="card-body">
					<form action="{{ route('admin_city_form', $id) }}" method="POST">
						@csrf
						<div class="form-group">
							<label>Страна: *</label>
							<select name="country_id" class="select2 form-control-sm form-control">
								<option value="">Выберите</option>
								@if ($list->count())
									@foreach ($list as $rec_list)
										<option value="{{ $rec_list->id }}" @if ($rec_list->id == old('country_id', $rec->country_id)) selected @endif>{{ $rec_list->name }}</option>
									@endforeach
								@endif
							</select>
						</div>
						<div class="form-group">
							<label>Название: *</label>
							<input type="text" name="name" value="{{ old('name', $rec->name) }}" placeholder="Например: Москва" class="form-control-sm form-control" />
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
