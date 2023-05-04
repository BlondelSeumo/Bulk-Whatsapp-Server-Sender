@if(Request::is('admin/*'))

 @include('layouts.main.admin')

@else

 @include('layouts.main.user')

@endif