<?php $this->layout('layout', ['title' => 'Home']) ?>

<h1>Home</h1>

<p>Message: <?php echo $this->e($message) ?></p>

<?php if ($auth->isLoggedIn()): ?>
    <p>Hello: <?php echo $auth->getUsername(); ?></p>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Title</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($posts as $post): ?>

            <tr>
                <th scope="row"><?php echo $post['id']; ?></th>
                <th colspan="2"><?php echo $post['title']; ?></th>
            </tr>

        <?php endforeach; ?>
        </tbody>
    </table>

<?php echo $paginator;?>

<?php else: ?>
    <h1>Зарегистрируйтесь или войдите</h1>
<?php endif; ?>
