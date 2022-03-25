<!-- How many minutes user have to finish test-->
<div class="col-md-12">
    <label class="control-label" for="setting_field_time">
        <?= __("How many minutes user have for pass this test?", "lquiz") ?>
    </label>
    <div class="col-md-12">
        <input type="number" step="1" name="lquiz_setting_field[time]" id="setting_field_time"
               value="<?= $args[0]['time']; ?>" required />
    </div>
</div>

<!-- Could user pass the test multiple times-->
<div class="col-md-12">
    <label class="control-label" for="setting_field_checkbox_time">
        <?=  __("Could user pass the test multiple times?", "lquiz") ?>
    </label>
    <input type="checkbox" name="lquiz_setting_field[checkbox_multiple_times]" value="checkbox_multiple_times" id="setting_field_checkbox_multiple_times"
        <?php if (isset($args[0]['checkbox_multiple_times'])) { if ($args[0]['checkbox_multiple_times'] ==='checkbox_multiple_times' ) { echo 'checked'; } }  ?>>
</div>

<!-- Show the score in the end-->
<div class="col-md-12">
    <label class="control-label" for="setting_field_checkbox_score_in_the_end">
        <?= __("Show the score in the end?", "lquiz") ?>
    </label>
    <input type="checkbox" name="lquiz_setting_field[meta_checkbox_score_in_the_end]" value="checkbox_score_in_the_end" id="setting_field_checkbox2"
        <?php if (isset($args[0]['meta_checkbox_score_in_the_end'])) { if ($args[0]['meta_checkbox_score_in_the_end'] ==='checkbox_score_in_the_end' ) { echo 'checked'; } }  ?>>
</div>

<!-- Could unlogged user pass the test-->
<div class="col-md-12">
    <label class="control-label" for="setting_field_meta_checkbox_unlogged">
        <?= __("Could not logged in user pass the test?", "lquiz") ?>
        <input type="checkbox" name="lquiz_setting_field[meta_checkbox_unlogged]" value="meta_checkbox_unlogged" id="setting_field_meta_checkbox_unlogged"
            <?php if (isset($args[0]['meta_checkbox_unlogged'])) { if ($args[0]['meta_checkbox_unlogged'] ==='meta_checkbox_unlogged' ) { echo 'checked'; } }  ?>>
    </label>
</div>