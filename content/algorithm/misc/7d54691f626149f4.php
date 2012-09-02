<h1>Оптимизация функции методом деформируемого многогранника (метод Нелдера-Мида)</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Оптимизация функции методом деформируемого многогранника (Метод Нелдера-Мида)
 
Передаваемая структура:
TNelderOption = record
Size: Cardinal; // Размер структуры (обязательно)
Flags: Cardinal; // Флаги (обязательно)
Func: TMathFunction; // Функция (обязательно)
N: Integer; // Размерность (обязательно)
X0: PExtended; // Указатель на начальную точку (обязательно)
X: PExtended; // Указатель куда записывать результат (обязательно)
Eps: Extended; // Точность (опция FIND_MIN_USE_EPS)
Delta: Extended; // Способ проверки (опция FIND_MIN_USE_DELTA)
R: Extended; // Расстояние между вершинами симплекса (опция FIND_MIN_USE_R)
Mode: Integer; // Метод решения (опция FIND_MIN_USE_MODE)
Alpha: Extended; // Коэффициент отражения (опция FIND_MIN_USE_ALPHA)
Beta: Extended; // Коэффициент сжатия (опция FIND_MIN_USE_BETA)
Gamma: Extended; // Коэффициент растяжения (опция FIND_MIN_USE_GAMMA)
end;
 
Возвращаемое значение - 0 если хорошо, иначе ошибка
 
Зависимости: Windows
Автор:       Mystic, mystic2000@newmail.ru, ICQ:125905046, Харьков
Copyright:   Mystic (посвящается Оксане в память о ее дипломе)
Дата:        25 апреля 2002 г.
********************************************** }
 
const
  CONST_1_DIV_SQRT_2 = 0.70710678118654752440084436210485;
 
  FIND_MIN_OK = 0;
  FIND_MIN_INVALID_OPTION = 1;
  FIND_MIN_INVALID_FUNC = 2;
  FIND_MIN_INVALID_N = 3;
  FIND_MIN_INVALID_X0 = 4;
  FIND_MIN_INVALID_X = 5;
  FIND_MIN_INVALID_EPS = 6;
  FIND_MIN_INVALID_DELTA = 7;
  FIND_MIN_INVALID_R = 8;
  FIND_MIN_MODE_NOT_SUPPORT = 9;
  FIND_MIN_OUT_OF_MEMORY = 10;
  FIND_MIN_INVALID_ALPHA = 11;
  FIND_MIN_INVALID_BETA = 12;
  FIND_MIN_INVALID_GAMMA = 13;
 
  FIND_MIN_MODE_STD = 0;
  FIND_MIN_MODE_1 = 1;
  FIND_MIN_MODE_2 = 2;
 
  FIND_MIN_USE_EPS = $00000001;
  FIND_MIN_USE_R = $00000002;
  FIND_MIN_USE_MODE = $00000004;
  FIND_MIN_USE_DELTA = $00000008;
  FIND_MIN_USE_ALPHA = $00000010;
  FIND_MIN_USE_BETA = $00000020;
  FIND_MIN_USE_GAMMA = $00000040;
 
  // Некоторые комбинации стандартных опций:
  FIND_MIN_USE_EPS_R = FIND_MIN_USE_EPS or FIND_MIN_USE_R;
  FIND_MIN_USE_EPS_R_MODE = FIND_MIN_USE_EPS_R or FIND_MIN_USE_MODE;
  FIND_MIN_USE_EPS_R_DELTA = FIND_MIN_USE_EPS_R or FIND_MIN_USE_DELTA;
  FIND_MIN_USE_EPS_R_MODE_DELTA = FIND_MIN_USE_EPS_R_MODE or FIND_MIN_USE_DELTA;
  FIND_MIN_USE_ALL = FIND_MIN_USE_EPS or FIND_MIN_USE_R or FIND_MIN_USE_MODE or
                     FIND_MIN_USE_DELTA or FIND_MIN_USE_ALPHA or
                     FIND_MIN_USE_BETA or FIND_MIN_USE_GAMMA;
 
