<?= $this->extend('admin/layout') ;?>
<?= $this->section('title') ;?>
Transaction
<?= $this->endSection() ;?>
<?= $this->section('content') ;?>
<div class="row">
    <div class="col-12">
        <form action="<?= base_url('admin/trx/import') ;?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ;?>
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title text-light">Import Excel</h3>
                </div>
                <div class="card-body">
                    <?php if (validation_errors()) : ?>
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            <?php foreach (validation_errors() as $error) : ?>
                            <li><?= $error ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                    <?php endif ?>
                    <div class="mb-2">
                        <label for="excel" class="form-label">File Excel</label>
                        <input type="file" name="excel" id="excel" class="form-control">
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('admin/trx') ;?>" class="btn btn-light">Back</a>
                    <button type="submit" class="btn btn-primary float-end">Import</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ;?>