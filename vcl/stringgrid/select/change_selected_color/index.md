---
Title: Сменить цвет выделения в TStringGrid
Date: 01.01.2007
---


Сменить цвет выделения в TStringGrid
====================================

::: {.date}
01.01.2007
:::

    procedure TForm1.StringGrid1DrawCell(Sender: TObject; ACol, ARow: Integer; 
      Rect: TRect; State: TGridDrawState); 
    const 
      SelectedColor = Clblue; 
    begin 
      if (state = [gdSelected]) then 
        with TStringGrid(Sender), Canvas do 
        begin 
          Brush.Color := SelectedColor; 
          FillRect(Rect); 
          TextRect(Rect, Rect.Left + 2, Rect.Top + 2, Cells[aCol, aRow]); 
        end; 
    end;
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
