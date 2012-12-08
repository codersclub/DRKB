---
Title: Как ускорить поиск?
Date: 01.01.2007
---


Как ускорить поиск?
===================

::: {.date}
01.01.2007
:::

    type
      TForm1 = class(TForm)
        DataSource1: TDataSource;
        Table1: TTable;
        Button1: TButton;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      SeekValue: string;
    begin
      Table1.DisableControls;
      Table1.FindKey([SeekValue]);
      Table1.EnableControls;
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
