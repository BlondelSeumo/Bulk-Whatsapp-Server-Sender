<div class="header pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          @isset($prev)
          <a href="{{ url($prev) }}" class="btn btn-outline-primary btn-sm btn-icon"><i class="fas fa-arrow-left"></i></a>
          @endisset
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links">
              <li class="breadcrumb-item"><a href="{{ url('/login') }}"><i class="fas fa-home"></i></a></li>
              @if(isset($title))
              <li class="breadcrumb-item"><a href="#">{!! $title ?? '' !!}</a></li>
              @endif
              @foreach(request()->segments() as $segment)
              <li class="breadcrumb-item"><a href="#">{{ Str::limit($segment,28) }}</a></li>
              @endforeach
            </ol>
          </nav>
        </div>
        <div class="col-lg-6 col-5 text-right">
          @isset($buttons)
          @foreach($buttons as $button)
          @if(isset($button['is_button']))
          @if($button['is_button'] == true)
          <button type="button" {!! $button['components'] ?? '' !!} class="btn btn-sm btn-neutral">{!! $button['name'] ?? '' !!}</button>
          @else
          <a href="{{ $button['url'] ?? '' }}" {!! $button['components'] ?? '' !!} class="btn btn-sm btn-neutral">{!! $button['name'] ?? '' !!}</a>
          @endif
          @else
          <a href="{{ $button['url'] ?? '' }}" {!! $button['components'] ?? '' !!} class="btn btn-sm btn-neutral">{!! $button['name'] ?? '' !!}</a>
          @endif
          @endforeach
          @endisset
        </div>
      </div>
    </div>
  </div>
</div>