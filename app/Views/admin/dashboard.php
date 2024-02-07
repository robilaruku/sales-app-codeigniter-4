<?= $this->extend('admin/layout'); ?>
<?= $this->section('title'); ?>
Home
<?= $this->endSection(); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Sales Graph</h3>
            </div>
            <div class="card-body">
                <canvas class="chart" id="sales-chart" style="height: 250px;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Latest Transaction
            </div>
            <div class="card-body">
                <table class="table table-bordered" style="height: 290px;">
                    <thead class="table-success">
                        <tr class="text-center">
                            <th>Product</th>
                            <th>Date</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($transactions as $transaction) : ?>
                            <tr>
                                <td><?= $transaction['product_name'] ;?></td>
                                <td><?= $transaction['trx_date'] ;?></td>
                                <td><?= $transaction['price'] ;?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    var areaChart = document.getElementById('sales-chart');
    var chart = new Chart(areaChart, {
        type: 'line',
        data: {
                labels: <?= json_encode($months) ?>,

                datasets:[
                    {
                        label: 'Overall Sales',
                        fill: true,
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        borderColor: 'rgb(255, 99, 132)',
                        data: <?= json_encode($totals); ?>
                    }
                ]
            }
    });
</script>
<?= $this->endSection(); ?>
