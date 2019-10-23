<?php

use App\Core\Layout;

/**
 * @var Layout $this
 * @var array $data
 */

$this->addStyle(asset_path('css/style.css'));
$this->addScriptFooter(asset_path('js/footer.js'));
$this->addScriptHeader(asset_path('js/header.js'));
?>

<?php foreach (array_chunk($data, 6) as $items): ?>
    <div class="row">
        <?php foreach ($items as $item): ?>
            <div class="col-4 col-lg-2">
                <div class="alert alert-<?php echo((int)$item->status === 1 ? 'info' : 'warning'); ?>">
                    <?php echo $item->name; ?>
                    <span class="badge badge-dark ml-3"><?php echo $item->id; ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>
