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
      <div class="col-sm-6">
         <div class="form-group">
            <label>{{ __('Latitude') }}</label>
            <input type="number" step="any" name="degreesLatitude" required="" class="form-control" placeholder="Example: 24.121231" value="{{ $template->body['location']['degreesLatitude'] ?? '' }}">
         </div>
      </div>
      <div class="col-sm-6">
         <div class="form-group">
            <label>{{ __('Longitude') }}</label>
            <input type="number" step="any" name="degreesLongitude" required="" class="form-control" placeholder="Example: 55.1121221" value="{{ $template->body['location']['degreesLongitude'] ?? '' }}">
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