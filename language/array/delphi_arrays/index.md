---
Title: Массив в Delphi
Date: 01.01.2007
---


Массив в Delphi
===============

Вариант 1:

Вот несколько функций для операций с двухмерными массивами. Самый
простой путь для создания собственной библиотеки. Процедуры SetV и GetV
позволяют читать и сохранять элементы массива VArray (его Вы можете
объявить как угодно). Например:

    type
      VArray: array[1..1] of double;
     
    var
      X: ^VArray;
      NR, NC: Longint;
     
    begin
      NR := 10000;
      NC := 100;
      if AllocArray(pointer(X), N * Sizeof(VArray)) then exit;
      SetV(X^, NC, 2000, 5, 3.27); { X[2000,5] := 3.27 }
    end;
     
    function AllocArray(var V: pointer; const N: longint): Boolean;
    begin {распределяем память для массива V размера N}
      try
        GetMem(V, N);
      except
        ShowMessage('ОШИБКА выделения памяти. Размер:' + IntToStr(N));
        Result := True;
        exit;
      end;
      FillChar(V^, N, 0); {в случае включения длинных строк заполняем их нулями}
      Result := False;
    end;
     
    procedure SetV(var X: Varray; const N, ir, ic: LongInt; const value:
      double);
    begin {заполняем элементами двухмерный массив X размером ? x N : X[ir,ic] := value}
     
      X[N * (ir - 1) + ic] := value;
    end;
     
    function GetV(const X: Varray; const N, ir, ic: Longint): double;
    begin {возвращаем величины X[ir,ic] для двухмерного массива шириной N столбцов}
      Result := X[N * (ir - 1) + ic];
    end;

------------------------------------------------------------------------

Вариант 2:

Самый простой путь - создать массив динамически

     Myarray := GetMem(rows * cols * sizeof(byte,word,single,double и пр.)  

сделайте функцию fetch\_num типа

    function fetch_num(r,c:integer) : single;  
     
    result := pointer + row + col*rows 

и затем вместо myarray[2,3] напишите

    myarray.fetch_num(2,3)  

поместите эти функции в ваш объект и работа с массивами станет пустячным
делом. Я экспериментировал с многомерными (вплоть до 8) динамическими
сложными массивами и эти функции показали отличный результат.

------------------------------------------------------------------------

Вариант 3:

Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com) Сборник Kuliba

