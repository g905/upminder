<form action="{{ $filter_route }}">
  <div class="card-body dynamic filters @if (!request('mentor_id')) filter_hide @else shown @endif">
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label>Ментор:</label>
          <select name="mentor_id" class="select2 form-control-sm form-control">
            <option value="">Все менторы</option>
            @if ($mentors->count())
              @foreach ($mentors as $mentor)
                <option value="{{ $mentor->id }}"
                    @if (request('mentor_id') == $mentor->id) selected="selected" @endif>
                  {{ $mentor->last_name }} {{ $mentor->first_name }} {{ $mentor->surname }}
                </option>
              @endforeach
            @endif
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>&nbsp;</label>
          <button class="btn btn-outline-dark btn-fw form-control">Применить</button>
        </div>
      </div>
    </div>
  </div>
</form>