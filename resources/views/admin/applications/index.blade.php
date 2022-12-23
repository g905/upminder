@extends('layouts.admin.layout')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
			<span class="page-title-icon bg-gradient-primary text-white me-2">
				<i class="mdi mdi-home"></i>
			</span>
      {{ $page_title }}
    </h3>
    <a href="{{ route('admin.applications.add') }}" class="btn btn-success">Добавить</a>
  </div>
  <div class="btn-group">
    <button type="button" data-card="filters" class="btn btn-small btn-primary btn-tabs show_card @if (request('mentor_id')) active @endif">Фильтрация</button>
    {{--    <button type="button" data-card="search" class="btn btn-small btn-primary btn-tabs show_card @if (request('search_query'))) active @endif">Поиск в тексте</button>--}}
  </div>
  <div class="row">
    <div class="col-md-12 grid-margin">
      <div class="card">
        @include('admin.components.filter-by-mentor', ['filter_route' => route('admin.applications.index')])
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 grid-margin">
      @include('layouts.alerts')
      <div class="card">
        <div class="card-body table">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <th width="36px"><input type="checkbox" class="select_all" /></th>
                <th width="36px">ID</th>
                <th width="250px">ФИО</th>
                <th width="200px">Тип заявки</th>
                <th width="200px">Статус</th>
                <th width="200px">Дата</th>
                <th width="200px" align="right">Действия</th>
              </thead>
              <tbody>
                @if ($applications->count())
                  @foreach ($applications as $application)
                    <tr>
                      <td><input type="checkbox" name="ids[]" value="{{ $application->id }}" /></td>
                      <td>{{ $application->id }}</td>
                      <td>{{ $application->last_name }} {{ $application->first_name }}</td>
                      <td>{{ $application->type->name }}</td>
                      <td>
                        @if(!$application->is_checked)
                          <span class="badge badge-gradient-dark">Не просмотрено</span>
                        @endif
                        @if($application->is_done)
                          <span class="badge badge-success">Обработана</span>
                        @else
                          <span class="badge badge-danger">Не обработана</span>
                        @endif
                      </td>
                      <td>{{ $application->created_at->format("d.m.Y H:i:s") }}</td>
                      
                      <td align="right">
                        <a href="{{ route('admin.applications.edit', [$application->id]) }}" class="badge badge-info">
                          <i class="remove mdi mdi-pencil"></i></a>
                        <a href="{{ route('admin.applications.delete', [$application->id]) }}" data-confirm="Удалить занятие?" class="confirm badge badge-danger">
                          <i class="remove mdi mdi-close-circle-outline"></i></a>
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
  {{ $applications->links() }}
@endsection
