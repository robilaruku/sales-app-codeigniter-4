<?= $this->extend('admin/layout'); ?>
<?= $this->section('title'); ?>
Category
<?= $this->endSection(); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <form method="POST" action="<?= base_url('admin/category/' . $category['id']); ?>">
            <?= csrf_field(); ?>
            <input type="hidden" name="_method" value="PUT">
            <div class="card">
                <div class="card-header text-bg-primary">
                    <h3 class="card-title text-light">Update Category</h3>
                </div>
                <div class="card-body">
                    <?php if (validation_errors()): ?>
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                <?php foreach (validation_errors() as $error): ?>
                                    <li>
                                        <?= $error ?>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif ?>
                    <div class="mb-2">
                        <label for="name" class="form-label">Category</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter category"
                            value="<?= old('name', $category['name']); ?>" />
                    </div>
                    <div class="mb-2">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="" <?= (old('status', $category['status']) == '') ? 'selected' : ''; ?>>
                                --- Pilih ---
                            </option>
                            <option value="active" <?= (old('status', $category['status']) == 'active') ? 'selected' : ''; ?>>
                                Active
                            </option>
                            <option value="inactive" <?= (old('status', $category['status']) == 'inactive') ? 'selected' : ''; ?>>
                                Inactive
                            </option>
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('admin/category'); ?>" class="btn btn-light">Back</a>
                    <button type="submit" class="btn btn-primary float-end">Update Category</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>

