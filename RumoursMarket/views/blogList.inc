<?php $render('partial/header', $data); ?>

<h1>My Blog</h1>

<?php if ($data['blogEntries'] != null && sizeof($data['blogEntries']) > 0) {
    $render('partial/blogEntries', $data);
} else {?>
    <!-- $render('partial/blogEntries', [ '@users' => $data['blogEntries']]); -->
    <p>No entries found.</p>
<?php } ?>

<?php $render('partial/footer', $data); ?>