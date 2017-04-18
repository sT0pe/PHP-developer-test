<div class="container-fluid">
    <ul class="nav nav-tabs nav-categories">
        <?php foreach ($categories as $category) { ?>
        <li id="tab-<?php echo $category['id']; ?>" class="tab <?php if( $cat_id == $category['id'] ){ echo 'active'; } ?>" role="presentation"><a href="javascript:void(null);" onclick="changeCategory(<?php echo $category['id']; ?>)"><?php echo $category['category']; ?></a></li>
        <?php } ?>
    </ul>

    <?php if(isset($_SESSION['errors'])){ ?>
        <div class="alert alert-danger error-div col-md-12">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <p><?php foreach ($_SESSION['errors'] as $error){ echo $error; } ?></p>
        </div>
    <?php } ?>
	<?php if(isset($_SESSION['success'])){ ?>
        <div class="alert alert-success error-div col-md-12">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <p><strong><?php echo $_SESSION['success']; ?></strong></p>
        </div>
	<?php } ?>

    <div class="container login-container">
        <div class="row login-row">
            <div class="pull-left">
                <span class="col-md-12 comment-count">
                    <span><strong>Коментарів: </strong></span>
                    <span id="comments-quantity"><strong><?php echo $quantity; ?></strong></span>
                </span>
            </div>
            <div class="pull-right text-right">
                <?php if( !isset($_SESSION['user_id']) ) { ?>
                    <a class="show-login-form" href="#">
                        <span class="btn btn-link">Увійти <span class="caret"></span></span>
                    </a>
                <?php } else { ?>
                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle btn-link" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <span><?php echo $_SESSION['user_name']; ?></span>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a href="/user/logout">Вийти</a></li>
                        </ul>
                    </div>
                <?php } ?>

            </div>
        </div>

        <div class="login-form">
            <form action="/user/login" method="post">
                <div class="form-group">
                    <input type="email" class="form-control" id="email" name="email" required placeholder="Електронна пошта" />
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="password" name="password" required placeholder="Пароль" />
                </div>
                <div class="form-group">
                        <button type="submit" class="btn btn-primary">Увійти</button>
                        <a class="btn close-form" href="#">Закрити</a>
                        <a class="btn go-to-registration" href="#" >Регістрація</a>
                </div>
            </form>
        </div>

        <div class="registration-form">
            <form action="/user/registration" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" name="name" required placeholder="І'мя" />
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" required placeholder="Електронна пошта" />
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" required placeholder="Пароль" />
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Готово</button>
                    <a class="btn close-form" href="#">Закрити</a>
                    <a href="#" class="btn go-to-login">Уже є акаунт?</a>
                </div>
            </form>
        </div>

    </div>

    <div class="container">
        <div class="row">
            <form action="javascript:void(null);" method="post" onsubmit="addComment(this);">
                <div class="form-group">
                    <div class="col-md-1"><img class="avatar" src="../../images/<?php if (isset($_SESSION['image'])) { echo $_SESSION['image']; } else { echo 'default.png'; }?>" alt="avatar"/></div>
                    <div class="col-md-11">
                        <textarea id="comment-text" class="form-control" name="text" rows="4" placeholder="Приєднатись до обговорення..."></textarea>
                        <div class="col-md-12 form-group form-inline quest-form">
                            <button type="submit" class="btn btn-primary pull-right form-control">Надіслати</button>
                            <?php if( isset($_SESSION['user_id']) ){ ?>
                                <input type="hidden" name="id_user" value="<?php echo $_SESSION['user_id']; ?>"/>
                            <?php } else { ?>
                                <span class="pull-right">&nbsp;</span>
                                <input type="text" name="guest" class="pull-right form-control" placeholder="Ім'я"/>
                            <?php } ?>
                        </div>
                        <input id="cat-id-form" name="category_id" type="hidden" value="<?php echo $categories[0]['id']; ?>"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="error-div" style="display:none;" class="error-div alert alert-danger col-md-12">
    <button type="button" class="close" onclick="closeError('error-div');">
        <span aria-hidden="true">&times;</span>
    </button>
    <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
    <span id="error-span"></span>
</div>

<div id="conversation" class="container">
    <?php echo $comments; ?>
</div>

<div id="comment-form-wrap" style="display:none;">
<div id="comment-form" class="comment-form">
        <div class="row">
            <form action="javascript:void(null);" method="post" onsubmit="addComment(this);">
                <div class="form-group">
                    <div class="col-image"><img class="avatar" src="../../images/<?php if (isset($_SESSION['image'])) { echo $_SESSION['image']; } else { echo 'default.png'; }?>" alt="avatar"/></div>
                    <div class="col-body">
                        <textarea id="text-reply" class="form-control" name="text" rows="4" placeholder="Приєднатись до обговорення..."></textarea>
                        <div class="col-md-12 form-group form-inline quest-form">
                            <a href="#" class="btn btn-danger pull-right form-control close-form-reply" onclick="closeFormReply(this);">Закрити</a>
                            <span class="pull-right">&nbsp;</span>
                            <button type="submit" class="btn btn-primary pull-right form-control">Надіслати</button>
							<?php if( isset($_SESSION['user_id']) ){ ?>
                                <input type="hidden" name="id_user" value="<?php echo $_SESSION['user_id']; ?>"/>
							<?php } else { ?>
                                <span class="pull-right">&nbsp;</span>
                                <input type="text" name="guest" class="pull-right form-control" placeholder="Ім'я"/>
							<?php } ?>
                        </div>
                        <input id="cat-id" name="category_id" type="hidden" value="<?php echo $categories[0]['id']; ?>"/>
                        <input id="comment-id" name="id_comment" type="hidden" value="0"/>
                        <input id="parent-id" name="id_parent" type="hidden" value="0" />
                    </div>
                </div>
            </form>
        </div>
</div>
</div>