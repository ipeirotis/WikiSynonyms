<div class="row">
  <div class="span12">
    <div id="newsletter">
      <div class="container">
        <h3 class="title">
          WikiSynonyms is a <u>reliable platform</u> to search synonyms.
        </h3>
        <h4 class="pitch">
          <span class="muted">Please enter a term or a phrase you want to search synonyms for:</span>
        </h4>
        <form id="search-form" action="<?php echo $this->make_route('/search') ?>" method="POST">
          <input id="term" name="term" type="text" <?php if ($term): ?> value="<?php echo $term ?>"<?php endif; ?>><input class="btn btn-subscribe btn-xlarge" type="submit" value="Search">
        </form>
      </div>
    </div>
  </div>
</div>    
<?php if ($synonyms): ?>
  <div class="row">
    <div class="span12">
      <div id="results">
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
              <?php if ($synonyms['http'] != 200): ?>
                <a class="search-again" href="#"><i class="icon-search"></i> <?php echo $synonym ?></a>
              <?php else: ?>
                <?php echo $synonym['term'] ?><?php if($synonym['canonical']) : ?>&nbsp;<abbr title="Canonical page"><i style="font-weight: bold;" class="fontello-wikipedia"></i></abbr><?php endif; ?><?php if($synonym['canonical']) : ?>&nbsp;<abbr title="oDesk Skill"><i style="color:#7AC143;" class="icon-circle-blank"></i></abbr><?php endif; ?>
              <?php endif; ?>
            </li>
          <?php endforeach; ?>
        </ol>
        <?php if ($synonyms['http'] == 200): ?>
        <hr/>
        <h6 style="margin-bottom: 0;">Reference:</h6>
        <i style="color:#7AC143;" class="icon-circle-blank"></i>: oDesk Skill, <i style="font-weight: bold;" class="fontello-wikipedia"></i>: Canonical page 
        <?php endif; ?>
      </div>
    </div> 
  </div> 
<?php endif; ?>

<script type="text/javascript">
  $(document).ready(function() {  
    var form = $('#search-form');
    var term = $('input#term');
    $('a.search-again').click(function(e) {
      var new_term = $(this).text();
      e.preventDefault();
      term.attr('value', new_term);
      form.submit();
    });

  });
</script>