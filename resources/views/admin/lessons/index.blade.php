@extends('layouts.admin.layout')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
			<span class="page-title-icon bg-gradient-primary text-white me-2">
				<i class="mdi mdi-home"></i>
			</span>
      {{ $page_title }}
    </h3>
    <a href="{{ route('admin.lessons.add', 0) }}" class="btn btn-success">Добавить</a>
  </div>
  <div class="btn-group">
    <button type="button" data-card="filters" class="btn btn-small btn-primary btn-tabs show_card @if (request('mentor_id')) active @endif">Фильтрация</button>
{{--    <button type="button" data-card="search" class="btn btn-small btn-primary btn-tabs show_card @if (request('search_query'))) active @endif">Поиск в тексте</button>--}}
  </div>
  <div class="row">
    <div class="col-md-12 grid-margin">
      <div class="card">
        @include('admin.components.filter-by-mentor', ['filter_route' => route('admin.lessons.index')])
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
                <th width="250px">Ментор</th>
                <th width="250px">Дата начала</th>
                <th width="250px">Дата конца</th>
                <th width="200px">Описание</th>
                <th width="200px">Стоимость</th>
                <th width="200px">Клиент</th>
                <th width="200px" align="right">Действия</th>
              </thead>
              <tbody>
                @if ($lessons->count())
                  @foreach ($lessons as $lesson)
                    <tr>
                      <td><input type="checkbox" name="ids[]" value="{{ $lesson->id }}" /></td>
                      <td>{{ $lesson->id }}</td>
                      <td>{{ $lesson->mentor->last_name }} {{ $lesson->mentor->first_name }}</td>
                      <td>{{ $lesson->date_start }}</td>
                      <td>{{ $lesson->date_end }}</td>
                      <td>{{ Str::limit($lesson->description, 30) }}</td>
                      <td>{{ $lesson->price }}</td>
                      <td>{{ $lesson->client }}</td>
          
                      <td align="right">
                        <a href="{{ route('admin.lessons.edit', $lesson->id) }}" class="badge badge-info"><i class="remove mdi mdi-pencil"></i></a>
                        <a href="{{ route('admin.lessons.delete', [$lesson->id]) }}" data-confirm="Удалить занятие?" class="confirm badge badge-danger"><i class="remove mdi mdi-close-circle-outline"></i></a>
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
  {{ $lessons->links() }}
@endsection
