<?php $this->layout('layout', ['title' => 'Post']) ?>

<h1>Post</h1>

<p>Message: <?php echo $this->e($message) ?></p>

<p>№: <?php echo $post['id']; ?></p>
<p>Text: <?php echo $post['title']; ?></p>
