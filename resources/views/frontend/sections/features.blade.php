 @php
 $features = \App\Models\Post::where('type','feature')
            ->where('featured',1)
            ->where('status',1)
            ->where('lang',app()->getLocale())
            ->with('preview','excerpt')
            ->latest()
            ->take($limit ?? 3)
            ->get();
 @endphp

 @foreach($features as $feature)
 <div class="col-xl-4 col-lg-4 col-md-6 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".5s">
   <div class="tp-service__item tp-service__inner-item service-inner mb-20">
      <div class="tp-service__icon">
         <img src="{{ asset($feature->preview->value ?? '') }}" alt="">
      </div> 
      <div class="tp-service__content">
         <h4 class="tp-service__title-sm"><a href="{{ url('feature/'.$feature->slug) }}">{{ Str::limit($feature->title,20) }}</a></h4>
         <p>{{  Str::limit($feature->excerpt->value ?? '',100) }}</p>
      </div>
      <div class="tp-service__link">
         <a href="{{ url('feature/'.$feature->slug) }}">
            <svg width="39" height="16" viewBox="0 0 39 16" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path d="M38.7071 8.70711C39.0976 8.31658 39.0976 7.68342 38.7071 7.29289L32.3431 0.928932C31.9526 0.538408 31.3195 0.538408 30.9289 0.928932C30.5384 1.31946 30.5384 1.95262 30.9289 2.34315L36.5858 8L30.9289 13.6569C30.5384 14.0474 30.5384 14.6805 30.9289 15.0711C31.3195 15.4616 31.9526 15.4616 32.3431 15.0711L38.7071 8.70711ZM0 9H38V7H0V9Z" fill="currentColor"/>
            </svg>
         </a>
      </div> 
   </div>
</div>
@endforeach
