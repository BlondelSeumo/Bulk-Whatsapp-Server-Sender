<form method="POST" action="{{ route('user.template.update',$template->id) }}" class="ajaxform">
   @csrf
   @method('PUT')
   <div class="row">
      <div class="col-sm-12">
         <div class="form-group">
            <label>{{ __('Template Name') }}</label>
            <input type="text" name="template_name" class="form-control" value="{{ $template->title }}">
         </div>
      </div>
      <div class="col-sm-12">
         <div class="form-group">
            <label>{{ __('Template Title (Header)') }}</label>
            <input  type="text" class="form-control" name="header_title" placeholder="{{ __('Example: Amazing boldfaced list title') }}" value="{{ $template->body['title'] ?? '' }}" required=""  maxlength="50"  />
         </div>
      </div>
      <div class="col-sm-12">
         <div class="form-row mb-1">
            <label class="col-6">{{ __('Message:') }}</label>
            <div class="col-6">
               <button type="button" data-toggle="modal" data-target="#help-modal" class="btn btn-neutral btn-sm float-right"><i class="fas fas fa-code"></i>&nbsp{{ __('Shortcodes') }}</button>
            </div>
         </div>
         <div class="form-group">
            <textarea class="form-control h-200" name="message" required="" maxlength="1000">{{ $template->body['text'] ?? '' }}</textarea>
         </div>
      </div>
      <div class="col-sm-12">
         <div class="form-group">
            <label>{{ __('Template Footer Text') }}</label>
            <input  type="text" class="form-control" name="footer_text" placeholder="{{ __('Example: Thank you') }}" required=""  maxlength="50" value="{{ $template->body['footer'] ?? '' }}" />
         </div>
      </div>
      <div class="col-sm-12">
         <div class="form-group">
            <label>{{ __('Button Text for select option') }}</label>
            <input  type="text" class="form-control" name="button_text" placeholder="{{ __('Example: Required, text on the button to view the list') }}" value="{{ $template->body['buttonText'] ?? '' }}" required=""  maxlength="50" />
         </div>
      </div>
      <div class="col-sm-12">
         <div class="list-option-area">
            <div class="row">
               <div class="col-6">
                  <h4 class="mt-2">{{ __('List Options') }}</h4>
               </div>
               <div class="col-6">
                  <a href="javascript:void(0)" id="add-more-option" class="btn btn-sm btn-primary btn-neutral float-right mb-1"><i class="fa fa-plus"></i>&nbsp; {{ __('Add More Card') }}</a>
               </div>
            </div>
            <div class="list-area">
               @foreach($template->body['sections'] as $sectionKey => $section)
               @if($sectionKey == 0)
               <div class="card card-primary card-item">
                  <div class="card-header">
                     <h4>{{ __('List 1') }}</h4>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="col-sm-12">
                           <div class="form-group">
                              <label>{{ __('List Section Title') }}</label>
                              <input  type="text" class="form-control" name="section[1][title]" placeholder="{{ __('Example: Select a fruit') }}" value="{{ $section['title'] ?? '' }}" required=""  maxlength="50" />
                           </div>
                        </div>
                     </div>
                     <div class="row list-item-area1">
                        @foreach($section['rows'] ?? [] as $rowKey => $row)
                        <div class="col-6 item-{{ $sectionKey+1 }}-{{ $rowKey+1 }}">
                           <div class="form-group">
                              <label>{{ __('Enter List Value Name') }}</label>
                              <input  type="text" class="form-control itemval-1" name="section[1][value][{{$rowKey}}][title]" placeholder="{{ __('Example: Banana') }}" value="{{ $row['title'] ?? '' }}" required=""  maxlength="50" />
                           </div>
                        </div>
                        <div class="col-6 item-{{ $sectionKey+1 }}-{{ $rowKey+1 }}">
                           <div class="form-group">
                              <label>{{ __('Enter List Value Description') }}</label>
                              @if($rowKey != 0)
                              <a href="javascript:void(0)" class="float-right btn btn-sm btn-danger remove-option-item" data-addbutton=".option-item-btn1" data-target=".item-{{ $sectionKey+1 }}-{{ $rowKey+1 }}">X</a>
                              @endif
                              <input  type="text" class="form-control" name="section[1][value][{{$rowKey}}][description]" placeholder="{{ __('Example: Banana is a healthly food') }}" value="{{ $row['description'] ?? '' }}"   maxlength="50" />
                           </div>
                        </div>
                        @endforeach
                     </div>
                     <div class="row">
                        <div class="col-12 text-right">
                           <a href="javascript:void(0)" class="text-right btn btn-sm btn-neutral add-more-option-item option-item-btn1" data-target=".list-item-area1" data-key="1"><i class="fas fa-plus"></i>&nbsp{{ __('Add More Item') }}</a>
                        </div>
                     </div>
                  </div>
               </div>
               @else
               <div class="card card-primary card-item card-area{{$sectionKey+1}}">
                  <div class="card-header">
                     <h4>List {{$sectionKey+1}}</h4>
                     <div class="card-header-action">
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm delete-card" data-target=".card-area{{$sectionKey+1}}">
                        <i class="fas fa-trash"></i>
                        </a>
                     </div>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="col-sm-12">
                           <div class="form-group">
                              <label>{{ __('List Section Title') }}</label>
                              <input type="text" class="form-control" name="section[{{$sectionKey+1}}][title]" placeholder="Example: Select a fruit"  required="" maxlength="50"  value="{{ $section['title'] ?? '' }}" />
                           </div>
                        </div>
                     </div>
                     <div class="row list-item-area{{$sectionKey+1}}">
                        @foreach($section['rows'] ?? [] as $rowKey => $row)
                        <div class="col-6 item-{{ $sectionKey+1 }}-{{ $rowKey+1 }}">
                           <div class="form-group">
                              <label>{{ __('Enter List Value Name') }}</label>
                              <input type="text" class="form-control itemval-{{$sectionKey+1}}" name="section[{{$sectionKey+1}}][value][{{$rowKey}}][title]" placeholder="Example: Banana" value="{{ $row['title'] ?? '' }}" required="" maxlength="50" />
                           </div>
                        </div>
                        <div class="col-6 item-{{ $sectionKey+1 }}-{{ $rowKey+1 }}">
                           <div class="form-group">
                              <label>{{ __('Enter List Value Description') }}</label>
                              @if($rowKey != 0)
                              <a href="javascript:void(0)" class="float-right btn btn-sm btn-danger remove-option-item" data-addbutton=".option-item-btn1" data-target=".item-{{ $sectionKey+1 }}-{{ $rowKey+1 }}">X</a>
                              @endif
                              <input type="text" class="form-control" name="section[{{$sectionKey+1}}][value][{{$rowKey}}][description]" placeholder="Example: Banana is a healthly food" value="{{ $row['description'] ?? '' }}" maxlength="50" />
                           </div>
                        </div>
                        @endforeach
                     </div>
                     <div class="row">
                        <div class="col-12 text-right">
                           <a href="javascript:void(0)" class="text-right btn btn-sm btn-neutral add-more-option-item option-item-btn{{$sectionKey+1}}" data-target=".list-item-area{{$sectionKey+1}}" data-key="{{$sectionKey+1}}"><i class="fas fa-plus"></i>&nbsp;{{ __('Add More Item') }}</a>
                        </div>
                     </div>
                  </div>
               </div>
               @endif
               @endforeach
            </div>
         </div>
      </div>
      <div class="col-sm-12">
         <div class="row">
            <div class="col-sm-8 d-flex">
               <label class="custom-toggle custom-toggle-primary">
               <input type="checkbox"  {{ $template->status == 1 ? 'checked' : '' }}  name="status" id="template-status" >
               <span class="custom-toggle-slider rounded-circle" data-label-off="{{ __('No') }}" data-label-on="{{ __('Yes') }}"></span>
               </label>
               <label class="mt-1 ml-1" for="template-status">
                  <h4>{{ __('Make it active template?') }}</h4>
               </label>
            </div>
            <div class="col-sm-4">
               <button type="submit" class="btn btn-outline-primary submit-button float-right">{{ __('Save Template') }}</button>
            </div>
         </div>
      </div>
   </div>
</form>