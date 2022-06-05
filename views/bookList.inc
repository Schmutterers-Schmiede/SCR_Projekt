<?php $render('partial/header', $data); ?>

<h1>List of Books</h1>
<nav class="nav nav-pills my-5">
    <?php foreach($data['categories'] as $cat) {
        $link($cat->getName(), 'Books', 'Index', ['cid' => $cat->getId()],
        'nav-link' . ($cat->getId() == $data['selectedCategoryId'] ? ' active' : ''));
    } ?>
</nav>

<?php if ($data['selectedCategoryId'] !== null) { ?>

<?php if ($data['books'] != null && sizeof($data['books']) > 0) {
    $render('partial/books', $data);
} else {?>
    <!-- $render('partial/books', [ '@books' => $data['books']]); -->
    <p>No books found.</p>
<?php } ?>
<?php } else { ?>
    <p>Please select a Category!</p>
<?php } ?>


<?php $render('partial/footer', $data); ?>