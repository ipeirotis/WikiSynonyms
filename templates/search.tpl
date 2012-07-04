<div>
  {if $errors}
  <ul class="error_list">
      {foreach $errors as $error}
      <li>{$error}</li>
      {/foreach}
  </ul>
  {/if}
  <form action="./index.php?action=search" method="post">
    <input type="hidden" name="submit" value="1"/>
    <input type="text" name="term" value="{$values.term}"/>
    <button type="submit">Search</button>
  </form>
</div>
<br/>
<br/>
{if $values.term }
<strong>{$total}</strong> synonym(s) has been found for term <strong>{$values.term}</strong>:<br/>
<ol>
  {foreach $synonyms as $synonym}
  <li {if $synonym['is_primary'] == 1 }style="color:green;"{elseif $synonym['is_primary'] == 2} style="color:red;" {/if}>
    {$synonym['term']}
  </li>
  {/foreach}
</ol>

{foreach $disambiguations as $k => $disambiguation}
<span style="color:red;">{$k}</span>
<ol>
  {foreach $disambiguation as $link}
  <li>
    {$link}
  </li>
  {/foreach}
</ol>
{/foreach}
{/if}