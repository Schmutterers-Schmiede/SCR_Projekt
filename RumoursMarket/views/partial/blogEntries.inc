<table class="table">
    <thead>
        <tr>
            <th>Datum</th>
            <th>Entrag</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['blogEntries'] as $blogEntry) : ?>
            <tr>
               <td><?php $htmlOut($blogEntry->getCreationDate()); ?></td>
               <td><b><?php $htmlOut($blogEntry->getBetreff()); ?></b><br>
               <?php $htmlOut($blogEntry->getBlogText()); ?>
               </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>