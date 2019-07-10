<!-- Sidebar -->
<ul class="sidebar navbar-nav">
  <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="{{route('dashboard')}}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>
  @if(Auth::user()->user_type == "admin")
  <li class="nav-item {{ (Request::is('users') || Request::is('users/create') || Request::route()->getName()=='users.edit' ) ? 'active' : '' }}">
    <a class="nav-link" href="{{url('users')}}">
      <i class="fas fa-fw fa-users"></i>
      <span>User Management</span>
    </a>
  </li>
  @php
  $active_pages_menu = ['custompage.index','custompage.create','custompage.edit','testimonial.index','testimonial.create','testimonial.edit'];
  
  @endphp
  <li class="nav-item dropdown {{(in_array(Request::route()->getName(),$active_pages_menu) ? 'show active' : '')}}">
    <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="{{(in_array(Request::route()->getName(),$active_pages_menu) ? 'true' : 'false')}}">
      <i class="fas fa-fw fa-folder"></i>
      <span>Pages</span>
    </a>
    <div class="dropdown-menu {{(in_array(Request::route()->getName(),$active_pages_menu) ? 'show' : '')}}" aria-labelledby="pagesDropdown">
      <a class="dropdown-item {{ (Request::is('custompage') || Request::is('custompage/create') || Request::route()->getName()=='custompage.edit' ) ? 'active' : '' }}" href="{{ url('custompage') }}">CMS Pages</a>      
      <a class="dropdown-item {{ (Request::is('testimonial') || Request::is('testimonial/create') || Request::route()->getName()=='testimonial.edit' ) ? 'active' : '' }}" href="{{ url('testimonial') }}">Testimonial</a>
      <a class="dropdown-item" href="{{ url('partner_images') }}">Partners</a>
    </div>
  </li>
   <li class="nav-item">
    <a class="nav-link" href="#">
      <i class="fas fa-fw fa-comments"></i>
      <span>Messages</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{route('chart_settings')}}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Chart Settings</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{route('mass_communication')}}">
      <i class="fas fa-fw fa-envelope-square"></i>
      <span>Mass Communication</span>
    </a>
  </li>
  <li class="nav-item dropdown {{(in_array(Request::route()->getName(),$active_pages_menu) ? 'show active' : '')}}">
    <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="{{(in_array(Request::route()->getName(),$active_pages_menu) ? 'true' : 'false')}}">
      <i class="fas fa-fw fa-folder"></i>
      <span>Front Settings</span>
    </a>
    <div class="dropdown-menu {{(in_array(Request::route()->getName(),$active_pages_menu) ? 'show' : '')}}" aria-labelledby="pagesDropdown">
      <a class="dropdown-item {{ (Request::is('custompage') || Request::is('custompage/create') || Request::route()->getName()=='custompage.edit' ) ? 'active' : '' }}" href="{{ url('donation_backend') }}">Donation</a>
      <a class="dropdown-item"  href="{{ url('headersetting') }}">Menu Settings</a>
    </div>
  </li>
  <li class="nav-item {{ (Request::is('socialmedia') || Request::is('socialmedia/create') || Request::route()->getName()=='socialmedia.edit' ) ? 'active' : '' }}">
    <a class="nav-link" href="{{url('socialmedia')}}">
      <i class="fas fa-fw fa-users"></i>
      <span>Social Media</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('subscriptions') }}">
      <i class="fas fa-fw fa-pager"></i>
      <span>My Subscriptions</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('transaction') }}">
      <i class="fas fa-fw fa-pager"></i>
      <span>Transaction History</span>
    </a>
  </li>
  @else
  <li class="nav-item">
    <a class="nav-link" href="{{ route('subscriptions') }}">
      <i class="fas fa-fw fa-pager"></i>
      <span>My Subscriptions</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('transaction') }}">
      <i class="fas fa-fw fa-pager"></i>
      <span>Transaction History</span>
    </a>
  </li>
  @endif
</ul>