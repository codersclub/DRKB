---
Title: Как снять выделение в TStringGrid?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как снять выделение в TStringGrid?
==================================

Если Вы хотите избавиться от выделенных ячеек TStringGrid, которые не
имеют фокуса, либо используются только для отображения данных, то
попробуйте воспользоваться следующей небольшой процедурой.

    procedure TForm1.GridClean(Sender: TObject); 
    var hGridRect: TGridRect; 
    begin 
       hGridRect.Top := -1; 
       hGridRect.Left := -1; 
       hGridRect.Right := -1; 
       hGridRect.Bottom := -1; 
       (Sender as TStringgrid).Selection := hGridRect; 
    end; 

Следующий код можно использовать например в событии грида OnExit:

    var MyGrid: TStringGrid; 
    ... 
    GridClean(MyGrid);

