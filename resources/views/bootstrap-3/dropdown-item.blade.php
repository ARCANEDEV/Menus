<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        {{ $item->getContent() }} <span class="caret"></span>
    </a>
    @if ($item->hasChildren())
        <ul class="{{ $item->isRoot() ? 'dropdown-menu' : 'dropdown-sub-menu' }}">
            @each('menus::bootstrap-3.menu-item', $item->children(), 'item')
        </ul>
    @endif
</li>