type
  PMathFunction = ^TMathFunction;
  TMathFunction = function(X: PExtended): Extended;
 
  PNelderOption = ^TNelderOption;
  TNelderOption = record
    Size: Cardinal; // Размер структуры (обязательно)
    Flags: Cardinal; // Флаги (обязательно)
    Func: TMathFunction; // Функция (обязательно)
    N: Integer; // Размерность (обязательно)
    X0: PExtended; // Указатель на начальную точку (обязательно)
    X: PExtended; // Указатель куда записывать результат (обязательно)
    Eps: Extended; // Точность (опция FIND_MIN_USE_EPS)
    Delta: Extended; // Способ проверки (опция FIND_MIN_USE_DELTA)
    R: Extended; // Расстояние между вершинами симплекса (опция FIND_MIN_USE_R)
    Mode: Integer; // Метод решения (опция FIND_MIN_USE_MODE)
    Alpha: Extended; // Коэффициент отражения (опция FIND_MIN_USE_ALPHA)
    Beta: Extended; // Коэффициент сжатия (опция FIND_MIN_USE_BETA)
    Gamma: Extended; // Коэффициент растяжения (опция FIND_MIN_USE_GAMMA)
  end;
 
{**********
  Проверка указателя Option на то, что все его параметры доступны для чтения
**********}
function CheckNelderOptionPtr(Option: PNelderOption): Integer;
begin
  // Проверка указателя #1 (допустимость указателя)
  if IsBadReadPtr(@Option, 4) then
  begin
    Result := FIND_MIN_INVALID_OPTION;
    Exit;
  end;
 
  // Проверка указателя #2 (слишком мало параметров)
  if Option.Size &lt; 24 then
  begin
    Result := FIND_MIN_INVALID_OPTION;
    Exit;
  end;
 
  // Проверка указателя #3 (все данные можно читать?)
  if IsBadReadPtr(@Option, Option.Size) then
  begin
    Result := FIND_MIN_INVALID_OPTION;
    Exit;
  end;
 
  Result := FIND_MIN_OK;
end;
 
{************
  Копирование данных из одной структуры в другую с попутной проверкой
  на допустимость значений всех параметров.
************}
function CopyData(const InOption: TNelderOption; var OutOption: TNelderOption): Integer;
var
  CopyCount: Cardinal;
