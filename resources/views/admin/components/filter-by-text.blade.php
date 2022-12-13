<form action="{{ $filter_route }}">
  <div class="card-body dynamic search @if (!request('search_query')) filter_hide @else shown @endif">
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label>{{ $filter_text ?? 'Поиск по фразе' }}:</label>
          <input type="text" name="search_query" value="{{ request('search_query') ?? '' }}" class="form-control" />
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>&nbsp;</label>
          <button class="btn btn-outline-dark btn-fw form-control">Поиск</button>
        </div>
      </div>
    </div>
  </div>
</form>