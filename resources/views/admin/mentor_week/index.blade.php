@extends('layouts.admin.layout')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
			<span class="page-title-icon bg-gradient-primary text-white me-2">
				<i class="mdi mdi-home"></i>
			</span>
      {{ $page_title }}
    </h3>
    <a href="{{ route('admin.mentor_week.add', 0) }}" class="btn btn-success">Добавить</a>
  </div>
  <div class="btn-group">
    <button type="button" data-card="filters" class="btn btn-small btn-primary btn-tabs show_card @if (request('mentor_id')) active @endif">Фильтрация</button>
    {{--    <button type="button" data-card="search" class="btn btn-small btn-primary btn-tabs show_card @if (request('search_query'))) active @endif">Поиск в тексте</button>--}}
  </div>
  <div class="row">
    <div class="col-md-12 grid-margin">
      <div class="card">
        @include('admin.components.filter-by-mentor', ['filter_route' => route('admin.mentor_week.index')])
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
                <th width="200px">Категория</th>
                <th width="250px">Дата начала</th>
                <th width="250px">Дата конца</th>
                <th width="250px">Статус</th>
                <th width="200px" align="right">Действия</th>
              </thead>
              <tbody>
                @if ($mentor_week->count())
                  @foreach ($mentor_week as $item)
                    <tr>
                      <td><input type="checkbox" name="ids[]" value="{{ $item->id }}" /></td>
                      <td>{{ $item->id }}</td>
                      <td>{{ $item->mentor->last_name }} {{ $item->mentor->first_name }}</td>
                      <td>
                        <div class="mb-2">
                          <span class="badge badge-dark">{{ $item->category->parent->name }}</span>
                        </div>
                        {{ $item->category->name }}
                      </td>
                      <td>
                        <div class="mb-2">{{ $item->date_start->format('d.m.Y') }}</div>
                        <div>{{ $item->date_start->format('H:i:s') }}</div>
                      </td>
                      <td>
                       <div class="mb-2">{{ $item->date_end->format('d.m.Y') }}</div>
                        <div>{{ $item->date_end->format('H:i:s') }}</div>
                      </td>
                      <td>
                        @if($item->is_active)
                          <span class="badge badge-success">Активный</span>
                        @else
                          <span class="badge badge-danger">Не активный</span>
                        @endif
                      </td>
                      
                      <td align="right">
                        <a href="{{ route('admin.mentor_week.edit', $item->id) }}" class="badge badge-info">
                          <i class="remove mdi mdi-pencil"></i></a>
                        <a href="{{ route('admin.mentor_week.delete', [$item->id]) }}" data-confirm="Удалить занятие?" class="confirm badge badge-danger">
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
  {{ $mentor_week->links() }}
@endsection
