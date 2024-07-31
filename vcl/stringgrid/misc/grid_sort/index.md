---
Title: Сортировка StringGrid
Date: 01.01.2007
---


Сортировка StringGrid
=====================

Вариант 1:

    Procedure GridSort(StrGrid: TStringGrid; NoColumn: Integer); 
    Var Line, PosActual: Integer; 
        Row: TStrings; 
    begin 
      Renglon := TStringList.Create; 
      For Line := 1 to StrGrid.RowCount-1 do 
      Begin 
        PosActual := Line; 
        Row.Assign(TStringlist(StrGrid.Rows[PosActual])); 
        While True do 
        Begin 
          If (PosActual = 0) Or (StrToInt(Row.Strings[NoColumn-1]) >= 
              StrToInt(StrGrid.Cells[NoColumn-1,PosActual-1])) then 
            Break; 
          StrGrid.Rows[PosActual] := StrGrid.Rows[PosActual-1]; 
          Dec(PosActual); 
        End; 
        If StrToInt(Row.Strings[NoColumn-1]) < StrToInt(StrGrid.Cells[NoColumn-1,PosActual]) then 
          StrGrid.Rows[PosActual] := Row; 
      End; 
      Renglon.Free; 
    end;

------------------------------------------------------------------------

Вариант 2:

Source: <https://forum.sources.ru>

    type TStringGridExSortType = (srtAlpha,srtInteger,srtDouble); 
     
    procedure GridSort(SG : TStringGrid; ByColNumber,FromRow,ToRow : integer; 
                       SortType : TStringGridExSortType = srtAlpha); 
    var Temp : TStringList; 
     
        function SortStr(Line : string) : string; 
        var RetVar : string; 
        begin 
          case SortType of 
               srtAlpha   : Retvar := Line; 
               srtInteger : Retvar := FormatFloat('000000000',StrToIntDef(trim(Line),0)); 
               srtDouble  : try 
                              Retvar := FormatFloat('000000000.000000',StrToFloat(trim(Line))); 
                            except 
                              RetVar  := '0.00'; 
                            end; 
          end; 
     
          Result := RetVar; 
        end; 
     
        // Рекурсивный QuickSort 
        procedure QuickSort(Lo,Hi : integer; CC : TStrings); 
     
            procedure Sort(l,r: integer); 
            var  i,j : integer; 
                 x   : string; 
            begin 
              i := l; j := r; 
              x := SortStr(CC[(l+r) DIV 2]); 
              repeat 
                while SortStr(CC[i]) < x do inc(i); 
                while x < SortStr(CC[j]) do dec(j); 
                if i <= j then begin 
                  Temp.Assign(SG.Rows[j]);      // Меняем местами 2 строки
                  SG.Rows[j].Assign(SG.Rows[i]); 
                  SG.Rows[i].Assign(Temp); 
                  inc(i); dec(j); 
                end; 
              until i > j; 
              if l < j then sort(l,j); 
              if i < r then sort(i,r); 
            end; 
     
         begin {quicksort}; 
           Sort(Lo,Hi); 
         end; 
     
    begin 
      Temp := TStringList.Create; 
      QuickSort(FromRow,ToRow,SG.Cols[ByColNumber]); 
      Temp.Free; 
    end;


------------------------------------------------------------------------

Вариант 3:

Source: <https://www.swissdelphicenter.ch>

