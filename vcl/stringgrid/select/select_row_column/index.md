---
Title: Выбор строки или колонки компонента TStringGrid
Author: Neil J. Rubenking
Date: 01.01.2007
---


Выбор строки или колонки компонента TStringGrid
===============================================

::: {.date}
01.01.2007
:::

Автор: Neil J. Rubenking

Вот функция, выбирающая при нажатии на кнопку первую строку сетки. Это
работает независимо от размера сетки и количества фиксированных
строк/колонок.

    procedure TForm1.Button1Click(Sender: TObject);
    var
      NewSel: TGridRect;
    begin
      with StringGrid1 do
      begin
        NewSel.Left := FixedCols;
        NewSel.Top := FixedRows;
        NewSel.Right := ColCount - 1;
        NewSel.Bottom := FixedRows;
        Selection := NewSel;
      end;
    end;
     
     
     
     
     StringGrid1.Row := номер строки от нуля;
     StringGrid1.Col := номер столбца от нуля;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
