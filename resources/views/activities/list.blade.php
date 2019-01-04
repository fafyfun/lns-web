@foreach ($activity as $event)
    <li class="list-group-item">
        @include ("activities.types.{$event->name}")
    </li>
@endforeach