@extends('layouts.admin.layout')

@section('content')
	<div class="page-header">
		<h3 class="page-title">
			<span class="page-title-icon bg-gradient-primary text-white me-2">
				<i class="mdi mdi-flag"></i>
			</span> 
			{{ $page_title }}
		</h3>
		<a href="{{ route('admin_company_list') }}" class="btn btn-dark">Вернуться к списку</a>
	</div>
			@error('categories')
				<div class="alert alert-warning">{{ $message }}</div>
			@endif
			@error('name')
				<div class="alert alert-warning">{{ $message }}</div>
			@endif
			@error('law_name')
				<div class="alert alert-warning">{{ $message }}</div>
			@endif
			@error('inn')
				<div class="alert alert-warning">{{ $message }}</div>
			@endif
			@error('contact_name')
				<div class="alert alert-warning">{{ $message }}</div>
			@endif
			@error('description')
				<div class="alert alert-warning">{{ $message }}</div>
			@endif
			@if (session('success'))
				<div class="alert alert-success">{{ session('success') }}</div>
			@endif
	<div class="btn-group">
		<button type="button" data-card="general" class="btn btn-small btn-primary btn-tabs show_card active">Общая информация</button>
		<button type="button" data-card="contacts" class="btn btn-small btn-primary btn-tabs show_card">Контакты</button>
		<button type="button" data-card="cv" class="btn btn-small btn-primary btn-tabs show_card">Описание</button>
	</div>
	<div class="row">
		<div class="col-md-12 grid-margin">
			<form action="{{ route('admin_company_form', $id) }}" method="POST" enctype="multipart/form-data" class="form_group_margin company_form">
				<input id="ajax_url" type="hidden" value="{{ route('admin_company_ajax') }}" />
				<input id="show_tab" type="hidden" value="{{ $show_tab }}" />
				@csrf
				<div class="card">
					<div class="card-body dynamic general">						
						<div class="form-group">
							<label>Категории: *</label>
							<select name="categories[]" size="7" multiple class="select2 multiple form-control-sm form-control">
								@if ($list_categories->count())
									@foreach ($list_categories as $rec_list)
										<option value="{{ $rec_list->id }}" @if (in_array($rec_list->id, $cat_list)) selected @endif @if ($rec_list->id == old('parent_id', $rec->parent_id)) selected @endif>{{ $rec_list->name }}</option>
									@endforeach
								@endif
							</select>
						</div>
						<div class="form-group">
							<label>Страна:</label>
							<select name="country_id" class="select2 load_cities form-control-sm form-control">
								<option value="">Не указана</option>
								@if ($list_countries->count())
									@foreach ($list_countries as $rec_country)
										<option value="{{ $rec_country->id }}" @if ($rec_country->id == old('country_id', $rec->country_id)) selected @endif>{{ $rec_country->name }}</option>
									@endforeach
								@endif
							</select>
						</div>
						<div class="form-group">
							<label>Город:</label>
							@if (!$id)
								<select name="city_id" disabled class="form-control-sm form-control">
									<option value="">Выберите сначала страну</option>
								</select>
							@else
								<select name="city_id" class="form-control-sm form-control">
									<option value="">Выберите сначала страну</option>
									@if ($list_cities->count())
										@foreach ($list_cities as $rec_city)
											<option value="{{ $rec_city->id }}" @if ($rec_city->id == old('city_id', $rec->city_id)) selected @endif>{{ $rec_city->name }}</option>
										@endforeach
									@endif
								</select>								
							@endif
						</div>
						<div class="form-group">
							<label>Название: *</label>
							<input type="text" name="name" value="{{ old('name', $rec->name) }}" placeholder="Например: Строительная компания Раз" class="form-control-sm form-control" />
						</div>
						<div class="form-group">
							<label>Юридическое название: *</label>
							<input type="text" name="law_name" value="{{ old('law_name', $rec->law_name) }}" placeholder="" class="form-control-sm form-control" />
						</div>
						<div class="form-group">
							<label>ИНН: *</label>
							<input type="text" name="inn" value="{{ old('inn', $rec->inn) }}" class="form-control-sm form-control" />
						</div>
						<div class="form-group">
							<label>Логотип: </label>
							<input type="file" name="logo" class="form-control" />
						</div>
						@if ($rec->logo)
							<div style="background: #f1f1f1; width: 200px; height: 150px; background-size: cover; background-image: url({{ route('get.avatar', $rec->logo) }});"></div>
						@endif
					</div>
					<div class="card-body dynamic contacts">
						<div class="form-group">
							<label>Контактное лицо:</label>
							<input type="text" name="contact_name" value="{{ old('contact_name', $rec->contact_name) }}" class="form-control" />
						</div>					
						<div class="form-group">
							<label>E-mail:</label>
							<input type="text" name="email" value="{{ old('email', $rec->email) }}" class="form-control" />
						</div>
						<div class="form-group">
							<label>Телефон:</label>
							<input type="phone" name="phone" value="{{ old('phone', $rec->phone) }}" class="form-control" />
						</div>	
						<div class="form-group">
							<label>URL сайта:</label>
							<input type="text" name="website" value="{{ old('website', $rec->website) }}" class="form-control" />
						</div>							
					</div>					
					<div class="card-body dynamic cv">	
						<div class="form-group">
							<label>Описание *:</label>
							<textarea name="description" rows="10" class="form-control">{{ old('description', $rec->description) }}</textarea>
						</div>					
					</div>
				</div>
				<br /><br /> 
				<div class="form-group">
					<input id="redirect" type="hidden" name="redirect" value="true" />
					<button class="btn btn-success">Сохранить и выйти</button>
					<button type="button" name="apply" onclick="document.getElementById('redirect').value = 'false'; form.submit();" class="btn btn-info">Применить</button>
					<a href="{[ route('admin_company_list') }}" class="btn btn-warning">Выйти без сохранения</a>
				</div>
			</form>
		</div>
	</div>
@endsection
