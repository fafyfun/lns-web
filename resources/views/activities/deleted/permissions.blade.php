
@foreach ($linkCollection as $key => $value)
    <li class="list-group-item">
        <a class="link" href='{{ $value }}'>{{ $key }}</a>
    </li>
@endforeach


