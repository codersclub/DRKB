---
Title: Сменить цвет выделения в TStringGrid
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Сменить цвет выделения в TStringGrid
====================================

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

