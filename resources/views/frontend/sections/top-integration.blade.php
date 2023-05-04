<div class="tp-integration__area tp-integration__bg pt-120">
         <div class="tp-integration__title-box text-center">
            <h3 class="tp-section-title">{{ $home->integration->title ?? '' }}</h3>
         </div>
         <div class="tp-integration__wrapper d-none d-md-block p-relative">
            <div class="tp-integration__border-shape">
               <img src="assets/frontend/img/border/border-shapepng.png" alt="">
            </div>
            @foreach($brands as $brandKey => $brand)
               @if($brand->lang == 'integration')
                  <div class="tp-integration__icon int-icon-{{ $brandKey+1 }} wow tpfadeUp" data-wow-duration=".7s" data-wow-delay=".{{ 3+$brandKey }}s">
                     <span><img src="{{ asset($brand->slug) }}" alt=""></span>
                  </div>
               @endif
            @endforeach
            
         </div>
         <div class="tp-integration__bottom p-relative text-center">
            <div class="tp-integration__big-thumb wow tpfadeUp" data-wow-duration=".7s" data-wow-delay="1s">
               <img src="{{ asset($home->integration_cover ?? '') }}" alt="">
            </div>
            <div class="int-icon-bottom int-icon-8 d-none d-md-block wow tpfadeLeft" data-wow-duration=".7s" data-wow-delay=".8">
               <span class="tp-pulse-border z-index"><img src="{{ asset($home->integration_left ?? '') }}" alt=""></span>
            </div>
            <div class="int-icon-bottom int-icon-9 d-none d-md-block wow tpfadeRight" data-wow-duration=".7s" data-wow-delay=".7s">
               <span class="tp-pulse-border z-index"><img src="{{ asset($home->integration_right ?? '') }}" alt=""></span>
            </div>
         </div>
      </div>