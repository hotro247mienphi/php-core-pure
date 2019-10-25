<?php

/**
 * @var App\Core\Layout $this
 * @var array $data
 */

$this->addScriptFooter(asset_path('js/footer.js'));
?>

<?php foreach (array_chunk($data, 6) as $items): ?>
    <div class="row">
        <?php foreach ($items as $item): ?>

        <?php $formId = sprintf('deleteForm-%s',$item->id); ?>

            <div class="col-4 col-lg-2">
                <div class="alert alert-<?php echo((int)$item->status === 1 ? 'info' : 'warning'); ?>">

                    <a href="<?php echo route('users.edit', ['id' => $item->id]) ?>">
                        <?php echo $item->name; ?>
                    </a>
                    <span class="badge badge-dark ml-3"><?php echo $item->id; ?></span>

                    <hr/>

                    <div class="btn-group">
                        <a href="<?php echo route('users.show', ['id'=>$item->id]); ?>" class="btn btn-info btn-sm">View</a>
                        <a href="<?php echo route('users.edit', ['id'=>$item->id]); ?>" class="btn btn-primary btn-sm">Edit</a>
                        <a href="javascript:;" class="btn btn-danger btn-sm" onclick="JsPure.confirmAndDelete('<?php echo $formId; ?>')">Delete</a>
                    </div>

                    <form action="<?php echo route('users.show', ['id'=>$item->id]); ?>" method="POST" id="<?php echo $formId; ?>" class="d-none">
                        <input type="hidden" name="_method" value="DELETE"/>
                    </form>

                </div>
            </div>

        <?php endforeach; ?>
    </div>
<?php endforeach; ?>
