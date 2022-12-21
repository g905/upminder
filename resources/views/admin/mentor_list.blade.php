@extends('layouts.admin.layout')

@section('content')
	<div class="page-header">
		<h3 class="page-title">
			<span class="page-title-icon bg-gradient-primary text-white me-2">
				<i class="mdi mdi-home"></i>
			</span> 
			{{ $page_title }}
		</h3>
		<a href="{{ route('admin_mentor_form', 0) }}" class="btn btn-success">Добавить</a>
	</div>
	<div class="btn-group">
		<button type="button" data-card="filters" class="btn btn-small btn-primary btn-tabs show_card @if ($filters['applied']) active @endif">Фильтрация</button>
		<button type="button" data-card="search" class="btn btn-small btn-primary btn-tabs show_card @if (!empty($filters['keyword'])) active @endif">Поиск</button>
	</div>
	<div class="row">
		<div class="col-md-12 grid-margin">
			<div class="card">
				<form action="{{ route('admin_mentor_list') }}">
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
								<br />
								<a href="{{ route('admin_mentor_list') }}">Сбросить фильтры</a>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Категория:</label>
								<select name="filters[category_id]" class="select2 form-control-sm form-control">
									<option value="">Все страны</option>
									@if ($categories->count())
										@foreach ($categories as $cat)
											<option value="{{ $cat->id }}" @if ($filters['category_id'] == $cat->id) selected @endif>{{ $cat->name }}</option>
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
				<form action="{{ route('admin_mentor_list') }}">
				<div class="card-body dynamic search @if (empty($filters['keyword'])) filter_hide @else shown @endif">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label>ФИО / Телефон / E-mail:</label>
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
								<th width="36px">
									ID
									@if ($order_by == 'id')
										@if ($order_by_asc == 'desc')
											<a href="{{ route('admin_mentor_list', 'order_by=id&order_by_asc=asc') }}">&LeftDownVectorBar;</a>
										@else
											<a href="{{ route('admin_mentor_list', 'order_by=id&order_by_asc=desc') }}">&LeftUpVectorBar;</a>
										@endif
									@else
										<a href="{{ route('admin_mentor_list', 'order_by=id&order_by_asc=desc') }}">&LeftUpVectorBar;</a>
									@endif
								</th>
								<th width="250px">
									Ф.И.О
									@if ($order_by == 'last_name')
										@if ($order_by_asc == 'desc')
											<a href="{{ route('admin_mentor_list', 'order_by=last_name&order_by_asc=asc') }}">&LeftDownVectorBar;</a>
										@else
											<a href="{{ route('admin_mentor_list', 'order_by=last_name&order_by_asc=desc') }}">&LeftUpVectorBar;</a>
										@endif
									@else
										<a href="{{ route('admin_mentor_list', 'order_by=last_name&order_by_asc=desc') }}">&LeftUpVectorBar;</a>
									@endif	
								</th>
								<th width="250px">Категории</th>
								<th width="250px">Страна / Город</th>
								<th align="center">E-mail</th>
								<th align="center">Телефон</th>
								<th align="center">
									Верицифирован
									@if ($order_by == 'verified')
										@if ($order_by_asc == 'desc')
											<a href="{{ route('admin_mentor_list', 'order_by=verified&order_by_asc=asc') }}">&LeftDownVectorBar;</a>
										@else
											<a href="{{ route('admin_mentor_list', 'order_by=verified&order_by_asc=desc') }}">&LeftUpVectorBar;</a>
										@endif
									@else
										<a href="{{ route('admin_mentor_list', 'order_by=verified&order_by_asc=desc') }}">&LeftUpVectorBar;</a>
									@endif
								</th>
								<th align="center">Статус аккаунта</th>
								<th width="200px" align="right">Действия</th>
							</thead>
							<tbody>
								@if ($list->count())
									@foreach ($list as $rec)
								
										<tr>
										
											<td><input type="checkbox" name="ids[]" value="{{ $rec->id }}" /></td>
											<td>{{ $rec->id }}</td>
											<td><a href="{{ route('admin_mentor_form', $rec->id) }}">{{ $rec->last_name }} {{ $rec->first_name }} {{ $rec->surname }}</a></td>
											<td>
												<div class="overflow_">{!! $rec->categories !!}</div>
											</td>
											<td>{!! $rec->country !!} / {!! $rec->city !!}</td>
											<td align="center"><a href="mailto:{{ $rec->email }}">{{ $rec->email }}</a></td>
											<td align="center"><a href="tel:{{ $rec->phone }}">{{ $rec->phone }}</a></td>
											<td>
												@if ($rec->verified)
													<span class="badge badge-success">Верифицирован</span>
												@else
													<span class="badge badge-warning">Нет</span>
												@endif											
											</td>
											<td>
												@if ($rec->vip_status)
													<span class="badge badge-danger">VIP</span>
												@else
													<span class="badge badge-info">Обычный</span>
												@endif
											</td>
											<td align="right">
												<a href="{{ route('admin_mentor_view', $rec->id) }}" class="badge badge-success"><i class="mdi mdi-eye"></i></a>
												<a href="{{ route('admin_mentor_form', $rec->id) }}" class="badge badge-info"><i class="remove mdi mdi-pencil"></i></a>
												<a href="{{ route('admin_delete_record', ['mentor', $rec->id]) }}" data-confirm="Удалить ментора {{ $rec->last_name }} {{ $rec->first_name }}?" class="confirm badge badge-danger"><i class="remove mdi mdi-close-circle-outline"></i></a>
											</td>
											
										</tr>
								
									@endforeach
								@else
									<tr>
										<td colspan="15">Нет информации</td>
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
