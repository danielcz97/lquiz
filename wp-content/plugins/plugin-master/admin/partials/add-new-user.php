<?php
global $wpdb, $user_ID;
require_once(dirname(__DIR__).'/classLquizAdminUserRole.php');

$userInfo = new classLquizAdminUserRole();
$arrayWithUsersInfo = $userInfo->getUserInfo();
?>
	<h3><?= __('Add new user', 'lquiz') ?></h3>
    <div class="container">
        <ul class="container--tabs">
            <li class="tab teacher"><?= __('Add New Teacher', 'lquiz') ?></li>
            <li class="tab parent"><?= __('Add New Parents', 'lquiz') ?></li>
            <li class="tab student"><?= __('Add New Student', 'lquiz') ?></li>
        </ul>

        <div class="container--content">
            <div class="content">
                <h1><?= __('Add Student', 'lquiz') ?></h1>
                <form action="" method="post" name="user_registeration">
                    <input type="hidden" id="userrole" name="userrole" value="teacher">
                    <div class="username d-grid">
                        <label><?= __('User Name', 'lquiz') ?></label>
                        <input type="text" name="username" placeholder="Enter Your Username" class="text" required />
                    </div>
                    <div class="email-address d-grid">
                        <label><?= __('Email address', 'lquiz') ?></label>
                        <input type="text" name="useremail" class="text" placeholder="Enter Your Email" required />
                    </div>
                    <div class="password d-grid">
                        <label><?= __('Password', 'lquiz') ?> </label>
                        <input type="password" name="password" class="text" placeholder="Enter Your password" required />
                    </div>
                    <div class="selectteacher">
                        <label><?= __('Select Teacher', 'lquiz') ?> </label>
                    <select name='teacherid'>
                        <option><?= __('Select Teacher', 'lquiz') ?></option>

		                <?php
		                foreach($arrayWithUsersInfo as $item) {
			                if($item['user_type'] == 'teacher'):
				                echo "<option  value=".$item['ID'].">".$item['user_nickname']."</option>";
			                endif;
		                }
		                ?>
                    </select>
                    </div>
                    <div class="selectparent">
                        <label><?= __('Select Parent', 'lquiz') ?> </label>

                    <select name='parentsid'>
                        <option><?= __('Select Parent', 'lquiz') ?></option>

		                <?php
		                foreach($arrayWithUsersInfo as $item) {
			                if($item['user_type'] == 'parents'):
				                echo "<option  value=".$item['ID'].">".$item['user_nickname']."</option>";
			                endif;
		                }
		                ?>
                    </select>
                    </div>

                    <div class="user-type d-grid mt-5">
                        <input type="submit" name="user_registeration" value="<?= __('Register', 'lquiz') ?>" />
                    </div>
                </form>            </div>
        </div>
    </div>
<?php

