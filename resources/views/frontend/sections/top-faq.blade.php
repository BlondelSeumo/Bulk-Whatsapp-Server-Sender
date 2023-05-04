<div class="tp-faq__area grey-bg">
         <div class="container">
            <div class="row align-items-end">
               <div class="col-xl-6 col-lg-6">
                  <div class="tp-faq__wrapper-box">
                     <div class="tp-faq__title-box">
                        <h3 class="tp-section-title wow tpfadeUp" data-wow-duration=".7s" data-wow-delay=".3s">{{ $home->top_faq->title ?? '' }}</h3>
                        <p class="wow tpfadeUp" data-wow-duration=".7s" data-wow-delay=".5s">{{ $home->top_faq->description ?? '' }}
                        </p>
                     </div>
                     <div class="tp-custom-accordio">
                        <div class="accordion" id="accordionExample">
                           @foreach($faqs as $faqKey => $topfaq)
                              @if($topfaq->slug == 'top')
                                 <div class="accordion-items wow tpfadeUp" data-wow-duration=".7s" data-wow-delay=".7s">
                                 <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-buttons {{ $faqKey > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse"
                                       data-bs-target="#collapseOne{{ $faqKey }}" aria-expanded="true" aria-controls="collapseOne">
                                       {{ $topfaq->title ?? '' }}
                                    </button>
                                 </h2>
                                 <div id="collapseOne{{ $faqKey }}" class="accordion-collapse collapse  {{ $faqKey == 0 ? 'show' : '' }}"
                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                      {{ $topfaq->excerpt->value ?? '' }}
                                    </div>
                                 </div>
                              </div>
                              @endif
                           @endforeach
                          
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-6 col-lg-6 wow tpfadeRight" data-wow-duration=".7s" data-wow-delay="1s">
                  <div class="tp-faq__thumb text-center">
                     <img src="https://ik.imagekit.io/gupshup/revamp/assets/v3/images/home/v5-casual-life.png?ik-sdk-version=react-1.1.1" alt="" >
                  </div>
               </div>
            </div>
         </div>
      </div>