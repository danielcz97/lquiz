<?php
defined( 'ABSPATH' ) || exit;
global $wpdb;
if ( 0 === post_exists( get_the_ID()) ):
session_start();
get_header();
$postId = strval(get_the_ID());
	$table_name = $wpdb->prefix . "new_scores";
    $sessionId = session_id();
	$get_category=	new lquiz_Admin();
	$is_in_database = $wpdb->get_results("SELECT * FROM $table_name WHERE  sessionid = '$sessionId' AND postid = $postId");
	echo "<input type='hidden' class='postid' value='".get_the_ID()."'/>";

	if (count($is_in_database) > 0):
    $dataDecode = json_decode(stripslashes($is_in_database[0]->currentcorrect), true);

	echo "<input type='hidden' class='endtime' value='".$is_in_database[0]->endtime."'>";
    echo "<input type='hidden' class='starttime' value='".$is_in_database[0]->starttime."'>";
	echo "<input type='hidden' class='status' value='".$is_in_database[0]->currentcorrect."'>";
    endif;
    ?>
<p id="demo"></p>
    <input type="hidden" name="sessionID" class="sessionId" value="<?= session_id() ?>">

<div class='content'>
    <input type="hidden" class="validationSession" value="<?= count($is_in_database); ?>">
    <h2 class="test-title">
        <?= get_the_title() ?>
    </h2>
    <h3 class="test-time">
		Time: <?= $args[0]['time']; ?> minutes
    </h3>
    <h4 class="test-content">
        <?= get_the_content() ?>
    </h4>
    <div class="test-buttons">


        <input id="start-test" type="submit" name="start-test" value="<?= __('Start test', 'lquiz') ?>">
<button id="show-results">
    <?= __('See results', 'lquiz') ?>
</button>
</div>
<div class="countdown"></div>
    <input type="hidden" id="timmerTime" value="<?= $args[0]['time']; ?>">


<div class="form-questions">
    <div class="time-left">
		<?= __('Time left: ', 'lquiz') ?> :
        <span id="timer"></span> |    <span class="test-time">
         <?= $args[0]['time']; ?>:00
    </span>
    </div>

    <h6 class="question-counter">
        Question <span class="question-current">1</span> of <span class="question-all"></span>
    </h6>

    <nav class="navigation-dots">
        <ul class="navigation-dots-ul">
        </ul>
    </nav>


    <form method="post" enctype="multipart/form-data" action="" id="questionForm">
        <input type="hidden" class="minutes" value="<?= $args[0]['time']; ?>">
        <?php $counter = 0;?>
        <?php foreach ($args[1] as $single) {
$counter = $counter +1;
	        ?>

        <div class="question_form" data-target="<?= $counter ?>">
          <h5 class="question-category">  <?= __('Question: ', 'lquiz')?>
            <?php $get_category->get_category_name($single['category']); ?>
          </h5>
            <?php if($single['category'] == 5): ?>


            <div class="row">
                <div class="col-md-12">
                    <h6>
                    <?php echo $single['title']; ?>
                        </h6>
                </div>
            </div>

                <textarea rows="10" type="textarea" name="answer[]"></textarea>
            <?php
            elseif($single['category'] == 3):
	            $listTitles = preg_split('/\s+/', $single['title']);
	            foreach($listTitles as $item) {
                    echo "<p>".$item."</p>";
                    echo "<input class='data-question' type='text' name='answer[]' />";

	            }
                elseif($single['category'] == 1):
                    $mediaUrl = wp_get_attachment_url($single['mediaId']);
                    $listTitles = preg_split('/(\r\n|\n|\r)/', $single['title']);
	                echo "<img src='".$mediaUrl."'><br>";
                        foreach($listTitles as $item) {
	                        if(strpos($single['title'], "%%%") !== false):
                            $test = str_replace("%%%", '<input type="text" class="word data-question" name="answer[]" value="" />', "<span class='image-span'>".$item."</span>");
                            echo $test."<br>";
                        endif;

}
           elseif($single['category'] == 4): ?>
                <h6>
		            <?php
                    $listTitles = preg_split('/(?<=[.?!])\s+(?=[a-z])/i', $single['title']);


		            foreach($listTitles as $item) {
			            $words = explode('/', $item);
			            $dashPosition = array_search('/',$words );
			            $keys = array_keys($words, '/');
                        foreach($words as $key) {
                            echo "<div>";
                            if(strlen($key) > 22) {
	                            echo "<div class='question'>".$key."</div>";
                            }
                            else if(strlen($key) > 0) {
	                            echo "<input type='checkbox' class='data-question' name='answer[]' value='$key'>".$key."</input>";
                            }
                            echo "</div>";
                        }
                    }
                    ?>
                </h6>

            <?php else:  ?>

            <h6>
            </h6>
            <div class="question-row">

                <?php
                if(strpos($single['title'], "%%%") !== false)
                {
                    $test = str_replace("%%%", '<input type="text" class="word data-question" name="answer[]" value="" />', "<span>".$single['title']."</span>");
                    echo $test;
                }
                else if(strpos($single['title'], "__") !== false)
                {
                    $test = str_replace("__", '<input type="text" name="answer[]" class="small-letter data-question" value="" />', "<span>".$single['title']."</span>");
                    echo $test;

                }

                else if(strpos($single['title'], "_") !== false)
                {
                    $test = str_replace("_", '<input type="text" name="answer[]" class="small-letter data-question" value="" />', "<span>".$single['title']."</span>");
                    echo $test;
                }

                else{
                    ?><input type="text" class="data-question" name="answer[]" value="" />;<?php
                }
  ?>
            </div>

            <?php endif; ?>
        </div>
        <?php        } ?>
        <div class="navbutton">
            <button type="button" id="prevButton">
                <?= __('Previous question', 'lquiz') ?>
            </button>
            <button type="button" id="nextButton">
                <?= __('Next question', 'lquiz') ?>
            </button>
        </div>
        <input type="hidden" value="<?= get_the_title() ?>" name="title">
    </form>
    <input type="submit" name="submittest" id="saveButton" value="<?= __('Save test', 'lquiz') ?>">


</div>
    <div class="after-submit">
        <?=  ($args[0]['checkbox_multiple_times'] ? '<button class="reset-session">'.__('Pass the test again', 'lquiz').'</button>' :  __("You can't pass the test again.", 'lquiz')) ?>
	    <?=  ($args[0]['meta_checkbox_score_in_the_end'] ? '<button data-bs-toggle="modal" data-bs-target="#exampleModal" class="show-results">'.__('See results of the test', 'lquiz').'</button>' : __("You can't see the results of that test.", 'lquiz')) ?>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Your results</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php
                        $getFromDatabase = $wpdb->get_results("SELECT * FROM $table_name WHERE sessionid = '$sessionId' and id=(SELECT max(id) FROM $table_name)");
                        foreach($getFromDatabase as $item ){
                            foreach($item as $i) {
                                echo $i."<br>";
                            }
                        }
                        ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
endif;
session_destroy();
get_footer();