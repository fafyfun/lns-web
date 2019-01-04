
{{ $event->auth->email }} ({{ $event->auth_type }}) <b>created</b> this user {{ $event->created_at->diffForHumans() }}