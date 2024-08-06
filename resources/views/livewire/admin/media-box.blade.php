
<div>
{{--    {{ $field }}--}}
    <div class="modal fade bs-example-modal-lg media_uploader_{{ $field }}"  wire:ignore.self id="bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="media_model" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-titl media_model" id="">
                        {{ __('admin/media.box.title') }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                </div>
                <div class="modal-body">

                    <div class="tab">
                        <ul class="nav nav-pills" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link text-blue active" data-toggle="tab" href="#upload_{{ $field }}" role="tab" aria-selected="true">{{ __('admin/media.box.upload') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-blue" data-toggle="tab" href="#gallery_{{ $field }}" role="tab" aria-selected="false">{{ __('admin/media.box.gallery') }}</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="upload_{{ $field }}" role="tabpanel">
                                <div class="pd-20">
                                    {{--@livewire('admin.media-upload')--}}
                                    <livewire:admin.file-uploader :field="$field" />

                                </div>
                            </div>
                            <div class="tab-pane fade" id="gallery_{{ $field }}" role="tabpanel">
                                <div class="pd-20">
                                    <livewire:admin.media-gallery />
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{--<button type="button" class="btn btn-secondary" data-dismiss="modal">--}}
                        {{--Close--}}
                    {{--</button>--}}
                    <button type="button" style=" background: #000; " data-dismiss="modal" class="use_image btn btn-primary">
                        {{ __('admin/media.box.use') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
</div>
