@extends('layouts.admin.layout')

@section('content')
	<div class="page-header">
		<h3 class="page-title">
			<span class="page-title-icon bg-gradient-primary text-white me-2">
				<i class="mdi mdi-home"></i>
			</span> 
			{{ $page_title }}
		</h3>
		<a href="{{ route('admin_city_form', 0) }}" class="btn btn-success">Добавить</a>
	</div>
	<div class="btn-group">
		<button type="button" data-card="filters" class="btn btn-small btn-primary btn-tabs show_card @if ($filters['applied']) active @endif">Фильтрация</button>
		<button type="button" data-card="search" class="btn btn-small btn-primary btn-tabs show_card @if (!empty($filters['keyword'])) active @endif">Поиск по городам</button>
	</div>
	<div class="row">
		<div class="col-md-12 grid-margin">
			<div class="card">
				<form action="{{ route('admin_city_list') }}">
				<div class="card-body dynamic filters @if (!$filters['applied']) filter_hide @else shown @endif">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label>Страна:</label>
								<select name="filters[country_id]" class="select2 form-control-sm form-control">
									<option value="">Все страны</option>
									@if ($countries->count())
										@foreach ($countries as $country)
											<option value="{{ $country->id }}" @if ($filters['country_id'] == $country->id) selected @endif>{{ $country->name }}</option>
										@endforeach
									@endif
								</select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>&nbsp;</label>
								<button class="btn btn-outline-dark btn-fw form-control">Фильтр</button>
							</div>
						</div>
					</div>
				</div>
				</form>
				<form action="{{ route('admin_city_list') }}">
				<div class="card-body dynamic search @if (empty($filters['keyword'])) filter_hide @else shown @endif">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label>Город:</label>
								<input type="text" name="keyword" value="{{ $filters['keyword'] }}" class="form-control" />
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>&nbsp;</label>
								<button class="btn btn-outline-dark btn-fw form-control">Поиск</button>
							</div>
						</div>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 grid-margin">
			@if (session('error'))
				<div class="alert alert-warning">{{ session('error') }}</div>
			@endif
			@if (session('success'))
				<div class="alert alert-success">{{ session('success') }}</div>
			@endif
			<div class="card">
				<div class="card-body table">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<th width="36px"><input type="checkbox" class="select_all" /></th>
								<th width="36px">ID</th>
								<th width="250px">Страна</th>
								<th>Название</th>
								<th width="200px" align="right">Действия</th>
							</thead>
							<tbody>
								@if ($list->count())
									@foreach ($list as $rec)
										<tr>
											<td><input type="checkbox" name="ids[]" value="{{ $rec->id }}" /></td>
											<td>{{ $rec->id }}</td>
											<td>{!! $rec->country !!}</td>
											<td>{{ $rec->name }}</td>
											<td align="right">
												<a href="{{ route('admin_city_form', $rec->id) }}" class="badge badge-info"><i class="remove mdi mdi-pencil"></i></a>
												<a href="{{ route('admin_delete_record', ['city', $rec->id]) }}" data-confirm="Удалить город {{ $rec->name }}?" class="confirm badge badge-danger"><i class="remove mdi mdi-close-circle-outline"></i></a>
											</td>
										</tr>
									@endforeach
								@else
									<tr>
										<td colspan="4">Нет информации</td>
									</tr>
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
