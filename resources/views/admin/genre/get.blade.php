<option value="all">All Genre</option>
@foreach($genres as $genre)
        <option value="{{ $genre->id }}">{{ $genre->name }}</option>
@endforeach
