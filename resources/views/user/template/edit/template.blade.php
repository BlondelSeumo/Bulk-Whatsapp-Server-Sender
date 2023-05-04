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
            <label>{{ __('Footer Text') }}</label>
            <input type="text" class="form-control" name="footer_text" required="" autofocus="" maxlength="100" value="{{ $template->body['footer'] ?? '' }}" />
         </div>
      </div>
      <div class="col-sm-12" id="list-button-appendarea">
         <div class="form-group button_message_text">
            <div class="row">
               <div class="col-6">
                  <h4 class="mt-2">{{ __('Call To Action Buttons') }}</h4>
               </div>
               <div class="col-6">
                  <a href="javascript:void(0)" id="add-more-action" class="btn btn-sm btn-primary btn-neutral float-right mb-1 {{ count($template->body['templateButtons'] ?? []) == 3 ? 'none' : '' }}"><i class="fa fa-plus"></i>&nbsp{{ __('Add More') }}</a>
               </div>
            </div>
            <div id="action-body">
               @foreach($template->body['templateButtons'] ?? [] as $key => $button)
               @php
               $option_type='';
               $display_text='';
               $button_action='';
               if(isset($button['urlButton'])){
               $option_type='urlButton'; 
               $display_text=$button['urlButton']['displayText'] ?? '';
               $button_action=$button['urlButton']['url'] ?? '';
               }
               elseif(isset($button['callButton'])){
               $option_type='callButton';
               $display_text=$button['callButton']['displayText'] ?? '';
               $button_action=$button['callButton']['phoneNumber'] ?? ''; 
               }
               elseif(isset($button['quickReplyButton'])){
               $option_type='quickReplyButton'; 
               $display_text=$button['quickReplyButton']['displayText'] ?? '';
               }
               @endphp
               @if($key == 0)
               <div class="card card-primary mt-2 call-to-action-area">
                  <div class="card-header">
                     <h4>{{ __('Button 1') }}</h4>
                  </div>
                  <div class="card-body">
                     <div class="form-row">
                        <div class="form-group col-sm-4">
                           <label>
                           {{ __('Select Action Type') }}
                           </label>
                           <select class="form-control action-type" name="buttons[0][type]" required="" >
                           <option value="urlButton" data-key="0" @if($option_type == 'urlButton') selected="" @endif>{{ __('Url Button') }}</option>
                           <option value="callButton" data-key="0" @if($option_type == 'callButton') selected="" @endif>{{ __('Phone number (Call Button)') }}</option>
                           <option value="quickReplyButton" data-key="0" @if($option_type == 'quickReplyButton') selected="" @endif>{{ __('Quick Reply Button') }}</option>
                           </select>
                        </div>
                        <div class="form-group col-sm-4">
                           <label>
                           {{ __('Button Display Text') }}
                           </label>
                           <input type="text" class="form-control" name="buttons[0][displaytext]" required="" autofocus="" maxlength="50" placeholder="{{ __('Button Display Text') }}" value="{{ $display_text }}" />
                        </div>
                        <div class="form-group col-sm-4 action-area0 {{ $option_type == 'quickReplyButton' ? 'none' : '' }}">
                           <label>
                           {{ __('Button Click To Action Value') }}
                           </label>
                           <input type="text" class="form-control input_action0" name="buttons[0][action]" required="" autofocus="" maxlength="50" placeholder="https://www.google.com/" value="{{ $button_action }}" />
                        </div>
                     </div>
                  </div>
               </div>
               @else
               <div class="card card-primary mt-2 call-to-action-area exist-action{{ $key+1 }}">
                  <div class="card-header">
                     <h4>{{ __('Button') }} {{ $key+1 }}</h4>
                     <div class="card-header-action">
                        <a href="javascript:void(0)" data-target=".exist-action{{ $key+1 }}" class="btn btn-sm btn-danger remove-action">
                        <i class="fas fa-trash"></i>
                        </a>
                     </div>
                  </div>
                  <div class="card-body">
                     <div class="form-row">
                        <div class="form-group col-sm-4">
                           <label>
                           {{ __('Select Action Type') }}
                           </label>
                           <select class="form-control action-type" name="buttons[{{ $key+1 }}][type]" required="">
                           <option value="urlButton" data-key="{{ $key+1 }}" @if($option_type == 'urlButton') selected="" @endif>{{ __('Url Button') }}</option>
                           <option value="callButton" data-key="{{ $key+1 }}" @if($option_type == 'callButton') selected="" @endif>{{ __('Phone number (Call Button)') }}</option>
                           <option value="quickReplyButton" data-key="{{ $key+1 }}" @if($option_type == 'quickReplyButton') selected="" @endif>{{ __('Quick Reply Button') }}</option>
                           </select>
                        </div>
                        <div class="form-group col-sm-4">
                           <label>
                           {{ __('Button Display Text') }}
                           </label>
                           <input type="text" class="form-control" name="buttons[{{ $key+1 }}][displaytext]" required="" autofocus="" maxlength="50" placeholder="{{ __('Button Display Text') }}" value="{{ $display_text }}">
                        </div>
                        <div class="form-group col-sm-4 action-area{{ $key+1 }} {{ $option_type == 'quickReplyButton' ? 'none' : '' }}">
                           <label>
                           {{ __('Button Click To Action Value') }}
                           </label>
                           <input type="text" class="form-control input_action{{ $key+1 }}" name="buttons[{{ $key+1 }}][action]" required="" autofocus="" maxlength="50" placeholder="https://www.google.com/" value="{{ $button_action }}">
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