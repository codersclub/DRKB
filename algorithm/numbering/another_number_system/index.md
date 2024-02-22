---
Title: Как представить число в другой системе счисления?
Date: 01.01.2007
---


Как представить число в другой системе счисления?
=================================================

Вариант 1.

    function BaseConvert(NumIn: string; BaseIn: Byte; BaseOut: Byte): string; 
    var 
      i: integer; 
      currentCharacter: char; 
      CharacterValue: Integer; 
      PlaceValue: Integer; 
      RunningTotal: Double; 
      Remainder: Double; 
      BaseOutDouble: Double; 
      NumInCaps: string; 
      s: string; 
    begin 
      if (NumIn = '') or (BaseIn < 2) or (BaseIn > 36) or (BaseOut < 1) or (BaseOut > 36) then 
      begin 
        Result := 'Error'; 
        Exit; 
      end; 
     
      NumInCaps    := UpperCase(NumIn); 
      PlaceValue   := Length(NumInCaps); 
      RunningTotal := 0; 
     
      for i := 1 to Length(NumInCaps) do 
      begin 
        PlaceValue       := PlaceValue - 1; 
        CurrentCharacter := NumInCaps[i]; 
        CharacterValue   := 0; 
        if (Ord(CurrentCharacter) > 64) and (Ord(CurrentCharacter) < 91) then 
          CharacterValue := Ord(CurrentCharacter) - 55; 
     
        if CharacterValue = 0 then 
          if (Ord(CurrentCharacter) < 48) or (Ord(CurrentCharacter) > 57) then 
          begin 
            BaseConvert := 'Error'; 
            Exit; 
          end  
          else 
            CharacterValue := Ord(CurrentCharacter); 
     
        if (CharacterValue < 0) or (CharacterValue > BaseIn - 1) then 
        begin 
          BaseConvert := 'Error'; 
          Exit; 
        end; 
        RunningTotal := RunningTotal + CharacterValue * (Power(BaseIn, PlaceValue)); 
      end; 
     
      while RunningTotal > 0 do  
      begin 
        BaseOutDouble := BaseOut; 
        Remainder     := RunningTotal - (int(RunningTotal / BaseOutDouble) * BaseOutDouble); 
        RunningTotal  := (RunningTotal - Remainder) / BaseOut; 
     
        if Remainder >= 10 then 
          CurrentCharacter := Chr(Trunc(Remainder + 55)) 
        else 
        begin 
          s := IntToStr(trunc(remainder)); 
          CurrentCharacter := s[Length(s)]; 
        end; 
        Result := CurrentCharacter + Result; 
      end; 
    end; 
     
    // Example, Beispiel 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      BaseConvert('FFFF', 16, 10); 
      // returns, ergibt '65535'. 
    end; 

Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>

------------------------------------------------------------------------

Вариант 2.

Решение от Борланд:

The following function will convert a number from one base to
a number of another base:

    procedure RadixStr(NumStr : pChar;
                       Radix : LongInt;
                       ResultStr : pChar;
                       NewRadix : LongInt;
                       var ErrorCode : LongInt);

The RadixStr() function takes a pointer to a null terminated string
containing a number of one base, and fills a buffer with a null
terminated string containing the number converted to another base.

Parameters:

- NumStr: A pointer to a null terminated string containing the numeric
string to convert:

- Radix: The base of the number contained in the NumStr parameter. The
base must be in the range of 2 to 36;

- ResultStr : A pointer to a null terminated string buffer to place the
resulting numeric string. The buffer should be sufficiently large to
hold the resulting string.

- NewRadix: The base to use in the conversion. The base must be in the
range of 2 to 36;

- ErrorCode: Upon return, contains  the return code 0 if successful, or
the character number of the offending character contained in the
buffer NumStr.

Examples of calling the RadixStr() function:

```
{Convert Hex to Decimal}
RadixStr('FF',
        16,
        lpBuffer,
        10,
        Code);
```

Should return the string \'255\' in lpbuffer^.

```
{Convert Decimal to Binary}
RadixStr('255',
        10,
        lpBuffer,
        2,
        Code);
```

Should return the string \'11111111\' in lpbuffer^.

```
{Convert Hex to Octal}
RadixStr('FF',
        16,
        lpBuffer,
        8,
        Code);
```

Should return the string \'377\' in lpbuffer^.

    {Function code}
    procedure RadixStr(NumStr : pChar;
                       Radix : LongInt;
                       ResultStr : pChar;
                       NewRadix : LongInt;
                       var ErrorCode : LongInt);
    var
      RadixChar : array[0..35] of Char;
      v : LongInt;
      i : LongInt;
      p : LongInt;
      c : Integer;
    begin
      if ((Abs(Radix) < 2) or
          (Abs(Radix) > 36)) then begin
        ErrorCode := p;
        Exit;
      end;
      StrLCopy(ResultStr, NumStr, StrLen(NumStr));
      for i := 0 to 35 do begin
        if i <= 9 then
          RadixChar[i] := Char(48 + (i))
        else
          RadixChar[i] := Char(64 + (i - 9))
      end;
      v := 0;
      for i := 0 to (StrLen(ResultStr) - 1) do begin
        ResultStr[i] := UpCase(ResultStr[i]);
        p := Pos(ResultStr[i], PChar(@RadixChar)) - 1;
        if ((p < 0) or
            (p >= Abs(Radix))) then begin
          ErrorCode := i;
          Exit;
        end;
        v := v * Abs(Radix) + p;
      end;
      if v = 0 then begin
        ResultStr := '0';
        ErrorCode := 0;
        exit;
      end else begin
        i:=0;
        repeat
          ResultStr[i] := RadixChar[v mod NewRadix];
          v := v div NewRadix;
          Inc(i)
        until v = 0;
        if Radix < 0 then begin
          ResultStr[i] := '-';
          ResultStr[i + 1] := #0
        end else
          ResultStr[i] := #0;
        p := StrLen(ResultStr);
        for i := 0 to ((p div 2) - 1) do begin
          ResultStr[i] := Char(Byte(ResultStr[i]) xor
                               Byte(ResultStr[(p - i) - 1]));
          ResultStr[(p - i) - 1] := Char(Byte(ResultStr[(p - i) - 1]) xor
                                         Byte(ResultStr[i]));
          ResultStr[i] := Char(Byte(ResultStr[i]) xor
                               Byte(ResultStr[(p - i) - 1]))
        end;
        ResultStr[p] := #0;
        ErrorCode := 0;
      end;
    end;
