<?= $this->extend('admin/layout'); ?>
<?= $this->section('title'); ?>
Product
<?= $this->endSection(); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary d-flex">
                <h3 class="card-title text-light">Product</h3>

                <a href="<?= base_url('admin/product/new'); ?>" class="btn badge text-decoration-none ms-auto">
                    <i data-feather="plus"></i>&nbsp; Add
                </a>
            </div>
            <div class="card-body">
                <?php if (session()->get('message')):
                    ; ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <label>
                            <?= session('message'); ?>
                        </label>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if (session()->get('error')):
                    ; ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <label>
                            <?= session('error'); ?>
                        </label>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <thead class="table-success">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Category</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>SKU</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($products as $x => $product):
                                    ?>
                                    <tr>
                                        <td class="text-center">
                                            <?= $x + 1; ?>
                                        </td>
                                        <td>
                                            <?= $product['category_name']; ?>
                                        </td>
                                        <td>
                                            <?= $product['name']; ?>
                                        </td>
                                        <td>
                                            <?= $product['price']; ?>
                                        </td>
                                        <td>
                                            <?= $product['sku']; ?>
                                        </td>
                                        <td class="text-center">
                                            <img src="<?= base_url('img/uploads/' . $product['image']); ?>" width="100" />
                                        </td>
                                        <td class="text-center">
                                            <?= $product['status']; ?>
                                        </td>
                                        <td class="text-center col-sm-4">
                                            <a class="btn btn-sm btn-info text-white rounded"
                                                href="<?= base_url('admin/product/' . $product['id']) ?>">
                                                <i data-feather="eye"></i> Detail
                                            </a>
                                            <a class="btn btn-sm btn-success rounded"
                                                href="<?= base_url('admin/product/' . $product['id'] . '/edit') ?>">
                                                <i data-feather="edit-2"></i> Edit
                                            </a>
                                            <form action="<?= base_url('admin/product/' . $product['id']); ?>" method="post"
                                                class="d-inline">
                                                <?= csrf_field(); ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" onclick="return confirm('Sure delete this Product ?')"
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
        </div>
    </div>
</div>

<?= $this->endSection(); ?>