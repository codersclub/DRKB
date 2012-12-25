---
Title: Печать ячеек
Date: 01.01.2007
---

Печать ячеек
============

::: {.date}
01.01.2007
:::

У кого-нибудь есть пример кода печати в заданной ячейке? Типа
PrintAt(row,col,\"Text\")?

Вот некоторый код, который я нашел после блужданий в группах новостей.
Правда сам я его не проверял, но источник утверждает, что он работает.
Так что будьте внимательны!

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

Буду рад, если помог.

Lloyd Linklater \<Sysop\>

Delphi Technical Support

Взято из Советов по Delphi от [Валентина
Озерова](mailto:mailto:webmaster@webinspector.com)

Сборник Kuliba
