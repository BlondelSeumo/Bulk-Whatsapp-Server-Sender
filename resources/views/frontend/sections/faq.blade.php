<div class="tp-support__area pt-120 pb-120 grey-bg p-relative">
         <div class="tp-support__bg">
            <img src="{{ asset('assets/frontend/img/faq/faq-bg-shape.png') }}" alt="">
         </div>
         <div class="container">
            <div class="row">
               <div class="col-12">
                  <div class="tp-support__title-box text-center mb-70">
                     <h3 class="tp-section-title">{{ __('Frequently asked questions') }} 📣</h3>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-12">
                  <div class="tp-support__faq">
                     <div class="tp-custom-accordio-2">
                        <div class="accordion" id="accordionExample-2">
                        	@foreach($faqs as $key => $faq)
                            @if($faq->slug != 'top')
                           <div class="accordion-items">
                              <h2 class="accordion-header" id="heading-{{ $key+1 }}">
                                 <button class="accordion-buttons {{ $key > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-{{ $key+1 }}" aria-expanded="{{ $key == 0 ? true : false }}" aria-controls="collapse-1">
                                    {{ $faq->title }}
                                 </button>
                              </h2>
                              <div id="collapse-{{ $key+1 }}" class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}" aria-labelledby="heading-{{ $key+1 }}"
                                 data-bs-parent="#accordionExample-2">
                                 <div class="accordion-body">
                                     {{ $faq->excerpt->value ?? '' }}
                                 </div>
                              </div>
                           </div>
                           @endif
                          @endforeach
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>