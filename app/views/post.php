<?php $this->layout('layout', ['title' => 'Post']) ?>

<?php echo flash()->display();?>

<h1>Post</h1>

<p>Message: <?php echo $this->e($message) ?></p>
<table class="table">
    <thead>
    <tr>
        <th scope="col">Id</th>
        <th scope="col">Title</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th scope="row"><?php echo $post['id']; ?></th>
        <th colspan="2"><?php echo $post['title']; ?></th>
    </tr>
    </tbody>
</table>