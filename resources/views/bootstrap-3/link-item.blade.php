<li class="{{ $item->isActive() }}">
    <a href="{{ $item->getUrl() }}" {!! $item->attributes() !!}>
        {{ $item->getContent() }}
    </a>
</li>
