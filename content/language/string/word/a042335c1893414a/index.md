---
Title: Заполнение списка словами из строки
Date: 01.01.2007
---


Заполнение списка словами из строки
===================================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Заполнение списка (TargetList) словами из строки (Text),
    с возможностью укзания множества разделителей
     
    Функция заполняет список TargetList, словами (наборами символов)
    из строки Text. Имеется возможность получения позиции каждого
    слова в строке (ReturnWordPlaces = True); добавления в TargetList
    не только слов, но и разделителей (ReturnWordDeviders = True);
    указания более чем одного разделителя (все в строке WordDeviders).
    Ограничением является невозможность указания разделителя,
    длинной более чем 1 символ.
     
    Result = TargetList.Count; {количество строк в TargetList}
     
    Зависимости: sysutils, classes, system
    Автор: VID, vidsnap@mail.ru, ICQ: 132234868, Махачкала
    Copyright: VID
    Дата: 02 мая 2002 г.
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
      * * * * * * * * * * * * }
     
    function GetWordListFromText(Text, WordDeviders: string; TargetList: TStrings;
      ReturnWordPlace, ReturnWordDeviders: Boolean): Integer;
    var
      X, TextLength, WP: Integer;
      W: string;
    begin
      Result := 0;
      TextLength := Length(Text);
      if TextLength = 0 then
        Exit;
      if Length(WordDeviders) = 0 then
        Exit;
      if TargetList = nil then
        Exit;
      TargetList.BeginUpdate();
      TargetList.Clear;
      WordDeviders := AnsiUpperCase(WordDeviders);
      W := '';
      X := 0;
      WP := 1;
      repeat
        X := X + 1;
        if (POS(AnsiUpperCase(Text[x]), WordDeviders) = 0) and (X <= TextLength)
          then
          W := W + Text[x]
        else
        begin
          if W <> '' then
          begin
            case ReturnWordPlace of
              True: TargetList.Add(W + '=' + Inttostr(WP));
              False: TargetList.Add(W);
            end;
          end;
          W := '';
          WP := X + 1;
          if ReturnWordDeviders = true then
          begin
            case ReturnWordPlace of
              True: TargetList.Add(Text[x] + '=' + Inttostr(x));
              False: TargetList.Add(TEXT[x]);
            end;
          end;
        end;
      until (X > TextLength);
      TargetList.EndUpdate;
      Result := TargetList.Count;
    end;
