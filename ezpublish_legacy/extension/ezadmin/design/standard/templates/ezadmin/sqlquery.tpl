<form action={"/admin/sqlquery"|ezurl} method="post" name="sqlquery" id="sqlquery">

{section show=$executed|eq(1)}
{section show=$success|eq(0)}
  <p>Error while executing.</p>
  <ul>
    <li>{$error|wash()}</li>
  </ul>
{section-else}
  <p>Successfully executed.</p>
  {section show=is_numeric($rows)}
  <p>{$rows|wash()} rows affected.</p>
  <p>Result</p>
  {* <p>{$result|attribute(show,1)}</p>*}
  {foreach $result as $r}
  <p>{$r.Field}</p>
  {/foreach}
  {/section}
{/section}
{/section}
{section show=$nosql|eq(1)}
    <p>Please provide input data.</p>
{/section}
    <label>SQL:</label>
    <textarea style="height: 99%;width: 99%;" name="sql" cols="5" rows="20" wrap="PHYSICAL">{$sql|wash()}</textarea>

  <p>
    <input class="button" type="submit" name="Skip" value="Skip">
    <input class="button" type="submit" name="Execute" value="Execute SQL">    
  </p>
</form>