---
Title: Как выбрать случайную запись?
Date: 01.01.2007
---


Как выбрать случайную запись?
=============================

::: {.date}
01.01.2007
:::

    procedure TForm1.FormCreate(Sender: TObject); 
    begin 
      Randomize; 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      Table1.First; 
      Table1.MoveBy(Random(Table1.RecordCount)); 
    end; 

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
