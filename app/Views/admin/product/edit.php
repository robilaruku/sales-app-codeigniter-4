<?= $this->extend('admin/layout') ;?>
<?= $this->section('title') ;?>
Product
<?= $this->endSection() ;?>
<?= $this->section('content') ;?>
<div class="row">
    <div class="col-12">
        <form action="<?= base_url('admin/product/' . $product['id']) ;?>" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="oldImage" value="<?= $product['image'] ;?>">
            <div class="card">
                <div class="card-header text-bg-primary">
                    <h3 class="card-title text-light">Edit Product</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <img src="<?= base_url('img/uploads/' . $product['image']); ?>" height="200" width="100%" />
                        </div>
                    </div>
                    <?php if (validation_errors()) : ?>
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            <?php foreach (validation_errors() as $error) : ?>
                            <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="category_id" class="form-label">Category</label>
                                <select name="category_id" id="category_id" class="form-select">
                                    <option>Choose Category</option>
                                    <?php foreach ($categories as $category) : ?>
                                        <option value="<?= $category['id'] ?>" <?= (old('category_id', $product['category_id']) == $category['id']) ? 'selected' : null ?>><?= $category['name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name" value="<?= old('name', $product['name']) ;?>" class="form-control"
                                    placeholder="Enter name">
                            </div>
                            <div class="mb-2">
                                <label for="price" class="form-label">Price</label>
                                <input type="text" name="price" id="price" value="<?= old('price', $product['price']); ?>" class="form-control"
                                    placeholder="Enter price">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="sku" class="form-label">SKU</label>
                                <input type="text" name="sku" id="sku" value="<?= old('sku', $product['sku']); ?>" class="form-control"
                                    placeholder="Enter SKU">
                            </div>
                            <div class="mb-2">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="active" <?= (old('status', $product['status']) == 'active') ? 'selected' : null ?>>Active</option>
                                    <option value="inactive" <?= (old('status', $product['status']) == 'inactive') ? 'selected' : null ?>>Inactive</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" name="image" id="image" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-2">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" name="description" class="form-control" placeholder="Enter description" rows="5"><?= old('description', $product['description']); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('admin/product') ;?>" class="btn btn-light">Back</a>
                    <button type="submit" class="btn btn-primary float-end">Update Product</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ;?>