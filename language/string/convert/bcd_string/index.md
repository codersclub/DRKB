---
Title: BCD -> String
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


BCD -> String
=============


    function BCDToNumString(const inStr: string): string;
      procedure UnPack(ch: Char; var ch1, ch2: Char);
      begin
        ch1 := Chr((Ord(ch) and $F) + $30);
        ch2 := Chr(((Ord(ch) shr 4) and $F) + $30);
        Assert((ch1 >= '0') and (ch1 <= '9'));
        Assert((ch2 >= '0') and (ch2 <= '9'));
      end;
    var
      i: Integer;
    begin
      SetLength(Result, Length(inStr) * 2);
      for i := 1 to Length(inStr) do
        UnPack(inStr[i], Result[2 * i - 1], Result[2 * i]);
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

