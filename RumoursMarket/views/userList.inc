<?php $render('partial/header', $data); ?>

<h1>Persons</h1>

<?php if ($data['users'] != null && sizeof($data['users']) > 0) {
    $render('partial/users', $data);
} else {?>
    <!-- $render('partial/users', [ '@users' => $data['users']]); -->
    <p>No persons found.</p>
<?php } ?>

<?php $render('partial/footer', $data); ?>