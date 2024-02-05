<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="<?= base_url('/admin'); ?>">
            <span class="align-middle">Sales App</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-item <?= url_is('admin') ? 'active' : null ?>">
                <a class="sidebar-link" href="<?= base_url('/admin'); ?>">
                    <i class="align-middle" data-feather="sliders"></i> 
                    <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-header">
                Data
            </li>

            <li class="sidebar-item <?= url_is('admin/category*') ? 'active' : null ?>">
                <a class="sidebar-link" href="<?= base_url('admin/category'); ?>">
                    <i class="align-middle" data-feather="book"></i> <span class="align-middle">Category</span>
                </a>
            </li>
            <li class="sidebar-item <?= url_is('admin/product*') ? 'active' : null ?>">
                <a class="sidebar-link" href="<?= base_url('admin/product'); ?>">
                    <i class="align-middle" data-feather="server"></i> <span class="align-middle">Product</span>
                </a>
            </li>
            <li class="sidebar-item <?= url_is('admin/trx*') ? 'active' : null ?>">
                <a class="sidebar-link" href="<?= base_url('admin/trx'); ?>">
                    <i class="align-middle" data-feather="dollar-sign"></i> <span class="align-middle">Sales</span>
                </a>
            </li>
        </ul>
    </div>
</nav>