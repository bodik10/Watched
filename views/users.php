<!-- Sort table widget -->
<script src="/js/sorttable.js"></script>

<!-- app's own JavaScript -->
<script src="/js/users.js"></script>

<?php if ($rows): ?>

    <table class="table table-striped table-hover" id="dest">
        <thead>
        <tr style="white-space: nowrap;">
            <th>#</th><th>User's Name</th><th>Movies</th><th>Runtime</th><th>Average Rating</th><th>Favorite Genre</th><th>Movies you watched</th><th></th>
        </tr>
        </thead>
        <tbody>
        
        <?php for ($i = 0; $i < count($rows); $i++): ?>
            <tr>
                <td><?= $i+1 ?></td>
                <td><span class="glyphicon glyphicon-user"></span> <?= $rows[$i]['name'] ?></td>
                <td><?= $rows[$i]['count'] ?></td>
                <td><?= $rows[$i]['runtime'] . " min" ?></td>
                <td><?= sprintf("%.2f", $rows[$i]['rating']) ?></td>
                <td><?= $rows[$i]['genre'] ?></td>
                <td><?= $rows[$i]['watched'] ?></td>
                <td><a href="#">Add a Friend</a></td>
            </tr>
        <?php endfor; ?>
        </tbody>

    </table>
    
<?php endif; ?>