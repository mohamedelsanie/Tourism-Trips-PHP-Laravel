<x-admin-layout>
    <x-slot name="header">
        <div class="page-header mb-0">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin/common.home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.contacts.index') }}">{{ __('admin/contact.index.title') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('admin/contact.edit.edit') }}<code>{{ $page->title }}</code></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <a href="{{ route('admin.contacts.index') }}" class="btn btn-primary btn-sm scroll-click">{{ __('admin/contact.show.back') }}</a>
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
                        <h4 class="text-blue h4">{{ __('admin/contact.edit.edit') }} </h4>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <form action="{{ route('admin.contacts.update', $page->id) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">

                            <div class="col-sm-12 col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/contact.fields.from_name') }}</label>
                                    <div class="col-sm-12 col-md-12">
                                        <input name="from_name" placeholder="{{ __('admin/contact.fields.from_name') }}" value="{{ $page->from_name }}" class="main_input border-gray-300 rounded-md shadow-sm form-control @error('from_name') border border-danger @enderror" type="text"/>
                                        @error('from_name')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/contact.fields.from_email') }}</label>
                                    <div class="col-sm-12 col-md-12">
                                        <input name="from_email" placeholder="{{ __('admin/contact.fields.from_email') }}" value="{{ $page->from_email }}" class=" border-gray-300 rounded-md shadow-sm form-control @error('from_email') border border-danger @enderror" type="text"/>
                                        @error('from_email')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/contact.fields.subject') }}</label>
                                    <div class="col-sm-12 col-md-12">
                                        <input name="subject" placeholder="{{ __('admin/contact.fields.subject') }}" value="{{ $page->subject }}" class=" border-gray-300 rounded-md shadow-sm form-control @error('subject') border border-danger @enderror" type="text"/>
                                        @error('subject')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/contact.fields.massege') }}</label>
                                    <div class="col-sm-12 col-md-12">
                                        <textarea name="massege" class="border-gray-300 rounded-md shadow-sm textarea_editor form-control @error('massege') border border-danger @enderror">{{ $page->massege }}</textarea>
                                        @error('massege')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>


                        <div class="col-sm-12 col-md-10">
                            <button class="btn btn-primary bg-gray-800" type="submit">{{ __('admin/contact.fields.update') }}</button>
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
            $(document).ready(function(){
                $('.main_input').focus();
            });
        </script>
    @endsection
    @section('page_title'){{ __('admin/contact.edit.title_tag',['page' => $page->title]) }}@endsection
</x-admin-layout>
