<?php foreach($comments as $comment): ?>
<div class="comment flex row">
    <div class="user-info mr-3 col-md-4">
        <img src="../../framework/assets/images/avatar.png">
        <p><?php echo $comment->userFirstname." ".$comment->userLastname ?></p>
    </div>
    <p><?php echo $comment->getContent() ?></p>
</div>
<?php endforeach; ?>