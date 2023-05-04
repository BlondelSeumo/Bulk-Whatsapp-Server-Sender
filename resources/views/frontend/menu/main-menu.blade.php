@if(!empty($data))
	@foreach ($data['data'] ?? []  as $row)
		@if (isset($row->children))
		<li>
            <a href="#">{{ $row->text }}</a>
			<ul class="submenu">
			 @foreach($row->children as $childrens)
			 	@include('frontend.menu.submenu', ['childrens' => $childrens])
			 @endforeach
			</ul>
		</li>
		@else
		<li>
			<a href="{{ url($row->href ?? '') }}" @if(!empty($row->target)) target="{{ $row->target }}" @endif>{{ $row->text ?? '' }}</a>
		</li>
		@endif
	@endforeach
@endif