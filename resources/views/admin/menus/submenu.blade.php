
<!-- Start an unoredered list -->
<ul>

    <!-- Loop through each category -->
@foreach ($menuitems as $key => $item)
    <!-- Include subcategories.blade.php file and pass the current category to it -->
        {{ $item->id }}
    @if(isset($item->title)) {{ $item->title }} @endif
        <div style="margin-right:20px; background: #ddd;">
            @if(isset($item->children))
                @foreach($item->children as $m)
                    @include('admin.menus.submenu', ['menuitems' => $m])
                @endforeach
            @endif
        </div>
    @endforeach
<ul>