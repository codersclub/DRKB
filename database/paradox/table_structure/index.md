---
Title: Печать структуры таблицы Paradox
Date: 01.01.2007
Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com)
---


Печать структуры таблицы Paradox
================================

    procedure TForm1.Button1Click(Sender: TObject);
    const
     
      FieldTypes: array[0..16] of string[10] = ('Unknown', 'String', 'Smallint',
        'Integer', 'Word', 'Boolean', 'Float', 'Currency', 'BCD', 'Date', 'Time',
        'DateTime', 'Bytes', 'VarBytes', 'Blob', 'Memo', 'Graphic');
    var
     
      i, nX, nY, nHeight, nWidth: Integer;
      rtxtMetric: TTextMetric;
      s: array[0..3] of string[10];
    begin
     
      with Table1.FieldDefs, Printer do
        begin
          Update;
          PrinterIndex := -1;
          Title := 'Структура ' + Table1.TableName;
          BeginDoc;
          nX := 0;
          nY := 0;
          WinProcs.GetTextMetrics(Canvas.Handle, rtxtMetric);
          nHeight := rtxtMetric.tmHeight;
          nWidth := rtxtMetric.tmAveCharWidth;
          for i := 0 to Count - 1 do
            begin
              s[0] := IntToStr(Items[i].FieldNo) + #9;
              s[1] := Items[i].Name + #9;
              s[2] := FieldTypes[Ord(Items[i].DataType)] + #9;
              s[3] := IntToStr(Items[i].Size);
              Canvas.TextOut(nX, nY, s[0]);
              Inc(nX, Length(s[0]) * nWidth);
              Canvas.TextOut(nX, nY, s[1]);
              Inc(nX, Length(s[1]) * nWidth);
              Canvas.TextOut(nX, nY, s[2]);
              Inc(nX, Length(s[2]) * nWidth);
              Canvas.TextOut(nX, nY, s[3]);
              nX := 0;
              nY := i * nHeight;
            end;
          EndDoc;
        end;
    end;


Сборник Kuliba
