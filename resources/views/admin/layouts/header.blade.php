@php
    $user = auth()->user();
    $notifications = $user->unreadNotifications;
@endphp
{{-- <style>
    .header-left .dropdown .dropdown-menu {
        background: #ffe0e6;
        color: #950808;
        font-weight: bold;
        border: none;
        border-radius: 0;
        -webkit-box-shadow: none;
        box-shadow: none;
        top: 52px !important;
        left: inherit !important;
        right: 0 !important;
        -webkit-box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
        line-height: 35px;
    }
</style> --}}

<header id="header" class="header" style="height: 59px; background-color: #212529; border-bottom: none;">
    <div class="top-left">
        <div class="navbar-header" style="background-color: #212529">
            <a class="navbar-brand" href="#"><img src="{{ asset('storage/logos/' . $settings->header_logo) }}"
                    height="auto" style="width: 60px !important;">

            </a>
            {{-- <a class="navbar-brand hidden" href="./"><img src="{{asset('images/logo2.png')}}" alt="Logo"></a> --}}
            <a id="menuToggle" class="menutoggle"><i class="fa fa-bars" style="color: white"></i></a>
        </div>
    </div>
    <div class="top-right">
        <div class="header-menu">
            <div class="header-left">
                <button class="search-trigger"><i class="fa fa-search" style="color: white"></i></button>
                <div class="form-inline">
                    <form class="search-form">
                        <input class="form-control mr-sm-2" type="text" placeholder="Search ..." aria-label="Search">
                        <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
                    </form>
                </div>

                {{-- <div class="dropdown for-notification">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="notification"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                        <span class="count bg-danger">{{ $notifications->count() }}</span>
                    </button>

                    <div class="dropdown-menu" aria-labelledby="notification">
                        <span class="red" style="padding: 20px;">You have {{ $notifications->count() }} Notifications
                            {{ $notifications->count() > 1 ? '' : '' }}</span>

                        @forelse ($notifications as $notification)
                            <a class="dropdown-item media {{ $notification->read_at ? 'read' : 'unread' }}"
                                href="{{ url('/admin/mark-notification/' . $notification->id) }}">
                                @if (!empty($notification->data['message']))
                                    <p style="color:#000">{{ $notification->data['message'] }}
                                        @if (!empty($notification->data['user']))
                                            <span style="font-weight:bold">USER NAME :
                                                {{ $notification->data['user'] }}</span>
                                        @endif
                                        @if (!empty($notification->data['package']))
                                            <span style="font-weight:bold">PACKAGE NAME:
                                                {{ $notification->data['package'] }}</span>
                                        @endif
                                    </p>
                                @endif
                            </a>
                        @empty
                            <!-- Display a message if there are no notifications -->
                        @endforelse
                    </div>
                </div> --}}
            </div>

            <div class="user-area dropdown float-right">
                <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <img id="user-avatar" class="user-avatar rounded-circle"
                        src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="User Avatar">
                </a>
                <div class="user-menu dropdown-menu">
                    <a class="nav-link" href="{{ route('admin.profile.edit') }}"><i class="fa fa- user"></i>My
                        Profile</a>
                    {{-- <a class="nav-link" href="#"><i class="fa fa- user"></i>Notifications <span class="count">
                            {{ $notifications->count() }}</span></a> --}}
                    <a class="nav-link" href="#"
                        onclick="event.preventDefault(); document.getElementById('logoutform').submit();"><i
                            class="fa fa-power -off"></i>Logout</a>
                </div>
            </div>
        </div>
    </div>
</header>