Сортировка по клику на заголовке столбца

    type
       TMoveSG = class(TCustomGrid); // reveals protected MoveRow procedure 
     
    {...}
     
     procedure SortGridByCols(Grid: TStringGrid; ColOrder: array of Integer);
     var
       i, j:   Integer;
       Sorted: Boolean;
     
     function Sort(Row1, Row2: Integer): Integer;
     var
       C: Integer;
     begin
       C      := 0;
       Result := AnsiCompareStr(Grid.Cols[ColOrder[C]][Row1], Grid.Cols[ColOrder[C]][Row2]);
       if Result = 0 then
       begin
         Inc(C);
         while (C <= High(ColOrder)) and (Result = 0) do
         begin
           Result := AnsiCompareStr(Grid.Cols[ColOrder[C]][Row1],
             Grid.Cols[ColOrder[C]][Row2]);
           Inc(C);
         end;
       end;
     end;
     
     begin
       if SizeOf(ColOrder) div SizeOf(i) <> Grid.ColCount then Exit;
     
       for i := 0 to High(ColOrder) do
         if (ColOrder[i] < 0) or (ColOrder[i] >= Grid.ColCount) then Exit;
     
       j := 0;
       Sorted := False;
       repeat
         Inc(j);
         with Grid do
           for i := 0 to RowCount - 2 do
             if Sort(i, i + 1) > 0 then
             begin
               TMoveSG(Grid).MoveRow(i + 1, i);
               Sorted := False;
             end;
       until Sorted or (j = 1000);
       Grid.Repaint;
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       { Sort rows based on the contents of two or more columns. 
        Sorts first by column 1. If there are duplicate values 
        in column 1, the next sort column is column 2 and so on...}
       SortGridByCols(StringGrid1, [1, 2, 0, 3, 4]);
     end;

----------------------------------------------------

Вариант 4:

Source: <https://www.swissdelphicenter.ch>

    procedure SortStringGrid(var GenStrGrid: TStringGrid; ThatCol: Integer);
    const
      // Define the Separator 
      TheSeparator = '@';
    var
      CountItem, I, J, K, ThePosition: integer;
      MyList: TStringList;
      MyString, TempString: string;
    begin
      // Give the number of rows in the StringGrid 
      CountItem := GenStrGrid.RowCount;
      //Create the List 
      MyList        := TStringList.Create;
      MyList.Sorted := False;
      try
        begin
          for I := 1 to (CountItem - 1) do
            MyList.Add(GenStrGrid.Rows[I].Strings[ThatCol] + TheSeparator +
              GenStrGrid.Rows[I].Text);
          //Sort the List 
          Mylist.Sort;
     
          for K := 1 to Mylist.Count do
          begin
            //Take the String of the line (K – 1) 
            MyString := MyList.Strings[(K - 1)];
            //Find the position of the Separator in the String 
            ThePosition := Pos(TheSeparator, MyString);
            TempString  := '';
            {Eliminate the Text of the column on which we have sorted the StringGrid}
            TempString := Copy(MyString, (ThePosition + 1), Length(MyString));
            MyList.Strings[(K - 1)] := '';
            MyList.Strings[(K - 1)] := TempString;
          end;
    
          // Refill the StringGrid 
          for J := 1 to (CountItem - 1) do
            GenStrGrid.Rows[J].Text := MyList.Strings[(J - 1)];
          end;
      finally
        //Free the List 
        MyList.Free;
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      // Sort the StringGrid1 on the second Column 
      // StringGrid1 nach der 1. Spalte sortieren 
      SortStringGrid(StringGrid1, 1);
    end;


------------------------------------------------------------------------

