@extends('layouts.admin.layout')

@section('content')
	<div class="page-header">
		<h3 class="page-title">
			<span class="page-title-icon bg-gradient-primary text-white me-2">
				<i class="mdi mdi-home"></i>
			</span> 
			{{ $page_title }}
		</h3>
		<a href="{{ route('admin_page_form', 0) }}" class="btn btn-success">Добавить</a>
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
											<a href="{{ route('admin_page_list', 'order_by=id&order_by_asc=asc') }}">&LeftDownVectorBar;</a>
										@else
											<a href="{{ route('admin_page_list', 'order_by=id&order_by_asc=desc') }}">&LeftUpVectorBar;</a>
										@endif
									@else
										<a href="{{ route('admin_page_list', 'order_by=id&order_by_asc=desc') }}">&LeftUpVectorBar;</a>
									@endif
								</th>
								<th width="250px">
									Заголовок
									@if ($order_by == 'title')
										@if ($order_by_asc == 'desc')
											<a href="{{ route('admin_page_list', 'order_by=title&order_by_asc=asc') }}">&LeftDownVectorBar;</a>
										@else
											<a href="{{ route('admin_page_list', 'order_by=title&order_by_asc=desc') }}">&LeftUpVectorBar;</a>
										@endif
									@else
										<a href="{{ route('admin_page_list', 'order_by=title&order_by_asc=desc') }}">&LeftUpVectorBar;</a>
									@endif	
								</th>
								<th width="250px">URL</th>
								<th align="center">Доступна</th>
								<th width="200px" align="right">Действия</th>
							</thead>
							<tbody>
								@if ($list->count())
									@foreach ($list as $rec)
								
										<tr>
										
											<td><input type="checkbox" name="ids[]" value="{{ $rec->id }}" /></td>
											<td>{{ $rec->id }}</td>
											<td><a href="{{ route('admin_page_form', $rec->id) }}">{{ $rec->title }}</a></td>
											<td><a href="/{{ $rec->slug }}">{{ $rec->slug }}</a></td>
											<td>
												@if ($rec->active)
													<span class="badge badge-success">Доступна</span>
												@else
													<span class="badge badge-warning">Недоступна</span>
												@endif											
											</td>
											<td align="right">
												<a href="{{ route('admin_page_form', $rec->id) }}" class="badge badge-info"><i class="remove mdi mdi-pencil"></i></a>
												<a href="{{ route('admin_delete_record', ['page', $rec->id]) }}" data-confirm="Удалить страницу {{ $rec->title }}?" class="confirm badge badge-danger"><i class="remove mdi mdi-close-circle-outline"></i></a>
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
