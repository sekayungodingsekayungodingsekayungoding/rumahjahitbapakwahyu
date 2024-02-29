<div class="appBottomMenu">
        <a href="/dashboard" class="item {{ request()->is('dashboard') ? 'active' : '' }}">
            <div class="col">
                <ion-icon name="home-outline"></ion-icon>
                <strong>Home</strong>
            </div>
        </a>
        <a href="/jahit/pesan" class="item {{ request()->is('vote/create') ? 'active' : '' }}">
            <div class="col">
                <div class="action-button large">
                    <ion-icon name="shirt-outline"></ion-icon>
                </div>
            </div>
        </a>
        <a href="/myrate" class="item {{ request()->is('addrate') ? 'active' : '' }}">
            <div class="col">
                <ion-icon name="star-half-outline"></ion-icon>
                <strong>Rate</strong>
            </div>
        </a>
    </div>
