<?php
use yii\helpers\Html;
$this->title = 'Маълумот сақланди';
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['indexlab']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>

        <div class="row">
            <div class="col-md-12">
            <!-- Line chart -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="far fa-chart-bar"></i>
                  Маълумот мувофақиятли сақланди
                </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <?= Html::a('Рўйхатга қайтиш', ['/registration/indexlab'], ['class' => 'link']) ?>
              </div>
              <!-- /.card-body-->
            </div>
            <!-- /.card -->
          </div>
        </div>
