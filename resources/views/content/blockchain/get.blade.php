<option value="all">All Blockchain</option>
@foreach($blockchains as $blockchain)
        <option value="{{ $blockchain->id }}">{{ $blockchain->name }}</option>
@endforeach
