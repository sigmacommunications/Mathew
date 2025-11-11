 <!-- Left Panel -->
 <!-- Left Panel -->
 <aside id="left-panel" class="left-panel" style="background-color:#212529">
     <nav class="navbar navbar-expand-sm navbar-default">
         <div id="main-menu" class="main-menu collapse navbar-collapse" style="background-color:#212529">
             <ul class="nav navbar-nav">

                 {{-- @if (auth()->check() && auth()->user()->payment_status == 1)
                    
                 @else
                     <li class="{{ request()->is('user/purchase-package/create') ? 'active' : '' }}">
                         <a href="{{ route('user.purchase.package.create') }}"><i
                                 class="menu-icon fa fa-laptop"></i>Dashboard</a>
                     </li>
                 @endif --}}

                 <li class="{{ request()->is('user/dashboard') ? 'active' : '' }}">
                     <a href="{{ route('user.dashboard') }}"><i class="menu-icon fa fa-laptop"></i>Dashboard </a>
                 </li>

                 <li class="{{ request()->is('user/transcript') ? 'active' : '' }}">
                     <a href="{{ route('user.transcript') }}"><i class="menu-icon fa fa-cogs"></i>Transcript List</a>
                 </li>

                 {{-- @if (auth()->check() && auth()->user()->payment_status == 1)
                    
                 @else
                     <li class="active">
                         <a href="{{ route('user.purchase.package.create') }}"><i class="menu-icon fa fa-cogs"></i>Video
                             List</a>
                     </li>
                 @endif --}}

                 {{-- <li class="{{ request()->is('user/video') ? 'active' : '' }}">
                     <a href="{{ route('user.video') }}"><i class="menu-icon fa fa-cogs"></i>Video List</a>
                 </li> --}}

                 <li class="menu-item-has-children dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                         aria-expanded="false"> <i class="menu-icon fa fa-cogs"></i>Account Setting</a>
                     <ul class="sub-menu children dropdown-menu">
                         <li>
                             <a href="{{ route('user.profile.edit') }}" style="color: black !important;">
                                 <i class="fa fa-puzzle-piece"></i>Profile
                             </a>
                         </li>
                 </li>
                 <li>
                     <a href="{{ route('user.change_password') }}" style="color: black !important;">
                         <i class="fa fa-puzzle-piece"></i>Change Password
                 </li>
                 </a>
                 </li>

             </ul>
             </li>


             <li class="menu-item">
                 <a class="dropdown-toggle" aria-haspopup="true" aria-expanded="false" href="#"
                     onclick="event.preventDefault(); document.getElementById('logoutform').submit();"><i
                         class="menu-icon fa fa-cogs"></i>Logout</a>
             </li>
             </ul>

         </div><!-- /.navbar-collapse -->
     </nav>
 </aside>
