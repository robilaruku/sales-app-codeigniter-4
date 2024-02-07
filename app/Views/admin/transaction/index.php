<?= $this->extend('admin/layout'); ?>
<?= $this->section('title'); ?>
Transaction
<?= $this->endSection(); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary d-flex">
                <h3 class="card-title text-light">Transaction</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="mt-2 mb-3">
                            <a href="<?= base_url('admin/trx/new'); ?>" class="btn btn-outline-success d-grid">
                                Import Data
                            </a>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mt-2 mb-3">
                            <a href="<?= base_url('admin/trx/export'); ?>" class="btn btn-outline-primary d-grid">
                                Export Data
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="mb-3">
                            <label for="product_id" class="form-label">Products</label>
                            <select name="product_id" id="product_id" class="form-select">
                                <option value>All Products</option>
                                <?php foreach ($products as $product): ?>
                                    <option value="<?= $product['id']; ?>" <?= ($product_id == $product['id']) ? 'selected' : null ?>>
                                        <?= $product['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="mb-3">
                            <label for="trx_date" class="form-label">Trx Date</label>
                            <input type="date" name="trx_date" id="trx_date" class="form-control"
                                placeholder="Enter keyword" value="<?= $trx_date ?? null ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div style="margin-top: 30px;">
                            <a href="<?= base_url('admin/trx'); ?>" class="btn btn-secondary d-grid">
                                Reset
                            </a>
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

                <table class="table table-hover">
                    <thead class="table-success">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Product</th>
                            <th>Date</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($transactions as $x => $transaction):
                            ?>
                            <tr>
                                <td class="text-center">
                                    <?= $startNumber + $x; ?>
                                </td>
                                    <td class="text-center">
                                    <?= $transaction['product_name']; ?>
                                </td>
                                <td class="text-center">
                                    <?= $transaction['trx_date']; ?>
                                </td>
                                <td class="text-center">
                                    <?= $transaction['price']; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?= $pager->links('default', 'pagination_link'); ?>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        function filter() {
            var product_id = document.getElementById('product_id').value;
            var trx_date = document.getElementById('trx_date').value;
            var base_url = '<?= base_url('admin/trx') ?>';
            var url = base_url + '?product_id=' + product_id + '&trx_date=' + trx_date;

            window.location.replace(url);
        }

        document.getElementById('product_id').addEventListener('change', function () {
            filter();
        });

        document.getElementById('trx_date').addEventListener('change', function (event) {
            filter();
        });
    });
</script>
<?= $this->endSection(); ?>