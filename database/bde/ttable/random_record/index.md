---
Title: Как выбрать случайную запись?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как выбрать случайную запись?
=============================

    procedure TForm1.FormCreate(Sender: TObject); 
    begin 
      Randomize; 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      Table1.First; 
      Table1.MoveBy(Random(Table1.RecordCount)); 
    end; 

