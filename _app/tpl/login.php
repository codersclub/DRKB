        <h1>Sign in</h1>

        <form id="login_form" action="" method="post">
            <p>
            <label for="username">Login:</label>
            <input type="text" id="username" name="username" required="required" value="<?= @$GLOBALS['username'] ?>"/>
            </p>

            <p>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required="required">
            </p>

            <p>
            <label for="submit"></label>
            <input id="submit" type="submit" value="Log in">
            </p>
        </form>
