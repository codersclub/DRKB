---
Title: Как восстановить индексы?
Date: 01.01.2007
---


Как восстановить индексы?
=========================

::: {.date}
01.01.2007
:::

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Table.Close;
      Table.Exclusive := True;
      Table.Open;
      DbiRegenIndexes(Table.Handle);
      Table.Close;
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
