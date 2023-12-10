---
Title: TStringGrid -> HTML
Author: Kostas
Date: 01.01.2007
---


TStringGrid -> HTML
===================

::: {.date}
01.01.2007
:::

    procedure SGridToHtml(SG: TStringgrid; Dest: TMemo; BorderSize: Integer);
    var 
      i, p: integer;
      SStyle1, SStyle2, Text: string;
    begin
      Dest.Clear;
      Dest.Lines.Add('<html>');
      Dest.Lines.Add('<body>');
      Dest.Lines.Add('  <table border="' + IntToStr(BorderSize) + '" width="' +
        IntToStr(SG.Width) + '" height="' + IntToStr(SG.Width) + '">');
     
      for i := 0 to SG.RowCount - 1 do
      begin
        Dest.Lines.Add('  <tr>');
        for p := 0 to SG.ColCount - 1 do
        begin
          SStyle1 := '';
          SStyle2 := '';
          if fsbold in SG.Font.Style then
          begin
            SStyle1 := SStyle1 + '<b>';
            SStyle2 := SStyle2 + '</b>';
          end;
          if fsitalic in SG.Font.Style then
          begin
            SStyle1 := SStyle1 + '<i>';
            SStyle2 := SStyle2 + '</i>';
          end;
          if fsunderline in SG.Font.Style then
          begin
            SStyle1 := SStyle1 + '<u>';
            SStyle2 := SStyle2 + '</u>';
          end;
          Text := sg.Cells[p, i];
          if Text = '' then Text := ' ';
          Dest.Lines.Add('    <td width="' + IntToStr(sg.ColWidths[p]) +
            '" height="' + IntToStr(sg.RowHeights[p]) +
            '"><font color="#' + IntToHex(sg.Font.Color, 6) +
            '" face="' + SG.Font.Name + '">' + SStyle1 +
            Text + SStyle2 + '</font></td>');
        end;
        Dest.Lines.Add('  </tr>');
      end;
      Dest.Lines.Add('  </table>');
      Dest.Lines.Add('</body>');;
      Dest.Lines.Add('</html>');
    end;
     
    // Example, Beispiel
    procedure TFormCSVInport.Button6Click(Sender: TObject);
    begin
      SGridToHtml(StringGrid1, Memo1, 1);
      Memo1.Lines.SaveToFile('c:\test.html');
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>

------------------------------------------------------------------------

    procedure ToHtml(SG: TStringGrid; S: string);
    Var i,j:integer;
        t:TStringList;
    begin
     try
      t:=TStringList.Create;
      t.Add('<table border="1" align="center" cellspacing="0" rules="all">');  //начало таблицы
     
      t.Add('<tr>');  //начало заголовков
      For j:=0 To SG.ColCount-1 Do
       t.Add('<th>'+SG.Cells[j,0]+'</th>');  //заголовки
      t.Add('</tr>');  //конец заголовков
     
     {ProgressBar1.Max:=SG.RowCount}
     
      For i:=1 To SG.RowCount Do
       begin
        t.Add('<tr>'); //начало ячеек
        For j:=0 To SG.ColCount-1 Do
         t.Add('<td>'+SG.Cells[j,i]+'</td>');  //ячейки
        t.Add('</tr>'); //конец ячеек
       {ProgressBar1.Position:=i}
       end;
     
       t.Add('</table>');  //конец таблицы
       t.SaveToFile(S); //сохраняем в файл
     
      {ProgressBar1.Position:=0}
     finally
      t.Free;
     end;
    end;



Пример вызова:

    ToHtml(StringGrid1, 'C:\123.html');



Автор: Kostas

Взято из <https://forum.sources.ru>



 
