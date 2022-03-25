<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       lquiz
 * @since      0.0.1
 *
 * @package    lquiz
 * @subpackage lquiz/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    lquiz
 * @subpackage lquiz/includes
 * @author     Daniel <daniel.czerepak@polcode.net>
 */
class lquiz_Questions {





    /**
     * Questions meta box function with html
     * 
     */
    public function questions_meta_box_function()
    {
        wp_nonce_field('cs_nonce_check', 'cs_nonce_check_value');
        global $post;
        $meta = get_post_meta($post->ID, 'question_meta_fields', true);
        if (empty($meta)) {
            $meta = array();
            $meta[] = array('id' => 0, 'question' => '', 'mark' => '', 'answer_meta' => array(array('answer' => '', 'correct' => '')));
        } ?>
<div class="wqt_wrapper wqt-questions-wrapper">
    <ul id="wqt-accordion-1" class="wqt-accordion wqt-question-append-js">
        <?php
                $counter = 0;
        foreach ($meta as $index => $key) {
            ?>
        <li class="wqt-questions-section" data-index="<?php echo $index; ?>">
            <input type='hidden' class="mcqs-id" name="question_meta_fields[<?php echo($counter); ?>][id][]" required>
            <div class="wqt-acc-head">
                <span class="wqt-question-rm" title="Usuń">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </span>
            </div>
            <div class="wqt-acc-panel">
                <div class="card">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Wybierz kategorię pytania</label>
                                    <select id="viewSelector<?php echo $counter ?>">
                                        <option value="view0<?php echo $counter ?>">
                                            Wybierz kategorię pytania</option>
                                        <option value="view1<?php echo $counter ?>">
                                            Wpisz literę</option>
                                        <option value="view2<?php echo $counter ?>">
                                            Wpisz datę</option>
                                        <option value="view3<?php echo $counter ?>">
                                            Wpisz słowo</option>
                                        <option value="view4<?php echo $counter ?>">
                                            Wpisz godzinę</option>
                                        <option value="view5<?php echo $counter ?>">
                                            Wybierz poprawną odpowiedź</option>
                                        <option value="view6<?php echo $counter ?>">
                                            Zadanie opisowe</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Wprowadź treść zadania</label>
                                    <input type="text" name="question_meta_fields[<?php echo $index; ?>][question][]"
                                        class="form-control wqt-meta-field" data-metatype="question" value="<?php if (isset($meta[$index]['question'][0])) {
                echo($meta[$index]['question'][0]);
            } else {
            } ?>">
                                </div>
                            </div>
                        </div>

                        <div id="view1<?php echo $counter ?>">
                            <div class="row" style="padding-right:15px">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Wprowadź słowo</label>
                                        <input type="text"
                                            name="question_meta_fields[<?php echo $index; ?>][ask_word][]"
                                            class="form-control wqt-meta-field" data-metatype="word" value="<?php if (isset($meta[$index]['ask_word'][0])) {
                echo $meta[$index]['ask_word'][0];
            } else {
            } ?>">
                                    </div>
                                </div>
                                <div class="wqt-answers-section">
                                    <div class="row wqt-answers-clone">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Poprawna odpowiedź</label>
                                                <input type="text"
                                                    name="question_meta_fields[<?php echo $index; ?>][answer_meta_word][]"
                                                    class="form-control wqt-meta-ans" data-metatype="answer" value="<?php if (isset($meta[$index]['answer_meta_word'][0])) {
                echo $meta[$index]['answer_meta_word'][0];
            } else {
            } ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="view2<?php echo $counter ?>">
                            <div class="row" style="padding-right:15px">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Prześlij zdjęcie</label>
                                        <?php 
                                        require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                                        require_once(ABSPATH . "wp-admin" . '/includes/file.php');
                                        require_once(ABSPATH . "wp-admin" . '/includes/media.php');
                                        ?>
                                        <input type="file" name="question_meta_fields[<?php echo $index; ?>][image][]"
                                            class="form-control wqt-meta-field" data-metatype="image" value="<?php if (isset($meta[$index]['image'][0])) {
                echo $meta[$index]['image'][0];
            } else {
            } ?>">
                                    </div>
                                </div>
                                <div class="wqt-answers-section">
                                    <div class="row wqt-answers-clone">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Poprawna odpowiedź</label>
                                                <input type="text"
                                                    name="question_meta_fields[<?php echo $index; ?>][answer_meta_word][]"
                                                    class="form-control wqt-meta-ans" data-metatype="answer" value="<?php if (isset($meta[$index]['answer_meta_image'][0])) {
                echo $meta[$index]['answer_meta_image'][0];
            } else {
            } ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="view3<?php echo $counter ?>">
                            <div class="row" style="padding-right:15px">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Wprowadź zdanie bez słowa</label>
                                        <input type="text"
                                            name="question_meta_fields[<?php echo $index; ?>][sentence][]"
                                            class="form-control wqt-meta-field" data-metatype="sentence" value="<?php if (isset($meta[$index]['sentence'][0])) {
                echo $meta[$index]['sentence'][0];
            } else {
            } ?>">
                                    </div>
                                </div>

                                <div class="wqt-answers-section">
                                    <div class="row wqt-answers-clone">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Poprawne słowo</label>
                                                <input type="text"
                                                    name="question_meta_fields[<?php echo $index; ?>][answer_meta_word][]"
                                                    class="form-control wqt-meta-ans" data-metatype="answer" value="<?php if (isset($meta[$index]['sentence_correct'][0])) {
                echo $meta[$index]['sentence_correct'][0];
            } else {
            } ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="view4<?php echo $counter ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Wybierz godzinę</label>
                                        <input type="time" step="300"
                                            name="question_meta_fields[<?php echo $index; ?>][answer_meta_time][]"
                                            class="form-control wqt-meta-ans" data-metatype="answer" value="<?php if (isset($meta[$index]['answer_meta_time'][0])) {
                echo $meta[$index]['answer_meta_time'][0];
            } else {
            } ?>">
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Poprawna godzina słownie</label>
                                        <input type="text"
                                            name="question_meta_fields[<?php echo $index; ?>][answer_meta_word][]"
                                            class="form-control wqt-meta-ans" data-metatype="answer" value="<?php if (isset($meta[$index]['answer_meta_time_correct'][0])) {
                echo $meta[$index]['answer_meta_time_correct'][0];
            } else {
            } ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="view5<?php echo $counter ?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Treść pytania</label>
                                        <input type="text"
                                            name="question_meta_fields[<?php echo $index; ?>][answer_meta_choice][]"
                                            class="form-control wqt-meta-ans" data-metatype="answer_meta_choice" value="<?php if (isset($meta[$index]['answer_meta_choice'][0])) {
                echo $meta[$index]['answer_meta_choice'][0];
            } else {
            } ?>">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Zła odpowiedź</label>
                                        <input type="text"
                                            name="question_meta_fields[<?php echo $index; ?>][answer_meta_choice_wrong][]"
                                            class="form-control wqt-meta-ans" data-metatype="answer_meta_choice_wrong"
                                            value="<?php if (isset($meta[$index]['answer_meta_choice_wrong'][0])) {
                echo $meta[$index]['answer_meta_choice_wrong'][0];
            } else {
            } ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Poprawna odpowiedź</label>
                                        <input type="text"
                                            name="question_meta_fields[<?php echo $index; ?>][answer_meta_word][]"
                                            class="form-control wqt-meta-ans" data-metatype="answer" value="<?php if (isset($meta[$index]['answer_meta_choice_correct'][0])) {
                echo $meta[$index]['answer_meta_choice_correct'][0];
            } else {
            } ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="view6<?php echo $counter ?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Treść pytania</label>
                                        <input type="text"
                                            name="question_meta_fields[<?php echo $index; ?>][answer_meta_question][]"
                                            class="form-control wqt-meta-ans" data-metatype="answer" value="<?php if (isset($meta[$index]['answer_meta_question'][0])) {
                echo $meta[$index]['answer_meta_question'][0];
            } else {
            } ?>">
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </li>
        <input type="hidden" name="question_meta_fields[]" class="wqt_question_id0" value="<?php echo $counter; ?>">
        <?php $counter = $counter + 1;
        } ?>
    </ul>
</div>

<div class="wqt_wrapper">
    <input type="button" class="btn btn-success wqt-add-question" value="Dodaj kolejne pytanie" />
</div>

<?php
    }


}