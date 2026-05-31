<ul>
    @foreach ($children as $child)
        <li>
            {{ $child->name }}
            @if ($child->allChildren)
                @include('categories.partials.children', ['children' => $child->allChildren])
            @endif
        </li>
    @endforeach
</ul>
