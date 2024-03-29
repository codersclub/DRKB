---
Title: Матрицы в Delphi
Author: Andrew M. Omutov
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Матрицы в Delphi
================

Уважаемые сограждане.
В ответ на вопросы Круглого Стола, в основном, от
собратьев студентов, публикую алгоритмы матричного исчисления. В них нет
ничего сложного, все базируется на функциях стандартного Borland Pascal
еще версии 7.0.

Я понимаю, что уровень подготовки наших преподавателей весьма отстает не
то, что от нынешних технологий, но даже и от весьма более ранних, но
все-таки попробую помочь собратьям "по-несчастью".... :o)))

Перечень функций этой библиотеки:

    Unit Matrix;
     
    interface
     
    type
       MatrixPtr = ^MatrixRec;
       MatrixRec = record
         MatrixRow   : byte;
         MatrixCol   : byte;
         MatrixArray : pointer;
       end;
       MatrixElement = real;
     
    (* Функция возвращает целочисленную степень *)
    function IntPower(X,n : integer) : integer;
     
    (* Функция создает квадратную матрицу *)
    function  CreateSquareMatrix(Size : byte) : MatrixPtr;
     
    (* Функция создает прямоугольную матрицу *)
    function  CreateMatrix(Row,Col : byte) : MatrixPtr;
     
    (* Функция дублирует матрицу *)
    function  CloneMatrix(MPtr : MatrixPtr) : MatrixPtr;
     
    (* Функция удаляет матрицу и возвращает TRUE в случае удачи *)
    function  DeleteMatrix(var MPtr : MatrixPtr) : boolean;
     
    (* Функция заполняет матрицу указанным числом *)
    function  FillMatrix(MPtr : MatrixPtr;Value : MatrixElement) : boolean;
     
    (* Функция удаляет матрицу MPtr1 и присваивает ей значение MPtr2 *)
    function  AssignMatrix(var MPtr1 : MatrixPtr;MPtr2 : MatrixPtr) : MatrixPtr;
     
    (* Функция отображает матрицу на консоль *)
    function  DisplayMatrix(MPtr : MatrixPtr;_Int,_Frac : byte) : boolean;
     
    (* Функция возвращает TRUE, если матрица 1x1 *)
    function  IsSingleMatrix(MPtr : MatrixPtr) : boolean;
     
    (* Функция возвращает TRUE, если матрица квадратная *)
    function  IsSquareMatrix(MPtr : MatrixPtr) : boolean;
     
    (* Функция возвращает количество строк матрицы *)
    function  GetMatrixRow(MPtr : MatrixPtr) : byte;
     
    (* Функция возвращает количество столбцов матрицы *)
    function  GetMatrixCol(MPtr : MatrixPtr) : byte;
     
    (* Процедура устанавливает элемент матрицы *)
    procedure SetMatrixElement(MPtr : MatrixPtr;Row,Col : byte;Value : MatrixElement);
     
    (* Функция возвращает элемент матрицы *)
    function  GetMatrixElement(MPtr : MatrixPtr;Row,Col : byte) : MatrixElement;
     
    (* Функция исключает векторы из матрицы *)
    function  ExcludeVectorFromMatrix(MPtr : MatrixPtr;Row,Col : byte) : MatrixPtr;
     
    (* Функция заменяет строку(столбец) матрицы вектором *)
    function  SetVectorIntoMatrix(MPtr,VPtr : MatrixPtr;_Pos : byte) : MatrixPtr;
     
    (* Функция возвращает детерминант матрицы *)
    function  DetMatrix(MPtr : MatrixPtr) : MatrixElement;
     
    (* Функция возвращает детерминант треугольной матрицы *)
    function  DetTriangularMatrix(MPtr : MatrixPtr) : MatrixElement;
     
    (* Функция возвращает алгебраическое дополнение элемента матрицы *)
    function  AppendixElement(MPtr : MatrixPtr;Row,Col : byte) : MatrixElement;
     
    (* Функция создает матрицу алгебраических дополнений элементов матрицы *)
    function  CreateAppendixMatrix(MPtr : MatrixPtr) : MatrixPtr;
     
    (* Функция транспонирует матрицу *)
    function TransponeMatrix(MPtr : MatrixPtr) : MatrixPtr;
     
    (* Функция возвращает обратную матрицу *)
    function ReverseMatrix(MPtr : MatrixPtr) : MatrixPtr;
     
    (* Функция умножает матрицу на число *)
    function MultipleMatrixOnNumber(MPtr : MatrixPtr;Number : MatrixElement) : MatrixPtr;
     
    (* Функция умножает матрицу на матрицу *)
    function MultipleMatrixOnMatrix(MPtr1,MPtr2 : MatrixPtr) : MatrixPtr;
     
    (* Функция суммирует две матрицы *)
    function AddMatrixOnMatrix(MPtr1,MPtr2 : MatrixPtr) : MatrixPtr;
     
    (* Функция вычитает из первой матрицы вторую *)
    function SubMatrixOnMatrix(MPtr1,MPtr2 : MatrixPtr) : MatrixPtr;
     
    (* Функция решает систему методом Гаусса и возвращает LU-матрицы *)
    (* Результат функции - вектор-столбец решений                    *)
     
    function GausseMethodMatrix(MPtr,VPtr : MatrixPtr;var LPtr,UPtr,BPtr : MatrixPtr) : MatrixPtr;
     
     
    implementation
     
     
    function IntPower(X,n : integer) : integer;
    var
      Res,i : integer;
    begin
      if n < 1 then IntPower:= 0
      else begin
        Res:= X;
        for i:=1 to n-1 do Res:= Res*X;
        IntPower:= Res;
      end;
    end;
     
     
    function CreateSquareMatrix(Size : byte) : MatrixPtr;
    var
      TempPtr : MatrixPtr;
    begin
      TempPtr:= nil;
      GetMem(TempPtr,SizeOf(MatrixRec));
      if TempPtr = nil then begin
        CreateSquareMatrix:= nil;
        Exit;
      end;
      with TempPtr^ do begin
        MatrixRow:= Size;
        MatrixCol:= Size;
        MatrixArray:= nil;
        GetMem(MatrixArray,Size*Size*SizeOf(MatrixElement));
        if MatrixArray = nil then begin
          FreeMem(TempPtr,SizeOf(MatrixRec));
          CreateSquareMatrix:= nil;
          Exit;
        end;
      end;
      FillMatrix(TempPtr,0);
      CreateSquareMatrix:= TempPtr;
    end;
     
     
    function CreateMatrix(Row,Col : byte) : MatrixPtr;
    var
      TempPtr : MatrixPtr;
    begin
      TempPtr:= nil;
      GetMem(TempPtr,SizeOf(MatrixRec));
      if TempPtr = nil then begin
        CreateMatrix:= nil;
        Exit;
      end;
      with TempPtr^ do begin
        MatrixRow:= Row;
        MatrixCol:= Col;
        MatrixArray:= nil;
        GetMem(MatrixArray,Row*Col*SizeOf(MatrixElement));
        if MatrixArray = nil then begin
          FreeMem(TempPtr,SizeOf(MatrixRec));
          CreateMatrix:= nil;
          Exit;
        end;
      end;
      FillMatrix(TempPtr,0);
      CreateMatrix:= TempPtr;
    end;
     
     
    function DeleteMatrix(var MPtr : MatrixPtr) : boolean;
    begin
      if MPtr = nil then DeleteMatrix:= FALSE
      else with MPtr^ do begin
        if MatrixArray <> nil then
          FreeMem(MatrixArray,MatrixRow*MatrixCol*SizeOf(MatrixElement));
        FreeMem(MPtr,SizeOf(MatrixRec));
        MPtr:= nil;
        DeleteMatrix:= TRUE;
      end;
    end;
     
     
    function CloneMatrix(MPtr : MatrixPtr) : MatrixPtr;
    var
      TempPtr : MatrixPtr;
      i,j     : byte;
    begin
      if MPtr = nil then CloneMatrix:= nil
      else with MPtr^ do begin
        TempPtr:= CreateMatrix(MPtr^.MatrixRow,MPtr^.MatrixCol);
        if TempPtr <> nil then begin
          for i:= 1 to MatrixRow do
            for j:= 1 to MatrixCol do
              SetMatrixElement(TempPtr,i,j,GetMatrixElement(MPtr,i,j));
          CloneMatrix:= TempPtr;
        end else CloneMatrix:= nil;
      end;
    end;
     
     
     
    function FillMatrix(MPtr : MatrixPtr;Value : MatrixElement) : boolean;
    var
      i,j : byte;
    begin
      if MPtr = nil then FillMatrix:= FALSE
      else with MPtr^ do begin
        for i:= 1 to MatrixRow do
          for j:= 1 to MatrixCol do
            SetMatrixElement(MPtr,i,j,Value);
        FillMatrix:= TRUE;
      end;
    end;
     
     
    function AssignMatrix(var MPtr1 : MatrixPtr;MPtr2 : MatrixPtr) : MatrixPtr;
    begin
      DeleteMatrix(MPtr1);
      MPtr1:= MPtr2;
      AssignMatrix:= MPtr1;
    end;
     
     
    function DisplayMatrix(MPtr : MatrixPtr;_Int,_Frac : byte) : boolean;
    var
      i,j : byte;
    begin
      if MPtr = nil then DisplayMatrix:= FALSE
      else with MPtr^ do begin
        for i:= 1 to MatrixRow do begin
          for j:= 1 to MatrixCol do
            write(GetMatrixElement(MPtr,i,j) : _Int : _Frac);
          writeln;
        end;
        DisplayMatrix:= TRUE;
      end;
    end;
     
     
    function IsSingleMatrix(MPtr : MatrixPtr) : boolean;
    begin
      if MPtr <> nil then with MPtr^ do begin
        if (MatrixRow = 1) and (MatrixCol = 1) then
          IsSingleMatrix:= TRUE
        else IsSingleMatrix:= FALSE;
      end else IsSingleMatrix:= FALSE;
    end;
     
     
    function IsSquareMatrix(MPtr : MatrixPtr) : boolean;
    begin
      if MPtr <> nil then with MPtr^ do begin
        if MatrixRow = MatrixCol then
          IsSquareMatrix:= TRUE
        else IsSquareMatrix:= FALSE;
      end else IsSquareMatrix:= FALSE;
    end;
     
    function GetMatrixRow(MPtr : MatrixPtr) : byte;
    begin
      if MPtr <> nil then GetMatrixRow:= MPtr^.MatrixRow
      else GetMatrixRow:= 0;
    end;
     
    function GetMatrixCol(MPtr : MatrixPtr) : byte;
    begin
      if MPtr <> nil then GetMatrixCol:= MPtr^.MatrixCol
      else GetMatrixCol:= 0;
    end;
     
    procedure SetMatrixElement(MPtr : MatrixPtr;Row,Col : byte;Value : MatrixElement);
    var
      TempPtr : ^MatrixElement;
    begin
      if MPtr <> nil then
        if (Row <> 0) or (Col <> 0) then with MPtr^ do begin
          pointer(TempPtr):= pointer(MatrixArray);
          Inc(TempPtr,MatrixRow*(Col-1)+Row-1);
          TempPtr^:= Value;
        end;
    end;
     
     
    function GetMatrixElement(MPtr : MatrixPtr;Row,Col : byte) : MatrixElement;
    var
      TempPtr : ^MatrixElement;
    begin
      if MPtr <> nil then begin
        if (Row <> 0) and (Col <> 0) then with MPtr^ do begin
          pointer(TempPtr):= pointer(MatrixArray);
          Inc(TempPtr,MatrixRow*(Col-1)+Row-1);
          GetMatrixElement:= TempPtr^;
        end else GetMatrixElement:= 0;
      end else GetMatrixElement:= 0;
    end;
     
     
    function ExcludeVectorFromMatrix(MPtr : MatrixPtr;Row,Col : byte) : MatrixPtr;
    var
      NewPtr           : MatrixPtr;
      NewRow, NewCol   : byte;
      i,j              : byte;
      DiffRow, DiffCol : byte;
    begin
      if MPtr <> nil then with MPtr^ do begin
     
        if Row = 0 then NewRow:= MatrixRow
        else NewRow:= MatrixRow-1;
        if Col = 0 then NewCol:= MatrixCol
        else NewCol:= MatrixCol-1;
     
        NewPtr:= CreateMatrix(NewRow, NewCol);
        if (NewPtr = nil) or (NewPtr^.MatrixArray = nil) then begin
          ExcludeVectorFromMatrix:= nil;
          Exit;
        end;
     
        DiffRow:= 0;
        DiffCol:= 0;
        for i:= 1 to MatrixRow do begin
          if i = Row then DiffRow:= 1
          else  for j:= 1 to MatrixCol do if j = Col then DiffCol:= 1
            else SetMatrixElement(NewPtr,i-DiffRow,j-DiffCol,
              GetMatrixElement(MPtr,i,j));
          DiffCol:= 0;
        end;
     
        ExcludeVectorFromMatrix:= NewPtr;
      end else ExcludeVectorFromMatrix:= nil;
    end;
     
     
    function SetVectorIntoMatrix(MPtr,VPtr : MatrixPtr;_Pos : byte) : MatrixPtr;
    var
      TempPtr : MatrixPtr;
      i       : byte;
    begin
      if (MPtr <> nil) and (VPtr <> nil) then begin
        TempPtr:= CloneMatrix(MPtr);
        if TempPtr = nil then begin
          SetVectorIntoMatrix:= nil;
          Exit;
        end;
        if VPtr^.MatrixRow = 1 then begin
          for i:= 1 to TempPtr^.MatrixCol do
            SetMatrixElement(TempPtr,_Pos,i,GetMatrixElement(VPtr,1,i));
        end else begin
          for i:= 1 to TempPtr^.MatrixRow do
            SetMatrixElement(TempPtr,i,_Pos,GetMatrixElement(VPtr,i,1));
        end;
        SetVectorIntoMatrix:= TempPtr;
      end else SetVectorIntoMatrix:= nil;
    end;
     
     
    function DetMatrix(MPtr : MatrixPtr) : MatrixElement;
    var
      TempPtr : MatrixPtr;
      i,j     : byte;
      Sum     : MatrixElement;
    begin
      if IsSquareMatrix(MPtr) then begin
        if not IsSingleMatrix(MPtr) then begin
          TempPtr:= nil;
          Sum:= 0;
          for j:= 1 to GetMatrixCol(MPtr) do begin
            AssignMatrix(TempPtr,ExcludeVectorFromMatrix(MPtr,1,j));
            Sum:= Sum+IntPower(-1,j+1)*GetMatrixElement(MPtr,1,j)*DetMatrix(TempPtr);
          end;
          DeleteMatrix(TempPtr);
          DetMatrix:= Sum;
        end else DetMatrix:= GetMatrixElement(MPtr,1,1);
      end else DetMatrix:= 0;
    end;
     
     
    function DetTriangularMatrix(MPtr : MatrixPtr) : MatrixElement;
    var
      i       : byte;
      Sum     : MatrixElement;
    begin
      if IsSquareMatrix(MPtr) then begin
        Sum:= 1;
        for i:= 1 to MPtr^.MatrixRow do
          Sum:= Sum*GetMatrixElement(MPtr,i,i);
        DetTriangularMatrix:= Sum;
      end else DetTriangularMatrix:= 0;
    end;
     
     
    function AppendixElement(MPtr : MatrixPtr;Row,Col : byte) : MatrixElement;
    var
      TempPtr : MatrixPtr;
    begin
      if IsSquareMatrix(MPtr) then begin
        TempPtr:= ExcludeVectorFromMatrix(MPtr,Row,Col);
        if TempPtr = nil then begin
          AppendixElement:= 0;
          Exit;
        end;
        AppendixElement:= IntPower(-1,Row+Col)*DetMatrix(TempPtr);
        DeleteMatrix(TempPtr);
      end else AppendixElement:= 0;
    end;
     
     
    function CreateAppendixMatrix(MPtr : MatrixPtr) : MatrixPtr;
    var
      TempPtr : MatrixPtr;
      i,j     : byte;
    begin
      if (MPtr <> nil) or (MPtr^.MatrixArray <> nil) or
         (not IsSquareMatrix(MPtr)) then with MPtr^ do begin
        TempPtr:= CreateMatrix(MatrixCol,MatrixRow);
        for i:= 1 to MatrixRow do
          for j:= 1 to MatrixCol do
            SetMatrixElement(TempPtr,i,j,AppendixElement(MPtr,i,j));
        CreateAppendixMatrix:= TempPtr;
      end else CreateAppendixMatrix:= nil;
    end;
     
     
     
    function TransponeMatrix(MPtr : MatrixPtr) : MatrixPtr;
    var
      TempPtr : MatrixPtr;
      i,j     : byte;
    begin
      if (MPtr <> nil) or (MPtr^.MatrixArray <> nil) then with MPtr^ do begin
        TempPtr:= CreateMatrix(MatrixCol,MatrixRow);
        for i:= 1 to MatrixRow do
          for j:= 1 to MatrixCol do
            SetMatrixElement(TempPtr,j,i,GetMatrixElement(MPtr,i,j));
        TransponeMatrix:= TempPtr;
      end else TransponeMatrix:= nil;
    end;
     
     
    function ReverseMatrix(MPtr : MatrixPtr) : MatrixPtr;
    var
      TempPtr     : MatrixPtr;
      Determinant : MatrixElement;
    begin
      if MPtr <> nil then begin
        TempPtr:= nil;
        AssignMatrix(TempPtr,CreateAppendixMatrix(MPtr));
        AssignMatrix(TempPtr,TransponeMatrix(TempPtr));
        Determinant:= DetMatrix(MPtr);
        if (TempPtr = nil) or (Determinant = 0) then begin
          DeleteMatrix(TempPtr);
          ReverseMatrix:= nil;
          Exit;
        end;
        AssignMatrix(TempPtr,MultipleMatrixOnNumber(TempPtr,1/Determinant));
        ReverseMatrix:= TempPtr;
      end else ReverseMatrix:= nil;
    end;
     
     
     
    function MultipleMatrixOnNumber(MPtr : MatrixPtr;Number : MatrixElement) : MatrixPtr;
    var
      TempPtr : MatrixPtr;
      i,j     : byte;
    begin
      if MPtr <> nil then with MPtr^ do begin
        TempPtr:= CreateMatrix(MatrixRow,MatrixCol);
        if TempPtr = nil then begin
          MultipleMatrixOnNumber:= nil;
          Exit;
        end;
        for i:= 1 to MatrixRow do
          for j:= 1 to MatrixCol do
            SetMatrixElement(TempPtr,i,j,GetMatrixElement(MPtr,i,j)*Number);
        MultipleMatrixOnNumber:= TempPtr;
      end else MultipleMatrixOnNumber:= nil;
    end;
     
     
    function MultipleMatrixOnMatrix(MPtr1,MPtr2 : MatrixPtr) : MatrixPtr;
    var
      TempPtr : MatrixPtr;
      i,j,k   : byte;
    begin
      if (MPtr1 <>  nil) and (MPtr2 <> nil) then begin
        TempPtr:= CreateMatrix(MPtr1^.MatrixRow,MPtr2^.MatrixCol);
        if TempPtr = nil then begin
          MultipleMatrixOnMatrix:= nil;
          Exit;
        end;
        for i:= 1 to TempPtr^.MatrixRow do
          for j:= 1 to TempPtr^.MatrixCol do
            for k:= 1 to MPtr1^.MatrixCol do
              SetMatrixElement(TempPtr,i,j,GetMatrixElement(TempPtr,i,j)+
                GetMatrixElement(MPtr1,i,k)*GetMatrixElement(MPtr2,k,j));
        MultipleMatrixOnMatrix:= TempPtr;
      end else MultipleMatrixOnMatrix:= nil;
    end;
     
     
     
    function AddMatrixOnMatrix(MPtr1,MPtr2 : MatrixPtr) : MatrixPtr;
    var
      TempPtr : MatrixPtr;
      i,j,k   : byte;
    begin
      if (MPtr1 <>  nil) and (MPtr2 <> nil) then begin
        TempPtr:= CreateMatrix(MPtr1^.MatrixRow,MPtr2^.MatrixCol);
        if TempPtr = nil then begin
          AddMatrixOnMatrix:= nil;
          Exit;
        end;
        for i:= 1 to TempPtr^.MatrixRow do
          for j:= 1 to TempPtr^.MatrixCol do
            SetMatrixElement(TempPtr,i,j,GetMatrixElement(Mptr1,i,j)+
              GetMatrixElement(MPtr2,i,j));
        AddMatrixOnMatrix:= TempPtr;
      end else AddMatrixOnMatrix:= nil;
    end;
     
     
    function SubMatrixOnMatrix(MPtr1,MPtr2 : MatrixPtr) : MatrixPtr;
    var
      TempPtr : MatrixPtr;
      i,j,k   : byte;
    begin
      if (MPtr1 <>  nil) and (MPtr2 <> nil) then begin
        TempPtr:= CreateMatrix(MPtr1^.MatrixRow,MPtr2^.MatrixCol);
        if TempPtr = nil then begin
          SubMatrixOnMatrix:= nil;
          Exit;
        end;
        for i:= 1 to TempPtr^.MatrixRow do
          for j:= 1 to TempPtr^.MatrixCol do
            SetMatrixElement(TempPtr,i,j,GetMatrixElement(MPtr1,i,j)-
              GetMatrixElement(MPtr2,i,j));
        SubMatrixOnMatrix:= TempPtr;
      end else SubMatrixOnMatrix:= nil;
    end;
     
     
     
    function GausseMethodMatrix(MPtr,VPtr : MatrixPtr;var LPtr,UPtr,BPtr : MatrixPtr) : MatrixPtr;
    var
      TempPtr  : MatrixPtr;
      TempVPtr : MatrixPtr;
      TempLPtr : MatrixPtr;
      TempUPtr : MatrixPtr;
      XSum     : MatrixElement;
      i,j,k    : byte;
    begin
      if (MPtr <> nil) and (VPtr <> nil) then begin
     
        TempUPtr:= CloneMatrix(MPtr);
        if TempUPtr = nil then begin
          GausseMethodMatrix:= nil;
          Exit;
        end;
        TempLPtr:= CreateMatrix(MPtr^.MatrixRow,MPtr^.MatrixCol);
        if TempLPtr = nil then begin
          DeleteMatrix(TempUPtr);
          GausseMethodMatrix:= nil;
          Exit;
        end;
        TempVPtr:= CloneMatrix(VPtr);
        if TempVPtr = nil then begin
          DeleteMatrix(TempLPtr);
          DeleteMatrix(TempUPtr);
          GausseMethodMatrix:= nil;
          Exit;
        end;
        TempPtr:= CreateMatrix(MPtr^.MatrixRow,1);
        if TempPtr = nil then begin
          DeleteMatrix(TempVPtr);
          DeleteMatrix(TempLPtr);
          DeleteMatrix(TempUPtr);
          GausseMethodMatrix:= nil;
          Exit;
        end;
     
        for j:= 1 to MPtr^.MatrixCol-1 do begin
          SetMatrixElement(TempLPtr,j,j,1);
          for i:= j+1 to MPtr^.MatrixRow do begin
            SetMatrixElement(TempLPtr,i,j,GetMatrixElement(TempUPtr,i,j)/
              GetMatrixElement(TempUPtr,j,j));
            for k:= j to MPtr^.MatrixCol do begin
              SetMatrixElement(TempUPtr,i,k,GetMatrixElement(TempUPtr,i,k)-
                GetMatrixElement(TempLPtr,i,j)*GetMatrixElement(TempUPtr,j,k));
            end;
            SetMatrixElement(TempVPtr,i,1,GetMatrixElement(TempVPtr,i,1)-
              GetMatrixElement(TempLPtr,i,j)*GetMatrixElement(TempVPtr,j,1));
          end;
        end;
     
        SetMatrixElement(TempLPtr,TempLPtr^.MatrixRow,TempLPtr^.MatrixCol,1);
        SetMatrixElement(TempPtr,TempPtr^.MatrixRow,1,
          GetMatrixElement(TempVPtr,TempVPtr^.MatrixRow,1)/
          GetMatrixElement(TempUPtr,TempUPtr^.MatrixRow,TempUPtr^.MatrixCol));
     
        for j:= MPtr^.MatrixCol-1 downto 1 do begin
          XSum:= 0;
          for k:= j+1 to MPtr^.MatrixCol do
            XSum:= XSum+GetMatrixElement(TempUPtr,j,k)*
              GetMatrixElement(TempPtr,k,1);
          SetMatrixElement(TempPtr,j,1,(GetMatrixElement(TempVPtr,j,1)-XSum)/
            GetMatrixElement(TempUPtr,j,j));
        end;
     
        LPtr:= TempLPtr;
        UPtr:= TempUPtr;
        BPtr:= TempVPtr;
        GausseMethodMatrix:= TempPtr;
      end else GausseMethodMatrix:= nil;
    end;
     
    end.

Мне кажется, что интерфейсное описание весьма простое, но если возникнут
какие-либо вопросы - пишите на E-mail - постараюсь ответить на все Ваши
вопросы. Может быть, азы матричного исчисления я опишу в виде отдельной
статьи по причине множества поступивших вопросов, хотя в этой матричной
математике нет ничего сложного :o) Следует отметить, что теория матриц
дает в Ваши руки весьма мощный инструмент по анализу данных весьма
различного характера, в чем я неоднократно убеждался на практике.

Важные, на мой взгляд, замечания. НЕ СТЕСНЯЙТЕСЬ использовать подход,
использующий стандартный тип Pascal - record - в объектах мало чего
хорошего в межкомпиляторном взаимодействии. Да и, кстати, использование
типа record до сих пор является самым быстрым способом математических
расчетов, в отличиие от ООП. Частенько простое 2+2=4 дает существенный
выигрыш по времени выполнения, по сравнению с объектным подходом, а если
математических вычислений в Вашей программе великое множество...