begin
  Result := FIND_MIN_OK;
 
  // Копируем одну структуру в другую
  CopyCount := SizeOf(TNelderOption);
  if InOption.Size &lt; CopyCount then CopyCount := InOption.Size;
  Move(InOption, OutOption, CopyCount);
 
  // Устанавливаем размер
  OutOption.Size := SizeOf(TNelderOption);
 
  // Проверка Option.Func
  if IsBadCodePtr(@OutOption.Func) then
  begin
    Result := FIND_MIN_INVALID_FUNC;
    Exit;
  end;
 
  // Проверка Option.N
  if OutOption.N &lt;= 0 then
  begin
    Result := FIND_MIN_INVALID_N;
    Exit;
  end;
 
  // Проверка Option.X0
  if IsBadReadPtr(OutOption.X0, OutOption.N * SizeOf(Extended)) then
  begin
    Result := FIND_MIN_INVALID_X0;
    Exit;
  end;
 
  // Проверка Option.X
  if IsBadWritePtr(OutOption.X, OutOption.N * SizeOf(Extended)) then
  begin
    Result := FIND_MIN_INVALID_X;
    Exit;
  end;
 
  // Проверка Option.Eps
  if (FIND_MIN_USE_EPS and OutOption.Flags) &lt;&gt; 0 then
  begin
    if OutOption.Size &lt; 34 then // Eps не вписывается в размер
    begin
      Result := FIND_MIN_INVALID_OPTION;
      Exit;
    end
    else if OutOption.Eps &lt;= 0 then
    begin
      Result := FIND_MIN_INVALID_EPS;
      Exit;
    end;
  end
  else begin
    OutOption.Eps := 1E-06; // Default value;
  end;
 
  // Проверка OutOption.Delta
  if (FIND_MIN_USE_DELTA and OutOption.Flags) &lt;&gt; 0 then
  begin
    if OutOption.Size &lt; 44 then
    begin
      Result := FIND_MIN_INVALID_OPTION;
      Exit;
    end
    else if (OutOption.Delta &lt; 0.0) or (OutOption.Delta &gt; 1.0) then
    begin
      Result := FIND_MIN_INVALID_DELTA;
      Exit;
    end;
  end
  else begin
    OutOption.Delta := 0.5; // Default value
  end;
 
  // Проверка OutOption.R
  if (FIND_MIN_USE_R and OutOption.Flags) &lt;&gt; 0 then
  begin
    if OutOption.Size &lt; 54 then
    begin
      Result := FIND_MIN_INVALID_OPTION;
      Exit;
    end
    else if (OutOption.R &lt;= 0.0) then
    begin
      Result := FIND_MIN_INVALID_R;
      Exit;
    end;
  end
  else begin
    OutOption.R := 100.0; // Default value
  end;
 
  // Проверка OutOption.Mode
  if (FIND_MIN_USE_MODE and OutOption.Flags) &lt;&gt; 0 then
  begin
    if OutOption.Size &lt; 58 then
    begin
      Result := FIND_MIN_INVALID_OPTION;
      Exit;
    end
    else
      if (OutOption.Mode &lt;&gt; FIND_MIN_MODE_STD) then
      if (OutOption.Mode &lt;&gt; FIND_MIN_MODE_1) then
      if (OutOption.Mode &lt;&gt; FIND_MIN_MODE_2) then
        begin
          Result := FIND_MIN_MODE_NOT_SUPPORT;
          Exit;
        end;
  end
  else begin
    OutOption.Mode := FIND_MIN_MODE_STD; // Default value
  end;
 
  // Проверка OutOption.Alpha
  if (FIND_MIN_USE_ALPHA and OutOption.Flags) &lt;&gt; 0 then
  begin
    if OutOption.Size &lt; 68 then
    begin
      Result := FIND_MIN_INVALID_OPTION;
      Exit;
    end
    else if OutOption.Alpha &lt; 0.0 then
    begin
      Result := FIND_MIN_INVALID_ALPHA;
      Exit;
    end;
  end
  else begin
    OutOption.Alpha := 1.0; // Default value
  end;
 
  // Проверка OutOption.Beta
  if (FIND_MIN_USE_BETA and OutOption.Flags) &lt;&gt; 0 then
  begin
    if OutOption.Size &lt; 78 then
    begin
      Result := FIND_MIN_INVALID_OPTION;
      Exit;
    end
    else if (OutOption.Beta &lt; 0.0) or (OutOption.Beta &gt; 1.0) then
    begin
      Result := FIND_MIN_INVALID_BETA;
      Exit;
    end;
  end
  else begin
    OutOption.Beta := 0.5; // Default value
  end;
 
  // Проверка OutOption.Gamma
  if (FIND_MIN_USE_GAMMA and OutOption.Flags) &lt;&gt; 0 then
  begin
    if OutOption.Size &lt; 88 then
    begin
      Result := FIND_MIN_INVALID_OPTION;
      Exit;
    end
    else if OutOption.Gamma &lt; 1.0 then
    begin
      Result := FIND_MIN_INVALID_GAMMA;
      Exit;
    end;
  end
  else begin
    OutOption.Gamma := 1.5; // Default value
  end;
end;
 
type
  TNelderTempData = record
    D1: Extended;
    D2: Extended;
    FC: Extended;
    FU: Extended;
    XN: PExtended;
    D0: PExtended;
    FX: PExtended;
    C: PExtended;
    U: PExtended;
    V: PEXtended;
    Indexes: PInteger;
  end;
 
function InitializeTempData(var TempData: TNelderTempData; N: Integer): Integer;
var
  SizeD0: Integer;
  SizeFX: Integer;
  SizeC: Integer;
  SizeU: Integer;
  SizeV: Integer;
  SizeIndexes: Integer;
  SizeAll: Integer;
  Ptr: PChar;
