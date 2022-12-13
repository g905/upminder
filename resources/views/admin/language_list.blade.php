@extends('layouts.admin.layout')

@section('content')
	<div class="page-header">
		<h3 class="page-title">
			<span class="page-title-icon bg-gradient-primary text-white me-2">
				<i class="mdi mdi-flag"></i>
			</span> 
			{{ $page_title }}
		</h3>
		<a href="{{ route('admin_language_form', 0) }}" class="btn btn-success">Добавить</a>
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
								<th>Язык</th>
								<th width="200px" align="right">Действия</th>
							</thead>
							<tbody>
								@if ($list->count())
									@foreach ($list as $rec)
										<tr>
											<td><input type="checkbox" name="ids[]" value="{{ $rec->id }}" /></td>
											<td>{{ $rec->id }}</td>
											<td>{{ $rec->name }}</td>
											<td align="right">
												<a href="{{ route('admin_language_form', $rec->id) }}" class="badge badge-info"><i class="remove mdi mdi-pencil"></i></a>
												<a href="{{ route('admin_delete_record', ['language', $rec->id]) }}" data-confirm="Удалить язык {{ $rec->name }}?" class="confirm badge badge-danger"><i class="remove mdi mdi-close-circle-outline"></i></a>
											</td>
										</tr>
									@endforeach
								@else
									<tr>
										<td colspan="3">Нет информации</td>
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
