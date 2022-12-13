@extends('layouts.admin.layout')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
			<span class="page-title-icon bg-gradient-primary text-white me-2">
				<i class="mdi mdi-flag"></i>
			</span>
      {{ $page_title }}
    </h3>
    <a href="{{ route('admin.mentor_week.index') }}" class="btn btn-dark">Вернуться к списку</a>
  </div>
  <div class="row">
    <div class="col-md-12 grid-margin">
      @include('layouts.alerts')
      <div class="card">
        <div class="card-body">
          <form action="{{ route('admin.mentor_week.update', $mentorWeek->id) }}" method="POST">
            @csrf
            @method('put')
            <div class="form-group">
              <label>Для ментора: *</label>
              <select name="mentor_id" class="select2 form-control-sm form-control">
                <option value="">Выберите</option>
                @if ($mentors->count())
                  @foreach ($mentors as $mentor)
                    <option value="{{ $mentor->id }}" @if ($mentor->id == old('mentor_id', $mentorWeek->mentor_id)) selected @endif>{{ $mentor->last_name }} {{ $mentor->first_name }} {{ $mentor->surname }}</option>
                  @endforeach
                @endif
              </select>
            </div>
            <div class="form-group">
              <label>Для категории: *</label>
              <select name="category_id" class="select2 form-control-sm form-control">
                <option value="">Выберите</option>
                @if ($categories->count())
                  @foreach ($categories as $parent)
                    <optgroup label="{{ $parent->name }}">
                      @foreach($parent->children as $category)
                        <option value="{{ $category->id }}" @if ($category->id == old('category_id', $mentorWeek->category_id)) selected @endif>{{ $category->name }} </option>
                      @endforeach
                    </optgroup>
                  @endforeach
                @endif
              </select>
            </div>
            <div class="form-group">
              <label>Статус: *</label>
              <div class="form-check">
                <label class="form-check-label">
                  <input id="verified0" type="radio" name="is_active" value="0" class="form-check-input" @if(!old('is_active', $mentorWeek->is_active)) checked @endif/>
                  Не активный
                  <i class="input-helper"></i>
                </label>
              </div>
              <div class="form-check">
                <label class="form-check-label">
                  <input id="verified1" type="radio" name="is_active" value="1" class="form-check-input" @if(old('is_active',$mentorWeek->is_active)) checked @endif/>
                  Активный
                  <i class="input-helper"></i>
                </label>
              </div>
            </div>
            <div class="form-group">
              <label>Дата начала: *</label>
              <input type="date" name="date_start" value="{{ old('date_start', $mentorWeek->date_start->format('Y-m-d')) }}" class="form-control" />
            </div>
            <div class="form-group">
              <label>Время начала: *</label>
              <input type="time" name="time_start" value="{{ old('time_start', $mentorWeek->date_end->format('H:i:s')) }}" class="form-control" />
            </div>
            <div class="form-group">
              <label>Дата конца: *</label>
              <input type="date" name="date_end" value="{{ old('date_end', $mentorWeek->date_end->format('Y-m-d')) }}" class="form-control" />
            </div>
            <div class="form-group">
              <label>Время конца: *</label>
              <input type="time" name="time_end" value="{{ old('time_end', $mentorWeek->date_end->format('H:i:s')) }}" class="form-control" />
            </div>
            
            <div class="form-group">
              <button class="btn btn-primary" type="submit" name="return" value="1">Сохранить и выйти</button>
              <button class="btn btn-success" type="submit">Сохранить</button>
              <a href="{{ route('admin.mentor_week.index') }}" class="btn btn-danger">Выйти без сохранения</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
