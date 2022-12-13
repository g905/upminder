@extends('layouts.admin.layout')

@section('content')
	<div class="page-header">
		<h3 class="page-title">
			<span class="page-title-icon bg-gradient-primary text-white me-2">
				<i class="mdi mdi-home"></i>
			</span> 
			{{ $page_title }}
		</h3>
		<a href="{{ route('admin_rev_form', 0) }}" class="btn btn-success">Добавить</a>
	</div>
	<div class="btn-group">
		<button type="button" data-card="filters" class="btn btn-small btn-primary btn-tabs show_card @if ($filters['applied']) active @endif">Фильтрация</button>
		<button type="button" data-card="search" class="btn btn-small btn-primary btn-tabs show_card @if (!empty($filters['keyword'])) active @endif">Поиск в тексте</button>
	</div>
	<div class="row">
		<div class="col-md-12 grid-margin">
			<div class="card">
				<form action="{{ route('admin_rev_list') }}">
				<div class="card-body dynamic filters @if (!$filters['applied']) filter_hide @else shown @endif">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label>Ментор:</label>
								<select name="filters[mentor_id]" class="select2 form-control-sm form-control">
									<option value="">Все менторы</option>
									@if ($mentors->count())
										@foreach ($mentors as $mentor)
											<option value="{{ $mentor->id }}" @if ($filters['mentor_id'] == $mentor->id) selected @endif>{{ $mentor->last_name }} {{ $mentor->first_name }} {{ $mentor->surname }}</option>
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
				<form action="{{ route('admin_rev_list') }}">
				<div class="card-body dynamic search @if (empty($filters['keyword'])) filter_hide @else shown @endif">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label>Поиск в тексте отзыва:</label>
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
								<th width="250px">Ментор</th>
								<th width="250px">Автор отзыва</th>
								<th width="250px">Тип</th>
								<th>Текст</th>
								<th width="200px">Статус</th>
								<th width="200px" align="right">Действия</th>
							</thead>
							<tbody>
								@if ($list->count())
									@foreach ($list as $rec)
										<tr>
											<td><input type="checkbox" name="ids[]" value="{{ $rec->id }}" /></td>
											<td>{{ $rec->id }}</td>
											<td>{!! $rec->mentor !!}</td>
											<td>{{ $rec->author }}</td>
											<td>
												@if ($rec->type == 1)
													<span class="badge badge-success">Положительный</span>
												@else
													<span class="badge badge-danger">Негативный</span>
												@endif
											</td>
											<td>{{ $rec->short }}</td>
											<td>
												@if ($rec->active)
													<span class="badge badge-success">Опубликован</span>
												@else
													<span class="badge badge-danger">Не опубликован</span>
												@endif
											</td>
											<td align="right">
												<a href="{{ route('admin_rev_form', $rec->id) }}" class="badge badge-info"><i class="remove mdi mdi-pencil"></i></a>
												<a href="{{ route('admin_delete_record', ['review', $rec->id]) }}" data-confirm="Удалить отзыв?" class="confirm badge badge-danger"><i class="remove mdi mdi-close-circle-outline"></i></a>
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
