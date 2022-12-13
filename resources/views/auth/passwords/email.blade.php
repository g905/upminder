@extends('layouts.admin.layout')

@section('content')
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <h4>Восстановление пароля</h4>
                <h6 class="font-weight-light">Введите E-mail аккаунта, чтобы продолжить.</h6>
				@error('email')
					<div class="alert alert-warning">{{ $message }}</div>
				@enderror
                <form action="{{ route('password.email') }}" method="POST" class="pt-3">
					@csrf
                  <div class="form-group">
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="E-mail" class="form-control form-control-lg">
                  </div>
                  <div class="mt-3 text-center">
                    <button class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn">Продолжить</button>
					<p></p>
                    <a href="/login" class="btn btn-block btn-warning btn-lg font-weight-medium">Войти в аккаунт</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
