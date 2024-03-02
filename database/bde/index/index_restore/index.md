---
Title: Как восстановить индексы?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как восстановить индексы?
=========================

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Table.Close;
      Table.Exclusive := True;
      Table.Open;
      DbiRegenIndexes(Table.Handle);
      Table.Close;
    end;

