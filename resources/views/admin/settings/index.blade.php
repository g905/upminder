@extends('layouts.admin.layout')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
			<span class="page-title-icon bg-gradient-primary text-white me-2">
				<i class="mdi mdi-flag"></i>
			</span>
      {{ $page_title }}
    </h3>
    <a href="{{ route('admin') }}" class="btn btn-dark">Вернуться на главную</a>
  </div>
  <div class="row">
    <div class="col-md-12 grid-margin">
      @include('layouts.alerts')
      <div class="card">
        <div class="card-body">
            @if($settings->count() > 0)
              <table class="table table-striped table-bordered mt-4">
                <thead>
                  <tr>
                    <th scope="col">{{ __('Ключ') }}</th>
                    <th scope="col">{{ __('Значение') }}</th>
                    <th scope="col">{{ __('Действия') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($settings as $setting)
                    <form action="{{ route('admin.settings.update', ['id' => $setting->id]) }}" method="POST" target="_top">
                      {{ csrf_field() }}
                      <tr>
                        <td>
                          <input type="text" class="form-control" name="settings[s_key]" placeholder="{{ __('key') }}" value="{{ $setting->s_key }}">
                        </td>
                        <td>
                          <input type="text" class="form-control" name="settings[s_value]" placeholder="{{ __('value') }}" value="{{ $setting->s_value }}">
                        </td>
                        <td>
                          <input type="submit" class="btn btn-primary" value="{{ __('Сохранить') }}">
                          <input type="button" class="btn btn-danger" value="{{ __('Удалить') }}" onClick="sureAndRedirect(this, '{{ route('admin.settings.destroy', ['id' => $setting->id]) }}')">
                        </td>
                      </tr>
                    </form>
                  @endforeach
                </tbody>
              </table>
    
              {!! $settings->appends(request()->input())->links() !!}
            @else
              <div class="alert alert-secondary" role="alert" style="margin-top:30px;">
                <div class="iq-alert-icon">
                  <i class="ri-information-line"></i>
                </div>
                <div class="iq-alert-text">{{ __('No_variables_found') }}</div>
              </div>
            @endif
     
        </div>
      </div>
    </div>
  </div>
@endsection
