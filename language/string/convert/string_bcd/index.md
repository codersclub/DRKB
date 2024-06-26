---
Title: String -> BCD
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


String -> BCD
=============

    function NumStringToBCD(const inStr: string): string;
      function Pack(ch1, ch2: Char): Char;
      begin
        Assert((ch1 >= '0') and (ch1 <= '9'));
        Assert((ch2 >= '0') and (ch2 <= '9'));
          {Ord('0') is $30, so we can just use the low nybble of the character
           as value.}
        Result := Chr((Ord(ch1) and $F) or ((Ord(ch2) and $F) shl 4))
      end;
    var
      i: Integer;
    begin
      if Odd(Length(inStr)) then
        Result := NumStringToBCD('0' + instr)
      else begin
        SetLength(Result, Length(inStr) div 2);
        for i := 1 to Length(Result) do
          Result[i] := Pack(inStr[2 * i - 1], inStr[2 * i]);
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      S1, S2: string;
    begin
      S1 := '15151515151515151515';
      S2 := NumStringToBCD(S1);
      memo1.lines.add('S1: ' + S1);
      memo1.lines.add('Length(S2): ' + IntToStr(Length(S2)));
      memo1.lines.add('S2 unpacked again: ' + BCDToNumString(S2));
    end;

