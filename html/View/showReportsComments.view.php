<div class="col-md-12">
<?php foreach($comments as $comment): ?>
    <div class="comment ">
        <div class="user-info mr-3 col-md-4">
            <img src="../../framework/assets/images/avatar.png">
            <p><?php echo $comment->comment()->user()->fullname()?></p>
        </div>
        <p><?php echo $comment->comment()->getContent() ?></p>
    </div>
<?php if($comment->user() !== null): ?>
    <div class="report_comments flex column w-100 jc-sb col-md-12 mb-3">
        <p>
            Lesson:
        <a href="/show/lesson?lesson_id="></a>
        </p>

        <div class=" flex bg-red white" >
            <p class=" mr-1 col-md-8"> Report by <?php echo $comment->user()->fullname()?></p>
            <form method="POST" action="/delete/comment" class="report_comments-remove-container col-md-1 col-offset-md-3 jc-center flex ai-center">
                <input type="hidden" name="commentaire_id" value="<?php echo $comment->comment()->getId() ?>">
                <button type="submit" class="bg-red no-border"><i class="fas fa-thin fa-trash" onclick></i></button>

            </form>
        </div>

        <p>Reason: <?php echo $comment->getReason() ?></p>

    </div>
    <?php endif; ?>
<?php endforeach; ?>
