 <!-- Left Panel -->
 <aside id="left-panel" class="left-panel" style="background-color:#212529">
     <nav class="navbar navbar-expand-sm navbar-default">

         <div id="main-menu" class="main-menu collapse navbar-collapse" style="background-color:#212529">
             <ul class="nav navbar-nav">
                 <li class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                     <a href="{{ route('admin.dashboard') }}"><i class="menu-icon fa fa-laptop"></i>Dashboard</a>
                 </li>
                 @can('role-list')
                     <li class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">
                         <a href="{{ route('roles.index') }}"><i class="menu-icon fa fa-cogs"></i>Roles</a>
                     </li>
                 @endcan

                 @can('permission-list')
                     <li class="{{ request()->routeIs('permission.*') ? 'active' : '' }}">
                         <a href="{{ route('permission.index') }}"><i class="menu-icon fa fa-cogs"></i>Permissions</a>
                     </li>
                 @endcan

                 @can('user-list')
                     <li class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                         <a href="{{ route('users.index') }}"><i class="menu-icon fa fa-cogs"></i>Users</a>
                     </li>
                 @endcan

                 @can('contact-list')
                     <li class="{{ request()->routeIs('contacts.*') ? 'active' : '' }}">
                         <a href="{{ route('contacts.index') }}"><i class="menu-icon fa fa-cogs"></i>Contacts</a>
                     </li>
                 @endcan

                 @can('blog-list')
                     <li class="{{ request()->routeIs('blogs.*') ? 'active' : '' }}">
                         <a href="{{ route('blogs.index') }}"><i class="menu-icon fa fa-cogs"></i>Blogs</a>
                     </li>
                 @endcan

                 @can('file-list')
                     <li class="{{ request()->routeIs('files.*') ? 'active show' : '' }}">
                         <a href="{{ route('files.index') }}"><i class="menu-icon fa fa-cogs"></i>File Upload</a>
                     </li>
                 @endcan

                 @can('event-list')
                     <li class="{{ request()->routeIs('events.*') ? 'active show' : '' }}">
                         <a href="{{ route('events.index') }}"><i class="menu-icon fa fa-cogs"></i>Events</a>
                     </li>
                 @endcan

                 @can('general_setting')
                     <li class="{{ request()->routeIs('settings.*') ? 'active' : '' }}">
                         <a href="{{ route('settings.index') }}"><i class="menu-icon fa fa-cogs"></i>General Settings</a>
                     </li>
                 @endcan

                 @can('category-list')
                     <li class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
                         <a href="{{ route('categories.index') }}">
                             <i class="menu-icon fa fa-cogs"></i>Categories
                         </a>
                     </li>
                 @endcan

                 @if (auth()->user()->hasRole('user'))
                     <li class="{{ request()->routeIs('transcript.*') ? 'active' : '' }}">
                         <a href="{{ route('user.transcript') }}">
                             <i class="menu-icon  fa fa-cogs"></i>Transcript List</a>
                     </li>

                     @if (auth()->check() && auth()->user()->payment_status == 1)
                         <li class="active">
                             <a href="{{ route('user.video') }}"><i class="menu-icon  fa fa-cogs"></i>Video List</a>
                         </li>
                     @else
                         <li class="active">
                             <a href="{{ route('user.purchase.package.create') }}"><i
                                     class="menu-icon  fa fa-cogs"></i>Video List</a>
                         </li>
                     @endif
                 @endif

                 <li class="menu-item-has-children dropdown {{ request()->routeIs('admin.profile.edit') || request()->routeIs('change_password') ? 'active show' : '' }}"
                     style="background-color: {{ request()->routeIs('admin.profile.edit') || request()->routeIs('change_password') ? '#f0f0f0' : 'transparent' }};">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                         aria-expanded="{{ request()->routeIs('admin.profile.edit') || request()->routeIs('change_password') ? 'true' : 'false' }}">
                         <i class="menu-icon fa fa-cogs"></i>Account Setting
                     </a>
                     <ul
                         class="sub-menu children dropdown-menu {{ request()->routeIs('admin.profile.edit') || request()->routeIs('change_password') ? 'show' : '' }}">
                         <!-- Profile -->
                         <li class="{{ request()->routeIs('admin.profile.edit') ? 'active' : '' }}">
                             <a href="{{ route('admin.profile.edit') }}" style="color: black">
                                 <i class="fa fa-user"></i>Profile
                             </a>
                         </li>
                         <!-- Change Password -->
                         <li class="{{ request()->routeIs('change_password') ? 'active' : '' }}">
                             <a href="{{ route('change_password') }}" style="color: black">
                                 <i class="fa fa-key"></i>Change Password
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



 {{-- <li class="menu-item-has-children dropdown {{ request()->routeIs('comments.*') ? 'active show' : '' }}">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                         aria-expanded="{{ request()->routeIs('comments.*') ? 'true' : 'false' }}"> <i
                             class="menu-icon fa fa-cogs"></i>Comments</a>
                     <ul class="sub-menu children dropdown-menu {{ request()->routeIs('comments.*') ? 'show' : '' }}">
                         <li class="{{ request()->routeIs('comments.index') ? 'active' : '' }}"><a
                                 href="{{ route('comments.index') }}">
                                 <i class="fa fa-puzzle-piece"></i>Comments</li>
                         </a>
                     </ul>
                 </li> --}}


 {{-- <li class="menu-item-has-children dropdown {{ request()->routeIs('package.*') ? 'active show' : '' }}">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                         aria-expanded="{{ request()->routeIs('package.*') ? 'true' : 'false' }}">
                         <i class="menu-icon fa fa-cogs"></i>Packages
                     </a>
                     <ul class="sub-menu children dropdown-menu {{ request()->routeIs('package.*') ? 'show' : '' }}">
                         <li class="{{ request()->routeIs('package.index') ? 'active' : '' }}">
                             <a href="{{ route('package.index') }}">
                                 <i class="fa fa-puzzle-piece"></i>Index
                         </li>
                         </a>
                     </ul>
                 </li> --}}

 {{-- <li class="menu-item-has-children dropdown {{ request()->routeIs('categories.*') ? 'active show' : '' }}">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                         aria-expanded="{{ request()->routeIs('categories.*') ? 'true' : 'false' }}">
                         <i class="menu-icon fa fa-cogs"></i>Categories
                     </a>
                     <ul
                         class="sub-menu children dropdown-menu {{ request()->routeIs('categories.*') ? 'show' : '' }}">
                         <li class="{{ request()->routeIs('categories.index') ? 'active' : '' }}">
                             <a href="{{ route('categories.index') }}">
                                 <i class="fa fa-puzzle-piece"></i>Categories
                         </li>
                         </a>
                     </ul>
                 </li> --}}



 {{-- <li class="menu-item-has-children dropdown {{ request()->routeIs('videos.*') ? 'active show' : '' }}">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                         aria-expanded="{{ request()->routeIs('videos.*') ? 'true' : 'false' }}"> <i
                             class="menu-icon fa fa-cogs"></i>Video Upload</a>
                     <ul class="sub-menu children dropdown-menu {{ request()->routeIs('videos.*') ? 'show' : '' }}">
                         <li class="{{ request()->routeIs('videos.index') ? 'active' : '' }}"><a
                                 href="{{ route('videos.index') }}">
                                 <i class="fa fa-puzzle-piece"></i>Videos</li>
                         </a>
                     </ul>
                 </li> --}}

 {{-- <li class="menu-item-has-children dropdown {{ request()->routeIs('reels.*') ? 'active show' : '' }}">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                         aria-expanded="{{ request()->routeIs('reels.*') ? 'true' : 'false' }}"> <i
                             class="menu-icon fa fa-cogs"></i>Reels Upload</a>
                     <ul class="sub-menu children dropdown-menu {{ request()->routeIs('reels.*') ? 'show' : '' }}">
                         <li class="{{ request()->routeIs('reels.index') ? 'active' : '' }}"><a
                                 href="{{ route('reels.index') }}">
                                 <i class="fa fa-puzzle-piece"></i>Reels</li>
                         </a>
                     </ul>
                 </li> --}}
