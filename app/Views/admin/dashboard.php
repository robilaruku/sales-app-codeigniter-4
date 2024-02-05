<?= $this->extend('admin/layout') ?>
<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Sales Graph
                </h3>
            </div>
            <div class="card-body">
                Sales Graph Here <br><br><br><br><br>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Latest Transaction
                </h3>
            </div>
            <div class="card-body">
                Latest Transaction Here <br><br><br><br><br>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>