Вот способ создания одно- и двухмерных динамических массивов:

    (*
    --
    -- модуль для создания двух очень простых классов обработки динамических массивов
    --     TDynaArray   :  одномерный массив
    --     TDynaMatrix  :  двумерный динамический массив
    --
    *)
     
    unit DynArray;
     
    interface
     
    uses
      SysUtils;
     
    type
      TDynArrayBaseType = double;
     
    const
      vMaxElements = (High(Cardinal) - $F) div sizeof(TDynArrayBaseType);
    {= гарантирует максимально возможный массив =}
     
    type
     
      TDynArrayNDX = 1..vMaxElements;
      TArrayElements = array[TDynArrayNDX] of TDynArrayBaseType;
      {= самый большой массив TDynArrayBaseType, который мы может объявить =}
      PArrayElements = ^TArrayElements;
      {= указатель на массив =}
     
      EDynArrayRangeError = class(ERangeError);
     
      TDynArray = class
      private
        fDimension: TDynArrayNDX;
        fMemAllocated: word;
        function GetElement(N: TDynArrayNDX): TDynArrayBaseType;
        procedure SetElement(N: TDynArrayNDX; const NewValue: TDynArrayBaseType);
      protected
        Elements: PArrayElements;
      public
        constructor Create(NumElements: TDynArrayNDX);
        destructor Destroy; override;
        procedure Resize(NewDimension: TDynArrayNDX); virtual;
        property dimension: TDynArrayNDX
          read fDimension;
        property Element[N: TDynArrayNDX]: TDynArrayBaseType
        read GetElement
          write SetElement;
        default;
      end;
     
    const
     
      vMaxMatrixColumns = 65520 div sizeof(TDynArray);
      {= построение матрицы класса с использованием массива объектов TDynArray =}
     
    type
     
      TMatrixNDX = 1..vMaxMatrixColumns;
      TMatrixElements = array[TMatrixNDX] of TDynArray;
      {= каждая колонка матрицы будет динамическим массивом =}
      PMatrixElements = ^TMatrixElements;
      {= указатель на массив указателей... =}
     
      TDynaMatrix = class
      private
        fRows: TDynArrayNDX;
        fColumns: TMatrixNDX;
        fMemAllocated: longint;
        function GetElement(row: TDynArrayNDX;
          column: TMatrixNDX): TDynArrayBaseType;
        procedure SetElement(row: TDynArrayNDX;
          column: TMatrixNDX;
          const NewValue: TDynArrayBaseType);
      protected
        mtxElements: PMatrixElements;
      public
        constructor Create(NumRows: TDynArrayNDX; NumColumns: TMatrixNDX);
        destructor Destroy; override;
        property rows: TDynArrayNDX
          read fRows;
        property columns: TMatrixNDX
          read fColumns;
        property Element[row: TDynArrayNDX; column: TMatrixNDX]: TDynArrayBaseType
        read GetElement
          write SetElement;
        default;
      end;
     
    implementation
     
    (*
    --
    --  методы TDynArray
    --
    *)
     
    constructor TDynArray.Create(NumElements: TDynArrayNDX);
    begin {==TDynArray.Create==}
      inherited Create;
      fDimension := NumElements;
      GetMem(Elements, fDimension * sizeof(TDynArrayBaseType));
      fMemAllocated := fDimension * sizeof(TDynArrayBaseType);
      FillChar(Elements^, fMemAllocated, 0);
    end; {==TDynArray.Create==}
     
    destructor TDynArray.Destroy;
    begin {==TDynArray.Destroy==}
      FreeMem(Elements, fMemAllocated);
      inherited Destroy;
    end; {==TDynArray.Destroy==}
     
    procedure TDynArray.Resize(NewDimension: TDynArrayNDX);
    begin {TDynArray.Resize==}
      if (NewDimension < 1) then
        raise EDynArrayRangeError.CreateFMT('Индекс вышел за границы диапазона : %d', [NewDimension]);
      Elements := ReAllocMem(Elements, fMemAllocated, NewDimension * sizeof(TDynArrayBaseType));
      fDimension := NewDimension;
      fMemAllocated := fDimension * sizeof(TDynArrayBaseType);
    end; {TDynArray.Resize==}
     
    function TDynArray.GetElement(N: TDynArrayNDX): TDynArrayBaseType;
    begin {==TDynArray.GetElement==}
      if (N < 1) or (N > fDimension) then
        raise EDynArrayRangeError.CreateFMT('Индекс вышел за границы диапазона : %d', [N]);
      result := Elements^[N];
    end; {==TDynArray.GetElement==}
     
    procedure TDynArray.SetElement(N: TDynArrayNDX; const NewValue: TDynArrayBaseType);
    begin {==TDynArray.SetElement==}
      if (N < 1) or (N > fDimension) then
        raise EDynArrayRangeError.CreateFMT('Индекс вышел за границы диапазона : %d', [N]);
      Elements^[N] := NewValue;
    end; {==TDynArray.SetElement==}
     
    (*
    --
    --  методы TDynaMatrix
    --
    *)
     
    constructor TDynaMatrix.Create(NumRows: TDynArrayNDX; NumColumns: TMatrixNDX);
    var col: TMatrixNDX;
    begin {==TDynaMatrix.Create==}
      inherited Create;
      fRows := NumRows;
      fColumns := NumColumns;
      {= выделение памяти для массива указателей (т.е. для массива TDynArrays) =}
      GetMem(mtxElements, fColumns * sizeof(TDynArray));
      fMemAllocated := fColumns * sizeof(TDynArray);
      {= теперь выделяем память для каждого столбца матрицы =}
      for col := 1 to fColumns do
        begin
          mtxElements^[col] := TDynArray.Create(fRows);
          inc(fMemAllocated, mtxElements^[col].fMemAllocated);
        end;
    end; {==TDynaMatrix.Create==}
     
    destructor TDynaMatrix.Destroy;
    var col: TMatrixNDX;
    begin {==TDynaMatrix.Destroy;==}
      for col := fColumns downto 1 do
        begin
          dec(fMemAllocated, mtxElements^[col].fMemAllocated);
          mtxElements^[col].Free;
        end;
      FreeMem(mtxElements, fMemAllocated);
      inherited Destroy;
    end; {==TDynaMatrix.Destroy;==}
     
    function TDynaMatrix.GetElement(row: TDynArrayNDX;
      column: TMatrixNDX): TDynArrayBaseType;
    begin {==TDynaMatrix.GetElement==}
      if (row < 1) or (row > fRows) then
        raise EDynArrayRangeError.CreateFMT('Индекс строки вышел за границы диапазона : %d', [row]);
      if (column < 1) or (column > fColumns) then
        raise EDynArrayRangeError.CreateFMT('Индекс столбца вышел за границы диапазона : %d', [column]);
      result := mtxElements^[column].Elements^[row];
    end; {==TDynaMatrix.GetElement==}
     
    procedure TDynaMatrix.SetElement(row: TDynArrayNDX;
      column: TMatrixNDX;
      const NewValue: TDynArrayBaseType);
    begin {==TDynaMatrix.SetElement==}
      if (row < 1) or (row > fRows) then
        raise EDynArrayRangeError.CreateFMT('Индекс строки вышел за границы диапазона : %d', [row]);
      if (column < 1) or (column > fColumns) then
        raise EDynArrayRangeError.CreateFMT('Индекс столбца вышел за границы диапазона : %d', [column]);
      mtxElements^[column].Elements^[row] := NewValue;
    end; {==TDynaMatrix.SetElement==}
     
    end.

Тестовая программа для модуля DynArray

    uses DynArray, WinCRT;
     
    const
      NumRows: integer = 7;
      NumCols: integer = 5;
     
    var
      M: TDynaMatrix;
      row, col: integer;
     
    begin
      M := TDynaMatrix.Create(NumRows, NumCols);
      for row := 1 to M.Rows do
        for col := 1 to M.Columns do
          M[row, col] := row + col / 10;
      writeln('Матрица');
      for row := 1 to M.Rows do
        begin
          for col := 1 to M.Columns do
            write(M[row, col]: 5: 1);
          writeln;
        end;
      writeln;
      writeln('Перемещение');
      for col := 1 to M.Columns do
        begin
          for row := 1 to M.Rows do
            write(M[row, col]: 5: 1);
          writeln;
        end;
      M.Free;
    end.

