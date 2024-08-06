<div>
    <form wire:submit.prevent="refresh" class="pt-3">

@csrf  

@method('PUT')

    <div class="gallery">
    @if(count($media) != 0)
    <div id="gallery" wire:loading.remove wire:target="refresh">
        <div class="row">
            {{--wire:loading wire:target="refresh()"--}}
            @foreach($media as $item)
                <div class="col-lg-4 col-sm-6">
                    <div class="thumbnail">
                        <div class="box border border-dark" style="height:150px; margin-bottom: 20px;cursor: pointer;">
                            <a class="image_ch cursor-pointer" data-dismiss="modal" aria-hidden="true" data-image="{{ Storage::disk('local')->url($item->file_name) }}" >
                                <img src="{{ Storage::disk('local')->url($item->file_name) }}" style="width:100%;height:100%;" />
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="clearfix"></div>
                <div class="col-sm-12">
                    {!! $links !!}
                </div>
            </div>
        </div>
    @else
        <div wire:loading.remove wire:target="refresh">
        <p>{{ __('admin/media.show.no_media') }}</p>
        </div>
    @endif
    </div>
    </form>
    {{-- The best athlete wants his opponent at his best. --}}
</div>
