@php
   $path = $_SERVER["REQUEST_URI"];
@endphp
<div class="email-app-sidebar tabs-links p-3">
    <ul class="nav main-menu side-nav-links" role="tablist">
        <li class="mb-3"><a class="btn-light @if($path == '/roomnum') active @endif" href="{{route('room.roomNumber')}}"><span class="title text-capitalize">Room Number</span></a></li>
        <li class="mb-3"><a class="btn-light @if($path == '/setting/tariff') active @endif" href="{{route('tariff.index')}}"><span class="title text-capitalize">Room Tariff</span></a></li>
        <li class="mb-3"><a class="btn-light @if($path == '/roomtype') active @endif" href="{{route('roomtype.index')}}"><span class="title text-capitalize">Room Specification</span></a></li>
        <li class="mb-3"><a class="btn-light @if($path == '/restaurant/restaurant-table') active @endif" href="{{route('restaurant-table.index')}}"><span class="title text-capitalize">Table</span></a></li>
        <li class="mb-3"><a class="btn-light @if($path == '/restaurant/restaurant-menu') active @endif" href="{{route('restaurant-item.index')}}"><span class="title text-capitalize">Menu</span></a></li>
        <li class="mb-3"><a class="btn-light @if($path == '/restaurant/restaurant-raw-material') active @endif" href="{{route('restaurant-raw-material.index')}}"><span class="title text-capitalize">Raw Item</span></a></li>
        <li class="mb-3"><a class="btn-light @if($path == '/restaurant/restaurant-item-attribute') active @endif" href="{{route('restaurant-item-attribute.index')}}"><span class="title text-capitalize">Item Attribute</span></a></li>
        <li class="mb-3"><a class="btn-light @if($path == '/restaurant/restaurant-item-category') active @endif" href="{{route('restaurant-item-category.index')}}"><span class="title text-capitalize">Item Category</span></a></li>
        <li class="mb-3"><a class="btn-light @if($path == '/tax/tax-slab') active @endif" href="{{route('taxslab.index')}}"><span class="title text-capitalize">Tax Slabs</span></a></li>
        <li class="mb-3"><a class="btn-light @if($path == '/setting/payment-method') active @endif" href="{{route('payment-method.index')}}"><span class="title text-capitalize">Payment Method</span></a></li>
        <li class="mb-3"><a class="btn-light @if($path == '/setting/vendor') active @endif" href="{{route('vendor.index')}}"><span class="title text-capitalize">Vendor</span></a></li>
        <li class="mb-3"><a class="btn-light @if($path == '/setting/company') active @endif" href="{{route('company.index')}}"><span class="title text-capitalize">Company</span></a></li>
        <li class="mb-3"><a class="btn-light @if($path == '/setting/waiter') active @endif" href="{{route('waiter.index')}}"><span class="title text-capitalize">Waiter</span></a></li>
        <li class="mb-3"><a class="btn-light @if($path == '/setting/event') active @endif" href="{{route('event.index')}}"><span class="title text-capitalize">Banquet Event</span></a></li>
        <li class="mb-3"><a class="btn-light @if($path == '/setting/feature') active @endif" href="{{route('feature.index')}}"><span class="title text-capitalize">Banquet Feature</span></a></li>
        <li class="mb-3"><a class="btn-light @if($path == '/setting/accessories') active @endif" href="{{route('accessories.index')}}"><span class="title text-capitalize">Banquet Accesories</span></a></li>
        <li class="mb-3"><a class="btn-light @if($path == '/setting/reason-closer') active @endif" href="{{route('reason-closer.index')}}"><span class="title text-capitalize">Room Closer</span></a></li>
        <li class="mb-3"><a class="btn-light @if($path == '/setting/usertype') active @endif" href="{{route('usertype.index')}}"><span class="title text-capitalize">Usertype</span></a></li>
        <li class="mb-3"><a class="btn-light @if($path == '/setting/user') active @endif" href="{{route('user.index')}}"><span class="title text-capitalize">User</span></a></li>
    </ul>
</div>