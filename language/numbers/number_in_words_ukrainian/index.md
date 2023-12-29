---
Title: Число украинской строкой
Date: 01.01.2007
---


Число украинской строкой
========================

::: {.date}
01.01.2007
:::

    unit UkrRecog;
    {копирайт непомню чей. Был для русских циферок, а я переделал под
    украинские}
    {если кто что найдет пришлите
     
    }
    {by Andrew Tkachenko, proektwo@netcity.ru, Ukraine,
     
    }
    interface
     
    const
     
      UkrMonthString: array[1..12] of string[9] = (
        'січня', 'лютого', 'березня', 'квiтня', 'травня',
        'червня', 'липня', 'серпня', 'вересня', 'жовтня',
        'листопада', 'грудня');
     
    function UkrRecognizeAmount(Amount: real;
      CurrName, CurrSubname: string): string;
     
    implementation
    uses Sysutils;
     
    function UkrRecognizeAmount(Amount: real;
      CurrName, CurrSubname: string): string;
    {* CurrName in [грн.]
     
    CurrSubName in [коп.]
    Распознается число <= 999 999 999 999.99*}
    const suffBL: string = ' ';
     
      suffDCT: string = 'дцять';
      suffNA: string = 'надцять ';
      suffDCM: string = 'десят';
      suffMZ: string = 'ь';
      sot: string = 'сот';
      st: string = 'ст';
      aa: string = 'а';
      ee: string = 'и'; {e}
      ii: string = 'і'; {и}
      oo: string = 'о';
      ov: string = 'ів'; {ов}
      C2: string = 'дв';
      C3: string = 'тpи';
      C4: string = 'чотир';
      C5: string = 'п''ят';
      C6: string = 'шіст';
      C7: string = 'сім';
      C8: string = 'вісім';
      C9: string = 'дев''ят';
    var
     
      i: byte;
      sAmount, sdInt, sdDec: string;
      IsMln, IsTha {,IsDcm}, IsRange1019: boolean;
      currNum, endMlx, sResult: string;
    begin
     
      if (amount <= 0) or (amount > 999999999999.99) then
        begin
          Result := '<<<< Ошибка в диапазоне >>>>';
          Exit;
        end;
      STR(Amount: 16: 2, sAmount);
      sdInt := Copy(sAmount, 1, 13);
      sdDec := Copy(sAmount, 15, 2);
      IsMln := false;
    //IsDcm:=false;
      IsTha := false;
      IsRange1019 := false;
      sResult := '';
      for i := 1 to 13 do
        begin
          currNum := Copy(sdInt, i, 1);
     
          if currNum <> suffBL then
            begin
              case i of
                5, 6, 7: if currNum <> '0' then IsMln := true;
                8, 9, 10: if currNum <> '0' then IsTha := true;
              end;
     
              if i in [2, 5, 8, 11] then {сотни}
                begin
                  if currNum = '1' then sResult := sResult + st + oo + suffBL;
                  if currNum = '2' then sResult := sResult + C2 + ii + st + ii + suffBL;
                  if currNum = '3' then sResult := sResult + C3 + st + aa + suffBL;
                  if currNum = '4' then sResult := sResult + C4 + ee + st + aa + suffBL;
                  if currNum = '5' then sResult := sResult + C5 + sot + suffBL;
                  if currNum = '6' then sResult := sResult + C6 + sot + suffBL;
                  if currNum = '7' then sResult := sResult + C7 + sot + suffBL;
                  if currNum = '8' then sResult := sResult + C8 + sot + suffBL;
                  if currNum = '9' then sResult := sResult + C9 + sot + suffBL;
                end;
              if i in [3, 6, 9, 12] then {десятки}
                begin
                  if currNum = '1' then IsRange1019 := true;
                  if currNum = '2' then sResult := sResult + C2 + aa + suffDCT + suffBL;
                  if currNum = '3' then sResult := sResult + C3 + suffDCT + suffBL;
                  if currNum = '4' then sResult := sResult + 'соpок ';
                  if currNum = '5' then
                    sResult := sResult + C5 + suffMZ + suffDCM + suffBL;
     
                  if currNum = '6' then
                    sResult := sResult + C6 + suffMZ + suffDCM + suffBL;
     
                  if currNum = '7' then
                    sResult := sResult + C7 + suffMZ + suffDCM + suffBL;
     
                  if currNum = '8' then
                    sResult := sResult + C8 + suffMZ + suffDCM + suffBL;
     
                  if currNum = '9' then
                    sResult := sResult + 'дев''ян' + oo + st + oo + suffBL;
     
                end;
              if i in [4, 7, 10, 13] then {единицы}
                begin
                  if (currNum = '0') then
                    if IsRange1019 then sResult := sResult + suffDCM + suffMZ + suffBL;
                  if (currNum = '1') then
                    begin
                      if (i = 13) and (not IsRange1019) then
                        sResult := sResult + 'одна '
                      else
                        begin
                          if (i = 10) and (IsRange1019) then
                            sResult := sResult + 'оди'
                          else if (i = 10) and (not IsRange1019) then
                            sResult := sResult + 'одна '
                          else
                            sResult := sResult + 'один' {ин};
     
                          if IsRange1019 and (i = 13) then
                            sResult := sResult + 'адцять' + suffBL
                          else if IsRange1019 then
                            sResult := sResult + suffNA
                          else
                            sResult := sResult + suffBL;
                        end;
                    end;
                  if (currNum = '2') then
                    begin
                      sResult := sResult + C2;
                      if (i = 10) and (IsRange1019 = False) then
                        sResult := sResult + ii
                      else if (i = 10) or (IsRange1019) then
                        sResult := sResult + aa
                      else
                        sResult := sResult + {aa} ii;
                      if IsRange1019 then
                        sResult := sResult + suffNA
                      else
                        sResult := sResult + suffBL;
                    end;
                  if (currNum = '3') then
                    begin
                      sResult := sResult + C3;
                      if IsRange1019 then
                        sResult := sResult + suffNA
                      else
                        sResult := sResult + suffBL;
                    end;
                  if (currNum = '4') then
                    begin
                      sResult := sResult + C4;
                      if IsRange1019 then
                        sResult := sResult + suffNA
                      else
                        sResult := sResult + ee + suffBL;
                    end;
                  if (currNum = '5') then
                    begin
                      sResult := sResult + C5;
                      if IsRange1019 then
                        sResult := sResult + suffNA
                      else
                        sResult := sResult + suffMZ + suffBL;
                    end;
                  if (currNum = '6') then
                    begin
                      sResult := sResult + C6;
                      if IsRange1019 then
                        sResult := sResult + suffNA
                      else
                        sResult := sResult + suffMZ + suffBL;
                    end;
                  if (currNum = '7') then
                    begin
                      sResult := sResult + C7;
                      if IsRange1019 then
                        sResult := sResult + suffNA
                      else
                        sResult := sResult + suffBL;
                    end;              if (currNum = '8') then
                    begin
                      sResult := sResult + C8;
                      if IsRange1019 then
                        sResult := sResult + suffNA
                      else
                        sResult := sResult + suffBL;
                    end;              if (currNum = '9') then
                    begin
                      sResult := sResult + C9;
                      if IsRange1019 then
                        sResult := sResult + suffNA
                      else
                        sResult := sResult + suffMZ + suffBL;
                    end;
                end;
     
              endMlx := '';
              case i of
                4:
                  begin
                    if IsRange1019 then
                      endMlx := ov + suffBL
                    else if currNum = '1' then
                      endMlx := suffBL
                    else if (currNum = '2') or (currNum = '3') or (currNum = '4') then
                      endMlx := aa + suffBL
                    else
                      endMlx := ov + suffBL;
                    sResult := sResult + 'мiльярд' + endMlx;
                  end;
                7: if IsMln then
                    begin
                      if IsRange1019 then
                        endMlx := ov + suffBL
                      else if currNum = '1' then
                        endMlx := suffBL
                      else if (currNum = '2') or (currNum = '3') or (currNum = '4') then
                        endMlx := aa + suffBL
                      else
                        endMlx := ov + suffBL;
                      sResult := sResult + 'мiльйон' + endMlx;
                    end;
                10: if IsTha then
                    begin
                      if IsRange1019 then
                        endMlx := suffBL
                      else if currNum = '1' then
                        endMlx := aa + suffBL
                      else if (currNum = '2') or (currNum = '3') or (currNum = '4') then
                        endMlx := ii + suffBL
                      else
                        endMlx := suffBL;
                      sResult := sResult + 'тисяч' + endMlx;
                    end;
              end; {case}
              if i in [4, 7, 10, 13] then IsRange1019 := false;
            end; {IF}
        end; {FOR}
     
      sResult := sResult + CurrName + ',' + suffBL + sdDec + suffBL + CurrSubname;
      sResult := AnsiUpperCase(sResult[1]) + Copy(sResult, 2, length(sResult) - 1);
      Result := sResult;
    end;
     
    end.

С уважением,

Andrew Tkachenko

ООО \"Проект ВО\"

Украина, г.Харьков

Взято из Советов по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com)

Сборник Kuliba
