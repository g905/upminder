@extends('layouts.admin.layout')

@section('content')
	<div class="page-header">
		<h3 class="page-title">
			<span class="page-title-icon bg-gradient-primary text-white me-2">
				<i class="mdi mdi-flag"></i>
			</span> 
			{{ $page_title }}
		</h3>
		<a href="{{ route('admin_mentor_form', 0) }}" class="btn btn-success">Добавить ментора</a>
		<a href="{{ route('admin_mentor_form', $rec->id) }}" class="btn btn-info">Редактировать ментора</a>
		<a href="{{ route('admin_mentor_list') }}" class="btn btn-dark">Вернуться к списку</a>
	</div>
	<div class="row">
		<div class="col-md-12 grid-margin">
			@error('name')
				<div class="alert alert-warning">{{ $message }}</div>
			@endif
			@if (session('success'))
				<div class="alert alert-success">{{ session('success') }}</div>
			@endif
			<form action="javascript:void(0);" method="POST" onsubmit="return false;" class="tabs_shown print form_group_margin mentor_form">
				<input id="ajax_url" type="hidden" value="{{ route('admin_mentor_ajax') }}" />
				<input id="show_tab" type="hidden" value="{{ $show_tab }}" />
				@csrf
				<div class="card">
					<div class="card-body dynamic general">
						<h3>Общая информация</h3>
						<br />
						<div class="form-group">
							<label>Категории: *</label>
							<select name="categories[]" size="7" multiple class="multiple form-control-sm form-control">
								@if ($list_categories->count())
									@foreach ($list_categories as $rec_list)
										<option value="{{ $rec_list->id }}" @if (in_array($rec_list->id, $cat_list)) selected @endif @if ($rec_list->id == old('parent_id', $rec->parent_id)) selected @endif>{{ $rec_list->name }}</option>
									@endforeach
								@endif
							</select>
						</div>
						<div class="form-group">
							<label>Страна:</label>
							<select name="country_id" class="load_cities form-control-sm form-control">
								<option value="">Не указан</option>
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
							<label>Фамилия: *</label>
							<input type="text" name="last_name" value="{{ old('last_name', $rec->last_name) }}" placeholder="Например: Иванов" class="form-control-sm form-control" />
						</div>
						<div class="form-group">
							<label>Имя: *</label>
							<input type="text" name="first_name" value="{{ old('first_name', $rec->first_name) }}" placeholder="Например: Иван" class="form-control-sm form-control" />
						</div>
						<div class="form-group">
							<label>Отчество:</label>
							<input type="text" name="surname" value="{{ old('surname', $rec->surname) }}" placeholder="Например: Петрович" class="form-control-sm form-control" />
						</div>
						<div class="form-group">
							<label>Профиль активен?</label>
							<div class="form-check">
								<label class="form-check-label">
									<input @if (old('verified', $rec->verified) == 1) checked @endif id="verified1" type="radio" name="verified" value="1" class="form-check-input" />
									Да, активен
									<i class="input-helper"></i>
								</label>
							</div>
							<div class="form-check">
								<label class="form-check-label">
									<input @if (old('verified', $rec->verified) == 0) checked @endif id="verified0" type="radio" name="verified" value="0" class="form-check-input" />
									Нет, не активен
									<i class="input-helper"></i>
								</label>
							</div>
						</div>
						<br />
						<div class="form-group">
							<label>VIP аккаунт?</label>
							<div class="form-check">
								<label class="form-check-label">
									<input @if (old('vip_status', $rec->vip_status) == 1) checked @endif id="vip_status1" type="radio" name="vip_status" value="1" class="form-check-input" />
									Да, аккаунт VIP
									<i class="input-helper"></i>
								</label>
							</div>
							<div class="form-check">
								<label class="form-check-label">
									<input @if (old('vip_status', $rec->vip_status) == 0) checked @endif id="vip_status0" type="radio" name="vip_status" value="0" class="form-check-input" />
									Нет, обычный аккаунт
									<i class="input-helper"></i>
								</label>
							</div>
						</div>
					</div>
					<div class="card-body dynamic contacts">
						<h3>Контакты</h3>
						<div class="form-group">
							<label>E-mail:</label>
							<input type="email" name="email" value="{{ old('email', $rec->email) }}" class="form-control" />
						</div>
						<div class="form-group">
							<label>Телефон:</label>
							<input type="phone" name="phone" value="{{ old('phone', $rec->phone) }}" class="form-control" />
						</div>					
					</div>					
					<div class="card-body dynamic cv">
						<h3>Резюме</h3>
						<div class="form-group">
							<label>Описание *:</label>
							<textarea name="description" rows="10" class="form-control">{{ old('description', $rec->description) }}</textarea>
						</div>
						<div class="form-group">
							<label>Чем могу помочь *:</label>
							<textarea name="help_text" rows="10" class="form-control">{{ old('help_text', $rec->help_text) }}</textarea>
						</div>					
					</div>
					<div class="card-body dynamic education">
						<h3>Образование и языки</h3>
						<a href="javascript:void(0);" data-tpl="education_tpl" data-row="row_education" class="add_row btn btn-warning">Добавить ещё</a>
						<br /><br />
						<div id="education_tpl" class="row row_education0 row_education row_tpl">
							<div class="col-md-3">
								<div class="form-group">
									<label>Дата начала: *</label>  
									<input type="date" name="education_date_start[]" value="" class="form-control" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Дата окончания: *</label>
									<input type="date" name="education_date_end[]" value="" class="form-control" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Учебное заведение: *</label>
									<input type="text" name="education_school[]" value="" class="form-control" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Название курса: *</label>
									<input type="text" name="education_course[]" value="" class="form-control minus_button" />
									<a href="javascript:void(0);" data-row="row_education0" class="badge badge-danger delete_row btn_row"><i class="remove mdi mdi-close-circle-outline"></i></a>
								</div>
							</div>
						</div>
						@if ($id > 0)
							@if ($edu_list->count())
								@foreach ($edu_list as $kk => $edu)
									<div class="row row_education{{ $kk + 1 }} row_education">
										<div class="col-md-3">
											<div class="form-group">
												<label>Дата начала: *</label>  
												<input type="date" name="education_date_start[]" value="{{ $edu->date_start }}" class="form-control" />
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label>Дата окончания: *</label>
												<input type="date" name="education_date_end[]" value="{{ $edu->date_end }}" class="form-control" />
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label>Учебное заведение: *</label>
												<input type="text" name="education_school[]" value="{{ $edu->school }}" class="form-control" />
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label>Название курса: *</label>
												<input type="text" name="education_course[]" value="{{ $edu->course }}" class="form-control minus_button" />
												<a href="javascript:void(0);" data-row="row_education{{ $kk + 1 }}" class="badge badge-danger delete_row btn_row"><i class="remove mdi mdi-close-circle-outline"></i></a>
											</div>
										</div>
									</div>
								@endforeach
							@endif
						@endif
						<div class="form-group">
							<label>Знание языков: *</label>
							<select name="languages[]" size="7" multiple class="multiple form-control-sm form-control">
								@if ($list_languages->count())
									@foreach ($list_languages as $rec_lang)
										<option value="{{ $rec_lang->id }}" @if (in_array($rec_lang->id, $lang_list)) selected @endif>{{ $rec_lang->name }}</option>
									@endforeach
								@endif
							</select>
						</div>
					</div>
					<div class="card-body dynamic experience">
						<h3>Опыт работы</h3>
						<a href="javascript:void(0);" data-tpl="experience_tpl" data-row="row_experience" class="add_row btn btn-warning">Добавить ещё</a>
						<br /><br />
						<div id="experience_tpl" class="row row_experience0 row_experience row_tpl">
							<div class="col-md-3">
								<div class="form-group">
									<label>Дата начала: *</label>  
									<input type="date" name="experience_date_start[]" value="" class="form-control" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Дата окончания: *</label>
									<input type="date" name="experience_date_end[]" value="" class="form-control" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Компания: *</label>
									<input type="text" name="experience_company[]" value="" class="form-control" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Должность: *</label>
									<input type="text" name="experience_position[]" value="" class="form-control minus_button" />
									<a href="javascript:void(0);" data-row="row_experience0" class="badge badge-danger delete_row btn_row"><i class="remove mdi mdi-close-circle-outline"></i></a>
								</div>
							</div>
						</div>
						@if ($id > 0)
							@if ($exp_list->count())
								@foreach ($exp_list as $kk => $exp)
									<div class="row row_experience{{ $kk + 1 }} row_experience">
										<div class="col-md-3">
											<div class="form-group">
												<label>Дата начала: *</label>  
												<input type="date" name="experience_date_start[]" value="{{ $exp->date_start }}" class="form-control" />
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label>Дата окончания: *</label>
												<input type="date" name="experience_date_end[]" value="{{ $exp->date_end }}" class="form-control" />
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label>Компания: *</label>
												<input type="text" name="experience_company[]" value="{{ $exp->company }}" class="form-control" />
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label>Должность: *</label>
												<input type="text" name="experience_position[]" value="{{ $exp->position }}" class="form-control minus_button" />
												<a href="javascript:void(0);" data-row="row_experience{{ $kk + 1 }}" class="badge badge-danger delete_row btn_row"><i class="remove mdi mdi-close-circle-outline"></i></a>
											</div>
										</div>
									</div>
								@endforeach
							@endif
						@endif
					</div>
					<div class="card-body dynamic services">
						<h3>Услуги</h3>	
						<a href="javascript:void(0);" data-tpl="service_tpl" data-row="row_service" class="add_row btn btn-warning">Добавить ещё</a>
						<br /><br />
						<div id="service_tpl" class="row row_service0 row_service row_tpl">
							<div class="col-md-3">
								<div class="form-group">
									<label>Название услуги: *</label>  
									<input type="text" name="service_service[]" value="" class="form-control" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Валюта: *</label>
									<select name="service_currency_id[]" class="form-control-sm form-control">
										@if ($list_currencies->count())
											@foreach ($list_currencies as $rec_curr)
												<option value="{{ $rec_curr->id }}">{{ $rec_curr->name }}</option>
											@endforeach
										@endif
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Цена в выбранной валюте: *</label>
									<input type="text" name="service_price[]" value="" class="form-control" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Скидка в %: *</label>
									<input type="text" name="service_discount[]" value="" class="form-control" />
									<a href="javascript:void(0);" data-row="row_service0" class="badge badge-danger delete_row btn_row"><i class="remove mdi mdi-close-circle-outline"></i></a>
								</div>
							</div>
						</div>
						@if ($id > 0)
							@if ($services_list->count())
								@foreach ($services_list as $kk => $serv)
									<div class="row row_service{{ $kk + 1 }} row_service">
										<div class="col-md-3">
											<div class="form-group">
												<label>Название услуги: *</label>  
												<input type="text" name="service_service[]" value="{{ $serv->service }}" class="form-control" />
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label>Валюта: *</label>
												<select name="service_currency_id[]" class="form-control-sm form-control">
													@if ($list_currencies->count())
														@foreach ($list_currencies as $rec_curr)
															<option value="{{ $rec_curr->id }}" @if ($serv->currency_id == $rec_curr->id) selected @endif>{{ $rec_curr->name }}</option>
														@endforeach
													@endif
												</select>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label>Цена в выбранной валюте: *</label>
												<input type="text" name="service_price[]" value="{{ $serv->price }}" class="form-control" />
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label>Скидка в %: *</label>
												<input type="text" name="service_discount[]" value="{{ $serv->discount }}" class="form-control minus_button" />
												<a href="javascript:void(0);" data-row="row_service0" class="badge badge-danger delete_row btn_row"><i class="remove mdi mdi-close-circle-outline"></i></a>
											</div>
										</div>
									</div>
								@endforeach
							@endif
						@endif
					</div>
				</div>
				<br /><br />
			</form>
		</div>
	</div>
@endsection
