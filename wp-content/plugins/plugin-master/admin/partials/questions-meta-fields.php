<?php
defined( 'ABSPATH' ) || exit;
wp_nonce_field(plugin_basename(__FILE__), 'images_nonce');

?>
<div class="accordion" id="accordionExample">
    <?php
    $media = get_attached_media('image', get_the_ID()); // Get image attachment(s) to the current Post
    if($args[0]):
     foreach ( $args[0] as $field => $key) {
            $counter = $field + 1;
            ?>
    <div class="empty-row custom-repeter-text">

    <div class="accordion-item">

                <h2 class="accordion-header" id="heading<?= $field; ?>">
                    <button class="accordion-button collapsed border-accordion" type="button" data-bs-toggle="collapse" data-bs-target="#collapse" aria-expanded="true" aria-controls="collapse">
                        <?= __('Question', 'lquiz')." ".$counter  ?>
                    </button>
                </h2>
                <div id="collapse" class="accordion-collapse collapse" aria-labelledby="heading" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <label class="control-label" for="category">
                            <?= __('Question Category', 'lquiz') ?>
                        </label>
                        <select name="category[]" class="form-select category" id="category"  select-group="first">
                            <option value="0" <?php if($key[ "category"]=="0" ){echo "selected" ;} ?>>
                                <?= __('Insert a letter', 'lquiz') ?>
                            </option>
                            <option value="1" <?php if($key[ "category"]=="1" ){echo "selected" ;} ?>>
                                <?= __('Insert date', 'lquiz') ?>
                            </option>
                            <option value="2" <?php if($key[ "category"]=="2" ){echo "selected" ;} ?>>
                                <?= __('Insert word', 'lquiz') ?>
                            </option>
                            <option value="3" <?php if($key[ "category"]=="3" ){echo "selected" ;} ?>>
                                <?= __('Insert time', 'lquiz') ?>
                            </option>
                            <option value="4" <?php if($key[ "category"]=="4" ){echo "selected" ;} ?>>
                                <?= __('Choice correct answer', 'lquiz') ?>
                            </option>
                            <option value="5" <?php if($key[ "category"]=="5" ){echo "selected" ;} ?>>
                                <?= __('Descript task', 'lquiz') ?>
                            </option>

                        </select>
                        <div class="questions-types-fields">
                            <label class="control-label" for="question"> <?= __('Question', 'lquiz') ?>
                            </label>
                            <textarea name="title[]" class="form-control textarea-field"><?= empty($key['title']) ?  : $key['title']; ?></textarea>

                            <div id="repeatable-question" class="my-2">
                                <?php
                                if($key['correct'] !== null):
                                foreach($key['correct'] as $correct)
                                {
                                    ?>

                                    <div class="row-with-correct-answer">
                                        <label class="control-label" id="answer-label" for="answer"> <?= __('Answer', 'lquiz') ?>:</label>
                                        <div class="w-100 d-flex justify-content-center align-items-center">
                                            <a class="button remove-answer me-2"> <?= __('X', 'lquiz') ?></a>
                                            <input type="text" class="form-control" name="correct[<?= $field; ?>][]"
                                               value="<?php if ($correct != '') echo esc_attr( $correct ); ?>"
                                               placeholder="<?= __('Correct answers', 'lquiz') ?>" id="answer" />
                                            <input class="form-check-input ms-2 d-none" type="checkbox" name="selectedanswer[]" id="flexRadioDefault1">
                                        </div>
                                    </div>
                                    <?php
                                }
                                else:
                                    ?>
                                    <div class="row-with-correct-answer">
                                        <label class="control-label" id="answer-label" for="answer"> <?= __('Answer', 'lquiz') ?>:</label>
                                        <div class="w-100 d-flex justify-content-center align-items-center">
                                            <a class="button remove-answer me-2"> <?= __('X', 'lquiz') ?></a>
                                            <input type="text" class="form-control" name="correct[<?= $field; ?>][]"
                                                   value=""
                                                   placeholder="<?= __('Correct answers', 'lquiz') ?>" id="answer" />
                                            <input class="form-check-input ms-2 d-none" type="checkbox" name="selectedanswer[]" id="flexRadioDefault1">
                                        </div>
                                    </div>
                                <?php
                                endif;
                                ?>
                                <div class="add-new-answer">
                                    <a class="button add-answer" id='add-new-answer' > <?= __('Add new answer', 'lquiz') ?></a>
                                </div>
                            </div>
                            <div>
                                <label class="control-label" for="points"> <?= __('Points for correct answer', 'lquiz') ?>:</label>
                                <input type="number" class="form-control" step="0.5" name="points[]" value="<?php  echo( $key['points'] ); ?>"
                                       id="points" />
<?php
                                if( $key['mediaId'] != null ) {

                                echo '<div class="image-wrapper"><a href="#" class="misha-upl"><img src="' . wp_get_attachment_url($key['mediaId']) . '" /></a>
                                <a href="#" class="misha-rmv">Remove image</a>
                                <input type="hidden" name="imgid[]" value="' . $key['mediaId'] . '"></div>';

                                } else {

                                echo '<div class="image-wrapper"><a href="#" class="misha-upl">Upload image</a>
                                <a href="#" class="misha-rmv" style="display:none">Remove image</a>
                                <input type="hidden" name="imgid[]" value="' . $key['mediaId']  . '"></div>';

                                }
?>
                            </div>
                            <div class="remove-button-container d-flex justify-content-end">

                            <a class="button remove-row"> <?= __('Delete', 'lquiz') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

            <?php
        }
     else:?>
         <div class="empty-row custom-repeter-text">

             <div class="accordion-item">

                 <h2 class="accordion-header" id="heading<?= $field; ?>">
                     <button class="accordion-button collapsed border-accordion" type="button" data-bs-toggle="collapse" data-bs-target="#collapse" aria-expanded="true" aria-controls="collapse">
					     <?= __('Question', 'lquiz')." ".$counter = $counter ?? ""  ?>
                     </button>
                 </h2>
                 <div id="collapse" class="accordion-collapse collapse" aria-labelledby="heading" data-bs-parent="#accordionExample">
                     <div class="accordion-body">
                         <label class="control-label" for="category">
						     <?= __('Question Category', 'lquiz') ?>
                         </label>
                         <select name="category[]" class="form-select category" id="category"  select-group="first">
                             <option value="0">
							     <?= __('Insert a letter', 'lquiz') ?>
                             </option>
                             <option value="1">
							     <?= __('Insert date', 'lquiz') ?>
                             </option>
                             <option value="2">
							     <?= __('Insert word', 'lquiz') ?>
                             </option>
                             <option value="3">
							     <?= __('Insert time', 'lquiz') ?>
                             </option>
                             <option value="4">
							     <?= __('Choice correct answer', 'lquiz') ?>
                             </option>
                             <option value="5">
							     <?= __('Descript task', 'lquiz') ?>
                             </option>

                         </select>
                         <div class="questions-types-fields">
                             <label class="control-label" for="question"> <?= __('Question', 'lquiz') ?>
                             </label>
                             <textarea name="title[]" class="form-control textarea-field"><?= empty($key['title']) ?  : $key['title']; ?></textarea>

                             <div id="repeatable-question" class="my-2">


                                         <div class="row-with-correct-answer">
                                             <label class="control-label" id="answer-label" for="answer"> <?= __('Answer', 'lquiz') ?>:</label>
                                             <div class="w-100 d-flex justify-content-center align-items-center">
                                                 <a class="button remove-answer me-2"> <?= __('X', 'lquiz') ?></a>
                                                 <input type="text" class="form-control" name="correct[0][]"
                                                        value=""
                                                        placeholder="<?= __('Correct answers', 'lquiz') ?>" id="answer" />
                                                 <input class="form-check-input ms-2 d-none" type="checkbox" name="selectedanswer[]" id="flexRadioDefault1">
                                             </div>
                                         </div>


                                 <div class="add-new-answer">
                                     <a class="button add-answer" id='add-new-answer' > <?= __('Add new answer', 'lquiz') ?></a>
                                 </div>
                                 <label class="control-label" for="points"> <?= __('Points for correct answer', 'lquiz') ?>:</label>
                                 <input type="number" class="form-control" step="0.5" name="points[]" value="<?php  echo( $key['points'] ); ?>"
                                        id="points" />
                                 <div class="image-wrapper">
	                             <?php

		                             echo '<a href="#" class="misha-upl"><img src="' . $key['imgid']  . '" /></a>
                                <a href="#" class="misha-rmv">Remove image</a>
                                <input type="hidden" name="imgid[]" value="' . $key['imgid'] . '">';



	                             ?>
                                 </div>
                             </div>
                             <div class="remove-button-container d-flex justify-content-end">
                             <a class="button remove-row"> <?= __('Delete', 'lquiz') ?></a>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     <?php endif;
    ?>

    <div class="add-next-question-button">
        <a id="add-row" class="button btn btn-primary">
            <?= __('Add new question', 'lquiz') ?>
        </a>
    </div>