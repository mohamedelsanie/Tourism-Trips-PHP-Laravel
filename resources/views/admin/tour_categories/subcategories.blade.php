
<!-- Start an unoredered list -->
<ul>

    <!-- Loop through each category -->
@foreach ($category as $cat)

    <!-- Include subcategories.blade.php file and pass the current category to it -->
        {{ $cat->title }}
        <div style="margin-left:20px">
        @include('admin.post_categories.subcategories', ['category' => $cat->children])
        </div>
    @endforeach
<ul>