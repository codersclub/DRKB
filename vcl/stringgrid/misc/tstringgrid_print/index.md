---
Title: Печать TStringGrid
Date: 01.01.2007
---


Печать TStringGrid
==================

Вариант 1:

Source: <https://delphiworld.narod.ru>

    procedure TForm1.Button1Click(Sender: TObject);
    var K: Double;
    begin
     Printer.BeginDoc;
     K :=  Printer.Canvas.Font.PixelsPerInch / Canvas.Font.PixelsPerInch*1.2;
     PrintStringGrid(StrGrid,
      K,  // Коэффициент
      200, // отступ от края листа в пихелах по Х
      200, // --"-- по Y
      200  // отступ снизу
      );
     Printer.EndDoc;
    end;
    
    {----------------------------------------------------------}
    unit GrdPrn3;
    interface
    uses
     Windows, Classes, Graphics, Grids, Printers, SysUtils;
    const
     OrdinaryLineWidth: Integer = 2;
     BoldLineWidth: Integer = 4;
    procedure PrintStringGrid(Grid: TStringGrid; Scale: Double; LeftMargin,
      TopMargin, BottomMargin: Integer);
    function DrawStringGridEx(Grid: TStringGrid; Scale: Double; FromRow,
      LeftMargin, TopMargin, Yfloor: Integer; DestCanvas: TCanvas): Integer;
      // возвращает номер строки, которая не поместилась до Y = Yfloor
      // не проверяет, вылезает ли общая длина таблицы за пределы страницы
      // Слишком длинное слово обрежется
    
    implementation
    
    procedure PrintStringGrid(Grid: TStringGrid; Scale: Double; LeftMargin,
        TopMargin, BottomMargin: Integer);
    var NextRow: Integer;
    begin
     //Printer.BeginDoc;
     if not Printer.Printing then raise Exception.Create(
        'function PrintStringGrid must be called between Printer.BeginDoc and Printer.EndDoc');
     NextRow := 0;
     repeat
       NextRow := DrawStringGridEx(Grid, Scale, NextRow, LeftMargin, TopMargin,
         Printer.PageHeight - BottomMargin, Printer.Canvas);
       if NextRow <> -1 then Printer.NewPage;
     until NextRow = -1;
     //Printer.EndDoc;
    end;
    
    function DrawStringGridEx(Grid: TStringGrid; Scale: Double; FromRow,
      LeftMargin, TopMargin, Yfloor: Integer; DestCanvas: TCanvas): Integer;
      // возвращает номер строки, которая не поместилась до Y = Yfloor
    var
     i, j, d, TotalPrevH, TotalPrevW, CellH, CellW, LineWidth: Integer;
     R: TRect;
     s: string;
    procedure CorrectCellHeight(ARow: Integer);
      // вычисление правильной высоты ячейки с учетом многострочного текста
      // Текст рабивается только по словам слишком длинное слово обрубается
    var
       i, H: Integer;
       R: TRect;
       s: string;
    begin
       R := Rect(0, 0, CellH*2, CellH);
       s := ':)'; // Одинарная высота строки
       CellH := DrawText(DestCanvas.Handle, PChar(s), Length(s), R,
         DT_LEFT or DT_TOP or DT_WORDBREAK or DT_SINGLELINE or
         DT_NOPREFIX or DT_CALCRECT) + 3*d;
       for i := 0 to Grid.ColCount-1 do
       begin
        CellW := Round(Grid.ColWidths[i]*Scale);
        R := Rect(0, 0, CellW, CellH);
        //InflateRect(R, -d, -d);
        R.Left := R.Left+d;
        R.Top := R.Top + d;
        s := Grid.Cells[i, ARow];
        // Вычисление ширины и высоты текста
        H := DrawText(DestCanvas.Handle, PChar(s), Length(s), R,
          DT_LEFT or DT_TOP or DT_WORDBREAK or DT_NOPREFIX or DT_CALCRECT);
        if CellH < H + 2*d then CellH := H + 2*d;
        // if CellW < R.Right - R.Left then Слишком длинное слово -
        // не помещается в одну строку; Перенос слов не поддерживается
       end;
      end;
    begin
     Result := -1; // все строки уместились между TopMargin и Yfloor
     if (FromRow < 0)or(FromRow >= Grid.RowCount) then Exit;
     DestCanvas.Brush.Style := bsClear;
     DestCanvas.Font := Grid.Font;
    //  DestCanvas.Font.Height := Round(Grid.Font.Height*Scale);
     DestCanvas.Font.Size := 10;
     Grid.Canvas.Font := Grid.Font;
     Scale := DestCanvas.TextWidth('test')/Grid.Canvas.TextWidth('test');
     d := Round(2*Scale);
     TotalPrevH := 0;
     for j := 0 to Grid.RowCount-1 do
     begin
      if (j >= Grid.FixedRows) and (j < FromRow) then Continue;
      // Fixed Rows рисуются на каждой странице
      TotalPrevW := 0;
      CellH := Round(Grid.RowHeights[j]*Scale);
      CorrectCellHeight(j);
      if TopMargin + TotalPrevH + CellH > YFloor then
      begin
       Result := j; // j-я строка не помещается в заданный диапазон
       if Result < Grid.FixedRows then Result := -1;
       // если фиксированные строки не влезают на страницу -
       // это тяж?лый случай...
       Exit;
      end;
      for i := 0 to Grid.ColCount-1 do
      begin
       CellW := Round(Grid.ColWidths[i]*Scale);
       R := Rect(TotalPrevW, TotalPrevH, TotalPrevW + CellW,
         otalPrevH + CellH);
       OffSetRect(R, LeftMargin, TopMargin);
       if (i < Grid.FixedCols)or(j < Grid.FixedRows) then
         LineWidth := BoldLineWidth
       else
         LineWidth := OrdinaryLineWidth;
       DestCanvas.Pen.Width := LineWidth;
       if LineWidth > 0 then
        DestCanvas.Rectangle(R.Left, R.Top, R.Right+1, R.Bottom+1);
       //InflateRect(R, -d, -d);
       R.Left := R.Left+d;
       R.Top := R.Top + d;
       s := Grid.Cells[i, j];
       DrawText(DestCanvas.Handle, PChar(s), Length(s), R,
        DT_LEFT or DT_TOP or DT_WORDBREAK or DT_NOPREFIX);
       TotalPrevW := TotalPrevW + CellW; // Общая ширина всех предыдущих колонок
      end;
      TotalPrevH := TotalPrevH + CellH;  // Общая высота всех предыдущих строк
     end;
    end;
    end.


