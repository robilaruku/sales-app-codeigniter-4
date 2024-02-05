<?= $this->extend('admin/layout'); ?>
<?= $this->section('title'); ?>
Category
<?= $this->endSection(); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary d-flex text-white">
                <h3 class="card-title">
                    List Category
                </h3>

                <a href="<?= base_url('admin/category/new'); ?>" class="btn badge text-decoration-none ms-auto">
                    <i data-feather="plus"></i>&nbsp; Add
                </a>
            </div>
            <div class="card-body">
                <?php if (session()->get('message')): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <label>
                            <?= session('message') ?>
                        </label>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if (session()->get('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <label>
                            <?= session('error') ?>
                        </label>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <table class="table table-striped table-hover">
                    <thead class="table-success">
                        <tr class="text-center">
                            <th>#</th>
                            <th>Name</th>
                            <th class="col-md-3">Status</th>
                            <th class="col-md-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $i => $category): ?>
                            <tr>
                                <td class="text-center">
                                    <?= $i + 1 ?>
                                </td>
                                <td class="text-center">
                                    <?= $category['name'] ?>
                                </td>
                                <td class="text-center">
                                    <?= $category['status'] ?>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('admin/category/' . $category['id']); ?>"
                                        class="btn btn-sm btn-info text-white rounded">
                                        <i data-feather="eye"></i> Detail
                                    </a>
                                    <a href="<?= base_url('admin/category/' . $category['id'] . "/edit"); ?>"
                                        class="btn btn-sm btn-success rounded">
                                        <i data-feather="edit-2"></i> Edit
                                    </a>
                                    <form action="<?= base_url('admin/category/' . $category['id']); ?>" method="post"
                                        class="d-inline">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" onclick="return confirm('Sure delete this category?')"
                                            class="btn btn-sm btn-danger rounded">
                                            <i data-feather="trash-2"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?= $this->endSection(); ?>