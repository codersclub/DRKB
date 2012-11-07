<h1>Как представить число в другой системе счисления?</h1>
<div class="date">01.01.2007</div>


<pre>
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
  if (NumIn = '') or (BaseIn &lt; 2) or (BaseIn &gt; 36) or (BaseOut &lt; 1) or (BaseOut &gt; 36) then 
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
    if (Ord(CurrentCharacter) &gt; 64) and (Ord(CurrentCharacter) &lt; 91) then 
      CharacterValue := Ord(CurrentCharacter) - 55; 
 
    if CharacterValue = 0 then 
      if (Ord(CurrentCharacter) &lt; 48) or (Ord(CurrentCharacter) &gt; 57) then 
      begin 
        BaseConvert := 'Error'; 
        Exit; 
      end  
      else 
        CharacterValue := Ord(CurrentCharacter); 
 
    if (CharacterValue &lt; 0) or (CharacterValue &gt; BaseIn - 1) then 
    begin 
      BaseConvert := 'Error'; 
      Exit; 
    end; 
    RunningTotal := RunningTotal + CharacterValue * (Power(BaseIn, PlaceValue)); 
  end; 
 
  while RunningTotal &gt; 0 do  
  begin 
    BaseOutDouble := BaseOut; 
    Remainder     := RunningTotal - (int(RunningTotal / BaseOutDouble) * BaseOutDouble); 
    RunningTotal  := (RunningTotal - Remainder) / BaseOut; 
 
    if Remainder &gt;= 10 then 
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
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
<hr /><p>Решение от Борланд:</p>
<p>The following function will convert a number from one base to</p>
<p>a number of another base:</p>
<p>procedure RadixStr(NumStr : pChar;</p>
<p>                   Radix : LongInt;</p>
<p>                   ResultStr : pChar;</p>
<p>                   NewRadix : LongInt;</p>
<p>                   var ErrorCode : LongInt);</p>
<p>The RadixStr() function takes a pointer to a null terminated string</p>
<p>containing a number of one base, and fills a buffer with a null</p>
<p>terminated string containing the number converted to another base.</p>
<p>Parameters:</p>
<p>NumStr: A pointer to a null terminated string containing the numeric</p>
<p>string to convert:</p>
<p>Radix: The base of the number contained in the NumStr parameter. The</p>
<p>base must be in the range of 2 to 36;</p>
<p>ResultStr : A pointer to a null terminated string buffer to place the</p>
<p>resulting numeric string. The buffer should be sufficiently large to</p>
<p>hold the resulting string.</p>
<p>NewRadix: The base to use in the conversion. The base must be in the</p>
<p>range of 2 to 36;</p>
<p>ErrorCode: Upon return, contains  the return code 0 if successful, or</p>
<p>the character number of the offending character contained in the</p>
<p>buffer NumStr.</p>
<p>Examples of calling the RadixStr() function:</p>
<p>{Convert Hex to Decimal}</p>
<p>RadixStr('FF',</p>
<p>         16,</p>
<p>         lpBuffer,</p>
<p>         10,</p>
<p>         Code);</p>
<p>Should return the string '255' in lpbuffer^.</p>
<p>{Convert Decimal to Binary}</p>
<p>RadixStr('255',</p>
<p>         10,</p>
<p>         lpBuffer,</p>
<p>         2,</p>
<p>         Code);</p>
<p>Should return the string '11111111' in lpbuffer^.</p>
<p>{Convert Hex to Octal}</p>
<p>RadixStr('FF',</p>
<p>         16,</p>
<p>         lpBuffer,</p>
<p>         8,</p>
<p>         Code);</p>
<p>Should return the string '377' in lpbuffer^.</p>
<pre>
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
  if ((Abs(Radix) &lt; 2) or
      (Abs(Radix) &gt; 36)) then begin
    ErrorCode := p;
    Exit;
  end;
  StrLCopy(ResultStr, NumStr, StrLen(NumStr));
  for i := 0 to 35 do begin
    if i &lt;= 9 then
      RadixChar[i] := Char(48 + (i))
    else
      RadixChar[i] := Char(64 + (i - 9))
  end;
  v := 0;
  for i := 0 to (StrLen(ResultStr) - 1) do begin
    ResultStr[i] := UpCase(ResultStr[i]);
    p := Pos(ResultStr[i], PChar(@RadixChar)) - 1;
    if ((p &lt; 0) or
        (p &gt;= Abs(Radix))) then begin
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
    if Radix &lt; 0 then begin
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
</pre>

