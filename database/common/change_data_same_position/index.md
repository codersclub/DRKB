---
Title: Внести изменения в набор данных и не потерять текушей позиции
Date: 01.01.2007
---


Внести изменения в набор данных и не потерять текушей позиции
=============================================================

::: {.date}
01.01.2007
:::

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
