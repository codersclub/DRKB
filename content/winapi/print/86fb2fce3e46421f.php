<h1>Печать ячеек</h1>
<div class="date">01.01.2007</div>


<p>У кого-нибудь есть пример кода печати в заданной ячейке? Типа PrintAt(row,col,"Text")?</p>
<p>Вот некоторый код, который я нашел после блужданий в группах новостей. Правда сам я его не проверял, но источник утверждает, что он работает. Так что будьте внимательны!</p>

<pre>
Procedure TForm1.PrintTableClick(Sender: TObject);
var
  xcord: integer;
  ycord: integer;
  recordbuffer: string;
begin
  xcord := 10;
  ycord := 10;
  Table1.First;
  Printer.BeginDoc;
  Printer.Canvas.Font.Name := 'Courier New';
  while not Table1.EOF do
    begin
      recordbuffer := concat((Table1.Fields[0].AsString), ' ', (Table1.Fields[1].AsString));
      recordbuffer := recordbuffer + concat(' ', (Table1.Fields[2].AsString);
{пока все поля не будут в recordbuffer}
        Printer.Canvas.TextOut(xcord, ycord, recordbuffer);
        ycord := ycord + 50;
        Table1.next;
    end;
  Printer.Enddoc;
end;
</pre>

<p>Буду рад, если помог.</p>

<p>Lloyd Linklater &lt;Sysop&gt;</p>
<p>Delphi Technical Support</p>
<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>

