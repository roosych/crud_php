<?php
include 'header.php';

if (!is_admin()){
    if(!is_author($_SESSION['user']['id'], $_GET['id'])) {
        set_flash_message('danger', '<strong>Уведомление!</strong> Редактировать можно только свой профиль.');
        redirect_to('users.php');
        exit();
    }
};

$user = get_user_by_id($_GET['id']);

?>
    <main id="js-page-content" role="main" class="page-content mt-3">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-lock'></i> Безопасность
            </h1>

        </div>
        <?=display_flash_message('danger')?>
        <?=display_flash_message('success')?>
        <form action="security_handler.php" method="post">
            <div class="row">
                <div class="col-xl-6">
                    <div id="panel-1" class="panel">
                        <div class="panel-container">
                            <div class="panel-hdr">
                                <h2>Обновление эл. адреса и пароля</h2>
                            </div>
                            <div class="panel-content">
                                <input type="hidden" value="<?=$user['id']?>" name="id">
                                <!-- email -->
                                <div class="form-group">
                                    <label class="form-label" for="">Email</label>
                                    <input type="email" class="form-control" value="<?=$user['email']?>" name="email">
                                </div>

                                <!-- password -->
                                <div class="form-group">
                                    <label class="form-label" for="">Пароль</label>
                                    <input type="password" class="form-control" name="password">
                                </div>

                                <!-- password confirmation-->
<!--                                <div class="form-group">-->
<!--                                    <label class="form-label" for="simpleinput">Подтверждение пароля</label>-->
<!--                                    <input type="password" id="simpleinput" class="form-control">-->
<!--                                </div>-->


                                <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                    <button type="submit" class="btn btn-warning" name="submit">Изменить</button>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </form>
    </main>

    <script src="js/vendors.bundle.js"></script>
    <script src="js/app.bundle.js"></script>
    <script>

        $(document).ready(function()
        {

            $('input[type=radio][name=contactview]').change(function()
                {
                    if (this.value == 'grid')
                    {
                        $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-g');
                        $('#js-contacts .col-xl-12').removeClassPrefix('col-xl-').addClass('col-xl-4');
                        $('#js-contacts .js-expand-btn').addClass('d-none');
                        $('#js-contacts .card-body + .card-body').addClass('show');

                    }
                    else if (this.value == 'table')
                    {
                        $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-1');
                        $('#js-contacts .col-xl-4').removeClassPrefix('col-xl-').addClass('col-xl-12');
                        $('#js-contacts .js-expand-btn').removeClass('d-none');
                        $('#js-contacts .card-body + .card-body').removeClass('show');
                    }

                });

                //initialize filter
                initApp.listFilter($('#js-contacts'), $('#js-filter-contacts'));
        });

    </script>
</body>
</html>