begin
  // Вычисляем размеры
  SizeD0 := N*(N+1)*SizeOf(Extended);
  SizeFX := (N+1)*SizeOf(Extended);
  SizeC := N * SizeOf(Extended);
  SizeU := N * SizeOf(Extended);
  SizeV := N * SizeOf(Extended);
  SizeIndexes := (N+1) * SizeOf(Integer);
  SizeAll := SizeD0 + SizeFX + SizeC + SizeU + SizeV + SizeIndexes;
 
  Ptr := SysGetMem(SizeAll);
  if not Assigned(Ptr) then
  begin
    Result := FIND_MIN_OUT_OF_MEMORY;
    Exit;
  end;
 
  TempData.D0 := PExtended(Ptr);
  Ptr := Ptr + SizeD0;
  TempData.FX := PExtended(Ptr);
  Ptr := Ptr + SizeFX;
  TempData.C := PExtended(Ptr);
  Ptr := Ptr + SizeC;
  TempData.U := PExtended(Ptr);
  Ptr := Ptr + SizeU;
  TempData.V := PExtended(Ptr);
  Ptr := Ptr + SizeV;
  TempData.Indexes := PInteger(Ptr);
  // Ptr := Ptr + SizeIndexes
 
  Result := FIND_MIN_OK;
end;
 
procedure FinalizeTempData(var TempData: TNelderTempData);
var
  Ptr: Pointer;
begin
  Ptr := TempData.D0;
  TempData.D0 := nil;
  TempData.FX := nil;
  TempData.C := nil;
  TempData.U := nil;
  TempData.V := nil;
  TempData.Indexes := nil;
  SysFreeMem(Ptr);
end;
 
{*********
  Строится симплекс:
    В целях оптимизации поменяем местами строки и столбцы
**********}
procedure BuildSimplex(var Temp: TNelderTempData; const Option: TNelderOption);
var
  I, J: Integer;
  PtrD0: PExtended;
begin
  with Temp, Option do
  begin
    D1 := CONST_1_DIV_SQRT_2 * R * (Sqrt(N+1) + N - 1) / N;
    D2 := CONST_1_DIV_SQRT_2 * R * (Sqrt(N+1) - 1) / N;
 
    FillChar(D0^, N*SizeOf(Extended), 0);
    PtrD0 := D0;
    PChar(PtrD0) := PChar(PtrD0) + N*SizeOf(Extended);
    for I := 0 to N-1 do
      for J := 0 to N-1 do
      begin
        if I = J
          then PtrD0^ := D1
          else PtrD0^ := D2;
        PChar(PtrD0) := PChar(PtrD0) + SizeOf(Extended);
      end;
  end;
end;
 
{*********
  Перемещение симплекса в точку A
*********}
procedure MoveSimplex(var Temp: TNelderTempData; const Option: TNelderOption; A: PExtended);
var
  I, J: Integer;
  PtrA, PtrD0: PExtended;
begin
  with Temp, Option do
  begin
    PtrD0 := D0;
    for I := 0 to N do
    begin
      PtrA := A;
      for J := 0 to N-1 do
      begin
        PtrD0^ := PtrD0^ + PtrA^;
        PChar(PtrD0) := PChar(PtrD0) + SizeOf(Extended);
        PChar(PtrA) := PChar(PtrA) + SizeOf(Extended);
      end;
    end;
  end;
end;
 
// Быстрая сортировка значений FX
procedure QuickSortFX(L, R: Integer; FX: PExtended; Indexes: PInteger);
var
  I, J, K: Integer;
  P, T: Extended;
