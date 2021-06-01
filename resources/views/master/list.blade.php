<ul class="list-group">
    @foreach ($masters as $master)
    <li class="list-group-item">
        <div class="list-bin">
            <div class="list-title">
                {{$master->name}} {{$master->surname}}
            </div>
            <div class="list-btn">
                <a href="{{route('master.edit', $master)}}" class="btn btn-info">
                    Edit
                </a>
                <form method="POST" action="{{route('master.destroy', $master)}}">
                    @csrf
                    <button type="submit" class="btn btn-danger">DELETE</button>
                </form>
            </div>

        </div>
        <div class="list-img">
            @if ($master->portrait)

            <img src="{{$master->portrait}}" alt="{{$master->name}} {{$master->surname}}">
            @else
            <img src="{{asset('portraits/noPhotoAvailable.jpg')}}" alt="{{$master->name}} {{$master->surname}}">
            @endif
        </div>
    </li>
    @endforeach
</ul>
