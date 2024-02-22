---
Title: Сортировка двух связанных списков по целочисленным значениям одного из них
Author: ___Nikolay
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Сортировка двух связанных списков по целочисленным значениям одного из них
==========================================================================

    procedure SortTwoListsByIntValues(lbNum, lbNames: TStrings);
    var
      i, j, b_val, b_j: integer;
      b_val_name: string;
    begin
      if lbNum.Count > 1 then
      begin
        for i := 0 to lbNum.Count - 2 do
        begin
          b_val := StrToInt(lbNum[i]);
          b_val_name := lbNames[i];
          b_j := i;
          for j := i + 1 to lbNum.Count - 1 do
          begin
            if StrToInt(lbNum[j]) < b_val then
            begin
              b_val := StrToInt(lbNum[j]);
              b_val_name := lbNames[j];
              b_j := j;
            end;
          end;
          lbNum[b_j] := lbNum[i];
          lbNum[i] := IntToStr(b_val);
     
          lbNames[b_j] := lbNames[i];
          lbNames[i] := b_val_name;
        end;
      end;
    end;


