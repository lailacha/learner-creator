<?php foreach($comments as $comment): ?>
<div class="comment ">
    <div class="user-info mr-3 col-md-4">
    <img class="w-50"src="<?php echo $comment->avatar ?>">

        <p><?php echo $comment->userFirstname." ".$comment->userLastname ?></p>
    </div>
   <?php echo $comment->getContent() ?>
    <i id="show" class="fa-solid fa-exclamation"></i>
</div>
    <div>
        <dialog class="modal">
            <div class="flex column">
                <h2>Report a comment</h2>
                    <?php echo $comment->showCommentForm() ?>
            </div>
            <div class="flex">
            <button id="hide" class="ml-2 error">Cancel</button>
            </div>
        </dialog>
    </div>
<?php endforeach; ?>