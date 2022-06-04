<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <title>SCR4 Book Shop</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <!-- DONE: navigation home -->
            <?php $link('SCR4 Book Shop', 'Home', 'Index', cssClass: 'navbar-brand'); ?>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar">
                <nav class="navbar-nav me-auto">
                    <!-- DONE: navigation -->
                    <?php $link('SCR4 Book Shop', 'Home', 'Index', cssClass: 'nav-link'); ?>
                    <?php $link('List', 'Books', 'Index', cssClass: 'nav-link'); ?>
                    <?php $link('Order', 'Order', 'Create', cssClass: 'nav-link'); ?>
                </nav>
                <!-- TODO: navigation user -->
                <?php $render('partial/user', $data['user']); ?>
            </div>
        </div>
    </nav>
    <div class="container mt-3">
        <?php if(isset($data['errors'])) {
            $render('partial/errors', $data['errors']);
        } ?>