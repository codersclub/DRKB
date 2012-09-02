<h1>Внести изменения в набор данных и не потерять текушей позиции</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TMyForm.MakeChanges;
var
  aBookmark: TBookmark;
begin
  Table1.DisableControls;
  aBookmark := Table.GetBookmark;
  try
    {ваш код}
  finally
    Table1.GotoBookmark(aBookmark);
    Table1.FreeBookmark(aBookmark);
    Table1.EnableControls;
  end;
end;
</pre>

