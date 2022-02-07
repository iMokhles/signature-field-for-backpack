<!-- Signature Field for Backpack for Laravel  -->
{{--
    Author: iMokhles
    Website: https://github.com/imokhles
    Addon: https://github.com/imokhles/signature-field-for-backpack
--}}

@php
    $prefix = isset($field['prefix']) ? $field['prefix'] : '';
    $value = old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '';
    $value = $value
        ? preg_match('/^data\:image\//', $value)
            ? $value
            : (isset($field['disk'])
                ? Storage::disk($field['disk'])->url($prefix.$value)
                : url($prefix.$value))
        :''; // if validation failed, tha value will be base64, so no need to create a URL for it

    $field['wrapper'] = $field['wrapper'] ?? $field['wrapperAttributes'] ?? [];
    $field['wrapper']['class'] = $field['wrapper']['class'] ?? "form-group col-sm-12";
    $field['wrapper']['data-field-name'] = $field['wrapper']['data-field-name'] ?? $field['name'];
    $field['wrapper']['data-init-function'] = $field['wrapper']['data-init-function'] ?? 'bpFieldInitSignatureElement';
@endphp

@include('crud::fields.inc.wrapper_start')
<div>
    <label>{!! $field['label'] !!}</label>
    @include('crud::fields.inc.translatable_icon')
</div>
<!-- Wrap the image or canvas element with a block element (container) -->
<div class="row">
    <div class="col-sm-6" data-handle="previewArea" style="margin-bottom: 20px;">
        <img data-handle="mainImage" src="">
    </div>
</div>

<div class="row">
    <div class="signature-pad-wrapper" data-handle="signaturePad">
        <canvas id="signature-pad" class="signature-pad" width="450" height="200"></canvas>
    </div>
</div>
<div class="">
    <input type="hidden" data-handle="hiddenImage" name="{{ $field['name'] }}" value="{{ $value }}">
    <button class="btn btn-success btn-sm" data-handle="confirm" type="button"><i class="la la-check"></i> {{ trans('backpack::crud.save') }}</button>
    <button class="btn btn-light btn-sm" data-handle="remove" type="button"><i class="la la-trash"></i> {{ trans('backpack::crud.clear') }}</button>
</div>

{{-- HINT --}}
@if (isset($field['hint']))
    <p class="help-block">{!! $field['hint'] !!}</p>
@endif
@include('crud::fields.inc.wrapper_end')


{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
        <style type="text/css">
            .signature-pad-wrapper {
                position: relative;
                width: 450px;
                height: 200px;
                -moz-user-select: none;
                -webkit-user-select: none;
                -ms-user-select: none;
                user-select: none;
                border: 1px dashed rgba(0,40,100,.12);
                margin-bottom: 5px; 
                margin-left: 15px;
            }
            .signature-pad {
                position: absolute;
                left: 0;
                top: 0;
                width:450px;
                height:200px;
            }
        </style>

    @endpush
    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
        <script>
            function bpFieldInitSignatureElement(element) {
                // element will be a jQuery wrapped DOM node
                // Find DOM elements under this form-group element
                var $signPadElement = element.find('[data-handle=signaturePad]');
                var $mainImage = element.find('[data-handle=mainImage]');
                var $hiddenImage = element.find("[data-handle=hiddenImage]");
                var $remove = element.find("[data-handle=remove]");
                var $confirm = element.find("[data-handle=confirm]");
                var $previews = element.find("[data-handle=previewArea]");

                var signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
                    backgroundColor: 'rgba(255, 255, 255, 0)',
                    penColor: 'rgb(0, 0, 0)'
                });

                // Hide 'Remove' button if there is no image saved
                if (!$hiddenImage.val()){
                    $previews.hide();
                    $remove.hide();
                } else {
                    // Make the main image show the image in the hidden input
                    $mainImage.attr('src', $hiddenImage.val());
                    $signPadElement.hide();
                    $confirm.hide();
                }


                $confirm.click(function() {
                    var data = signaturePad.toDataURL('image/png');
                    if (!signaturePad.isEmpty()) {
                        $signPadElement.hide();
                        $previews.show();
                        $mainImage.attr('src',data);
                        $hiddenImage.val(data);
                        $remove.show();
                        $confirm.hide();
                    }

                });
                $remove.click(function() {
                    signaturePad.clear();
                    $mainImage.attr('src','');
                    $hiddenImage.val('');
                    $confirm.show();
                    $remove.hide();
                    $previews.hide();
                    $signPadElement.show();
                });

            }
        </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
