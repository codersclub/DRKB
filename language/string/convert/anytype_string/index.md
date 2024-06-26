---
Title: Как преобразовать значение любого типа в строку?
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Как преобразовать значение любого типа в строку?
================================================

Более подробно ищите в хелпе Delphi по словам "Variant" и "TVarData"...

     
    function ToString(Value: Variant): String;
    begin
      case TVarData(Value).VType of
        varSmallInt,
        varInteger   : Result := IntToStr(Value);
        varSingle,
        varDouble,
        varCurrency  : Result := FloatToStr(Value);
        varDate      : Result := FormatDateTime('dd/mm/yyyy', Value);
        varBoolean   : if Value then Result := 'T' else Result := 'F';
        varString    : Result := Value;
        else            Result := '';
      end;
    end;

Использование:

    ShowMessage(ToString(10.87));
    ShowMessage(ToString(10));

или

    var
      V1 : Double;
      V2 : Integer;
      V3 : TDateTime;
      V4 : Boolean;
     
    begin
      ...
     
      ShowMessage(ToString(V1));  // Double a String
      ShowMessage(ToString(V2));  // Integer a String
      ShowMessage(ToString(V3));  // DateTime a String
      ShowMessage(ToString(V4));  // Boolean a String
    end;
     

Так же можно пользоваться другими вариантами, например:

    varCurrency : Result := CurrToStrF(Value,ffFixed,CurrencyDecimals);

и

    varDate: Result := DateToStr(Value);


