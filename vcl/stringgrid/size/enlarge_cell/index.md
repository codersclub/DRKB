---
Title: Увеличение ячейки TStringGrid при увеличении числа строк
Author: Пётр Соболь
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Увеличение ячейки TStringGrid при увеличении числа строк
========================================================

    procedure TForm1.StringGrid1DrawCell(Sender: TObject; ACol, ARow:
      Integer; Rect: TRect; State: TGridDrawState);
    var
      Format: Word;
      C: array[0..255] of Char;
      r: integer;
    begin
      C := '';
      Format := DT_LEFT or DT_WORDBREAK;
      (Sender as TStringGrid).Canvas.FillRect(Rect);
      StrPCopy(C, (Sender as TStringGrid).Cells[ACol, ARow]);
      if c <> '' then //если есть значения
      begin
        r := WinProcs.DrawText((Sender as TStringGrid).Canvas.Handle, C,
          StrLen(C), Rect, Format);
        if r > (Sender as TStringGrid).RowHeights[Arow] then
          //если высота колонки меньше
          (Sender as TStringGrid).RowHeights[Arow] := r;
      end;
    end;



 
