<!-- Sort table widget -->
<script src="/js/sorttable.js"></script>

<!-- app's own JavaScript -->
<script src="/js/list.js"></script>

<?php if ($rows): ?>
    <p><b><a href="#" class="reset_filters">Reset All Filters</a></b></p>
    <p><b>Filter by year:</b> <span id="filter_list_year"></span></p>
    <p><b>Filter by genre:</b> <span id="filter_list_genre"></span></p>

    <table class="table table-striped table-hover" id="dest">
        <thead>
        <tr style="white-space: nowrap;">
            <th>#</th><th>Movie</th><th>Year</th><th>Runtime</th><th>Genre</th><th>When Watched</th><th>Your Rating</th><th>IMDb Rating</th><th>PAW <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom" title="Number of persons also watched that movie"></span></th>
        </tr>
        </thead>
        <tbody>
        
        <?php for ($i = 0; $i < count($rows); $i++): ?>
            <tr>
                <td><?= $i+1 ?></td>
                <td><?= $rows[$i]['name'] ?></td>
                <td><?= $rows[$i]['released'] ?></td>
                <td><?= $rows[$i]['runtime'] ?></td>
                <td class="genre_cell"><?= $rows[$i]['genre'] ?></td>
                <td class="date_cell"><?= $rows[$i]['date'] ?></td>
                <td><?= ($rows[$i]['rating'] == 0) ? "no rating" : $rows[$i]['rating'] ?></td>
                <td><?= $rows[$i]['rating_imdb'] ?></td>
                <td><?= $rows[$i]['counter'] - 1 ?></td>
            </tr>
        <?php endfor; ?>
        </tbody>

    </table>
    
<?php endif; ?>