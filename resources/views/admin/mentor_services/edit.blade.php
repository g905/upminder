@extends('layouts.admin.layout')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
			<span class="page-title-icon bg-gradient-primary text-white me-2">
				<i class="mdi mdi-flag"></i>
			</span>
      {{ $page_title }}
    </h3>
    <a href="{{ route('admin.mentor_services.index') }}" class="btn btn-dark">Вернуться к списку</a>
  </div>
  <div class="row">
    <div class="col-md-12 grid-margin">
      @include('layouts.alerts')
      <div class="card">
        <div class="card-body">
          <form action="{{ route('admin.mentor_services.update', $mentor_service->id) }}" method="POST">
            @csrf
            @method('put')
            <div class="form-group">
              <label>Услуга: *</label>
              <select name="type_service" class="select2 form-control-sm form-control">
                <option value="">Выберите</option>
                @if (count($service_types))
                  @foreach ($service_types as $index => $item)
                    <option value="{{ $index  }}" @if ($index == old('type_service', $mentor_service->type_service)) selected @endif>
                      @if($item == 'main')
                        Основная
                      @else
                        Дополнительная
                      @endif
                    </option>
                  @endforeach
                @endif
              </select>
            </div>
            <div class="form-group">
              <label>Название: *</label>
              <input type="text" name="name" value="{{ old('name', $mentor_service->name) }}" placeholder="Например: Иванов" class="form-control-sm form-control" />
            </div>
            
            
            <div class="form-group">
              <button class="btn btn-primary" type="submit" name="return" value="1">Сохранить и выйти</button>
              <button class="btn btn-success" type="submit">Сохранить</button>
              <a href="{{ route('admin.mentor_services.index') }}" class="btn btn-danger">Выйти без сохранения</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
