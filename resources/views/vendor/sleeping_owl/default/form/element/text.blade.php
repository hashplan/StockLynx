<div class="form-group row {{ $errors->has($name) ? 'has-error' : '' }}">
	<label for="{{ $name }}" class="col-sm-1 form-control-label">
		{{ $label }}

		@if($required)
			<span class="text-danger">*</span>
		@endif
	</label>
    <div class="col-sm-11">
        <input class="form-control"
               name="{{ $name }}"
               type="text"
               id="{{ $name }}"
               value="{{ $value }}"
               @if($readonly) readonly @endif
        >
        @include(AdminTemplate::getViewPath('form.element.errors'))
    </div>
</div>