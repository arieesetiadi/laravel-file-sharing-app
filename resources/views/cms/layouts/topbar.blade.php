<div class="app-header">
    <nav class="navbar navbar-light navbar-expand-lg">
        <div class="container-fluid">
            <div id="navbar" class="navbar-nav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link hide-sidebar-toggle-button" href="#">
                            <i class="material-icons">first_page</i>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="d-flex">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-type="link" data-title="You are about to sign out!" href="{{ route('cms.auth.logout.process') }}" onclick="swalConfirm(event)">
                            <i class="material-icons text-dark">power_settings_new</i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
