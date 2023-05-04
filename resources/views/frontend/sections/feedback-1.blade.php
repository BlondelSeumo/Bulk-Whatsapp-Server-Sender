<div class="tp-testimonial__area grey-bg pt-120 pb-120">
         <div class="container">
            <div class="row">
               <div class="col-12">
                  <div class="tp-testimonial__title-box text-center mb-80 wow tpfadeUp" data-wow-duration=".7s" data-wow-delay=".3s">
                     <h3 class="tp-section-title">{{ $home->testimonial->title ?? '' }}</h3>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-xl-6 col-lg-6 col-12 wow tpfadeLeft" data-wow-duration=".9s" data-wow-delay=".5s">
                  <div class="tp-testimonial__thumb">
                     <img src="{{ asset($home->testimonial_cover ?? '') }}" alt="">
                  </div>
               </div>
               <div class="col-xl-6 col-lg-6 col-12">
                  <div class="tp-testimonial__wrapper">
                     @foreach($testimonials as $testimonial)
                     <div class="tp-testimonial__item mb-15 d-flex wow tpfadeUp" data-wow-duration=".7s" data-wow-delay=".7s">
                        <div class="tp-testimonial__icon">
                           <span><img src="{{ asset($testimonial->preview->value ?? '') }}" alt=""></span>
                        </div>
                        <div class="tp-testimonial__content">
                           <p>{{ Str::limit($testimonial->excerpt->value ?? '',150) }}</p>
                           <h3 class="tp-testimonial__title-sm">{{ $testimonial->title ?? '' }} <span>({{ $testimonial->slug ?? '' }})</span></h3>
                        </div>
                     </div>
                     @endforeach
                  </div>
               </div>
            </div>
         </div>
      </div>