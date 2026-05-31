<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Hierarchy</title>
</head>
<body>
<h1>Category Hierarchy</h1>
<a href="{{ route('categories.create') }}">Create Category</a>

<ul>
    @foreach ($categories as $category)
        <li>
            {{ $category->name }}
            @if ($category->allChildren)
                @include('categories.partials.children', ['children' => $category->allChildren])
            @endif
        </li>
    @endforeach
</ul>
</body>
</html>
