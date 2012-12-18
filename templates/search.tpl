<div id="newsletter">
  <div class="container">
    <h3 class="title">
      WikiSynonyms is a <u>reliable platform</u> to search synonyms.</span>
    </h3>
    <h4 class="pitch">
      <span class="muted">Please enter a term or a phrase you want to search synonyms for:</span>
    </h4>
    <form action="./search" method="POST">
      <input id="term" name="term" type="text" {if $term}value="{$term}"{/if}><input class="btn btn-subscribe btn-xlarge" type="submit" value="Search">
    </form>
  </div>
</div>
{if $synonyms}
<div id="results" class="container">
  {if $synonyms['http'] != 200}
    {if $synonyms['http'] == 204}
    <div class="alert alert-error">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Error!</strong> {$synonyms['message']}
    </div>
    {/if}
    {if $synonyms['http'] == 300}
    <div class="alert">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Warning!</strong> {$synonyms['message']}
    </div>
    {/if}
  {else}
  <h4>Synonyms:</h4>
  {/if}
  <hr/>
  <ol>
    {foreach $synonyms['terms'] as $synonym}
    <li>
      {$synonym}
    </li>
    {/foreach}
  </ol>

</div>
{/if}