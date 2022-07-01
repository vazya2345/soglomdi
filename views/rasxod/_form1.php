<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Users;

?>

<div class="rasxod-form">

    <?php $form = ActiveForm::begin(); ?>
<?php

        echo $form->field($model, 'rasxod_desc')->textarea(['rows' => 6]);

        echo $form->field($model, 'user_id')->dropDownList(Users::getAllWithFil());


        echo '<div class="form-group">';
        echo Html::submitButton('Саклаш', ['class' => 'btn btn-success']);
        echo '</div>';
?>

    <?php ActiveForm::end(); ?>

</div>
