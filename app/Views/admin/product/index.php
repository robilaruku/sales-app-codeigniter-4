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
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" id="category_id" class="form-select">
                                <option value>All Category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id']; ?>" <?= ($category_id == $category['id']) ? 'selected' : null ?>>
                                        <?= $category['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" name="search" id="search" class="form-control"
                                placeholder="Enter keyword" value="<?= $search ?? null ?>">
                        </div>
                    </div>
                </div>
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
                        <table class="table table-hover table-bordered table-condensed table-responsive">
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
                                            Rp.
                                            <?= number_format($product['price'], 0, ',', '.'); ?>
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
                <?= $pager->links('default', 'pagination_link'); ?>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        function filter() {
            var category_id = $('#category_id').val();
            var search = $('#search').val();
            var base_url = '<?= base_url('admin/product') ?>';
            var url = base_url + '?category_id=' + category_id + '&search=' + search;

            window.location.replace(url);
        }

        $('#category_id').on('change', function () {
            filter();
        });

        $('#search').keypress(function (event) {
            if (event.keyCode == 13) {
                filter();
            }
        });
    });
</script>
<?= $this->endSection(); ?>