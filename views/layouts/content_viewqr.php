<?php
/* @var $content string */

use yii\bootstrap4\Breadcrumbs;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <div class="content-header">
        <div class="d-flex flex-md-row flex-column justify-content-between">
            <h1 class="m-0 text-dark">
                <?php
                        if (!is_null($this->title)) {
                            echo \yii\helpers\Html::encode($this->title);
                        } else {
                            echo \yii\helpers\Inflector::camelize($this->context->id);
                        }
                ?>
                            
            </h1>
            <div class="">
                <button type="button" onclick="print();" class="btn btn-info">
                    <i class="fas fa-print"></i> Распечатать
                </button>
            </div>
        </div>
    </div>
    <!-- /.content-header -->
    <div class="d-print-none"></div>
    <!-- Main content -->
    <div class="content px-2">
        <?= $content ?><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>

<style type="text/css">
.btn-info {
    color: #212529;
    background-color: #6cb2eb;
    border-color: #6cb2eb;
}
</style>