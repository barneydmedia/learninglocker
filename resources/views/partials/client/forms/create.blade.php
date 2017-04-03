<form method="POST" action="/lrs/{{ $lrs->_id }}/client/create">
  <button type="submit" class="btn btn-success" >
  	<i class='icon icon-plus'></i> {{ Lang::get('lrs.client.new_client') }}
  </button>
</form>