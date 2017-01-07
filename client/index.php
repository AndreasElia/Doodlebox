<?php
    if (! isset($_SESSION['token'])) {
        $token = md5(uniqid(rand(), TRUE));

        $_SESSION['token'] = $token;
        $_SESSION['token_time'] = time();
    } else {
        $token = $_SESSION['token'];
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo $token; ?>">

        <title>Doodlebox | Home</title>

        <script>
            window.Laravel = { csrfToken: '<?php echo $token; ?>' };
        </script>

        <!-- Styles -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="/public/css/app.css" rel="stylesheet">
    </head>
    <body>

        <div id="app">
            <app-header></app-header>

            <latest-doodles v-if="this.$route.meta.showLatest"></latest-doodles>

            <router-view></router-view>

            <app-footer></app-footer>
        </div>

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="/public/js/app.js"></script>
    </body>
</html>
