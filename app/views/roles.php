<?php $this->layout('layout', ['title' => 'Admin roles']) ?>


<table class="table">
    <thead>
    <tr>
        <th scope="col">Email</th>
        <th scope="col">Username</th>
        <th scope="col">Role</th>
        <th scope="col">New role</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <?php foreach ($arrUsers as $dataUser): ?>
        <tbody>
        <tr>
            <form action="/admin/editRole" method="post">
                <th scope="row"><?php echo $dataUser['email']; ?></th>
                <th colspan="2"><?php echo $dataUser['username']; ?></th>
                <th colspan="2"><?php echo $dataUser['roles_mask']; ?></th>
                <th colspan="2"><input type="number" placeholder="1" name="idRole"></th>
                <th colspan="2">
                    <button type="submit">Change role</button>
                </th>
                <input type="hidden" value="<?php echo $dataUser['id']; ?>" name="id">
            </form>
        </tr>
        </tbody>
    <?php endforeach; ?>
</table>