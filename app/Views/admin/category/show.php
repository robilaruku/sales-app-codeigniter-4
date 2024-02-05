<?= $this->extend('admin/layout'); ?>
<?= $this->section('title'); ?>
Category
<?= $this->endSection(); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-bg-primary">
                <h3 class="card-title text-light">Detail Category</h3>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <label for="name" class="form-label">Category</label>
                    <input type="text" name="name" class="form-control" value="<?= $category['name']; ?>" disabled />
                </div>
                <div class="mb-2">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-select" disabled>
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
                <a href="<?= base_url('/admin/category'); ?>" class="btn btn-light">Back</a>
            </div>
        </div>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>