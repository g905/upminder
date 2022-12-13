@extends('layouts.admin.layout')

@section('content')
	<div class="page-header">
		<h3 class="page-title">
			<span class="page-title-icon bg-gradient-primary text-white me-2">
				<i class="mdi mdi-home"></i>
			</span> 
			{{ $page_title }}
		</h3>
		<a href="{{ route('admin_mentor_cat_form', 0) }}" class="btn btn-success">Добавить</a>
		@if ($filters['parent_id'] > 0)
			<a href="{{ route('admin_mentor_cat_form', 0) }}?parent_id={{ $filters['parent_id'] }}" class="btn btn-info">Добавить подкатегорию</a>
		@endif
	</div>
	<div class="btn-group">
		<button type="button" data-card="filters" class="btn btn-small btn-primary btn-tabs show_card @if ($filters['applied']) active @endif">Фильтрация</button>
		<button type="button" data-card="search" class="btn btn-small btn-primary btn-tabs show_card @if (!empty($filters['keyword'])) active @endif">Поиск по категориям</button>
	</div>
	<div class="row">
		<div class="col-md-12 grid-margin">
			<div class="card">
				<form action="{{ route('admin_mentor_cat_list') }}">
				<div class="card-body dynamic filters @if (!$filters['applied']) filter_hide @else shown @endif">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label>Родительская категория:</label>
								<select name="filters[parent_id]" class="select2 form-control-sm form-control">
									<option value="">Отображать все</option>
									@if ($parents->count())
										@foreach ($parents as $parent)
											<option value="{{ $parent->id }}" @if ($filters['parent_id'] == $parent->id) selected @endif>{{ $parent->name }}</option>
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
				<form action="{{ route('admin_mentor_cat_list') }}">
				<div class="card-body dynamic search @if (empty($filters['keyword'])) filter_hide @else shown @endif">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label>Название категории:</label>
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
								<th width="36px"><input type="checkbox" name="select_all" /></th>
								<th width="36px">
									ID
									@if ($order_by == 'id')
										@if ($order_by_asc == 'desc')
											<a href="{{ route('admin_mentor_cat_list', 'order_by=id&order_by_asc=asc') }}">&LeftDownVectorBar;</a>
										@else
											<a href="{{ route('admin_mentor_cat_list', 'order_by=id&order_by_asc=desc') }}">&LeftUpVectorBar;</a>
										@endif
									@else
										<a href="{{ route('admin_mentor_cat_list', 'order_by=id&order_by_asc=desc') }}">&LeftUpVectorBar;</a>
									@endif
								</th>
								<th width="250px">Родительская</th>
								<th>
									Название
									@if ($order_by == 'name')
										@if ($order_by_asc == 'desc')
											<a href="{{ route('admin_mentor_cat_list', 'order_by=name&order_by_asc=asc') }}">&LeftDownVectorBar;</a>
										@else
											<a href="{{ route('admin_mentor_cat_list', 'order_by=name&order_by_asc=desc') }}">&LeftUpVectorBar;</a>
										@endif
									@else
										<a href="{{ route('admin_mentor_cat_list', 'order_by=name&order_by_asc=desc') }}">&LeftUpVectorBar;</a>
									@endif
								</th>
								<th width="50px" align="center">Кол-во менторов</th>
								<th width="200px" align="right">Действия</th>
							</thead>
							<tbody>
								@if ($list->count())
									@foreach ($list as $rec)
										<tr>
											<td><input type="checkbox" name="ids[]" value="{{ $rec->id }}" /></td>
											<td>{{ $rec->id }}</td>
											<td>{!! $rec->parent !!}</td>
											<td><a href="{{ route('admin_mentor_cat_form', $rec->id) }}">{{ $rec->name }}</a></td>
											<td align="center">{{ $rec->mentors }}</td>
											<td align="right">
												<a href="{{ route('admin_mentor_cat_form', $rec->id) }}" class="badge badge-info"><i class="mdi mdi-pencil btn-icon-append"></i></a>
												<a href="{{ route('admin_delete_record', ['mentor_category', $rec->id]) }}" data-confirm="Удалить город {{ $rec->name }}?" class="confirm badge badge-danger"><i class="remove mdi mdi-close-circle-outline"></i></a>
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