begin
  repeat
    I := L;
    J := R;
 
    // P := FX[(L+R) shr 1] :
    P := PExtended(PChar(FX) + SizeOf(Extended) * ((L+R) shr 1))^;
 
    repeat
      // while FX[I] &lt; P do Inc(I):
      while PExtended(PChar(FX) + SizeOf(Extended)*I)^ &lt; P do
        Inc(I);
 
      // while FX[J] &gt; P do Dec(J):
      while PExtended(PChar(FX) + SizeOf(Extended)*J)^ &gt; P do
        Dec(J);
 
      if I &lt;= J then
      begin
        // Переставляем местами значения FX
        T := PExtended(PChar(FX) + SizeOf(Extended)*I)^;
        PExtended(PChar(FX) + SizeOf(Extended)*I)^ := PExtended(PChar(FX) + SizeOf(Extended)*J)^;
        PExtended(PChar(FX) + SizeOf(Extended)*J)^ := T;
 
        // Поддерживаем порядок и в индексах
        K := PInteger(PChar(Indexes) + SizeOf(Integer)*I)^;
        PInteger(PChar(Indexes) + SizeOf(Integer)*I)^ := PInteger(PChar(Indexes) + SizeOf(Integer)*J)^;
        PInteger(PChar(Indexes) + SizeOf(Integer)*J)^ := K;
 
        Inc(I);
        Dec(J);
      end;
    until I&gt;J;
 
    if L &lt; J then
      QuickSortFX(L, J, FX, Indexes);
    L := I;
  until I &gt;= R;
 
end;
 
procedure CalcFX(var Temp: TNelderTempData; Option: TNelderOption);
var
  I: Integer;
  PtrD0, PtrFX: PExtended;
begin
  with Temp, Option do
  begin
    // Вычисление значений функции
    PtrD0 := D0;
    PtrFX := FX;
    for I := 0 to N do
    begin
      PtrFX^ := Func(PtrD0);
      PChar(PtrD0) := PChar(PtrD0) + N * SizeOf(Extended);
      PChar(PtrFX) := PChar(PtrFX) + SizeOf(Extended);
    end;
  end;
end;
 
// Освежаем и сортируем FX + освежаем индексы
procedure RefreshFX(var Temp: TNelderTempData; Option: TNelderOption);
var
  I: Integer;
  PtrIndexes: PInteger;
begin
  with Temp, Option do
  begin
    // Заполение индексов
    PtrIndexes := Indexes;
    for I := 0 to N do
    begin
      PtrIndexes^ := I;
      PChar(PtrIndexes) := PChar(PtrIndexes) + SizeOf(Integer);
    end;
 
    // Сортировка
    QuickSortFX(0, N, FX, Indexes);
 
    // Возвращаемое значение: Result := D0 + SizeOf(Extended) * Indexes[N]
    PChar(PtrIndexes) := PChar(PtrIndexes) - SizeOf(Integer);
    XN := PExtended(PChar(D0) + N*SizeOf(Extended)*PtrIndexes^);
  end;
end;
 
procedure CalcC(var Temp: TNelderTempData; const Option: TNelderOption);
var
  PtrC, PtrD0: PExtended;
  I, J: Integer;
begin
  with Temp, Option do
  begin
 
    PtrD0 := D0;
 
    // C := 0;
    FillChar(C^, N*SizeOf(Extended), 0);
 
    // C := Sum (Xn)
    for I := 0 to N do
      if PtrD0 &lt;&gt; XN then
      begin
        PtrC := C;
        for J := 0 to N-1 do
        begin
          PtrC^ := PtrC^ + PtrD0^;
          PChar(PtrC) := PChar(PtrC) + SizeOf(Extended);
          PChar(PtrD0) := PChar(PtrD0) + SizeOf(Extended);
        end;
      end
      else begin
        // Пропускаем вектор из D0:
        PChar(PtrD0) := PChar(PtrD0) + N * SizeOf(Extended);
      end;
 
    // C := C / N
    PtrC := C;
    for J := 0 to N-1 do
    begin
      PtrC^ := PtrC^ / N;
      PChar(PtrC) := PChar(PtrC) + SizeOf(Extended);
    end;
  end;
end;
 
procedure ReflectPoint(var Temp: TNelderTempData; const Option: TNelderOption; P: PExtended; Factor: Extended);
var
  PtrC, PtrXN: PExtended;
  I: Integer;
