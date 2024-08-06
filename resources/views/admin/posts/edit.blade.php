<x-admin-layout>
    <x-slot name="header">
        <div class="page-header mb-0">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin/common.home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">{{ __('admin/news.index.title') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('admin/news.edit.edit') }}<code>{{ $post->title }}</code></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-primary btn-sm scroll-click">{{ __('admin/news.show.back') }}</a>
                </div>
            </div>
        </div>
    </x-slot>
    @php $field = 'media'; @endphp
    <div class="py-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="clearfix mb-10">
                    <div class="pull-left">
                        <h4 class="text-blue h4">{{ __('admin/news.edit.edit') }} </h4>
                    </div>
                </div>
                <div class="dropdown-divider"></div>

                <form action="{{ route('admin.posts.update', $post->id) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <div class="col-sm-12 col-md-8 mb-30">

                            <div class="form-group row">
                                <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/news.fields.title') }}</label>
                                <div class="col-sm-12 col-md-12">
                                    <ul class="nav nav-tabs" role="tablist">
                                        @foreach(config('translatable.languages') as $key => $lang)
                                            <li class="nav-item @if($errors->has($key.'*title'))  border border-danger @endif">
                                                <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#title-{{ $key }}" role="tab">{{ $lang }}</a>
                                            </li>
                                        @endforeach
                                    </ul><!-- Tab panes -->
                                    <div class="tab-content">
                                        @foreach(config('translatable.languages') as $key => $lang)
                                            <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="title-{{ $key }}" role="tabpanel">
                                                <input name="{{ $key }}[title]" placeholder="{{ __('admin/news.fields.title') }}" value="{{ $post->translate($key)->title }}" class="@if(LaravelLocalization::getCurrentLocale() == $key) slug-input main_input @endif border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*title')) border border-danger @endif" type="text"/>
                                                @if($errors->has($key.'*title'))<span class="text-danger">{{ $errors->first($key.'*title') }}</span>@endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/news.fields.slug') }}</label>
                                <div class="col-sm-12 col-md-12">
                                    <input name="slug" placeholder="{{ __('admin/news.fields.slug') }}" value="{{ $post->slug }}" class="slug-output border-gray-300 rounded-md shadow-sm form-control @error('slug') border border-danger @enderror" type="text"/>
                                    <span class="">{{ __('admin/news.fields.current_slug') }}{{ getSetting('site_url') }}<b class="text-success">{{ $post->slug }}</b></span>
                                    @error('slug')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="card card-box custom mb-10" id="accordionWork">
                                <div class="card-header" data-toggle="collapse" href="#collapseWork">
                                    <a class="card-title">
                                        {{ __('admin/news.fields.info') }}
                                    </a>
                                </div>
                                <div id="collapseWork" class="card-body show" data-parent="#accordionWork" >

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/news.fields.meta_desc') }}</label>
                                        <div class="col-sm-12 col-md-12">
                                            <ul class="nav nav-tabs" role="tablist">
                                                @foreach(config('translatable.languages') as $key => $lang)
                                                    <li class="nav-item @if($errors->has($key.'*description'))  border border-danger @endif">
                                                        <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#description-{{ $key }}" role="tab">{{ $lang }}</a>
                                                    </li>
                                                @endforeach
                                            </ul><!-- Tab panes -->
                                            <div class="tab-content">
                                                @foreach(config('translatable.languages') as $key => $lang)
                                                    <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="description-{{ $key }}" role="tabpanel">
                                                        <textarea name="{{ $key }}[description]" placeholder="{{ __('admin/news.fields.meta_desc') }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*description')) border border-danger @endif">{{ $post->translate($key)->description }}</textarea>
                                                        @if($errors->has($key.'*description'))<span class="text-danger">{{ $errors->first($key.'*description') }}</span>@endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/news.fields.content') }}</label>
                                        <div class="col-sm-12 col-md-12">
                                            <ul class="nav nav-tabs" role="tablist">
                                                @foreach(config('translatable.languages') as $key => $lang)
                                                    <li class="nav-item @if($errors->has($key.'*content'))  border border-danger @endif">
                                                        <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#content-{{ $key }}" role="tab">{{ $lang }}</a>
                                                    </li>
                                                @endforeach
                                            </ul><!-- Tab panes -->
                                            <div class="tab-content">
                                                @foreach(config('translatable.languages') as $key => $lang)
                                                    <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="content-{{ $key }}" role="tabpanel">
                                                        <textarea name="{{ $key }}[content]" placeholder="{{ __('admin/news.fields.content') }}" id="editor_{{ $key }}" class="0textarea_editor_{{ $key }} border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*content')) border border-danger @endif">{{ $post->translate($key)->content }}</textarea>
                                                        @if($errors->has($key.'*content'))<span class="text-danger">{{ $errors->first($key.'*content') }}</span>@endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row" data-select2-id="0">
                                        <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/news.fields.tags') }}</label>
                                        <div class="col-sm-12 col-md-10">
                                            <select name="tags[]" class="custom-select2 form-control select2-hidden-accessible @error('tags') border border-danger @enderror" multiple="" style="width: 100%">
                                                <optgroup label="{{ __('admin/news.fields.tags') }}">
                                                    @foreach($tags as $tag)
                                                        <option value="{{ $tag->id }}" {{is_array($p_tags) && in_array($tag->id, $p_tags) ? 'selected' : '' }}>{{ $tag->title }}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        </div>
                                        @error('tags')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4 mb-30">
                            <div class="card card-box custom mb-10" id="accordionImage">
                                <div class="card-header" data-toggle="collapse" href="#collapseImage">
                                    <a class="card-title">
                                        {{ __('admin/news.fields.image') }}
                                    </a>
                                </div>
                                <div id="collapseImage" class="card-body show pb-0" data-parent="#accordionImage" aria-expanded="true">
                                    <div class="form-group row" id="user_image_field_{{$field}}">
                                        <div class="col-sm-6 col-md-6 hidden">
                                            <input name="image" id="user_image_{{$field}}" placeholder="image" value="{{ $post->image }}" class="hidden form-control @error('image') border border-danger @enderror" type="text"/>
                                            @error('image')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-sm-12 col-md-12">
                                            {{--@livewire('admin.media-upload')--}}
                                            <div class="image_preview" style="float: left; margin-right: 20px;">
                                                @if($post->image)
                                                    <img src="{{ $post->image }}" width="100" />
                                                @endif
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="block">
                                                <a href="#" class="btn-block" data-toggle="modal" data-target=".media_uploader_{{$field}}" type="button">{{ __('admin/news.fields.media') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card card-box custom mb-10" id="accordionCategory">
                                <div class="card-header" data-toggle="collapse" href="#collapseCategory">
                                    <a class="card-title">
                                        {{ __('admin/news.fields.category') }}
                                    </a>
                                </div>
                                <div id="collapseCategory" class="card-body show" data-parent="#accordionCategory" >

                                    <div class="form-group row">
                                        <div class="col-sm-12 col-md-12">
                                            <select name="category_id" class="border-gray-300 rounded-md shadow-sm custom-select col-12 @error('category') border border-danger @enderror">
                                                <option @if($post->category_id == '') selected @endif>{{ __('admin/news.fields.select_category') }}</option>
                                                @foreach($categories as $cat)
                                                    <option value="{{ $cat->id }}" @if($cat->id == $post->category_id) selected @endif>{{ $cat->title }}</option>
                                                @endforeach
                                            </select>
                                            @error('category')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card card-box custom mb-10" id="accordionCommentsStatus">
                                <div class="card-header" data-toggle="collapse" href="#collapseCommentsStatus">
                                    <a class="card-title">
                                        {{ __('admin/news.fields.comments_status') }}
                                    </a>
                                </div>
                                <div id="collapseCommentsStatus" class="card-body show" data-parent="#accordionCommentsStatus" >

                                    <div class="form-group row">
                                        <div class="col-sm-12 col-md-12">
                                            <select name="comments_status" class="border-gray-300 rounded-md shadow-sm custom-select col-12 @error('comments_status') border border-danger @enderror">
                                                @if($post->comments_status == 'open')
                                                    <option value="open" selected>{{ __('admin/news.fields.open') }}</option>
                                                    <option value="closed">{{ __('admin/news.fields.closed') }}</option>
                                                @elseif($post->comments_status == 'closed')
                                                    <option value="open">{{ __('admin/news.fields.open') }}</option>
                                                    <option value="closed" selected>{{ __('admin/news.fields.closed') }}</option>
                                                @else
                                                    <option selected="">{{ __('admin/news.fields.choose') }}</option>
                                                    <option value="open">{{ __('admin/news.fields.open') }}</option>
                                                    <option value="closed">{{ __('admin/news.fields.closed') }}</option>
                                                @endif
                                            </select>
                                            @error('comments_status')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card card-box custom mb-10" id="accordionStatus">
                                <div class="card-header" data-toggle="collapse" href="#collapseStatus">
                                    <a class="card-title">
                                        {{ __('admin/news.fields.status') }}
                                    </a>
                                </div>
                                <div id="collapseStatus" class="card-body show" data-parent="#accordionStatus" >

                                    <div class="form-group row">
                                        <div class="col-sm-12 col-md-12">
                                            <select name="status" class="border-gray-300 rounded-md shadow-sm custom-select col-12 @error('status') border border-danger @enderror">
                                                @if($post->status == 'publish')
                                                    <option value="publish" selected>{{ __('admin/news.fields.publish') }}</option>
                                                    <option value="pending">{{ __('admin/news.fields.pending') }}</option>
                                                    <option value="draft">{{ __('admin/news.fields.draft') }}</option>
                                                @elseif($post->status == 'pending')
                                                    <option value="publish">{{ __('admin/news.fields.publish') }}</option>
                                                    <option value="pending" selected>{{ __('admin/news.fields.pending') }}</option>
                                                    <option value="draft">{{ __('admin/news.fields.draft') }}</option>
                                                @elseif($post->status == 'draft')
                                                    <option value="publish">{{ __('admin/news.fields.publish') }}</option>
                                                    <option value="pending">{{ __('admin/news.fields.pending') }}</option>
                                                    <option value="draft" selected>{{ __('admin/news.fields.draft') }}</option>
                                                @else
                                                    <option selected="">{{ __('admin/news.fields.choose') }}</option>
                                                    <option value="publish">{{ __('admin/news.fields.publish') }}</option>
                                                    <option value="pending">{{ __('admin/news.fields.pending') }}</option>
                                                    <option value="draft">{{ __('admin/news.fields.draft') }}</option>
                                                @endif
                                            </select>
                                            @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-10">
                            <button class="btn btn-primary bg-gray-800" type="submit">{{ __('admin/news.fields.update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="user_image_modal_{{$field}}">
        <livewire:admin.media-box :field="$field" />
    </div>


    @section('scripts')
        <script>
            $('#user_image_modal_{{$field}} #gallery_{{$field}} a.image_ch').click(function(){
                $('#user_image_field_{{$field}} #user_image_{{$field}}').val($(this).data('image'));
                var value = $("#user_image_{{$field}}").val();
                $("#user_image_field_{{$field}} .image_preview").html('<a class="cursor-pointer remove_img"><i class="fa fa-times-circle text-gray-700 text-2x1 float-left"></i><img src="'+value+'" width="100" /></a>');

                $("#user_image_field_{{$field}} .image_preview a.remove_img").click(function(){
                    $('#user_image_field_{{$field}} #user_image_{{$field}}').val('');
                    $("#user_image_field_{{$field}} .image_preview a.remove_img").remove();
                });
                //$('.media_uploader').modal('hide');
            });

            $(document).ready(function(){
                @if(LaravelLocalization::getCurrentLocale() == $key)
                $('.main_input').focus();
                        @endif
                var slug = function(str) {
                        var $slug = '';
                        var trimmed = $.trim(str);
                        //replace all special characters | symbols with a space
                        $slug = trimmed.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ')
                        // trim spaces at start and end of string
                            .replace(/^\s+|\s+$/gm,'')
                            // replace space with dash/hyphen
                            .replace(/\s+/g, '-');
                        return $slug.toLowerCase();
                    };

                $('.slug-input').keyup(function() {
                    var takedata = $('.slug-input').val();
                    $('.slug-output').val(slug(takedata));
                });
            });
        </script>
    @endsection
    @section('page_title'){{ __('admin/news.edit.title_tag',['post' => $post->title]) }}@endsection
</x-admin-layout>
