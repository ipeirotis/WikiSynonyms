<div id="newsletter">
  <div class="container">
    <h3 class="title">
      WikiSynonyms is a <u>reliable platform</u> to search synonyms.
    </h3>
    <h4 class="pitch">
      <span class="muted">Please enter a term or a phrase you want to search synonyms for:</span>
    </h4>
    <form action="<?php echo $this->make_route('/search') ?>" method="POST">
      <input id="term" name="term" type="text" <?php if ($term): ?> value="<?php echo $term ?>"<?php endif; ?>><input class="btn btn-subscribe btn-xlarge" type="submit" value="Search">
    </form>
  </div>
</div>
<?php if ($synonyms): ?>
<div id="results" class="container">
  <?php if ($synonyms['http'] != 200): ?>
    <?php if ($synonyms['http'] == 204): ?>
    <div class="alert alert-error">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Error!</strong> <?php echo $synonyms['message'] ?>
    </div>
    <?php endif; ?>
    <?php if ($synonyms['http'] == 300): ?>
    <div class="alert">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Warning!</strong> <?php echo $synonyms['message'] ?>
    </div>
    <?php endif; ?>
  <?php else: ?>
  <h4>Synonyms:</h4>
  <?php endif; ?>
  <hr/>
  <ol>
    <?php foreach ($synonyms['terms'] as $synonym) : ?>
    <li>
      <?php echo $synonym ?>
    </li>
    <?php endforeach; ?>
  </ol>

</div>
<?php endif; ?>