begin
  with Temp, Option do
  begin
    PtrXN := XN;
    PtrC := C;
    for I := 0 to N-1 do
    begin
      P^ := PtrC^ + Factor * (PtrC^ - PtrXN^);
      PChar(P) := PChar(P) + SizeOf(Extended);
      PChar(PtrC) := PChar(PtrC) + SizeOf(Extended);
      PChar(PtrXN) := PChar(PtrXN) + SizeOf(Extended);
    end;
  end;
end;
 
const
  SITUATION_EXPANSION = 0;
  SITUATION_REFLECTION = 1;
  SITUATION_COMPRESSION = 2;
  SITUATION_REDUCTION = 3;
 
function DetectSituation(var Temp: TNelderTempData; const Option: TNelderOption): Integer;//FX, U: PExtended; Func: PMathFunction; N: Integer; FU: Extended): Integer;
var
  PtrFX: PEXtended;
begin
  with Temp, Option do
  begin
    FU := Func(Temp.U);
    if FU &lt; FX^ then
      Result := SITUATION_EXPANSION
    else begin
      PtrFX := PExtended(PChar(FX)+(N-1)*SizeOf(Extended));
      if FU &lt; PtrFX^ then
        Result := SITUATION_REFLECTION
      else begin
        PChar(PtrFX) := PChar(PtrFX) + SizeOf(Extended);
        if FU &lt; PtrFX^ then
          Result := SITUATION_COMPRESSION
        else
          Result := SITUATION_REDUCTION;
      end;
    end;
  end;
end;
 
procedure Expansion(var Temp: TNelderTempData;const Option: TNelderOption);
var
  FV: EXtended;
  LastIndex: Integer;
  TempPtr: PChar;
begin
  with Temp, Option do
  begin
 
    ReflectPoint(Temp, Option, V, Gamma);
    FV := Func(Temp.V);
 
    // Коррекция FX
    Move(FX^, (PChar(FX)+SizeOf(Extended))^, N*SizeOf(Extended));
 
    // Заносим на первое место
    if FV &lt; FU then
    begin
      FX^ := FV;
      Move(V^, XN^, N*SizeOf(EXtended));
    end
    else begin
      FX^ := FU;
      Move(U^, XN^, N*SizeOf(Extended));
    end;
 
    // Коррекция Indexes
    TempPtr := PChar(Indexes) + N*SizeOf(Integer);
    LastIndex := PInteger(TempPtr)^;
    Move(Indexes^, (PChar(Indexes)+SizeOf(Integer))^, N*SizeOf(Integer));
    Indexes^ := LastIndex;
 
    // Коррекция XN
    PChar(XN) := PChar(D0) + PInteger(TempPtr)^ * N * SizeOf(EXtended);
  end;
end;
 
// Рекурсивный бинарный поиск точки, где будет произведена вставка
// Интересно переделать в итерацию !!! (так оптимальней)
function RecurseFind(FX: PExtended; Value: Extended; L,R: Integer): Integer;
var
  M: Integer;
  Temp: Extended;
begin
  if R&lt;L then begin
    Result := L; // Result := -1 если поиск точный
    Exit;
  end;
  M := (L+R) div 2;
  Temp := PExtended(PChar(FX) + M*SizeOf(Extended))^;
  if Temp=Value then
  begin
    Result := M;
    Exit;
  end;
  if Temp&gt;Value
    then Result := RecurseFind(FX, Value, L, M-1)
    else Result := RecurseFind(FX, Value, M+1, R)
end;
 
procedure Reflection(var Temp: TNelderTempData;const Option: TNelderOption);
var
  InsertN: Integer;
  ShiftPosition: PChar;
  //IndexesPtr: PInteger;
  //FV: Extended;
  //I: Integer;
  TempIndex: Integer;
  TempPtr: PChar;
