<h1>Как заблокировать TDBGrid от автодобавления новой записи?</h1>
<div class="date">01.01.2007</div>


<p>Добавьте в обработчик события вашего TTable "BeforeInsert" следующую строку:</p>
<pre>
procedure TForm1.Tbable1BeforeInsert(DataSet: TDataset);
begin
  Abort;  // &lt;&lt;---эту строчку
end;
</pre>

<p>Осуществляем перехват нажатия клавиши и проверку на конец файла (end-of-file):</p>
<pre>
procedure TForm8.DBGrid1KeyDown(Sender: TObject;
  var Key: Word; Shift: TShiftState);
begin
  if (Key = VK_DOWN) then
  begin
    TTable1.DisableControls;
    TTable1Next;
    if TTable1.EOF then
      Key := 0
    else
      TTable1.Prior;
    TTable1.EnableControls;
  end;
end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

