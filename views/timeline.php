<link rel="stylesheet" href="css/timeline-reset.css"> <!-- CSS reset -->
<link rel="stylesheet" href="css/timeline-style.css"> <!-- Resource style -->

<script src="/js/modernizr.js"></script>

<!-- app's own JavaScript -->
<script src="/js/timeline.js"></script>

<?php if ($rows): ?>
    
    <section id="cd-timeline" class="cd-container">
        
        <?php foreach ($rows as $row): ?>
        
    		<div class="cd-timeline-block">
    			
    			<img class="cd-timeline-img cd-picture" src="<?= $row['poster'] ?>">

    			<div class="cd-timeline-content">
    				<h2><?= $row['name'] . " (" . $row['released'] . ")"?>
    				<div class='star_container'>
    				<?php 
    				    if ($row['rating'] > 0){
    				        echo "";
    				        for ($i=0; $i<$row['rating']; $i++){
    				            echo "<img src='img/star-filled-48.png' width=16>";
    				        }
    				    }
    				?>
    				</div>
    				</h2>
    				<div class="timeline_infodiv"><?= "{$row['genre']} | {$row['runtime']} | <a href='http://www.imdb.com/title/{$row['imdb_id']}'>IMDb Rating: {$row['rating_imdb']}</a>" ?></div>
    				<p><?= $row['plot'] ?></p>
    				<span class="cd-date"><?= date("F d, Y", strtotime($row['date'])) ?></span>
    			</div> <!-- cd-timeline-content -->
    		</div> <!-- cd-timeline-block -->
		
		<?php endforeach; ?>

	</section> <!-- cd-timeline -->
    
<?php endif; ?>