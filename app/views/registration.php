<?php $this->layout('layout', ['title' => 'Reg']) ?>

<p>Message: <?php echo $this->e($message);?></p>

<main class="form-signin w-100 m-auto">
    <form action="/reg" method="post">
        <h1 class="h3 mb-3 fw-normal">Please reg</h1>

        <div class="form-floating">
            <input type="text" class="form-control" id="username" placeholder="Bob" name="username">
            <label for="username">Username</label>
        </div>
        <div class="form-floating">
            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email">
            <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
            <label for="floatingPassword">Password</label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
        <p class="mt-5 mb-3 text-muted">© 2017–2022</p>
    </form>
</main>
