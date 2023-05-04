<form method="POST" action="{{ route('user.template.update',$template->id) }}" class="ajaxform">
    @csrf
    @method('PUT')
    <div class="row">
       <div class="col-sm-12">
        <div class="form-group">
            <label>{{ __('Template Name:') }}</label>
            <input type="text" name="template_name" required="" class="form-control" value="{{ $template->title }}">
        </div>
    </div>   
    <div class="col-sm-12">
        <div class="form-group">
            <label>{{ __('Message Caption') }}</label>
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
        @php
        $buttons=count($template->body['buttons'] ?? []);
        @endphp
        @foreach($template->body['buttons'] ?? [] as $key => $button)
        @if($key == 0)
        <div class="form-group plain_button_message_text">
            <div class="row">
                <div class="col-6">
                    <label>{{ __('Button 1 Text') }}</label>
                </div>
                <div class="col-6">
                    <a href="javascript:void(0)" id="add-more" class="btn btn-sm btn-primary btn-neutral float-right mb-1 {{ $buttons == 3 ? 'none' : '' }}"><i class="fa fa-plus"></i>&nbsp{{ __('Add More') }}</a>
                </div>
            </div>
            <input type="text" class="form-control" name="buttons[]" required="" autofocus="" maxlength="50"  value="{{ $button['buttonText']['displayText'] ?? '' }}"/>
        </div>

        @else
        <div class="plain_button_message_text exist_button{{ $key+1 }}">
            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label>{{ __('Button') }} {{ $key+1 }} {{ __('Text') }}</label>
                    </div>
                    <div class="col-6">
                        <a href="javascript:void(0)" data-target=".exist_button{{ $key+1 }}" class="btn btn-sm btn-danger float-right mb-1 remove-button"><i class="fa fa-trash"></i></a>
                    </div>
                </div>
                <input type="text" class="form-control" name="buttons[]" required="" autofocus="" maxlength="50" value="{{ $button['buttonText']['displayText'] ?? '' }}">
            </div>
        </div>
        @endif

        @endforeach
    </div>
    <div class="col-sm-12">
        <div class="row">
           <div class="col-sm-8 d-flex">
            <label class="custom-toggle custom-toggle-primary">
                <input type="checkbox"  {{ $template->status == 1 ? 'checked' : '' }}  name="status" id="template-status" >
                <span class="custom-toggle-slider rounded-circle" data-label-off="{{ __('No') }}" data-label-on="{{ __('Yes') }}"></span>
            </label>
            <label class="mt-1 ml-1" for="template-status"><h4>{{ __('Make it active template?') }}</h4></label>
        </div>
        <div class="col-sm-4">
         <button type="submit" class="btn btn-outline-primary submit-button float-right">{{ __('Save Template') }}</button>
     </div>
 </div>
</div>
</div>
</form>