<div class="titrePage">
  <h2>Photo Added By</h2>
</div>
{if isset ($gestionA)}
<div>
<form method="post" >
<fieldset>
  <legend>{'Configuration'|translate}</legend>
 <p>
  <strong>{'Add information before'|@translate}</strong>
  {html_options name="infopab" options=$gestionA.OPTIONS selected=$gestionA.SELECTED}
 </p>
{if isset ($gestionB)}
 <p>
  <strong>{'Link on users'|@translate}</strong> 
  {html_radios name="inspabs2" values=$pabs2 output=$pabs2t selected="{$PABS}"}
  ({'parameter show from the plugin'|@translate} "{'See photos by user'|@translate}")
 </p>
{/if}
 <p>
  <div style="text-align:center;">
  <input class="submit" name="submitpab" type="submit" value="{'Save Settings'|@translate}">
  </div>
 </p>
</fieldset>
</form>
</div>
{/if}
