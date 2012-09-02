<h1>TStringGrid &gt; HTML</h1>
<div class="date">01.01.2007</div>


<pre>procedure SGridToHtml(SG: TStringgrid; Dest: TMemo; BorderSize: Integer);
var 
  i, p: integer;
  SStyle1, SStyle2, Text: string;
begin
  Dest.Clear;
  Dest.Lines.Add('&lt;html&gt;');
  Dest.Lines.Add('&lt;body&gt;');
  Dest.Lines.Add('  &lt;table border="' + IntToStr(BorderSize) + '" width="' +
    IntToStr(SG.Width) + '" height="' + IntToStr(SG.Width) + '"&gt;');
 
  for i := 0 to SG.RowCount - 1 do
  begin
    Dest.Lines.Add('  &lt;tr&gt;');
    for p := 0 to SG.ColCount - 1 do
    begin
      SStyle1 := '';
      SStyle2 := '';
      if fsbold in SG.Font.Style then
      begin
        SStyle1 := SStyle1 + '&lt;b&gt;';
        SStyle2 := SStyle2 + '&lt;/b&gt;';
      end;
      if fsitalic in SG.Font.Style then
      begin
        SStyle1 := SStyle1 + '&lt;i&gt;';
        SStyle2 := SStyle2 + '&lt;/i&gt;';
      end;
      if fsunderline in SG.Font.Style then
      begin
        SStyle1 := SStyle1 + '&lt;u&gt;';
        SStyle2 := SStyle2 + '&lt;/u&gt;';
      end;
      Text := sg.Cells[p, i];
      if Text = '' then Text := ' ';
      Dest.Lines.Add('    &lt;td width="' + IntToStr(sg.ColWidths[p]) +
        '" height="' + IntToStr(sg.RowHeights[p]) +
        '"&gt;&lt;font color="#' + IntToHex(sg.Font.Color, 6) +
        '" face="' + SG.Font.Name + '"&gt;' + SStyle1 +
        Text + SStyle2 + '&lt;/font&gt;&lt;/td&gt;');
    end;
    Dest.Lines.Add('  &lt;/tr&gt;');
  end;
  Dest.Lines.Add('  &lt;/table&gt;');
  Dest.Lines.Add('&lt;/body&gt;');;
  Dest.Lines.Add('&lt;/html&gt;');
end;
 
// Example, Beispiel
procedure TFormCSVInport.Button6Click(Sender: TObject);
begin
  SGridToHtml(StringGrid1, Memo1, 1);
  Memo1.Lines.SaveToFile('c:\test.html');
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
<hr /><pre>
procedure ToHtml(SG: TStringGrid; S: string);
Var i,j:integer;
 &nbsp;&nbsp; t:TStringList;
begin
 try
  t:=TStringList.Create;
  t.Add('&lt;table border="1" align="center" cellspacing="0" rules="all"&gt;');&nbsp; //начало таблицы
&nbsp;
  t.Add('&lt;tr&gt;');&nbsp; //начало заголовков
  For j:=0 To SG.ColCount-1 Do
 &nbsp; t.Add('&lt;th&gt;'+SG.Cells[j,0]+'&lt;/th&gt;');&nbsp; //заголовки
  t.Add('&lt;/tr&gt;');&nbsp; //конец заголовков
&nbsp;
 {ProgressBar1.Max:=SG.RowCount}
&nbsp;
  For i:=1 To SG.RowCount Do
 &nbsp; begin
 &nbsp;&nbsp; t.Add('&lt;tr&gt;'); //начало ячеек
 &nbsp;&nbsp; For j:=0 To SG.ColCount-1 Do
 &nbsp;&nbsp;&nbsp; t.Add('&lt;td&gt;'+SG.Cells[j,i]+'&lt;/td&gt;');&nbsp; //ячейки
 &nbsp;&nbsp; t.Add('&lt;/tr&gt;'); //конец ячеек
 &nbsp; {ProgressBar1.Position:=i}
 &nbsp; end;
&nbsp;
 &nbsp; t.Add('&lt;/table&gt;');&nbsp; //конец таблицы
 &nbsp; t.SaveToFile(S); //сохраняем в файл
&nbsp;
  {ProgressBar1.Position:=0}
 finally
  t.Free;
 end;
end;
</pre>
<p>&nbsp;<br>
<p>Пример вызова:</p>
<pre>ToHtml(StringGrid1, 'C:\123.html');
</pre>
<p>&nbsp;<br>
<p class="author">Автор: Kostas</p>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<p>&nbsp;<br>
<p>&nbsp;</p>
