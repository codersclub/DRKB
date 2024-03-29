---
Title: Огромные числа
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Огромные числа
==============

Данный модуль использует массив байт для предоставления БОЛЬШИХ чисел.
Бинарно-хранимые числа заключены в массив, где первый элемент является
Наименьшим Значимым Байтом (Least Significant Byte - LSB), последний -
Наибольшим Значимым Байтом (Most Significant Byte - MSB), подобно всем
Intel-целочисленным типам.

Арифметика здесь использует не 10- или 2-тиричную, а 256-тиричную
систему исчисления, чтобы каждый байт представлял одну (1) цифру.

Числа HugeInttype - Подписанные Числа (Signed Numbers).

При компиляции с директивой R+, ADD и MUL могут в определенных
обстоятельствах генерировать "Arithmetic Overflow Error"
(RunError(215)) - ошибка арифметического переполнения. В таком случае
пользуйтесь переменной "HugeIntCarry".

Переменная "HugeIntDiv0" используется для проверки деления на ноль.

Используйте {$DEFINE HugeInt\_xx } или поле "Conditional defines"
(символ условного компилирования) в "Compiler options" (опции
компилятора) для задания размерности, где xx должно быть равно 64, 32
или 16, в противном случае HugeIntSize будет равен 8 байтам.

    unit HugeInts;
    interface
     
    const
    {$IFDEF HugeInt_64 }
     
      HugeIntSize = 64;
     
    {$ELSE}{$IFDEF HugeInt_32 }
     
      HugeIntSize = 32;
    {$ELSE}{$IFDEF HugeInt_16 }
     
      HugeIntSize = 16;
    {$ELSE}
     
      HugeIntSize = 8;
    {$ENDIF}{$ENDIF}{$ENDIF}
     
      HugeIntMSB = HugeIntSize - 1;
     
    type
     
      HugeInt = array[0..HugeIntMSB] of Byte;
     
    const
     
      HugeIntCarry: Boolean = False;
      HugeIntDiv0: Boolean = False;
     
    procedure HugeInt_Min(var a: HugeInt); { a := -a }
    procedure HugeInt_Inc(var a: HugeInt); { a := a + 1 }
    procedure HugeInt_Dec(var a: HugeInt); { a := a - 1 }
     
    procedure HugeInt_Add(a, b: HugeInt; var R: HugeInt); { R := a + b }
    procedure HugeInt_Sub(a, b: HugeInt; var R: HugeInt); { R := a - b }
    procedure HugeInt_Mul(a, b: HugeInt; var R: HugeInt); { R := a * b }
    procedure HugeInt_Div(a, b: HugeInt; var R: HugeInt); { R := a div b }
    procedure HugeInt_Mod(a, b: HugeInt; var R: HugeInt); { R := a mod b }
     
    function HugeInt_IsNeg(a: HugeInt): Boolean;
    function HugeInt_Zero(a: HugeInt): Boolean;
    function HugeInt_Odd(a: HugeInt): Boolean;
     
    function HugeInt_Comp(a, b: HugeInt): Integer; {-1:a< 0; 1:a>}
    procedure HugeInt_Copy(Src: HugeInt; var Dest: HugeInt); { Dest := Src }
     
    procedure String2HugeInt(AString: string; var a: HugeInt);
    procedure Integer2HugeInt(AInteger: Integer; var a: HugeInt);
    procedure HugeInt2String(a: HugeInt; var S: string);
     
    implementation
     
    procedure HugeInt_Copy(Src: HugeInt; var Dest: HugeInt);
    { Dest := Src }
    begin
     
      Move(Src, Dest, SizeOf(HugeInt));
    end; { HugeInt_Copy }
     
    function HugeInt_IsNeg(a: HugeInt): Boolean;
    begin
     
      HugeInt_IsNeg := a[HugeIntMSB] and $80 > 0;
    end; { HugeInt_IsNeg }
     
    function HugeInt_Zero(a: HugeInt): Boolean;
    var
      i: Integer;
    begin
     
      HugeInt_Zero := False;
      for i := 0 to HugeIntMSB do
        if a[i] <> 0 then
          Exit;
      HugeInt_Zero := True;
    end; { HugeInt_Zero }
     
    function HugeInt_Odd(a: HugeInt): Boolean;
    begin
     
      HugeInt_Odd := a[0] and 1 > 0;
    end; { HugeInt_Odd }
     
    function HugeInt_HCD(a: HugeInt): Integer;
    var
      i: Integer;
    begin
     
      i := HugeIntMSB;
      while (i > 0) and (a[i] = 0) do
        Dec(i);
      HugeInt_HCD := i;
    end; { HugeInt_HCD }
     
    procedure HugeInt_SHL(var a: HugeInt; Digits: Integer);
    { Перемещение байтов переменной "Digits" в левую часть,
     
    байты "Digits" будут 'ослабевать' в MSB-части.
    LSB-часть заполняется нулями. }
    var
      t: Integer;
      b: HugeInt;
    begin
     
      if Digits > HugeIntMSB then
        FillChar(a, SizeOf(HugeInt), 0)
      else if Digits > 0 then
      begin
        Move(a[0], a[Digits], HugeIntSize - Digits);
        FillChar(a[0], Digits, 0);
      end; { else if }
    end; { HugeInt_SHL }
     
    procedure HugeInt_SHR(var a: HugeInt; Digits: Integer);
    var
      t: Integer;
    begin
     
      if Digits > HugeIntMSB then
        FillChar(a, SizeOf(HugeInt), 0)
      else if Digits > 0 then
      begin
        Move(a[Digits], a[0], HugeIntSize - Digits);
        FillChar(a[HugeIntSize - Digits], Digits, 0);
      end; { else if }
    end; { HugeInt_SHR }
     
    procedure HugeInt_Inc(var a: HugeInt);
    { a := a + 1 }
    var
     
      i: Integer;
      h: Word;
    begin
     
      i := 0;
      h := 1;
      repeat
        h := h + a[i];
        a[i] := Lo(h);
        h := Hi(h);
        Inc(i);
      until (i > HugeIntMSB) or (h = 0);
      HugeIntCarry := h > 0;
    {$IFOPT R+ }
      if HugeIntCarry then
        RunError(215);
    {$ENDIF}
    end; { HugeInt_Inc }
     
    procedure HugeInt_Dec(var a: HugeInt);
    { a := a - 1 }
    var
      Minus_1: HugeInt;
    begin
     
      { самый простой способ }
      FillChar(Minus_1, SizeOf(HugeInt), $FF); { -1 }
      HugeInt_Add(a, Minus_1, a);
    end; { HugeInt_Dec }
     
    procedure HugeInt_Min(var a: HugeInt);
    { a := -a }
    var
      i: Integer;
    begin
     
      for i := 0 to HugeIntMSB do
        a[i] := not a[i];
      HugeInt_Inc(a);
    end; { HugeInt_Min }
     
    function HugeInt_Comp(a, b: HugeInt): Integer;
    { a = b: ==0; a > b: ==1; a < b: ==-1 }
    var
     
      A_IsNeg, B_IsNeg: Boolean;
      i: Integer;
    begin
     
      A_IsNeg := HugeInt_IsNeg(a);
      B_IsNeg := HugeInt_IsNeg(b);
      if A_IsNeg xor B_IsNeg then
        if A_IsNeg then
          HugeInt_Comp := -1
        else
          HugeInt_Comp := 1
      else
      begin
        if A_IsNeg then
          HugeInt_Min(a);
        if B_IsNeg then
          HugeInt_Min(b);
        i := HugeIntMSB;
        while (i > 0) and (a[i] = b[i]) do
          Dec(i);
        if A_IsNeg then { оба отрицательные! }
          if a[i] > b[i] then
            HugeInt_Comp := -1
          else if a[i] < b[i] then
            HugeInt_Comp := 1
          else
            HugeInt_Comp := 0
        else { оба положительные } if a[i] > b[i] then
            HugeInt_Comp := 1
          else if a[i] < b[i] then
            HugeInt_Comp := -1
          else
            HugeInt_Comp := 0;
      end; { else }
    end; { HugeInt_Comp }
     
    procedure HugeInt_Add(a, b: HugeInt; var R: HugeInt);
    { R := a + b }
    var
     
      i: Integer;
      h: Word;
    begin
     
      h := 0;
      for i := 0 to HugeIntMSB do
      begin
        h := h + a[i] + b[i];
        R[i] := Lo(h);
        h := Hi(h);
      end; { for }
      HugeIntCarry := h > 0;
    {$IFOPT R+ }
      if HugeIntCarry then
        RunError(215);
    {$ENDIF}
    end; { HugeInt_Add }
     
    procedure HugeInt_Sub(a, b: HugeInt; var R: HugeInt);
    { R := a - b }
    var
     
      i: Integer;
      h: Word;
    begin
     
      HugeInt_Min(b);
      HugeInt_Add(a, b, R);
    end; { HugeInt_Sub }
     
    procedure HugeInt_Mul(a, b: HugeInt; var R: HugeInt);
    { R := a * b }
    var
     
      i, j, k: Integer;
      A_end, B_end: Integer;
      A_IsNeg, B_IsNeg: Boolean;
      h: Word;
    begin
     
      A_IsNeg := HugeInt_IsNeg(a);
      B_IsNeg := HugeInt_IsNeg(b);
      if A_IsNeg then
        HugeInt_Min(a);
      if B_IsNeg then
        HugeInt_Min(b);
      A_End := HugeInt_HCD(a);
      B_End := HugeInt_HCD(b);
      FillChar(R, SizeOf(R), 0);
      HugeIntCarry := False;
      for i := 0 to A_end do
      begin
        h := 0;
        for j := 0 to B_end do
          if (i + j) < HugeIntSize then
          begin
            h := h + R[i + j] + a[i] * b[j];
            R[i + j] := Lo(h);
            h := Hi(h);
          end; { if }
        k := i + B_End + 1;
        while (k < HugeIntSize) and (h > 0) do
        begin
          h := h + R[k];
          R[k] := Lo(h);
          h := Hi(h);
          Inc(k);
        end; { while }
        HugeIntCarry := h > 0;
    {$IFOPT R+}
        if HugeIntCarry then
          RunError(215);
    {$ENDIF}
      end; { for }
      { если все хорошо... }
      if A_IsNeg xor B_IsNeg then
        HugeInt_Min(R);
    end; { HugeInt_Mul }
     
    procedure HugeInt_DivMod(var a: HugeInt; b: HugeInt; var R: HugeInt);
    { R := a div b  a := a mod b }
    var
     
      MaxShifts, s, q: Integer;
      d, e: HugeInt;
      A_IsNeg, B_IsNeg: Boolean;
    begin
     
      if HugeInt_Zero(b) then
      begin
        HugeIntDiv0 := True;
        Exit;
      end { if }
      else
        HugeIntDiv0 := False;
      A_IsNeg := HugeInt_IsNeg(a);
      B_IsNeg := HugeInt_IsNeg(b);
      if A_IsNeg then
        HugeInt_Min(a);
      if B_IsNeg then
        HugeInt_Min(b);
      if HugeInt_Comp(a, b) < 0 then
        { a<b; нет необходимости деления }
        FillChar(R, SizeOf(R), 0)
      else
      begin
        FillChar(R, SizeOf(R), 0);
        repeat
          Move(b, d, SizeOf(HugeInt));
          { сначала вычисляем количество перемещений (сдвигов) }
          MaxShifts := HugeInt_HCD(a) - HugeInt_HCD(b);
          s := 0;
          while (s <= MaxShifts) and (HugeInt_Comp(a, d) >= 0) do
          begin
            Inc(s);
            HugeInt_SHL(d, 1);
          end; { while }
          Dec(s);
          { Создаем новую копию b }
          Move(b, d, SizeOf(HugeInt));
          { Перемещаем (сдвигаем) d }
          HugeInt_ShL(d, S);
          { Для добавление используем e = -d, это быстрее чем вычитание d }
          Move(d, e, SizeOf(HugeInt));
          HugeInt_Min(e);
          Q := 0;
          { пока a >= d вычисляем a := a+-d и приращиваем Q}
          while HugeInt_Comp(a, d) >= 0 do
          begin
            HugeInt_Add(a, e, a);
            Inc(Q);
          end; { while }
          { Упс!, слишком много вычитаний; коррекция }
          if HugeInt_IsNeg(a) then
          begin
            HugeInt_Add(a, d, a);
            Dec(Q);
          end; { if }
          HugeInt_SHL(R, 1);
          R[0] := Q;
        until HugeInt_Comp(a, b) < 0;
        if A_IsNeg xor B_IsNeg then
          HugeInt_Min(R);
      end; { else }
    end; { HugeInt_Div }
     
    procedure HugeInt_DivMod100(var a: HugeInt; var R: Integer);
    { 256-тиричное деление - работает только с
     
    положительными числами: R := a mod 100; a:= a div 100; }
    var
     
      Q: HugeInt;
      S: Integer;
    begin
     
      R := 0;
      FillChar(Q, SizeOf(Q), 0);
      S := HugeInt_HCD(a);
      repeat
        r := 256 * R + a[S];
        HugeInt_SHL(Q, 1);
        Q[0] := R div 100;
        R := R mod 100;
        Dec(S);
      until S < 0;
      Move(Q, a, SizeOf(Q));
    end; { HugeInt_DivMod100 }
     
    procedure HugeInt_Div(a, b: HugeInt; var R: HugeInt);
    begin
     
      HugeInt_DivMod(a, b, R);
    end; { HugeInt_Div }
     
    procedure HugeInt_Mod(a, b: HugeInt; var R: HugeInt);
    begin
     
      HugeInt_DivMod(a, b, R);
      Move(a, R, SizeOf(HugeInt));
    end; { HugeInt_Mod }
     
    procedure HugeInt2String(a: HugeInt; var S: string);
     
      function Str100(i: Integer): string;
      begin
        Str100 := Chr(i div 10 + Ord('0')) + Chr(i mod 10 + Ord('0'));
      end; { Str100 }
    var
     
      R: Integer;
      Is_Neg: Boolean;
    begin
     
      S := '';
      Is_Neg := HugeInt_IsNeg(a);
      if Is_Neg then
        HugeInt_Min(a);
      repeat
        HugeInt_DivMod100(a, R);
        Insert(Str100(R), S, 1);
      until HugeInt_Zero(a) or (Length(S) = 254);
      while (Length(S) > 1) and (S[1] = '0') do
        Delete(S, 1, 1);
      if Is_Neg then
        Insert('-', S, 1);
    end; { HugeInt2String }
     
    procedure String_DivMod256(var S: string; var R: Integer);
    { 10(00)-тиричное деление - работает только с
     
    положительными числами: R := S mod 256; S := S div 256 }
    var
      Q: string;
    begin
     
      FillChar(Q, SizeOf(Q), 0);
      R := 0;
      while S <> '' do
      begin
        R := 10 * R + Ord(S[1]) - Ord('0');
        Delete(S, 1, 1);
        Q := Q + Chr(R div 256 + Ord('0'));
        R := R mod 256;
      end; { while }
      while (Q <> '') and (Q[1] = '0') do
        Delete(Q, 1, 1);
      S := Q;
    end; { String_DivMod256 }
     
    procedure String2HugeInt(AString: string; var a: HugeInt);
    var
     
      i, h: Integer;
      Is_Neg: Boolean;
    begin
     
      if AString = '' then
        AString := '0';
      Is_Neg := AString[1] = '-';
      if Is_Neg then
        Delete(Astring, 1, 1);
      i := 0;
      while (AString <> '') and (i <= HugeIntMSB) do
      begin
        String_DivMod256(AString, h);
        a[i] := h;
        Inc(i);
      end; { while }
      if Is_Neg then
        HugeInt_Min(a);
    end; { String2HugeInt }
     
    procedure Integer2HugeInt(AInteger: Integer; var a: HugeInt);
    var
      Is_Neg: Boolean;
    begin
     
      Is_Neg := AInteger < 0;
      if Is_Neg then
        AInteger := -AInteger;
      FillChar(a, SizeOf(HugeInt), 0);
      Move(AInteger, a, SizeOf(Integer));
      if Is_Neg then
        HugeInt_Min(a);
    end; { Integer2HugeInt }
     
    end.

