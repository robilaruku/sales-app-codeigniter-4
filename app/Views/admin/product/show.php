<?= $this->extend('admin/layout'); ?>
<?= $this->section('title'); ?>
Product
<?= $this->endSection(); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title text-light">Detail Product</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <img src="<?= base_url('img/uploads/' . $product['image']); ?>" height="200" width="100%" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="category" class="form-label">Category</label>
                            <input id="category" type="text" value="<?= $product['category_name']; ?>"
                                class="form-control" disabled />
                        </div>
                        <div class="mb-2">
                            <label for="name" class="form-label">Name</label>
                            <input id="name" type="text" value="<?= $product['name']; ?>" class="form-control"
                                disabled />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="sku" class="form-label">SKU</label>
                            <input id="sku" type="text" value="<?= $product['sku']; ?>" class="form-control" disabled />
                        </div>
                        <div class="mb-2">
                            <label for="status" class="form-label">Status</label>
                            <input id="status" type="text" value="<?= $product['status']; ?>" class="form-control"
                                disabled />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-2">
                            <label for="price" class="form-label">Price</label>
                            <input id="price" type="text"
                                value="Rp. <?= number_format($product['price'], 0, ',', '.'); ?>" class="form-control"
                                disabled />
                        </div>
                        <div class="mb-2">
                            <label for="description" class="form-label">Description</label>
                            <input id="description" type="text" value="<?= $product['description']; ?>"
                                class="form-control" disabled />
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="<?= base_url('admin/product'); ?>" class="btn btn-light">Back</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>