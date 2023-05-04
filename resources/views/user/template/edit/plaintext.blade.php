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