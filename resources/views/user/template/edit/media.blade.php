<form method="POST" action="{{ route('user.template.update',$template->id) }}" class="ajaxform">
   @csrf
   @method('PUT')
   <div class="row">
      <div class="col-sm-12">
         <div class="form-group">
            <label>{{ __('Template Name') }}</label>
            <input type="text" name="template_name" required="" class="form-control" value="{{ $template->title }}">
         </div>
      </div>
      <div class="col-sm-12">
         <div class="form-group">
            <label>{{ __('Select File') }}</label>
            <input id="phone" type="file" class="form-control" name="file"  />
            <small>{{__(' Supported file type:')}}</small> <small class="text-danger">{{ __('jpg,jpeg,png,webp,pdf,docx,xlsx,csv,txt') }}</small>
            <br>
            @if(isset($template->body['image']))
            <a href="{{ asset($template->body['image']['url'] ?? '') }}" target="_blank">
            <img src="{{ asset($template->body['image']['url'] ?? '') }}" height="50">
            </a>
            @elseif($template->body['document'])
            <a href="{{ asset($template->body['document']['url'] ?? '') }}" target="_blank">
            {{ __('Attachment') }}
            </a>
            @endif
         </div>
      </div>
      <div class="col-sm-12">
         <div class="form-row mb-1">
            <label class="col-12 text-left">{{ __('Media Caption:') }}</label>
         </div>
         <div class="form-group">
            <input class="form-control" name="message" required="" maxlength="1000" value="{{ $template->body['caption'] ?? '' }}" />
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