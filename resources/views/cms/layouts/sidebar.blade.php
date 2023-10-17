{{-- Sidebar --}}
<div class="app-sidebar">
    <div class="logo">
        <a class="logo-icon" href="{{ route('cms.dashboard') }}">
            <span class="logo-text">CMS</span>
        </a>
        <div class="sidebar-user-switcher user-activity-online">
            <a href="#">
                <img class="rounded-circle" src="{{ admin()->avatar_path }}" alt="Admin Avatar">
                <span class="activity-indicator"></span>
                <span class="user-info-text">{{ admin()->name }}<br>
                    <span class="user-state-info">Online</span>
                </span>
            </a>
        </div>
    </div>
    <div class="app-menu">
        <ul class="accordion-menu">
            <li class="sidebar-title">
                Main
            </li>
            <li class="{{ $sidebar['dashboard'] ?? '' }}">
                <a href="{{ route('cms.dashboard') }}">
                    <i class="material-icons text-dark">dashboard</i>
                    Dashboard
                </a>
            </li>
            <li class="sidebar-title">
                Master
            </li>
            <li class="{{ $sidebar['users'] ?? '' }}">
                <a href="{{ route('cms.users.index') }}">
                    <i class="material-icons text-dark">people</i>
                    Users
                </a>
            </li>
            <li class="{{ $sidebar['shares'] ?? '' }}">
                <a href="{{ route('cms.shares.index') }}">
                    <i class="material-icons text-dark">description</i>
                    File Shares
                </a>
            </li>
        </ul>
    </div>
</div>
