<x-admin-layout>
    <x-slot name="header">
        <div class="page-header mb-0">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('admin/common.home') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ __('admin/menu.index.title') }}
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">

                    <a href="{{ route('admin.menus.index') }}?id=new" class="btn btn-primary btn-sm scroll-click"><i class="fa fa-plus"></i> {{ __('admin/menu.index.create') }}</a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="clearfix mb-10">
                            <div class="pull-left">
                                <h4 class="text-blue h4">{{ __('admin/menu.index.title') }}</h4>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                    </div>
<!--------------------------------->


                <div class="container-fluid">

                    <div class="content info-box">
                        @if(count($menus) > 0)
                            {{ __('admin/menu.index.select') }}
                            <form action="{{route('admin.menus.index')}}" class="form-inline">
                                <select name="id" class="border-gray-300 rounded-md shadow-sm form-control" style="padding: 0 25px 0 10px;">
                                    @foreach($menus as $menu)
                                        @if($desiredMenu != '')
                                            <option value="{{$menu->id}}" @if($menu->id == $desiredMenu->id) selected @endif>{{$menu->title}}</option>
                                        @else
                                            <option value="{{$menu->id}}">{{$menu->title}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <button class="btn btn-sm btn-primary btn-menu-select" style="padding:10px 20px;">{{ __('admin/menu.index.select_button') }}</button>
                            </form>

                        @endif

                    </div>


                    <div class="row" id="main-row">
                        <div class="col-sm-3 cat-form @if(count($menus) == 0) disabled @endif">

                            <div class="panel-group" id="menu-items">


                                <div class="card card-box custom mb-10" id="accordionTourCategories">
                                    <div class="card-header" data-toggle="collapse" href="#collapseTourCategories">
                                        <a class="card-title">
                                            {{ __('admin/menu.index.tour_categories') }}
                                        </a>
                                    </div>
                                    <div id="collapseTourCategories" class="card-body show" data-parent="#accordionTourCategories" >

                                        <div class="form-group row">
                                            <div class="col-sm-12 col-md-12">
                                                <div class="item-list-body" id="categories-tour-list">
                                                    @foreach($tour_categories as $cat)
                                                        <p><input type="checkbox" name="select-tour-category[]" value="{{$cat->id}}"> {{$cat->title}}</p>
                                                    @endforeach
                                                </div>
                                                <div class="item-list-footer">
                                                    <label class="btn btn-sm btn-default" style="padding: 0;margin-top: 12px;"><input type="checkbox" id="select-all-tour-categories"> {{ __('admin/menu.index.select_all') }}</label>
                                                    <button type="button" class="pull-right btn btn-primary btn-sm" style="padding:10px 20px;background-color: blue;" id="add-tour-categories">{{ __('admin/menu.index.addto_menu') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card card-box custom mb-10" id="accordionTours">
                                    <div class="card-header" data-toggle="collapse" href="#collapseTours">
                                        <a class="card-title">
                                            {{ __('admin/menu.index.tours') }}
                                        </a>
                                    </div>
                                    <div id="collapseTours" class="card-body show" data-parent="#accordionTours" >

                                        <div class="form-group row">
                                            <div class="col-sm-12 col-md-12">
                                                <div class="item-list-body" id="posts-list">
                                                    @foreach($tours as $post)
                                                        <p><input type="checkbox" name="select-post[]" value="{{$post->id}}"> {{$post->title}}</p>
                                                    @endforeach
                                                </div>
                                                <div class="item-list-footer">
                                                    <label class="btn btn-sm btn-default" style="padding: 0;margin-top: 12px;"><input type="checkbox" id="select-all-tours"> {{ __('admin/menu.index.select_all') }}</label>
                                                    <button type="button" id="add-tours" class="pull-right btn btn-primary btn-sm" style="padding:10px 20px;background-color: blue;">{{ __('admin/menu.index.addto_menu') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="card card-box custom mb-10" id="accordionCategories">
                                    <div class="card-header" data-toggle="collapse" href="#collapseCategories">
                                        <a class="card-title">
                                            {{ __('admin/menu.index.categories') }}
                                        </a>
                                    </div>
                                    <div id="collapseCategories" class="card-body show" data-parent="#accordionCategories" >

                                        <div class="form-group row">
                                            <div class="col-sm-12 col-md-12">
                                                <div class="item-list-body" id="categories-list">
                                                    @foreach($categories as $cat)
                                                        <p><input type="checkbox" name="select-category[]" value="{{$cat->id}}"> {{$cat->title}}</p>
                                                    @endforeach
                                                </div>
                                                <div class="item-list-footer">
                                                    <label class="btn btn-sm btn-default" style="padding: 0;margin-top: 12px;"><input type="checkbox" id="select-all-categories"> {{ __('admin/menu.index.select_all') }}</label>
                                                    <button type="button" class="pull-right btn btn-primary btn-sm" style="padding:10px 20px;background-color: blue;" id="add-categories">{{ __('admin/menu.index.addto_menu') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <div class="card card-box custom mb-10" id="accordionPosts">
                                    <div class="card-header" data-toggle="collapse" href="#collapsePosts">
                                        <a class="card-title">
                                            {{ __('admin/menu.index.posts') }}
                                        </a>
                                    </div>
                                    <div id="collapsePosts" class="card-body show" data-parent="#accordionPosts" >

                                        <div class="form-group row">
                                            <div class="col-sm-12 col-md-12">
                                                <div class="item-list-body" id="posts-list">
                                                    @foreach($posts as $post)
                                                        <p><input type="checkbox" name="select-post[]" value="{{$post->id}}"> {{$post->title}}</p>
                                                    @endforeach
                                                </div>
                                                <div class="item-list-footer">
                                                    <label class="btn btn-sm btn-default" style="padding: 0;margin-top: 12px;"><input type="checkbox" id="select-all-posts"> {{ __('admin/menu.index.select_all') }}</label>
                                                    <button type="button" id="add-posts" class="pull-right btn btn-primary btn-sm" style="padding:10px 20px;background-color: blue;">{{ __('admin/menu.index.addto_menu') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="card card-box custom mb-10" id="accordionLinks">
                                    <div class="card-header" data-toggle="collapse" href="#collapseLinks">
                                        <a class="card-title">
                                            {{ __('admin/menu.index.links') }}
                                        </a>
                                    </div>
                                    <div id="collapseLinks" class="card-body show" data-parent="#accordionLinks" >

                                        <div class="form-group row">
                                            <div class="col-sm-12 col-md-12">

                                                <div class="item-list-body">

                                                    @foreach(config('translatable.languages') as $key => $lang)
                                                        <div class="form-group">
                                                            <label>{{ __('admin/menu.index.url') }} {{ $lang }}</label>
                                                            <input type="url" id="url_{{ $key }}" name="{{ $key }}[url]" class="border-gray-300 rounded-md shadow-sm form-control" placeholder="https://">
                                                        </div>
                                                    @endforeach
                                                    @foreach(config('translatable.languages') as $key => $lang)
                                                        <div class="form-group">
                                                            <label>{{ __('admin/menu.index.link') }} {{ $lang }}</label>
                                                            <input type="text" id="linktext_{{ $key }}" name="{{ $key }}[text]" class="border-gray-300 rounded-md shadow-sm form-control" placeholder="">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="item-list-footer">
                                                    <button type="button" class="pull-right btn btn-primary btn-sm" style="padding:10px 20px;background-color: blue;" id="add-custom-link">{{ __('admin/menu.index.addto_menu') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>

                        <div class="col-sm-9 cat-view">

                            <div class="panel-group" id="menu-items">

                                <div class="card card-box custom mb-10" >
                                    <div class="card-header">
                                        <a class="card-title">
                                            {{ __('admin/menu.index.menu_structure') }}
                                        </a>
                                    </div>
                                    <div class="card-body show" >

                                        @if($the_id == 'new')
                                            <h4>{{ __('admin/menu.index.create_title') }}</h4>
                                            <form method="post" action="{{route('admin.menus.index')}}/create">
                                                {{csrf_field()}}
                                                @method('post')
                                                <div class="row">

                                                    @foreach(config('translatable.languages') as $key => $lang)
                                                        <div class="col-sm-12">
                                                            <label>{{ __('admin/menu.index.menu_name') }} {{ $lang }}</label>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <input type="text" name="{{ $key }}[title]" class="border-gray-300 rounded-md shadow-sm form-control">
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    <div class="col-sm-6 text-right">
                                                        <button class="btn btn-sm btn-primary">{{ __('admin/menu.index.create') }}</button>
                                                    </div>
                                                </div>
                                            </form>
                                        @else
                            @if(empty($desiredMenu))
                            @else

                                <div id="menu-content">
                                    <div id="result"></div>
                                    <div style="min-height: 240px;">
                                        <p>{{ __('admin/menu.index.menu_top_title') }}</p>
                                        @if($desiredMenu != '')


                                            <ul class="menu ui-sortable" id="menuitems">
                                                @if(!empty($menuitems))
                                                    @foreach($menuitems as $key=>$item)
                                                        <li data-id="{{$item->id}}" class="menu-item"><span class="menu-item-bar"><i class="fa fa-arrows"></i> @if(empty($item->name)) {{$item->title}} @else {{$item->name}} @endif <a href="#collapse{{$item->id}}" class="pull-right" data-toggle="collapse"><i class="fa fa-pencil"></i></a></span>
                                                            <div class="collapse" id="collapse{{$item->id}}">
                                                                <div class="input-box">
                                                                    <form method="post" action="{{route('admin.menus.updateMenuItem',$item->id)}}">
                                                                        {{csrf_field()}}
                                                                        <div class="form-group">
                                                                            <label>{{ __('admin/menu.index.link_name') }}</label>
                                                                            <input type="text" name="name" value="@if(empty($item->name)) {{$item->title}} @else {{$item->name}} @endif" class="form-control">
                                                                        </div>
                                                                        @if($item->type == 'custom')
                                                                            <div class="form-group">
                                                                                <label>{{ __('admin/menu.index.url') }}</label>
                                                                                <input type="text" name="slug" value="{{$item->slug}}" class="form-control">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <input type="checkbox" name="target" value="_blank" @if($item->target == '_blank') checked @endif> {{ __('admin/menu.index.target') }}
                                                                            </div>
                                                                        @endif
                                                                        <div class="form-group">
                                                                            <button class="btn btn-sm btn-primary">{{ __('admin/menu.index.save') }}</button>
                                                                            <a href="{{route('admin.menus.deleteMenuItem',['id' => $item->id,'key' => $key])}}" class="btn btn-sm btn-danger">{{ __('admin/menu.index.delete') }}</a>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <ul>
                                                                @if(isset($item->children))
                                                                    @foreach($item->children as $m)
                                                                        @foreach($m as $in=>$data)
                                                                            <li data-id="{{$data->id}}" class="menu-item"> <span class="menu-item-bar"><i class="fa fa-arrows"></i> @if(empty($data->name)) {{$data->title}} @else {{$data->name}} @endif <a href="#collapse{{$data->id}}" class="pull-right" data-toggle="collapse"><i class="fa fa-pencil"></i></a></span>
                                                                                <div class="collapse" id="collapse{{$data->id}}">
                                                                                    <div class="input-box">
                                                                                        <form method="post" action="{{route('admin.menus.updateMenuItem',$data->id)}}">
                                                                                            {{csrf_field()}}
                                                                                            <div class="form-group">
                                                                                                <label>{{ __('admin/menu.index.link_name') }}</label>
                                                                                                <input type="text" name="name" value="@if(empty($data->name)) {{$data->title}} @else {{$data->name}} @endif" class="form-control">
                                                                                            </div>
                                                                                            @if($data->type == 'custom')
                                                                                                <div class="form-group">
                                                                                                    <label>{{ __('admin/menu.index.url') }}</label>
                                                                                                    <input type="text" name="slug" value="{{$data->slug}}" class="form-control">
                                                                                                </div>
                                                                                                <div class="form-group">
                                                                                                    <input type="checkbox" name="target" value="_blank" @if($data->target == '_blank') checked @endif> {{ __('admin/menu.index.target') }}
                                                                                                </div>
                                                                                            @endif
                                                                                            <div class="form-group">
                                                                                                <button class="btn btn-sm btn-primary">{{ __('admin/menu.index.save') }}</button>
                                                                                                <a href="{{route('admin.menus.deleteMenuItem',['id' => $data->id,'key' => $key])}}/{{$in}}" class="btn btn-sm btn-danger">{{ __('admin/menu.index.delete') }}</a>
                                                                                            </div>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                                <ul>
                                                                                </ul>

                                                                            </li>

                                                                        @endforeach
                                                                    @endforeach
                                                                @endif
                                                            </ul>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        @endif
                                    </div>
                                    @if($desiredMenu != '')
                                        <div class="text-right">
                                            <button class="btn btn-sm btn-primary" id="saveMenu">{{ __('admin/menu.index.save_menu') }}</button>
                                            <a href="{{route('admin.menus.destroy',$desiredMenu->id)}}" class="btn btn-sm btn-danger pull-left">{{ __('admin/menu.index.delete_menu') }}</a>
                                        </div>

                                        <div class="text-left">
                                        </div>
                                    @endif
                                </div>

                                            @endif
                                        @endif
                        </div>
                    </div>
                </div>
                <div id="serialize_output" style="display: none;">@if($desiredMenu){{$desiredMenu->content}}@endif</div>
                @section('scripts')
                    <script src="{{ asset('assets/admin/src/scripts/jquery-sortable.js') }}"></script>
                @if($desiredMenu)
                    <script>

                        $('#select-all-categories').click(function(event) {
                            if(this.checked) {
                                $('#categories-list :checkbox').each(function() {
                                    this.checked = true;
                                });
                            }else{
                                $('#categories-list :checkbox').each(function() {
                                    this.checked = false;
                                });
                            }
                        });

                        $('#select-all-tour-categories').click(function(event) {
                            if(this.checked) {
                                $('#categories-tour-list :checkbox').each(function() {
                                    this.checked = true;
                                });
                            }else{
                                $('#categories-tour-list :checkbox').each(function() {
                                    this.checked = false;
                                });
                            }
                        });

                        $('#select-all-tours').click(function() {
                            if(this.checked) {
                                $('#tours-list :checkbox').each(function() {
                                    this.checked = true;
                                });
                            }else{
                                $('#tours-list :checkbox').each(function() {
                                    this.checked = false;
                                });
                            }
                        });

                        $('#select-all-posts').click(function() {
                            if(this.checked) {
                                $('#posts-list :checkbox').each(function() {
                                    this.checked = true;
                                });
                            }else{
                                $('#posts-list :checkbox').each(function() {
                                    this.checked = false;
                                });
                            }
                        });

                        $('#add-tour-categories').click(function(){
                            var menuid = {{ $desiredMenu->id }};
                            var n = $('input[name="select-tour-category[]"]:checked').length;
                            var array = $('input[name="select-tour-category[]"]:checked');
                            var ids = [];
                            for(i=0;i<n;i++){
                                ids[i] =  array.eq(i).val();
                            }
                            if(ids.length == 0){
                                return false;
                            }
                            $.ajax({
                                type:"get",
                                data: {menuid:menuid,ids:ids},
                                url: "{{route('admin.menus.addToursCatToMenu')}}",
                                success:function(res){
                                    location.reload();
                                }
                            })
                        });

                        $('#add-categories').click(function(){
                            var menuid = {{ $desiredMenu->id }};
                            var n = $('input[name="select-category[]"]:checked').length;
                            var array = $('input[name="select-category[]"]:checked');
                            var ids = [];
                            for(i=0;i<n;i++){
                                ids[i] =  array.eq(i).val();
                            }
                            if(ids.length == 0){
                                return false;
                            }
                            $.ajax({
                                type:"get",
                                data: {menuid:menuid,ids:ids},
                                url: "{{route('admin.menus.addCatToMenu')}}",
                                success:function(res){
                                    location.reload();
                                }
                            })
                        });
                        $('#add-tours').click(function(){
                            var menuid = {{ $desiredMenu->id }};
                            var n = $('input[name="select-post[]"]:checked').length;
                            var array = $('input[name="select-post[]"]:checked');
                            var ids = [];
                            for(i=0;i<n;i++){
                                ids[i] =  array.eq(i).val();
                            }
                            if(ids.length == 0){
                                return false;
                            }
                            $.ajax({
                                type:"get",
                                data: {menuid:menuid,ids:ids},
                                url: "{{route('admin.menus.addTourToMenu')}}",
                                success:function(res){
                                    location.reload();
                                }
                            })
                        });

                        $('#add-posts').click(function(){
                            var menuid = {{ $desiredMenu->id }};
                            var n = $('input[name="select-post[]"]:checked').length;
                            var array = $('input[name="select-post[]"]:checked');
                            var ids = [];
                            for(i=0;i<n;i++){
                                ids[i] =  array.eq(i).val();
                            }
                            if(ids.length == 0){
                                return false;
                            }
                            $.ajax({
                                type:"get",
                                data: {menuid:menuid,ids:ids},
                                url: "{{route('admin.menus.addPostToMenu')}}",
                                success:function(res){
                                    location.reload();
                                }
                            })
                        });
                        $("#add-custom-link").click(function(){
                            var menuid = {{ $desiredMenu->id }};
                            var url_ar = $('#url_ar').val();
                            var url_en = $('#url_en').val();
                            var link_ar = $('#linktext_ar').val();
                            var link_en = $('#linktext_en').val();
                            var target = 'custom';
                            if(url_ar.length > 0 && link_ar.length > 0){
                                $.ajax({
                                    type:"get",
                                    data: {menuid:menuid,url_ar:url_ar,url_en:url_en,link_ar:link_ar,link_en:link_en,target:target},
                                    url: "{{route('admin.menus.addCustomLink')}}",
                                    success:function(res){
//                                        alert(res);
                                        location.reload();
                                    }
                                });
                            }
                        });
                    </script>
                    <script>
                        var group = $("#menuitems").sortable({
                            group: 'serialization',
                            onDrop: function ($item, container, _super) {
                                var data = group.sortable("serialize").get();
                                var jsonString = JSON.stringify(data, null, ' ');
                                $('#serialize_output').text(jsonString);
                                _super($item, container);
                            },
                        });
                    </script>
                    <script>
                        $('#saveMenu').click(function(){
                            var menuid = {{ $desiredMenu->id }};
                            var location = $('input[name="location"]:checked').val();
                            var newText = $("#serialize_output").text();
                            var data = JSON.parse($("#serialize_output").text());
                            $.ajax({
                                type:"get",
                                data: {menuid:menuid,data:data,location:location},
                                url: "{{route('admin.menus.updateMenu')}}",
                                success:function(res){
//                                    alert(data);
                                    location.reload();
                                }
                            })
                        });
                    </script>
                @endif
                @endsection
                <style>
                    .item-list,.info-box{background: #fff;padding: 10px;}
                    .item-list-body{max-height: 300px;overflow-y: scroll;}
                    .panel-body p{margin-bottom: 5px;}
                    .info-box{margin-bottom: 15px;}
                    .item-list-footer{padding-top: 10px;}
                    .panel-heading a{display: block;}
                    .form-inline{display: inline;}
                    .form-inline select{padding: 4px 10px;}
                    .btn-menu-select{padding: 4px 10px}
                    .disabled{pointer-events: none; opacity: 0.7;}
                    .menu-item-bar{background: #eee;padding: 5px 10px;border:1px solid #d7d7d7;margin-bottom: 5px; width: 75%; cursor: move;display: block;}
                    #serialize_output{display: block;}
                    .menulocation label{font-weight: normal;display: block;}

                    body.dragging, body.dragging * {cursor: move !important;}

                    .dragged {
                        padding: 0 10px;
                        position: absolute;
                        top: 20px;
                        right: 0px;
                        bottom: 20px;
                    }

                    ol.example li.placeholder {position: relative;}
                    ol.example li.placeholder:before {position: absolute;}

                    #menuitem{list-style: none;}
                    #menuitem ul{list-style: none;}
                    .input-box{width:75%;background:#fff;padding: 10px;box-sizing: border-box;margin-bottom: 10px;border: 1px solid #ddd;margin-top: -6px;}
                    .input-box .form-control{width: 50%}

                    @if(LaravelLocalization::getCurrentLocale() == 'ar')
                    ul.menu ul {margin-right: 25px;  }
                    @else
                    ul.menu ul {margin-left: 25px;  }
                    @endif



                </style>
                <!--------------------------------->
            </div>
            </div>
            </div>
            </div>
        </div>
    </div>
    @section('page_title'){{ __('admin/menu.index.title_tag') }}@endsection
</x-admin-layout>
