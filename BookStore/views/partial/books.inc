<table class="table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Price</th>
            <th>In Cart</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['books'] as $book) : ?>
            <tr<?php if ($book->isInCart()) { ?> class="table-primary"<?php } ?>>
                <td><?php $htmlOut($book->getTitle()); ?></td>
                <td><?php $htmlOut($book->getAuthor()); ?></td>
                <td><?php $htmlOut($book->getPrice()); ?></td>
                <td><?php $htmlOut($book->getCartCount()); ?></td>
                <td>
                    <div class="d-flex">
                        <!-- TODO -->
                        <?php $beginForm('Cart', 'Add', ['bid' => $book->getId(), 'returnUrl' => $data['returnUrl']], 'post', 'form-inline'); ?>
                            <button class="btn btn-link">Add to cart</button>
                        <?php $endForm(); ?>
                        <?php if ($book->isInCart()) { ?>
                            <?php $beginForm('Cart', 'Remove', ['bid' => $book->getId(), 'returnUrl' => $data['returnUrl']], 'post', 'form-inline'); ?>
                                <button class="btn btn-link">Remove from cart</button>
                            <?php $endForm(); ?>
                        <?php } ?>
                    </div>
                </td>
                </tr>
            <?php endforeach; ?>
    </tbody>
</table>