---
Title: Использование PHP-like операций с массивами
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Использование PHP-like операций с массивами
===========================================

Ниже представлены функции explode(), implode(), sort(), rsort()

    //Some Array-functions like in PHP.
     
    type
     
      ArrOfStr = array of string;
     
    implementation
     
    function explode(sPart, sInput: string): ArrOfStr;
    begin
      while Pos(sPart, sInput) <> 0 do 
      begin
        SetLength(Result, Length(Result) + 1);
        Result[Length(Result) - 1] := Copy(sInput, 0,Pos(sPart, sInput) - 1);
        Delete(sInput, 1,Pos(sPart, sInput));
      end;
      SetLength(Result, Length(Result) + 1);
      Result[Length(Result) - 1] := sInput;
    end;
     
    function implode(sPart: string; arrInp: ArrOfStr): string;
    var 
      i: Integer;
    begin
      if Length(arrInp) <= 1 then Result := arrInp[0]
      else 
      begin
        for i := 0 to Length(arrInp) - 2 do Result := Result + arrInp[i] + sPart;
        Result := Result + arrInp[Length(arrInp) - 1];
      end;
    end;
     
    procedure sort(arrInp: ArrOfStr);
    var 
      slTmp: TStringList; 
      i: Integer;
    begin
      slTmp := TStringList.Create;
      for i := 0 to Length(arrInp) - 1 do slTmp.Add(arrInp[i]);
      slTmp.Sort;
      for i := 0 to slTmp.Count - 1 do arrInp[i] := slTmp[i];
      slTmp.Free;
    end;
     
    procedure rsort(arrInp: ArrOfStr);
    var 
      slTmp: TStringList; 
      i: Integer;
    begin
      slTmp := TStringList.Create;
      for i := 0 to Length(arrInp) - 1 do slTmp.Add(arrInp[i]);
      slTmp.Sort;
      for i := 0 to slTmp.Count - 1 do arrInp[slTmp.Count - 1 - i] := slTmp[i];
      slTmp.Free;
    end;

