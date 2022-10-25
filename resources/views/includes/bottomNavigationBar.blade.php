
@unless (\Request::route()->getName() == 'user.find-store')
    @if (Auth::user() && Auth::user()->first_name && Auth::user()->last_name)
        <div id="footer-bar" class="footer-bar-1">
            <a href="{{ route('user.restaurant-foods.index') }}" class="{{ \Request::route()->getName() == 'user.restaurant-foods.index' ? 'active-nav' : '' }}">
                <i class='fas fa-hamburger'></i>
                <span>{{ __('text.menu') }}</span>
            </a>
            <a href="{{ route('user.restaurant-food-categories.index') }}" class="{{ \Request::route()->getName() == 'user.restaurant-food-categories.index' ? 'active-nav' : '' }}">
                <i class="fa-solid fa-list-check"></i>
                <span>{{ __('text.categories') }}</span>
            </a>
            <a href="{{ route('user.restaurant-foods.create') }}" class="{{ \Request::route()->getName() == 'user.restaurant-foods.create' ? 'active-nav' : '' }}">
                <div class="home_route">
                    <i class="fa fa-plus pb-1" aria-hidden="true" style="font-size: 20px;"></i>
                    <span style="font-size: 14px;"></span>
                </div>
            </a>
            <a href="{{ route('user.index') }}" class="{{ \Request::route()->getName() == 'user.index' ? 'active-nav' : '' }}">
                <i class="fa-solid fa-store"></i>
                <span>{{ __('text.home') }}</span>
            </a>
            <a href="{{route('user.restaurant.edit',auth()->user()->id)}}" class="{{ \Request::route()->getName() == 'user.restaurant.edit' ? 'active-nav' : '' }}" data-menu="menu-settings">
                <i class="fa fa-cog"></i>
                <span>{{ __('text.setting') }}</span>
            </a>
        </div>
    @endif
@endunless