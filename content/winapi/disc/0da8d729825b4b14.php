<h1>Можно ли удалять из списка TDriveComboBox диски которые отключены?</h1>
<div class="date">01.01.2007</div>


<p>На некоторых laptop компьютерах может не быть флоппи дисковода. Можно ли удалять из списка TDriveComboBox диски которые отключены?</p>

<p>В примере TDriveComboBox не показывает дисководы, которые не готовы. (not ready). Учтите что на многих компьютерах будет ощутимая задержка при поверке plug&amp;play флоппи дисковода.</p>
<pre>
procedure TForm1.FormCreate(Sender: TObject);
var
  i: integer;
  OldErrorMode: Word;
  OldDirectory: string;
begin
  OldErrorMode := SetErrorMode(SEM_NOOPENFILEERRORBOX);
  GetDir(0, OldDirectory);
  i := 0;
  while i &lt;= DriveComboBox1.Items.Count - 1 do
    begin
{$I-}
      ChDir(DriveComboBox1.Items[i][1] + ':\');
{$I+}
      if IoResult &lt;&gt; 0 then
        DriveComboBox1.Items.Delete(i)
      else
        inc(i);
    end;
  ChDir(OldDirectory);
  SetErrorMode(OldErrorMode);
end;
</pre>


