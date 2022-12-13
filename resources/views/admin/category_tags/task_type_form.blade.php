@extends('layouts.admin.layout')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
			<span class="page-title-icon bg-gradient-primary text-white me-2">
				<i class="mdi mdi-flag"></i>
			</span>
      {{ $page_title }}
    </h3>
    <a href="{{ route('admin_task_type_list') }}" class="btn btn-dark">Вернуться к списку</a>
  </div>
  <div class="row">
    <div class="col-md-12 grid-margin">
      @error('category_id')
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
          <form action="{{ route('admin_task_type_form', $id) }}" method="POST">
            @csrf
            <div class="form-group">
              <label>Категория: *</label>
              <select name="category_id" class="select2 form-control-sm form-control">
                <option value="">Выберите</option>
                @foreach($parent_categories as $parent)
                  <optgroup label="{{ $parent->name }}">
                    @foreach ($parent->children as $rec_list)
                      <option value="{{ $rec_list->id }}" @if ($rec_list->id == old('category_id', $rec->category_id)) selected @endif>{{ $rec_list->name }}</option>
                    @endforeach
                  </optgroup>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Название: *</label>
              <input type="text" name="name" value="{{ old('name', $rec->name) }}" placeholder="Например: телеграм бот" class="form-control-sm form-control" />
            </div>
            <div class="form-group">
              <label>Фильтр: *</label>
              <div class="form-check">
                <label class="form-check-label">
                  <input id="verified0" type="radio" name="is_filter" value="0" class="form-check-input" @if(!$rec->is_filter) checked @endif/>
                    Не используется
                  <i class="input-helper"></i>
                </label>
              </div>
              <div class="form-check">
                <label class="form-check-label">
                  <input id="verified1" type="radio" name="is_filter" value="1" class="form-check-input" @if($rec->is_filter) checked @endif/>
                    Используется
                  <i class="input-helper"></i>
                </label>
              </div>
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
