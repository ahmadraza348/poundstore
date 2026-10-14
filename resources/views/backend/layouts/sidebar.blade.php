<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>


                <li class="{{ request()->route()->getName() == 'admin.dashboard' ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <img src="{{ asset('backend/assets/img/icons/dashboard.svg') }}" alt="img">
                        <span>Dashboard</span>
                    </a>
                </li>   
                <li class="{{ request()->routeIs('category.*') ? 'active' : '' }}">
                        <a href="{{ route('category.index') }}">
                            <img src="{{ asset('backend/assets/img/icons/users1.svg') }}" alt="img">
                            <span>Category</span>
                        </a>
                </li>
                <li class="{{ request()->routeIs('product.*') ? 'active' : '' }}">
                        <a href="{{ route('product.index') }}">
                            <img src="{{ asset('backend/assets/img/icons/product.svg') }}" alt="img">
                            <span>Products</span>
                        </a>
                </li>
                <li class="{{ request()->routeIs('city.*') ? 'active' : '' }}">
                    <a href="{{ route('city.index') }}">
                        <img src="{{ asset('backend/assets/img/icons/users1.svg') }}" alt="img">
                        <span>Cities / Areas</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('outlet.*') ? 'active' : '' }}">
                    <a href="{{ route('outlet.index') }}">
                        <img src="{{ asset('backend/assets/img/icons/product.svg') }}" alt="img">
                        <span>Outlets</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('franchise-enquiry.*') ? 'active' : '' }}">
                    <a href="{{ route('franchise-enquiry.index') }}">
                        <img src="{{ asset('backend/assets/img/icons/users1.svg') }}" alt="img">
                        <span>Franchise Enquiries</span>   
                    </a>                  
                </li>
                <li class="{{ request()->routeIs('contact-message.*') ? 'active' : '' }}">
                    <a href="{{ route('contact-message.index') }}">
                        <img src="{{ asset('backend/assets/img/icons/mail.svg') }}" alt="img">
                        <span>Contact Messages</span>                       
                    </a>
                </li>

            </ul>



        </div>
    </div>
</div>
