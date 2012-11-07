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
    t:TStringList;
begin
 try
  t:=TStringList.Create;
  t.Add('&lt;table border="1" align="center" cellspacing="0" rules="all"&gt;');  //начало таблицы
 
  t.Add('&lt;tr&gt;');  //начало заголовков
  For j:=0 To SG.ColCount-1 Do
   t.Add('&lt;th&gt;'+SG.Cells[j,0]+'&lt;/th&gt;');  //заголовки
  t.Add('&lt;/tr&gt;');  //конец заголовков
 
 {ProgressBar1.Max:=SG.RowCount}
 
  For i:=1 To SG.RowCount Do
   begin
    t.Add('&lt;tr&gt;'); //начало ячеек
    For j:=0 To SG.ColCount-1 Do
     t.Add('&lt;td&gt;'+SG.Cells[j,i]+'&lt;/td&gt;');  //ячейки
    t.Add('&lt;/tr&gt;'); //конец ячеек
   {ProgressBar1.Position:=i}
   end;
 
   t.Add('&lt;/table&gt;');  //конец таблицы
   t.SaveToFile(S); //сохраняем в файл
 
  {ProgressBar1.Position:=0}
 finally
  t.Free;
 end;
end;
</pre>
<p> <br>
<p>Пример вызова:</p>
<pre>ToHtml(StringGrid1, 'C:\123.html');
</pre>
<p> <br>
<div class="author">Автор: Kostas</div>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<p> <br>
<p></p>
