@extends('layouts.admin.layout')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
			<span class="page-title-icon bg-gradient-primary text-white me-2">
				<i class="mdi mdi-flag"></i>
			</span>
      {{ $page_title }}
    </h3>
    <a href="{{ route('admin.applications.index') }}" class="btn btn-dark">Вернуться к списку</a>
  </div>
  <div class="btn-group">
    @foreach($applications_types as $type)
      <button type="button" data-card="{{ $type->short_code }}"
          class="btn btn-small btn-primary btn-tabs show_card {{ $application->application_type_id == $type->id ? 'active' : '' }}">
        {{ $type->name }}
      </button>
    @endforeach
  </div>
  <div class="row">
    <div class="col-md-12 grid-margin">
      
      <div class="card">
        
        @foreach($applications_types as $type)
          <div class="card-body dynamic {{ $type->short_code }}">
            @include('layouts.alerts')
            
            @if($type->short_code === 'find')
              <form action="{{ route('admin.applications.update', ['application'=>$application->id,'app_type' => $type->id]) }}"
                  method="POST"
                  class="form_group_margin mentor_form">
                @method('PUT')
                @csrf
                <div class="form-group">
                  <label>Почта: *</label>
                  <input type="text" name="email" value="{{ old('email', $application->email) }}" placeholder="test@test.ru" class="form-control-sm form-control" />
                </div>
                <div class="form-group">
                  <label>Фамилия: *</label>
                  <input type="text" name="last_name" value="{{ old('last_name', $application->last_name) }}" placeholder="Например: Иванов" class="form-control-sm form-control" />
                </div>
                <div class="form-group">
                  <label>Имя: *</label>
                  <input type="text" name="first_name" value="{{ old('first_name', $application->first_name) }}" placeholder="" class="form-control-sm form-control" />
                </div>
                <div class="form-group">
                  <label>Отчество: *</label>
                  <input type="text" name="surname" value="{{ old('surname', $application->surname) }}" placeholder="" class="form-control-sm form-control" />
                </div>
                <div class="form-group">
                  <label>Телефон: *</label>
                  <input type="text" name="phone" value="{{ old('phone', $application->phone) }}" class="form-control" />
                </div>
                <div class="form-group">
                  <label>Телеграм: </label>
                  <input type="text" name="telegram" value="{{ old('telegram', $application->telegram) }}" class="form-control" />
                </div>
                <div class="form-group">
                  <label>Способ связи: </label>
                  <select name="communicate_method" size="7" class="select2 form-control-sm form-control">
                    @foreach(config('app.communicate_method') as $id => $type)
                      <option value="{{ $id }}" @if ($id == old('communicate_method', $application->communicate_method)) selected @endif>{{ $type }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Цель консультаци: </label>
                  <textarea name="purpose_mentoring" rows="8" class="visual form-control">{{ old('purpose_mentoring', $application->purpose_mentoring) }}</textarea>
                </div>
                <div class="form-group">
                  <label>Язык: </label>
                  <select name="language_id" size="7" class="select2 form-control-sm form-control">
                    @if ($languages->count())
                      @foreach ($languages as $language)
                        <option value="{{ $language->id }}" @if ($language->id == old('language_id', $application->language_id)) selected @endif>{{ $language->name }}</option>
                      @endforeach
                    @endif
                  </select>
                </div>
                <div class="form-group">
                  <label>Промокод: </label>
                  <input type="text" name="promo_code" value="{{ old('promo_code', $application->promo_code) }}" class="form-control" />
                </div>
                <div class="form-group">
                  <label>Город: </label>
                  <input type="text" name="city" value="{{ old('city', $application->city) }}" class="form-control" />
                </div>
                <div class="form-group">
                  <button class="btn btn-primary" type="submit" name="return" value="1">Сохранить и выйти</button>
                  <button class="btn btn-success" type="submit">Сохранить</button>
                  <a href="{{ route('admin.applications.index') }}" class="btn btn-danger">Выйти без сохранения</a>
                </div>
              </form>
              
            @elseif($type->short_code === 'lesson')
              <form action="{{ route('admin.applications.update', ['application'=>$application->id,'app_type' => $type->id]) }}"
                  method="POST"
                  class="form_group_margin mentor_form">
                @method('PUT')
                @csrf
                <div class="form-group">
                  <label>Для ментора: *</label>
                  <select name="mentor_id" class="select2 form-control-sm form-control">
                    <option value="">Выберите</option>
                    @if ($mentors->count())
                      @foreach ($mentors as $mentor)
                        <option value="{{ $mentor->id }}"
                            @if ($mentor->id == old('mentor_id', $application->mentor_id)) selected @endif>
                          {{ $mentor->last_name }} {{ $mentor->first_name }} {{ $mentor->surname }}
                        </option>
                      @endforeach
                    @endif
                  </select>
                </div>
                <div class="form-group">
                  <label>Почта: *</label>
                  <input type="text" name="email" value="{{ old('email', $application->email) }}" placeholder="" class="form-control-sm form-control" />
                </div>
                <div class="form-group">
                  <label>Фамилия: *</label>
                  <input type="text" name="last_name" value="{{ old('last_name', $application->last_name) }}" placeholder="Например: Иванов" class="form-control-sm form-control" />
                </div>
                <div class="form-group">
                  <label>Имя: *</label>
                  <input type="text" name="first_name" value="{{ old('first_name', $application->first_name) }}" placeholder="" class="form-control-sm form-control" />
                </div>
                <div class="form-group">
                  <label>Телефон: *</label>
                  <input type="text" name="phone" value="{{ old('phone', $application->phone) }}" class="form-control" />
                </div>
                <div class="form-group">
                  <label>Телеграм: </label>
                  <input type="text" name="telegram" value="{{ old('telegram',$application->telegram) }}" class="form-control" />
                </div>
                <div class="form-group">
                  <label>Способ связи: </label>
                  <select name="communicate_method" size="7" class="select2 form-control-sm form-control">
                    @foreach(config('app.communicate_method') as $id => $type)
                      <option value="{{ $id }}" @if ($id == old('communicate_method',$application->communicate_method)) selected @endif>{{ $type }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Цель консультаци: </label>
                  <textarea name="purpose_mentoring" rows="8" class="visual form-control">{{ old('purpose_mentoring', $application->purpose_mentoring) }}</textarea>
                </div>
             
                <div class="form-group">
                  <label>Теги задач: </label>
                  <select name="mentor_tag_id[]" size="7" multiple class="select2 form-control-sm form-control multiple">
                    @foreach($mentor->tags as $tag)
                      <option value="{{ $tag->id }}" @if(in_array($tag->id, old('mentor_tag_id', $application->mentor_tags->pluck('id')->toArray()))  ) selected @endif>{{ $tag->name }}</option>
                    @endforeach
                    
                  </select>
                </div>
                <div class="form-group">
                  <label>Язык: </label>
                  <select name="language_id" size="7" class="select2 form-control-sm form-control">
                    @if ($languages->count())
                      @foreach ($languages as $language)
                        <option value="{{ $language->id }}" @if ($language->id == old('language_id', $application->language_id)) selected @endif>{{ $language->name }}</option>
                      @endforeach
                    @endif
                  </select>
                </div>
                <div class="form-group">
                  <label>Промокод: </label>
                  <input type="text" name="promo_code" value="{{ old('promo_code', $application->promo_code) }}" class="form-control" />
                </div>
                
                <div class="form-group">
                  <label>Услуга: </label>
                  <select name="mentor_service_id" size="7" class="select2 form-control-sm form-control ">
                    @if ($mentors->count())
                      @foreach ($mentors as $mentor)
                        <optgroup label="{{ $mentor->last_name }} {{ $mentor->first_name }} {{ $mentor->surname }}">
                          @foreach($mentor->services as $item)
                            <option value="{{ $item->id }}" @if ($item->id == old('mentor_service_id', $application->mentor_service_id)) selected @endif>{{ $item->service }}</option>
                          @endforeach
                        </optgroup>
                      @endforeach
                    @endif
                  </select>
                </div>
                
                <div class="form-group">
                  <button class="btn btn-primary" type="submit" name="return" value="1">Сохранить и выйти</button>
                  <button class="btn btn-success" type="submit" onclick="">Сохранить</button>
                  <a href="{{ route('admin.applications.index') }}" class="btn btn-danger">Выйти без сохранения</a>
                  <button type="button" name="apply" onclick="document.getElementById('redirect').value = 'false'; form.submit();" class="btn btn-info">Применить</button>
                </div>
              </form>
              
            @elseif($type->short_code ==='mentoring')
              <form action="{{ route('admin.applications.update', ['application'=>$application->id,'app_type' => $type->id]) }}"
                  method="POST"
                  class="form_group_margin mentor_form"
                  onsubmit="return checkSize(2097152)"
                  enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                  <label>Почта: *</label>
                  <input type="text" name="email" value="{{ old('email', $application->email) }}" placeholder="" class="form-control-sm form-control" />
                </div>
                <div class="form-group">
                  <label>Фамилия: *</label>
                  <input type="text" name="last_name" value="{{ old('last_name', $application->last_name) }}" placeholder="Например: Иванов" class="form-control-sm form-control" />
                </div>
                <div class="form-group">
                  <label>Имя: *</label>
                  <input type="text" name="first_name" value="{{ old('first_name', $application->first_name) }}" placeholder="" class="form-control-sm form-control" />
                </div>
                <div class="form-group">
                  <label>Телефон: *</label>
                  <input type="text" name="phone" value="{{ old('phone', $application->phone) }}" class="form-control" />
                </div>
                <div class="form-group">
                  <label>Телеграм: </label>
                  <input type="text" name="telegram" value="{{ old('telegram',$application->telegram) }}" class="form-control" />
                </div>
                <div class="form-group">
                  <label>Способ связи: </label>
                  <select name="communicate_method" size="7" class="select2 form-control-sm form-control">
                    @foreach(config('app.communicate_method') as $id => $type)
                      <option value="{{ $id }}" @if ($id == old('communicate_method',$application->communicate_method)) selected @endif>{{ $type }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Теги задач: </label>
                  <select name="mentor_tag_id[]" size="7" multiple class="select2 form-control-sm form-control multiple">
                    @foreach($category_tags as $tag)
                      <option value="{{ $tag->id }}" @if(in_array($tag->id, old('mentor_tag_id', $application->mentor_tags->pluck('id')->toArray())))  ) selected @endif>{{ $tag->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Язык: </label>
                  <select name="language_id" size="7" class="select2 form-control-sm form-control">
                    @if ($languages->count())
                      @foreach ($languages as $language)
                        <option value="{{ $language->id }}" @if ($language->id == old('language_id',$application->language_id)) selected @endif>{{ $language->name }}</option>
                      @endforeach
                    @endif
                  </select>
                </div>
                <div class="form-group">
                  <label>Часовой пояс: </label>
                  <input type="text" name="timezone" value="{{ old('timezone', $application->timezone) }}" class="form-control" />
                </div>
                <div class="form-group">
                  <label>Ссылка на резюме: </label>
                  <input type="text" name="resume_link" value="{{ old('resume_link', $application->resume_link) }}" class="form-control" />
                </div>
                <div class="form-group">
                  <label>Резюме: </label>
                  <input type="file" name="resume"  value="{{ old('resume', '') }}" class="form-control upload" />
                  @if($application->resume)
                  <div class="mt-3">Документ:
                    <a href="{{ route('admin.download.resume', $application->resume) }}" >Скачать</a></div>
                  @endif
                </div>
                <div class="form-group">
                  <label>Категория: </label>
                  <select name="category_id" size="7" class="select2 form-control-sm form-control ">
                    @foreach($mentor_parent_categories as $parent_cat)
                      <optgroup label="{{ $parent_cat->name }}">
                        @foreach($mentor_categories as $category)
                          @if($category->parent_id == $parent_cat->id)
                            <option value="{{ $category->id }}" @if ($category->id == old('category_id', $application->category_id)) selected @endif>{{ $category->name }}</option>
                          @endif
                        @endforeach
                      </optgroup>
                    @endforeach
                  </select>
                </div>
                
                <div class="form-group">
                  <button class="btn btn-primary" type="submit" name="return" value="1">Сохранить и выйти</button>
                  <button class="btn btn-success" type="submit" onclick="">Сохранить</button>
                  <a href="{{ route('admin.applications.index') }}" class="btn btn-danger">Выйти без сохранения</a>
                  <button type="button" name="apply" onclick="document.getElementById('redirect').value = 'false'; form.submit();" class="btn btn-info">Применить</button>
                </div>
              </form>
              
            @elseif($type->short_code ==='company')
              <form action="{{ route('admin.applications.update', ['application'=>$application->id,'app_type' => $type->id]) }}"
                  method="POST"
                  class="form_group_margin mentor_form">
                @method('PUT')
                @csrf
                <div class="form-group">
                  <label>Почта: *</label>
                  <input type="text" name="email" value="{{ old('email', $application->email) }}" placeholder="" class="form-control-sm form-control" />
                </div>
                <div class="form-group">
                  <label>Фамилия: *</label>
                  <input type="text" name="last_name" value="{{ old('last_name', $application->last_name) }}" placeholder="Например: Иванов" class="form-control-sm form-control" />
                </div>
                <div class="form-group">
                  <label>Имя: *</label>
                  <input type="text" name="first_name" value="{{ old('first_name', $application->first_name) }}" placeholder="" class="form-control-sm form-control" />
                </div>
                <div class="form-group">
                  <label>Телефон: *</label>
                  <input type="text" name="phone" value="{{ old('phone', $application->phone) }}" class="form-control" />
                </div>
                
                <div class="form-group">
                  <label>Название компании: </label>
                  <input type="text" name="law_name" value="{{ old('law_name', $application->law_name) }}" class="form-control" />
                </div>
                <div class="form-group">
                  <label>Инн компании: </label>
                  <input type="text" name="inn" value="{{ old('inn', $application->inn) }}" class="form-control" />
                </div>
                
                <div class="form-group">
                  <button class="btn btn-primary" type="submit" name="return" value="1">Сохранить и выйти</button>
                  <button class="btn btn-success" type="submit" onclick="">Сохранить</button>
                  <a href="{{ route('admin.applications.index') }}" class="btn btn-danger">Выйти без сохранения</a>
                  <button type="button" name="apply" onclick="document.getElementById('redirect').value = 'false'; form.submit();" class="btn btn-info">Применить</button>
                </div>
              </form>
              
            @endif
          </div>
        @endforeach
      </div>
    
    
    </div>
  </div>

@endsection

@push('js')
  <script>
    $(document).ready(function () {
      $(".show_card.active").click();
      
      
    })
  </script>
  <script>
    function checkSize(max_img_size = 2) {
      var input = document.getElementsByClassName("upload");
      // check for browser support (may need to be modified)
      if (input.files && input.files.length == 1)
      {
        if (input.files[0].size > max_img_size)
        {
          alert("The file must be less than " + (max_img_size / 1024 / 1024) + "MB");
          return false;
        }
      }
      
      return true;
    }
  </script>
@endpush
