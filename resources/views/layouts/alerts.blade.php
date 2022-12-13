@if(session()->has('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session()->get('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

@if(session()->has('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session()->get('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

@if(session()->has('info'))
  <div class="alert alert-info alert-dismissible fade show" role="alert">
    {!! session()->get('info') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

@if ($errors->any())
  @foreach ($errors->all() as $error)
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ $error }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endforeach
@endif
