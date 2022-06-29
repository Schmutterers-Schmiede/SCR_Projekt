<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Member since</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['users'] as $user) : ?>
            <tr>
                <td><?php $htmlOut($user->getUserName()); ?></td>
                <td><?php $htmlOut($user->getCreationDate()); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>