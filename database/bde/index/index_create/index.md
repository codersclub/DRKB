---
Title: Создание индекса
Author: OAmiry (Borland)
Date: 01.01.2007
---


Создание индекса
================

::: {.date}
01.01.2007
:::

Автор: OAmiry (Borland)

Ниже приведен код обработчика кнопки OnClick, с помощью которого
строится индекс:

    procedure TForm1.Button1Click(Sender: TObject);
    var
      bActive, bExclusive: Boolean;
    begin
      bActive := Table1.Active;
      bExclusive := Table1.Exclusive;
      Table1.IndexDefs.Update;
      with Table1 do
      begin
        Close;
        {таблица dBASE должна быть открыта в монопольном (exclusive) режиме}
        Exclusive := TRUE;
        Open;
        if Table1.IndexDefs.IndexOf('FNAME') <> 0 then
          Table1.AddIndex('FNAME', 'FNAME', []);
        Close;
        Exclusive := bExclusive;
        Active := bActive;
      end;
    end;

Если вы собираетесь запускать проект из Delphi, пожалуйста убедитесь в
том, что свойство таблицы Active в режиме проектирования установлено в
False.

Взято с <https://delphiworld.narod.ru>
