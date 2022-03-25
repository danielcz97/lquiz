<div class="empty-row custom-repeter-text">
	<div class="accordion-item">
		<h2 class="accordion-header" id="heading">
			<button class="accordion-button collapsed border-accordion" type="button" data-bs-toggle="collapse" data-bs-target="#collapse" aria-expanded="true" aria-controls="collapse">
				 <?= __('Question', 'lquiz') ?>
			</button>
		</h2>
		<div id="collapse" class="accordion-collapse collapse" aria-labelledby="heading" data-bs-parent="#accordionExample">
			<div class="accordion-body">
				<label class="control-label" for="category">

					<?= __('Question Category', 'lquiz') ?>
				</label>
				<select name="category[]" class="form-select category" id="category"  select-group="first">
					<option value="0" >
						<?= __('Insert a letter', 'lquiz') ?>
                    </option>
					<option value="1">
						<?= __('Insert date', 'lquiz') ?>
					</option>
					<option value="2">
						<?= __('Insert word', 'lquiz') ?>
					</option>
					<option value="3" >
						<?= __('Insert time', 'lquiz') ?>
					</option>
					<option value="4">
						<?= __('Choice correct answer', 'lquiz') ?>
					</option>
					<option value="5" >
						<?= __('Description task', 'lquiz') ?>
					</option>
				</select>
				<div class="questions-types-fields">
					<label class="control-label" for="question">
                        <?= __('Question', 'lquiz') ?>
                    </label>
					<textarea name="title[]" class="form-control textarea-field"></textarea>
					<div id="repeatable-question" class="my-2">
                        <div class="row-with-correct-answer">
								<label class="control-label" id="answer-label" for="answer"><?= __('Answer	', 'lquiz') ?>:</label>
								<div class="w-100 d-flex justify-content-center align-items-center">
									<a class="button remove-answer me-2"> X</a>
									<input type="text" class="form-control" name="correct[][]"
									       value=""
									       placeholder="<?= __('Answer', 'lquiz') ?>" id="answer" />
									<input class="form-check-input ms-2 d-none" type="checkbox" name="selectedanswer[]" id="flexRadioDefault1">
								</div>
							</div>
						<div class="add-new-answer">
							<a class="button add-answer" id='add-new-answer' > <?= __('Add new answer	', 'lquiz') ?>
                            </a>
						</div>
						<label class="control-label" for="points"> <?= __('Points for correct answer:', 'lquiz') ?></label>
						<input type="number" class="form-control" step="0.5" name="points[]" value=""
						       id="points" />
						<div class="image-wrapper">
							<label class="control-label" for="images">:</label>
							<input type="file" id="wp_custom_attachment" name="wp_custom_attachment[]" value="" size="25" />
						</div>
					</div>
					<a class="button remove-row"> <?= __('Delete', 'lquiz') ?></a>
				</div>
			</div>
		</div>
	</div>
</div>