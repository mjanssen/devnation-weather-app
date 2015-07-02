<form action="" method="post">


</form>

<div class="container">

    <form class="form-signin" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="email" class="sr-only">Email address</label>
        {{ form.render('email') }}
        <label for="password" class="sr-only">Password</label>
        {{ form.render('password') }}
        <div class="checkbox">
            <label>
                {{ form.render('remember') }} Remember me
            </label>
        </div>
        {{ form.render('csrf') }}
        {{ form.render('go') }}
        <a class="btn btn-info" href="/user/login/oauth/google">Register using Google</a>
    </form>

</div>