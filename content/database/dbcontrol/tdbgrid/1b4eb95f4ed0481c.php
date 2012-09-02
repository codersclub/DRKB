<h1>Как передвинуть колонку в TDBGrid?</h1>
<div class="date">01.01.2007</div>


<pre>
type
  THackAccess = class(TCustomGrid);
 
{
  THackAccess Is needed because TCustomGrid.MoveColumn is
  protected and you can't access it directly.
}
 
// In the implementation-Section:
 
procedure MoveDBGridColumns(DBGrid: TDBGrid; FromColumn, ToColumn: Integer);
begin
  THackAccess(DBGrid).MoveColumn(FromColumn, ToColumn);
end;
 
 
{Example}
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  MoveDBGridColumns(DBGrid1, 1, 2)
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
