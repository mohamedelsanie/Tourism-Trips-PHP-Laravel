<x-admin-layout>
    <x-slot name="header">
        <div class="page-header mb-0">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin/common.home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.video.comments.index') }}">{{ __('admin/video_comment.index.title') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('admin/video_comment.edit.edit') }}<code>{{ $comment->title }}</code></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <a href="{{ route('admin.video.comments.index') }}" class="btn btn-primary btn-sm scroll-click">{{ __('admin/video_comment.show.back') }}</a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="clearfix mb-10">
                    <div class="pull-left">
                        <h4 class="text-blue h4">{{ __('admin/video_comment.edit.edit') }} </h4>
                    </div>
                </div>
                <div class="dropdown-divider"></div>

                <form action="{{ route('admin.video.comments.update', $comment->id) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <div class="col-sm-12 col-md-8 mb-30">

                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/video_comment.fields.name') }}</label>
                                <div class="col-sm-12 col-md-10">
                                    <input name="name" placeholder="{{ __('admin/video_comment.fields.name') }}" value="{{ $comment->name }}" class="border-gray-300 rounded-md shadow-sm form-control @error('name') border border-danger @enderror" type="text"/>
                                    @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>


                            <div class="card card-box custom mb-10" id="accordionWork">
                                <div class="card-header" data-toggle="collapse" href="#collapseWork">
                                    <a class="card-title">
                                        {{ __('admin/video_comment.fields.info') }}
                                    </a>
                                </div>
                                <div id="collapseWork" class="card-body show" data-parent="#accordionWork" >

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/video_comment.fields.comment') }}</label>
                                        <div class="col-sm-12 col-md-10">
                                            <textarea name="comment" class="border-gray-300 rounded-md shadow-sm textarea_editor form-control @error('comment') border border-danger @enderror">{{ $comment->comment }}</textarea>
                                            @error('comment')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/video_comment.fields.video_id') }}</label>
                                        <div class="col-sm-12 col-md-10">
                                            <select name="video_id" class="border-gray-300 rounded-md shadow-sm custom-select col-12 @error('video_id') border border-danger @enderror">
                                                <option value="" @if($comment->video_id == '') selected @endif>{{ __('admin/video_comment.fields.choose') }}</option>
                                                @foreach($posts as $post)
                                                    <option value="{{ $post->id }}" @if($comment->video_id == $post->id) selected @endif>{{ $post->title }}</option>
                                                @endforeach
                                            </select>
                                            @error('video_id')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/video_comment.fields.user_id') }}</label>
                                        <div class="col-sm-12 col-md-10">
                                            <select name="user_id" class="border-gray-300 rounded-md shadow-sm custom-select col-12 @error('user_id') border border-danger @enderror">
                                                <option value="" @if($comment->user_id == '') selected @endif>{{ __('admin/video_comment.fields.choose') }}</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}" @if($comment->user_id == $user->id) selected @endif>{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('user_id')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/video_comment.fields.comment_stars') }}</label>
                                        <div class="col-sm-12 col-md-10">
                                            <select name="comment_stars" class="border-gray-300 rounded-md shadow-sm custom-select col-12 @error('comment_stars') border border-danger @enderror">
                                                <option value="" @if($comment->comment_stars == '') selected @endif>{{ __('admin/video_comment.fields.choose') }}</option>
                                                <option value="5" @if($comment->comment_stars == '5') == 5) selected @endif>5</option>
                                                <option value="4" @if($comment->comment_stars == '4') == 4) selected @endif>4</option>
                                                <option value="3" @if($comment->comment_stars == '3') == 3) selected @endif>3</option>
                                                <option value="2" @if($comment->comment_stars == '2') == 2) selected @endif>2</option>
                                                <option value="1" @if($comment->comment_stars == '1') == 1) selected @endif>1</option>
                                            </select>
                                            @error('comment_stars')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4 mb-30">
                            <div class="card card-box custom mb-10" id="accordionStatus">
                                <div class="card-header" data-toggle="collapse" href="#collapseStatus">
                                    <a class="card-title">
                                        {{ __('admin/video_comment.fields.status') }}
                                    </a>
                                </div>
                                <div id="collapseStatus" class="card-body show" data-parent="#accordionStatus" >

                                    <div class="form-group row">
                                        <div class="col-sm-12 col-md-12">
                                            <select name="status" class="border-gray-300 rounded-md shadow-sm custom-select col-12 @error('status') border border-danger @enderror">
                                                @if($comment->status == 'publish')
                                                    <option value="publish" selected>{{ __('admin/video_comment.fields.publish') }}</option>
                                                    <option value="pending">{{ __('admin/video_comment.fields.pending') }}</option>
                                                    <option value="draft">{{ __('admin/video_comment.fields.draft') }}</option>
                                                @elseif($comment->status == 'pending')
                                                    <option value="publish">{{ __('admin/video_comment.fields.publish') }}</option>
                                                    <option value="pending" selected>{{ __('admin/video_comment.fields.pending') }}</option>
                                                    <option value="draft">{{ __('admin/video_comment.fields.draft') }}</option>
                                                @elseif($comment->status == 'draft')
                                                    <option value="publish">{{ __('admin/video_comment.fields.publish') }}</option>
                                                    <option value="pending">{{ __('admin/video_comment.fields.pending') }}</option>
                                                    <option value="draft" selected>{{ __('admin/video_comment.fields.draft') }}</option>
                                                @else
                                                    <option selected="">{{ __('admin/video_comment.fields.choose') }}</option>
                                                    <option value="publish">{{ __('admin/video_comment.fields.publish') }}</option>
                                                    <option value="pending">{{ __('admin/video_comment.fields.pending') }}</option>
                                                    <option value="draft">{{ __('admin/video_comment.fields.draft') }}</option>
                                                @endif
                                            </select>
                                            @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12 col-md-10">
                            <button class="btn btn-primary bg-gray-800" type="submit">{{ __('admin/video_comment.fields.update') }}</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    @section('page_title'){{ __('admin/video_comment.edit.title_tag',['comment' => $comment->name]) }}@endsection
</x-admin-layout>