begin
  with Temp, Option do
  begin
    // Определения позиции вставки
    InsertN := RecurseFind(FX, FU, 0, N);
 
    // Сдвижка FX
    ShiftPosition := PChar(FX)+InsertN*SizeOf(Extended);
    Move(ShiftPosition^, (ShiftPosition+SizeOf(Extended))^,
      (N-InsertN)*SizeOf(Extended));
    PExtended(ShiftPosition)^ := FU;
 
    // Коррекция D0
    Move(U^, XN^, N*SizeOf(EXtended));
 
    // Коррекция Indexes
    TempPtr := PChar(Indexes)+N*SizeOf(Integer);
    TempIndex := PInteger(TempPtr)^;
    ShiftPosition := PChar(Indexes)+InsertN*SizeOf(Integer);
    Move(ShiftPosition^, (ShiftPosition+SizeOf(Integer))^,
      (N-InsertN)*SizeOf(Integer));
    PInteger(ShiftPosition)^ := TempIndex;
 
    // Коррекция XN
    PChar(XN) := PChar(D0) + N * PInteger(TempPtr)^ * SizeOf(EXtended);
  end;
end;
 
procedure Compression(var Temp: TNelderTempData;const Option: TNelderOption);
begin
  with Temp, Option do
  begin
    // Вычисление новой точки
    ReflectPoint(Temp, Option, U, Beta);
    FU := Func(U);
 
    Reflection(Temp, Option);
  end;
end;
 
procedure Reduction(var Temp: TNelderTempData;const Option: TNelderOption);
var
  ZeroPoint: PExtended;
  PtrD0, PtrFX: PExtended;
  PtrX0, PtrX: PExtended;
  FX0: EXtended;
  I, J: Integer;
begin
  with Temp, Option do
  begin
    PChar(ZeroPoint) := PChar(D0) + N*Indexes^*SizeOf(Extended);
    PtrD0 := D0;
    PtrFX := FX;
    FX0 := FX^;
 
    for I := 0 to N do
    begin
      if PtrD0 = ZeroPoint then
      begin
        // Точка пропускается
        PtrFX^ := FX0;
      end
      else begin
        // Вычисляем точку:
        PtrX := PtrD0;
        PtrX0 := ZeroPoint;
        for J := 0 to N-1 do
        begin
          PtrX^ := 0.5 * (PtrX^ + PtrX0^);
          PChar(PtrX) := PChar(PtrX) + SizeOf(Extended);
          PChar(PtrX0) := PChar(PtrX0) + SizeOf(Extended);
        end;
        // Вычисляем функцию
        PtrFX^ := Func(PtrD0);
      end;
      PChar(PtrFX) := PChar(PtrFX) + SizeOf(Extended);
      PChar(PtrD0) := PChar(PtrD0) + N*SizeOf(Extended);
    end;
  end;
 
  RefreshFX(Temp, Option);
end;
 
var
  It: Integer = 0;
function NeedStop(var Temp: TNelderTempData; const Option: TNelderOption): Boolean;
var
  PtrD0, PtrC, PtrFX: PExtended;
  Sum1, Sum2: Extended;
  I, J: Integer;
begin
  // Не все параметры используются...
  with Temp, Option do
  begin
    Sum1 := 0.0;
    if Delta &gt; 0.0 then
    begin
      FC := Func(C);
      PtrFX := FX;
      for I := 0 to N do
      begin
        Sum1 := Sum1 + Sqr(PtrFX^-FC);
        PChar(PtrFX) := PChar(PtrFX) + SizeOf(Extended)
      end;
      Sum1 := Delta * Sqrt(Sum1/(N+1));
    end;
 
    Sum2 := 0.0;
    if Delta &lt; 1.0 then
    begin
      PtrD0 := D0;
      for I := 0 to N do
      begin
        PtrC := C;
        for J := 0 to N-1 do
        begin
          Sum2 := Sum2 + Sqr(PtrD0^-PtrC^);
          PChar(PtrC) := PChar(PtrC) + SizeOf(Extended);
          PChar(PtrD0) := PChar(PtrD0) + SizeOf(Extended);
        end;
      end;
      Sum2 := (1.0-Delta) * Sqrt(Sum2/(N+1));
    end;
 
    Result := Sum1 + Sum2 &lt; Eps;
  end;
