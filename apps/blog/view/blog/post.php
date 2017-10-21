<?php
if ( ! empty( $errorMsg ) ) {
	?>
    <div class="message message-error"><?= $errorMsg ?></div>
<?php } ?>
<form name="postArticleForm" action="/admin/postArticle.post" id="postArticleForm" method="POST" class="form">
    <div class="input-group input-group-inline">
        <div class="width-20">
            <div class="label">{w:message articleTitle}</div>
        </div>
        <div class="content width-80">
            <input type="text" name="articleTitle" class="input" title="{w:message articleTitle}"/>
        </div>
    </div>
    <div class="input-group input-group-inline">
        <div class="width-20">
            <div class="label">{w:message articleContent}</div>
        </div>
        <div class="content width-80">
			<textarea name="articleContent" class="textarea" id="articleContent" title="{w:message
			articleContent}"></textarea>
        </div>
    </div>
    <div class="input-group input-group-inline text-center">
        <button class="button" type="submit" name="postButton">{w:message btn.post}</button>
        <button class="button button-orange" type="button" name="postButton">{w:message btn.preview}</button>
        <button class="button button-white" type="button" name="postButton">{w:message btn.cancel}</button>
    </div>
</form>
<script type="text/javascript" src="/resources/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        CKEDITOR.replace('articleContent');
    })
</script>