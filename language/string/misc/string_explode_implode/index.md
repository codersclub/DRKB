---
Title: Explode / Implode a string
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Explode / Implode a string
==========================

Вариант 1:

    type
      TStrArray = array of string;
     
    function Explode(var a: TStrArray; Border, S: string): Integer;
    var
      S2: string;
    begin
      Result  := 0;
      S2 := S + Border;
      repeat
        SetLength(A, Length(A) + 1);
        a[Result] := Copy(S2, 0,Pos(Border, S2) - 1);
        Delete(S2, 1,Length(a[Result] + Border));
        Inc(Result);
      until S2 = '';
    end;

How to use it:

    procedure TForm1.Button1Click(Sender: TObject);
    var
      S: string;
      A: TStrArray;
      AnzTokens, i: Integer;
    begin
      S := 'Ein=Text=durch=Geleichzeichen=getrennt';
      AnzTokens := Explode(A, '=', S);
      for i := 0 to AnzTokens -1 do
        Memo1.Lines.Add(A[i]);
    end;

---------------------------------

Вариант 2:

    {
      * These 2 functions are from the programming language PHP, unite certainly well-known.
      * Now one can use it also in Delphi:)
    }
     
    {...}
     
    //* Needed type declaration
    type
      TExplodeArray = array of String;
     
    {...}
     
    function Implode(const cSeparator: String; const cArray: TExplodeArray): String;
    var
      i: Integer;
    begin
      Result := '';
      for i := 0 to Length(cArray) -1 do begin
        Result := Result + cSeparator + cArray[i];
      end;
      System.Delete(Result, 1, Length(cSeparator));
    end;
     
    function Explode(const cSeparator, vString: String): TExplodeArray;
    var
      i: Integer;
      S: String;
    begin
      S := vString;
      SetLength(Result, 0);
      i := 0;
      while Pos(cSeparator, S) > 0 do begin
        SetLength(Result, Length(Result) +1);
        Result[i] := Copy(S, 1, Pos(cSeparator, S) -1);
        Inc(i);
        S := Copy(S, Pos(cSeparator, S) + Length(cSeparator), Length(S));
      end;
      SetLength(Result, Length(Result) +1);
      Result[i] := Copy(S, 1, Length(S));
    end;