end;
 
procedure Correct(var Temp: TNelderTempData; Option: TNelderOption);
var
  S: Extended;
  PtrC: PEXtended;
  I: Integer;
begin
  with Temp, Option do
  begin
    S := (D1 + (N-1)*D2) /(N+1);
    PtrC := C;
    for I := 0 to N-1 do
    begin
      PtrC^ := PtrC^ - S;
      PChar(PtrC) := PChar(PtrC) + SizeOf(Extended);
    end;
    BuildSimplex(Temp, Option);
    MoveSimplex(Temp, Option, C);
  end;
end;
 
function Norm(X1, X2: PEXtended; N: Integer): Extended;
var
  I: Integer;
begin
  Result := 0.0;
  for I := 0 to N-1 do
  begin
    Result := Result + Sqr(X1^ - X2^);
    PChar(X1) := PChar(X1) + SizeOf(Extended);
    PChar(X2) := PChar(X2) + SizeOf(Extended);
  end;
  Result := Sqrt(Result);
end;
 
function SolutionNelder(const Option: TNelderOption): Integer;
var
  Temp: TNelderTempData;
  IsFirst: Boolean;
begin
  It := 0;
  IsFirst := True;
  Result := InitializeTempData(Temp, Option.N);
  if Result &lt;&gt; FIND_MIN_OK then Exit;
 
  try
    // Шаг №1: построение симплекса
    BuildSimplex(Temp, Option);
 
    // Шаг №2: перенос симплекса в точку X0
    MoveSimplex(Temp, Option, Option.X0);
 
    repeat
      // Шаг №3: вычисление значений функции (+ сортировка)
      CalcFX(Temp, Option);
 
      RefreshFX(Temp, Option);
 
      repeat
        // Шаг №4: вычисление центра тяжести без точки Indexes[N]
        CalcC(Temp, Option);
 
        // Шаг №5: Вычисление точки U
        ReflectPoint(Temp, Option, Temp.U, Option.Alpha);
 
        // Шаг №6: Определение ситуации
        Temp.FU := Option.Func(Temp.U);
        case DetectSituation(Temp, Option){Temp.FX, Temp.U, Option.Func, Option.N, Temp.FU)} of
          SITUATION_EXPANSION: // Растяжение
            Expansion(Temp, Option);
          SITUATION_REFLECTION:
            Reflection(Temp, Option); // Отражение
          SITUATION_COMPRESSION: // Сжатие
            Compression(Temp, Option);
          SITUATION_REDUCTION: // Редукция
            Reduction(Temp, Option);
          else Assert(False, 'Другое не предусматривается');
        end;
 
        // Шаг №7 критерий остановки
        if NeedStop(Temp, Option) then Break;
 
      until False;
 
      if not IsFirst then
      begin
        if Norm(Option.X, Temp.C, Option.N) &lt; Option.Eps then
        begin
          Move(Temp.C^, Option.X^, Option.N*SizeOf(Extended));
          Break;
        end;
      end;
 
      IsFirst := False;
      Move(Temp.C^, Option.X^, Option.N*SizeOf(Extended));
 
      case Option.Mode of
        FIND_MIN_MODE_STD: Break;
        FIND_MIN_MODE_1: Correct(Temp, Option);
        FIND_MIN_MODE_2:
          begin
            BuildSimplex(Temp, Option);
            MoveSimplex(Temp, Option, Temp.C);
          end;
      end;
 
    until False;
 
    Result := FIND_MIN_OK;
 
  finally
    FinalizeTempData(Temp);
  end;
end;
 
function FindMin_Nelder(const Option: TNelderOption): Integer;
var
  UseOption: TNelderOption;
begin
  try
    Result := CheckNelderOptionPtr(@Option);
    if Result &lt;&gt; FIND_MIN_OK then Exit;
 
    Result := CopyData(Option, UseOption);
    if Result &lt;&gt; FIND_MIN_OK then Exit;
 
    Result := SolutionNelder(UseOption);
  finally
  end;
 
end;
</pre>