Вариант 5:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    unit olimp_;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      Grids, StdCtrls;
     
    type
      TForm1 = class(TForm)
        Tabl: TStringGrid;
        Button1: TButton;
        Label1: TLabel;
        procedure FormActivate(Sender: TObject);
        procedure Button1Click(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.FormActivate(Sender: TObject);
    begin
      tabl.Cells[0, 0] := 'Страна';
      tabl.Cells[1, 0] := 'Золотых';
      tabl.Cells[2, 0] := 'Серебряных';
      tabl.Cells[3, 0] := 'Бронзовых';
      tabl.Cells[4, 0] := 'Всего';
      tabl.Cells[5, 0] := 'Баллов';
      tabl.Cells[0, 1] := 'Австралия';
      tabl.Cells[0, 2] := 'Белоруссия';
      tabl.Cells[0, 3] := 'Великобритания';
      tabl.Cells[0, 4] := 'Германия';
      tabl.Cells[0, 5] := 'Италия';
      tabl.Cells[0, 6] := 'Китай';
      tabl.Cells[0, 7] := 'Корея';
      tabl.Cells[0, 8] := 'Куба';
      tabl.Cells[0, 9] := 'Нидерланды';
      tabl.Cells[0, 10] := 'Россия';
      tabl.Cells[0, 11] := 'США';
      tabl.Cells[0, 12] := 'Франция';
      tabl.Cells[0, 13] := 'Япония';
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      c, r: integer; // номер колонки и строки таблицы
      s: integer; // всего медалей у команды
      p: integer; // очков у команды
     
      m: integer; // номер строки с максимальным количеством очков
      buf: array[0..5] of string; // буфер для обмена строк
      i: integer; // номер строки используется во время сортировки
     
    begin
      for r := 1 to tabl.rowcount do // обработать все строки
      begin
        s := 0;
        // вычисляем общее кол-во медалей
        for c := 1 to 3 do
          if tabl.cells[c, r] <> '' then
            s := s + StrToInt(tabl.cells[c, r])
          else
            tabl.cells[c, r] := '0';
        // вычисляем количество очков
        p := 7 * StrToInt(tabl.cells[1, r]) +
          6 * StrToInt(tabl.cells[2, r]) +
          5 * StrToInt(tabl.cells[3, r]);
     
        // вывод результата
        tabl.cells[4, r] := IntToStr(s); // всего медалей
        tabl.cells[5, r] := IntToStr(p); // очков
      end;
     
      // сортировка таблицы по убыванию в соответствие
      // с количеством баллов (по содержимому 5-ого столбца)
      // сортировка методом выбора
      for r := 1 to tabl.rowcount - 1 do
      begin
        m := r; // максимальный элемент - в r-ой строке
        for i := r to tabl.rowcount - 1 do
          if StrToInt(tabl.cells[5, i]) > StrToInt(tabl.cells[5, m]) then
            m := i;
     
        if r <> m then
        begin // обменяем r-ую и m-ую строки таблицы
          for c := 0 to 5 do
          begin
            buf[c] := tabl.Cells[c, r];
            tabl.Cells[c, r] := tabl.Cells[c, m];
            tabl.Cells[c, m] := buf[c];
          end;
        end;
      end;
    end;
     
    end.


------------------------------------------------------------------------

Вариант 6:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    program H;
     
     uses WinCrt, SysUtils;
     
       const
         min = 10;
         max = 13;
         maxHeap = 1 shl max;
     
       type
         heap = array [1..maxHeap] of integer;
         heapBase = ^heap;
     
       var
         currentSize, heapSize: integer;
         A: heapBase;
     
       procedure SwapInts (var a, b: integer);
       var
         t: integer;
       begin
         t := a;
         a := b;
         b := t
       end;
     
       procedure InitHeap (size: integer);
       var
         i: integer;
       begin
         heapSize := size;
         currentSize := size;
         Randomize;
         for i := 1 to size do
           A^[i] := Random(size) + 1;
       end;
     
       procedure Heapify (i: integer);
       var
         left, right, largest: integer;
       begin
         largest := i;
         left := 2 * i;
         right := left + 1;
         if left <= heapSize then
           if A^[left] > A^[i] then
             largest := left;
         if right <= heapSize then
           if A^[right] > A^[largest] then
             largest := right;
         if largest <> i then
           begin
             SwapInts (A^[largest], A^[i]);
             Heapify (largest)
           end
       end;
     
       procedure BuildHeap;
       var
         i: integer;
       begin
         for i := heapSize div 2 downto 1 do
           Heapify (i)
       end;
     
       procedure HeapSort;
       var
         i: integer;
       begin
         BuildHeap;
         for i := currentSize downto 2 do
           begin
             SwapInts (A^[i], A^[1]);
             dec (heapSize);
             Heapify (1)
           end
       end;
     
     type
       TAvgTimes = array [min..max] of TDateTime;
     var
       sTime, eTime, tTime: TDateTime;
       i, idx, size: integer;
       avgTimes: TAvgTimes;
     
     
     begin
       tTime := 0;
       i := min;
       size := 1 shl min;
       new (A);
       while i <= max do
         begin
           for idx := 1 to 10 do
             begin
               InitHeap (size);
               sTime := Time;
               HeapSort;
               eTime := Time;
               tTime := tTime + (eTime - sTime)
             end;
           avgTimes[i] := tTime / 10.0;
           inc (i);
           size := size shl 1;
         end;
     end.
     