------------------------------------------------------------------------

Вариант 2:

Author: pankerstein

Source: Vingrad.ru <https://forum.vingrad.ru>

Недавно довелось использовать код из "DRKB", для печати stringGrid,
однако он не выводит на печать (у меня не вывел) 0-й столбец.

Я переделал его, добавив прорисовку ячеек таблицы, более удобное
расположение заголовка таблицы, в качестве параметров процедуре можно
передать отступ от края и сверху листа в миллиметрах. Также снабдил код
комментариями. (я сам новичёк в программировании, и будь в том коде
комменты, разобрался бы куда легче чем пришлось).

Надеюсь кому нибудь пригодится...

    procedure PrintGrid(sGrid: TStringGrid;
      left_StandOff,top_StandOff:integer; sTitle: string);
    var
      X1, X2,PixelsX,PrinterCoordX: Integer;
      Y1, Y2,PixelsY,PrinterCoordY: Integer;
      I: Integer;
      F: Integer;
      TR: TRect;
    begin
      { left_StandOff - отступ в миллиметрах слева от края листа
      top_StandOff - отступ в миллиметрах сверху от края листа
      PrinterCoordX и PrinterCoordY - тот же отступ только в пикселах
      Высота строк и ширина столбцов взяты соответственно 150 и 400,
      при желании их размер можно передать в процедуру как параметры
      }
      //получаем информацию о разрешении принтера
      PixelsX:=GetDeviceCaps(printer.Handle,LogPixelsX);//разрешение по Х
      PixelsY:=GetDeviceCaps(printer.Handle,LogPixelsY);//разрешение по Y
      PrinterCoordX:=round(PixelsX/25.4*left_StandOff);//переводим мм в пиксели
      PrinterCoordY:=round(PixelsY/25.4*top_StandOff); //---
      with printer do
      begin
        //Печатаем заголовок таблицы
        Title := sTitle;
        BeginDoc; // Начало печати
        Canvas.Pen.Color := 0; // цвет-чёрный
        Canvas.Font.Name := 'verdana'; // шрифт
        Canvas.Font.Size := 10; // размер шрифта
        Canvas.Font.Style := [];
        //Текст заголовка в заданных координатах
        Canvas.TextOut(PrinterCoordX, PrinterCoordY-100-
        printer.Canvas.Font.Size*10, Printer.Title);
        Canvas.Pen.Color := 0;
        Canvas.Font.Name := 'Verdana';
        Canvas.Font.Size := 8; 
      end;
      for i:=0 to sgrid.colcount-1 do //перебираем столбцы
        for f:=0 to sgrid.rowcount-1 do //перебираем в столбце все строки
      begin
        X1 := PrinterCoordX+i*400; //400-это ширина столбца
        X2 := PrinterCoordX+400+i*400; //тоже
        Y1:=PrinterCoordY+f*150; //150-высота строки
        y2:=PrinterCoordY+150+f*150; //тоже
        TR:=Rect(x1,y1,x2,y2);
        with printer do
        begin
          Canvas.MoveTo(x1,y1);//Двигаем рисовалку в верхний левый угол таблицы
          {пишем надпись в квадрате(ячейке) i-столбеца и f-строки со сдвигом
          от верха на Y+50 и со сдвигом от левого края колонки на X+50
          }
          Canvas.TextRect(TR, X1 + 50, Y1 + 50, sGrid.Cells[i,f]);
          //рисуем линии ячейки
          Canvas.LineTo(x1,y2);
          Canvas.LineTo(x2,y2);
          Canvas.LineTo(x2,y1);
          Canvas.LineTo(x1,y1);
        end;
      end;
      Printer.EndDoc; // конец печати
    end;
     
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      PrintGrid(StringGrid1,20,20, 'Таблица1: "Название"');
    end;

