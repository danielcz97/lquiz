<table id="repeatable-fieldset-one" width="100%">
    <tbody>
    <?php
    if ( $question_repeter_group ) :
        foreach ( $question_repeter_group as $field ) {
            ?>
            <tr>
                <th>
                    <a class="button remove-row" href="#1"> <?= __('Delete', 'lquiz') ?></a>
                </th>
                <th>
                    <label class="control-label" for="category">
                        <?= __('Question Category', 'lquiz') ?>
                    </label>
                    <select name="category[]" id="category" class="category" select-group="first">
                        <option value="0" <?php if($field[ "category"]=="0" ){echo "selected" ;} ?>>
                            <?= __('Insert a letter', 'lquiz') ?>
                        </option>
                        <option value="1" <?php if($field[ "category"]=="1" ){echo "selected" ;} ?>>
                            <?= __('Insert date', 'lquiz') ?>
                        </option>
                        <option value="2" <?php if($field[ "category"]=="2" ){echo "selected" ;} ?>>
                            <?= __('Insert word', 'lquiz') ?>
                        </option>
                        <option value="3" <?php if($field[ "category"]=="3" ){echo "selected" ;} ?>>
                            <?= __('Insert time', 'lquiz') ?>
                        </option>
                        <option value="4" <?php if($field[ "category"]=="4" ){echo "selected" ;} ?>>
                            <?= __('Choice correct answer', 'lquiz') ?>
                        </option>
                        <option value="5" <?php if($field[ "category"]=="5" ){echo "selected" ;} ?>>
                            <?= __('Descript task', 'lquiz') ?>
                        </option>
                    </select>
                </th>

                <th>
                    <label class="control-label" for="question"> <?= __('Question', 'lquiz') ?>
                    </label>

                    <input type="text" name="title[]"
                           value="<?php if($field['title'] != '') echo esc_attr( $field['title'] ); ?>"
                           placeholder="<?= __('Question', 'lquiz') ?>" id="question" />
                    <div id="repeatable-question">
                <th>
                    <label class="control-label" for="points"> <?= __('Points for correct answer', 'lquiz') ?>:</label>
                    <input type="number" step="0.5" name="points[]" value="<?php  echo( $field['points'] ); ?>"
                           id="points" />
                </th>
                <th>
                    <label class="control-label" for="question2"><?= __('Exercises', 'lquiz') ?>:</label>

                    <input type="text" name="tdesc[]"
                           value="<?php if ($field['tdesc'] != '') echo esc_attr( $field['tdesc'] ); ?>"
                           placeholder="<?= __('Exercises', 'lquiz') ?>" id="question2" />
                </th>

                <th>
                    <label class="control-label" for="answer"> <?= __('Correct answers', 'lquiz') ?>:</label>
                    <input type="text" name="correct[]"
                           value="<?php if ($field['correct'] != '') echo esc_attr( $field['correct'] ); ?>"
                           placeholder="<?= __('Correct answers', 'lquiz') ?>" id="answer" />
                </th>

                <th id="image">
                    <label class="control-label" for="images"><?php echo __('Image', 'lquiz') ?>:</label>
                    <input type="file" name="<?php $field['images']; ?>" value="<?php
                    if ($field['images'] != '') echo wp_get_attachment_url($field['images']); ?>" id="images" />
                </th>
            </tr>

            <?php
        }
    else :
        ?>
        <tr class="ten">
            <th>
                <a class="button  cmb-remove-row-button button-disabled" href="#">
                    <?= __('Delete', 'lquiz') ?>
                </a>
            </th>
            <th>
                <label class="control-label" for="category">
                    <?= __('Question Category', 'lquiz') ?>:</label>
                <select name="category[]" id="category" class="category" select-group="first">
                    <option value="1">
                        <?= __('Insert a letter', 'lquiz') ?>
                    </option>
                    <option value="2">
                        <?= __('Insert date', 'lquiz') ?>
                    </option>
                    <option value="3">
                        <?= __('Insert word', 'lquiz') ?>
                    </option>
                    <option value="4">
                        <?= __('Insert time', 'lquiz') ?>
                    </option>
                    <option value="5">
                        <?= __('Choice correct answer', 'lquiz') ?>
                    </option>
                    <option value="6">
                        <?= __('Descript task', 'lquiz') ?>
                    </option>
                </select>
            </th>
            <th>
                <label class="control-label" for="question"><?= __('Question', 'lquiz') ?>:</label>
                <input type="text" name="title[]" placeholder="<?= __('Question', 'lquiz') ?>" id="question" />
            </th>
            <th>
                <label class="control-label" for="points"> <?= __('Points for correct answer', 'lquiz') ?>:</label>
                <input type="number" step="0.5" name="points[]" id="points" />
            </th>

            <th>
                <label class="control-label" for="exercises"> <?= __('Exercises', 'lquiz') ?>:</label>
                <input type="text" name="tdesc[]" value="" id="exercises"
                       placeholder=" <?= __('Exercises', 'lquiz') ?>" />
            </th>
            <th>
                <label class="control-label" for="correct_answer"> <?= __('Correct answers', 'lquiz') ?>:</label>
                <input type="text" name="correct[]" value="" id="correct_answer"
                       placeholder="<?= __('Correct answers', 'lquiz') ?>" />
            </th>
            <td id="image">
                <label class="control-label" for="images"><?= __('Image', 'lquiz') ?>:</label>
                <input type="file" name="images[]" value="" id="images" />
            </th>
        </tr>
    <?php endif; ?>
    <tr class="empty-row custom-repeter-text">
        <th>
            <a class="button remove-row" href="#1"> <?= __('Delete', 'lquiz') ?> </a>
        </th>
        <th>
            <label class="control-label" for="category">
                <?= __('Question Category', 'lquiz') ?>:</label>
            <select name="category[]" id="category" class="category" select-group="first">
                <option value="1">
                    <?= __('Insert a letter', 'lquiz') ?>
                </option>
                <option value="2">
                    <?= __('Insert date', 'lquiz') ?>
                </option>
                <option value="3">
                    <?= __('Insert word', 'lquiz') ?>
                </option>
                <option value="4">
                    <?= __('Insert time', 'lquiz') ?>
                </option>
                <option value="5">
                    <?= __('Choice correct answer', 'lquiz') ?>
                </option>
                <option value="6">
                    <?= __('Descript task', 'lquiz') ?>
                </option>
            </select>
        </th>
        <th>
            <label class="control-label" for="question"> <?= __('Question', 'lquiz') ?>:</label>
            <input type="text" name="title[]" placeholder="<?= __('Question', 'lquiz') ?>" id="question" />
        </th>

        <th>
            <label class="control-label" for="points"> <?= __('Points for correct answer', 'lquiz') ?>:</label>
            <input type="number" step="0.5" name="points[]" id="points" />
        </th>

        <th>
            <label class="control-label" for="exercises"> <?= __('Exercises', 'lquiz') ?>:</label>
            <input type="text" name="tdesc[]" value="" id="exercises"
                   placeholder=" <?= __('Exercises', 'lquiz') ?>" />
        </th>

        <th>
            <label class="control-label" for="correct_answer"> <?= __('Correct answers', 'lquiz') ?>:</label>
            <input type="text" name="correct[]" value="" id="correct_answer"
                   placeholder="<?= __('Correct answers', 'lquiz') ?>" />
        </th>

        <th id="image">
            <label class="control-label" for="images"><?= __('Image', 'lquiz') ?>:</label>
            <input type="file" name="images[]" value="" id="images" />
        </th>
    </tr>

    </tbody>
</table>
<p>
    <a id="add-row" class="button" href="#">
        <?= __('Add next question', 'lquiz') ?>
    </a>
</p>