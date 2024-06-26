---
Title: String -> TStringList
Author: Vit
Date: 30.04.2002
---


String -> TStringList
=====================

Вариант 1:

Author: Игорь Шевченко, whitefranz@hotmail.com

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Преобразование строки с разделителями в StringList.
     
    Преобразование строки с разделителями в StringList или наследник TStrings.
    Навеяно одноименной процедурой из InfoPower :-)
     
    Зависимости: Classes
    Автор:       Игорь Шевченко, whitefranz@hotmail.com, Москва
    Copyright:   Игорь Шевченко, Woll2Woll software (original)
    Дата:        30 апреля 2002 г.
    ***************************************************** }
     
    procedure StrBreakApart(const S, Delimeter: string; Parts: TStrings);
    var
      CurPos: integer;
      CurStr: string;
    begin
      Parts.clear;
      Parts.BeginUpdate();
      try
        CurStr := S;
        repeat
          CurPos := Pos(Delimeter, CurStr);
          if (CurPos > 0) then
          begin
            Parts.Add(Copy(CurStr, 1, Pred(CurPos)));
            CurStr := Copy(CurStr, CurPos + Length(Delimeter),
              Length(CurStr) - CurPos - Length(Delimeter) + 1);
          end
          else
            Parts.Add(CurStr);
        until CurPos = 0;
      finally
        Parts.EndUpdate();
      end;
    end;
    Пример использования: 
     
    var
      Tmp: StringList;
    begin
      Tmp := TStringList.Create();
      StrBreakApart('Text1<BR>Text2<BR>Text3<BR>Text4', '<BR>', Tmp);
      // После вызова Tmp содержит
      // Text1
      // Text2
      // Text3
      // Text4
      ...
      Tmp.Free();
    end;

------------------------------------------------------------------------

Вариант 2:

Author: Vit

Можно сделать значительно проще:

    procedure StrBreakApart(const S, Delimeter: string; Parts: TStrings);

    begin
      Parts.text:=StringReplace(S, Delimeter, #13#10, [rfReplaceAll, rfIgnoreCase]);
    end;

