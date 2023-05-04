 <div id="price" class="tp-price__area tp-price__border pt-120 pb-90 ">
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-lg-6 col-10">
            <div class="tp-price__section text-center pb-60 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".3s">
               <h3 class="tp-section-title-sm pb-20">{{ __('Pricing to suite all size of business') }}</h3>
               <span>{{ __('*We help companies of all sizes') }}</span>
            </div>
         </div>
      </div>
      <div class="row g-0 align-items-end align-items-lg-center">
         @foreach($plans ?? [] as $plan)
         <div class="col-xl-4 col-lg-4 col-md-6 mb-30 wow tpfadeLeft" data-wow-duration=".9s" data-wow-delay=".5s">
            <div class="tp-price__item {{ $plan->is_recommended == 1 ? 'tp-price__active z-index' : '' }}">
               <div class="tp-price__icon d-flex justify-content-between align-items-center">
                  <span class="icon {{ $plan->labelcolor }}"><i class="{{ $plan->iconname }}"></i></span>
                  <span>{{ $plan->title }} </span>
               </div>
               <h3 class="tp-price__title">{{ amount_format($plan->price,'icon') }} <small class="tp-price__small_title">{{ $plan->days == 30 ? '/month' : '/year' }}</small></h3>
               <div class="tp-price__list">
                  <ul>
                     @foreach($plan->data ?? [] as $key => $data)
                     <li class="{{ planData($key,$data)['value'] == false && planData($key,$data)['is_bool'] == true ? 'd-none' : '' }}">

                        {{ ucfirst(str_replace('_',' ',planData($key,$data)['title'])) }}
                     </li>
                     @endforeach
                  </ul>
               </div>
               <div class="tp-price__btn">
                  <a class="tp-btn-border" href="{{ url('/register',$plan->id) }}"><span>{{ $plan->is_trial == 1 ? __('Free '.$plan->trial_days.' days trial') : __('Sign Up Now') }}</span></a>
               </div>
            </div>
         </div>
         @endforeach
      </div>
   </div>
</div>