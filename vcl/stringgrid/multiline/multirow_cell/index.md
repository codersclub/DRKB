---
Title: Многострочные ячейки в TStringGrid
Author: Пётр Соболь
Date: 01.01.2007
---


Многострочные ячейки в TStringGrid
==================================

::: {.date}
01.01.2007
:::

Сперва необходимо установить свойство DefaultDrawing в False. Далее,
необходимо вставить следующий код в обработчик события OnDrawCell:

    procedure TForm1.StringGrid1DrawCell(Sender: TObject;
                                         Col, Row: Longint;
                                         Rect: TRect;
                                         State: TGridDrawState);
    var
       Line1: string;
       Line2: string;
       ptr: integer;
       padding: integer;
       hGrid: TStringGrid;
     
    begin
      hGrid:= (Sender as TStringGrid);
      ptr := Pos(';', hGrid.Cells[Col, Row]);
      if ptr > 0 then
      begin
         Line1 := Copy(hGrid.Cells[Col, Row], 1, ptr - 1);
         Line2 := Copy(hGrid.Cells[Col, Row], ptr + 1,
                       Length(hGrid1.Cells[Col,Row]) - ptr);
      end
      else Line1 := hGrid.Cells[Col, Row];
      hGrid.Canvas.FillRect(Rect);
      hGrid.Canvas.TextOut(Rect.Left, Rect.Top + 2, Line1);
      if ptr > 0 then
         hGrid.Canvas.TextOut(Rect.Left, Rect.Top -
                              hGrid.Canvas.Font.Height + 3, Line2);
    end;

Теперь достаточно для переноса строки вставить в неё точку с запятой.
Так же не забудьте изменить высоту строки так, чтобы переносы строки
поместились в ячейку:

StringGrid1.RowHeights[0] := StringGrid1.DefaultRowHeight * 2 ;

Взято из <https://forum.sources.ru>

------------------------------------------------------------------------

Ниже приведен пример, делающий заголовок многострочным, центрированным и
с жирным шрифтом:

    // if Dispatch.GetIDsOfNames(GUID_NULL, @NameRefs, NameCount,
     
    procedure TForm1.grid1DrawCell(Sender: TObject; Col, Row: Longint;
      Rect: TRect; State: TGridDrawState);
    var
      l_oldalign: word;
      l_YPos, l_XPos, i: integer;
      s, s1: string;
      l_col, l_row: longint;
    begin
      l_col := col;
      l_row := row;
      with sender as tstringgrid do
      begin
        if (l_row = 0) then
          canvas.font.style := canvas.font.style + [fsbold];
        if l_row = 0 then
        begin
          l_oldalign := settextalign(canvas.handle, ta_center);
          l_XPos := rect.left + (rect.right - rect.left) div 2;
          s := cells[l_col, l_row];
          while s <> '' do
          begin
            if pos(#13, s) <> 0 then
            begin
              if pos(#13, s) = 1 then
                s1 := ''
              else
              begin
                s1 := trim(copy(s, 1, pred(pos(#13, s))));
                delete(s, 1, pred(pos(#13, s)));
              end;
              delete(s, 1, 2);
            end
            else
            begin
              s1 := trim(s);
              s := '';
            end;
            l_YPos := rect.top + 2;
            canvas.textrect(rect, l_Xpos, l_YPos, s1);
            inc(rect.top, rowheights[l_row] div 3);
          end;
          settextalign(canvas.handle, l_oldalign);
        end
        else
        begin
          canvas.textrect(rect, rect.left + 2, rect.top + 2, cells[l_col, l_row]);
        end;
     
        canvas.font.style := canvas.font.style - [fsbold];
      end;
    end;
     
     
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

    procedure TForm1.grid1DrawCell(Sender: TObject; Col, Row: Longint;
       Rect: TRect; State: TGridDrawState);
     
      var l_oldalign : word;
          l_YPos,l_XPos,i : integer;
          s,s1 : string;
          l_col,l_row :longint;
     
     begin
       l_col := col;
       l_row := row;
       with sender as tstringgrid do
       begin
         if (l_row=0) then
           canvas.font.style:=canvas.font.style+[fsbold];
         if l_row=0 then
         begin
           l_oldalign:=settextalign(canvas.handle,ta_center);
           l_XPos:=rect.left + (rect.right - rect.left) div 2;
           s:=cells[l_col,l_row];
           while s<>'' do
           begin
             if pos(#13,s)<>0 then
             begin
               if pos(#13,s)=1 then
                 s1:=''
               else
               begin
                 s1:=trim(copy(s,1,pred(pos(#13,s))));
                 delete(s,1,pred(pos(#13,s)));
               end;
               delete(s,1,2);
             end
             else
             begin
               s1:=trim(s);
               s:='';
             end;
             l_YPos:=rect.top+2;
             canvas.textrect(rect,l_Xpos,l_YPos,s1);
             inc(rect.top,rowheights[l_row] div 3);
           end;
           settextalign(canvas.handle,l_oldalign);
         end
         else
         begin
            canvas.textrect(rect,rect.left+2,rect.top+2,cells[l_col,l_row]);
         end;
     
         canvas.font.style:=canvas.font.style-[fsbold];
       end;
     end;
     
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Автор: Пётр Соболь

Была необходимость в использовании многострочного TStringGrida. Не один
из трех способов создания не сработал, Переработал статью о подобной
проблеме с TDBGridом. Получилось нечто очень компактное, чем и решил
поделиться. Обработка того же события прорисовки, в uses надо добавить
WinProcs:

    procedure TForm1.StringGrid1DrawCell(Sender: TObject; ACol, ARow:
      Integer;
      Rect: TRect; State: TGridDrawState);
    var
      Format: Word;
      C: array[0..255] of Char;
    begin
      Format := DT_LEFT or DT_WORDBREAK;
      (Sender as TStringGrid).Canvas.FillRect(Rect);
      StrPCopy(C, (Sender as TStringGrid).Cells[ACol, ARow]);
      WinProcs.DrawText((Sender as TStringGrid).Canvas.Handle, C,
        StrLen(C), Rect, Format);
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
