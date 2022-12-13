@extends('layouts.admin.layout')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
			<span class="page-title-icon bg-gradient-primary text-white me-2">
				<i class="mdi mdi-flag"></i>
			</span>
      {{ $page_title }}
    </h3>
    <a href="{{ route('admin.lessons.index') }}" class="btn btn-dark">Вернуться к списку</a>
  </div>
  <div class="row">
    <div class="col-md-12 grid-margin">
      @include('layouts.alerts')
      <div class="card">
        <div class="card-body">
          <form action="{{ route('admin.lessons.store') }}" method="POST">
            @csrf
            <div class="form-group">
              <label>Для ментора: *</label>
              <select name="mentor_id" class="select2 form-control-sm form-control">
                <option value="">Выберите</option>
                @if ($mentors->count())
                  @foreach ($mentors as $mentor)
                    <option value="{{ $mentor->id }}" @if ($mentor->id == old('mentor_id', $mentor->mentor_id)) selected @endif>{{ $mentor->last_name }} {{ $mentor->first_name }} {{ $mentor->surname }}</option>
                  @endforeach
                @endif
              </select>
            </div>
            <div class="form-group">
              <label>Клиент: *</label>
              <input type="text" name="client" value="{{ old('client' ?? '') }}" placeholder="Например: Иван" class="form-control-sm form-control" />
            </div>
            <div class="form-group">
              <label>Цена: *</label>
              <input type="text" name="price" value="{{ old('price' ?? '') }}" placeholder="" class="form-control-sm form-control" />
            </div>
            <div class="form-group">
              <label>Дата начала: *</label>
              <input type="date" name="date_start" value="" class="form-control" />
            </div>
            <div class="form-group">
              <label>Время начала: *</label>
              <input type="time" name="time_start" value="" class="form-control" />
            </div>
            <div class="form-group">
              <label>Дата конца: *</label>
              <input type="date" name="date_end" value="" class="form-control" />
            </div>
            <div class="form-group">
              <label>Время конца: *</label>
              <input type="time" name="time_end" value="" class="form-control" />
            </div>
            <div class="form-group">
              <label>Описание: *</label>
              <textarea name="description" rows="8" class="visual form-control">{{ old('description') ?? '' }}</textarea>
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit" name="return" value="1">Сохранить и выйти</button>
              <button class="btn btn-success" type="submit">Сохранить</button>
              <a href="{{ route('admin.lessons.index') }}" class="btn btn-danger">Выйти без сохранения</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
