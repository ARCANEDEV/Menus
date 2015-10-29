@if ($item->isDivider())
    @include('menus::bootstrap-3.divider-item', ['item' => $item])
@elseif ($item->isHeader())
    @include('menus::bootstrap-3.header-item', ['item' => $item])
@elseif ($item->isDropdown())
    @include('menus::bootstrap-3.dropdown-item', ['item' => $item])
@else
    @include('menus::bootstrap-3.link-item', ['item' => $item])
@endif
