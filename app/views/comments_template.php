<?php if( ($comment['status'] == 0 && !empty($comment['children'])) || $comment['status'] != 0 ) { ?>
<li class="list-unstyled">
    <?php if( $comment['status'] != 0 ) { ?>
	<div id="post-<?php echo $comment['id']; ?>" class="post-parent row">
		<div id="post-remove-<?php echo $comment['id']; ?>" class="show-back">
            <form method="post" action="javascript:void(null);" onsubmit="deleteComment(this);">
                <div class="col-image"><img class="avatar" src="../../images/<?php if (isset($comment['id_user'])) { echo $comment['image']; } else { echo 'default.png'; }?>" alt="avatar"/></div>
                <div class="col-body">
                    <div class="post-header">
                        <span><?php if (isset($comment['id_user'])) { echo $comment['name']; } else { echo $comment['guest']; }?></span>
                        <span>•</span>
                        <span><?php echo $comment['created_at'];?></span>
                    </div>
                    <div class="post-content">
                        <p class="comment"><?php echo $comment['text'];?></p>
                    </div>
                    <div class="post-footer">
                        <span id="rating-<?php echo $comment['id']; ?>" class="<?php if($ratings[$comment['id']] >= 0){ echo 'text-success'; } else { echo 'text-danger'; }?>"><?php echo $ratings[$comment['id']]; ?></span>
                        <a id="vote-<?php echo $comment['id']; ?>" data-user="<?php if( isset($_SESSION['user_id']) ){ echo $_SESSION['user_id'];} else { echo '0';} ?>" data-author="<?php if( isset($comment['id_user']) ){ echo $comment['id_user']; } else { echo '0'; } ?>" class="vote-up" href="javascript:void(null);" onclick="vote(this, <?php echo $comment['id']; ?>);">
                            <span class="glyphicon glyphicon-thumbs-up btn" aria-hidden="true"></span>
                        </a>
                        <span>|</span>
                        <a class="vote-down" href="javascript:void(null);" onclick="vote(this, <?php echo $comment['id']; ?>);">
                            <span class="glyphicon glyphicon-thumbs-down btn" aria-hidden="true"></span>
                        </a>
                        <span>•</span>
                        <a class="btn reply" onclick="CommentReply(<?php echo $comment['id'] ?>)">Відповісти</a>
                        <?php if( isset($_SESSION['user_id']) && isset($comment['id_user']) && $_SESSION['user_id'] == $comment['id_user'] ){ ?>
                            <input type="hidden" name="category" value="<?php echo $comment['category_id'] ?>"/>
                            <input type="hidden" name="id" value="<?php echo $comment['id'] ?>"/>
                            <a class="btn comment-edit" onclick="CommentEdit(<?php echo $comment['id'] ?>, '<?php echo $comment['text'];?>')">Редагувати</a>
                            <button type="submit" class="btn btn-link">Видалити</button>
                        <?php } ?>
                    </div>
            </form>
            <div id="reply-<?php echo $comment['id']; ?>"></div>
            <div class="row-edit"></div>
			</div>
		</div>
	</div>
    <?php } else { ?>
        <div class="post-parent row">
            <div class="col-md-1"><img class="avatar" src="../../images/default.png" alt="avatar"/></div>
            <div class="col-md-11">
                <p>Коментар видалено!</p>
            </div>
        </div>
    <?php } ?>

    <?php if(!empty($comment['children'])) { ?>
    <ul class="children">
        <?php echo getCommentsTemplate($comment['children'], $ratings);?>
    </ul>
    <?php } ?>
</li>

<?php } ?>