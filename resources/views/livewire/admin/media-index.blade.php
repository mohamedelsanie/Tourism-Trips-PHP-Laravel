<div>
    <form wire:submit.prevent="refresh" class="pt-3">
        <div  wire:loading.remove wire:target="refresh">
            <div class="row all_media">
                {{-- Be like water. --}}
                @if(count($media) > 0)
                    @foreach($media as $med)
                        <div class="col-lg-3 col-sm-6">
                            <div class="thumbnail">
                                <div class="box border border-dark" style="height:150px; margin-bottom: 20px;cursor: pointer;">
                                    <div class="tools">
                                        @if(AdminCan('media-delete'))
                                        <a class="delete_media" href="{{ route('admin.media.delete',$med->id) }}">{{ __('admin/media.index.delete') }}</a>
                                        @endif
                                        @if(AdminCan('media-edit'))
                                        <a class="edit_media" href="{{ route('admin.media.edit',$med->id) }}">{{ __('admin/media.index.edit') }}</a>
                                        @endif
                                    </div>
                                    <img src="/storage/{{ $med->file_name }}" style="width: 100%;height: 100%;" />
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="clearfix"></div>
            <div class="pagination">
                {!! $media->links() !!}
            </div>
        </div>
    </form>
</div>
