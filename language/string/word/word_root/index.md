---
Title: Определить корень слова (для поиска похожих слов)
Author: \_\_\_Nikolay
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Определить корень слова (для поиска похожих слов)
=================================================

    // Поиск по корню слова
    function RootOfWord(s: string): string;
    label
      start;
    const
      sGlas = 'аеёиоуыэюяaeiou'; // With english letters
      sSoglas = 'бвгджзйклмнпрстфхцчшщъь';
      sCompletions1 = 'й ь s';
      sCompletions2 = 'ам ям ом ем ин ём ся ет ит ут ют ат ят ыв ив ев ан ян ов ев ог ег ир ер ых ок ющ ущ er ed';
      sCompletions3 = 'енн овл евл ённ анн ост ест';
      sAttachments1 = 'в с';
      sAttachments2 = 'на за ис из до по вы во со';
      sAttachments3 = 'при рас пре про под';
      sAttachments4 = 'пере';
    var
      sResult: string;
      i, iCnt, iGlasCount, iCheckCount: integer;
    begin
      sResult := AnsiLowerCase(Trim(s));
      iCheckCount := 0;
     
      start:
      // "ся"
      if Length(sResult) > 3 then
        if sResult[Length(sResult) - 1] + sResult[Length(sResult)] = 'ся' then
          Delete(sResult, Length(sResult) - 1, 2);
     
      (*  E N G L I S H  *)
     
      // "ing"
      if Length(sResult) > 4 then
        if sResult[Length(sResult) - 2] + sResult[Length(sResult) - 1] + sResult[Length(sResult)] = 'ing' then
          Delete(sResult, Length(sResult) - 2, 3);
     
      // --
     
      // Гласные
      if Length(sResult) > 3 then
      begin
        iGlasCount := 0;
        for i := Length(sResult) downto 1 do
          if Pos(sResult[i], sGlas) <> 0 then // Если последний символ - гласная
            inc(iGlasCount)
          else
            break;
        if iGlasCount <> 0 then
        begin
          iGlasCount := iGlasCount - 1;
          Delete(sResult, Length(sResult) - iGlasCount, iGlasCount + 1);
        end;
      end;
     
      // Окончания
      if Length(sResult) > 3 then
        if Pos(sResult[Length(sResult)], sCompletions1) <> 0 then
          Delete(sResult, Length(sResult), 1);
     
      // "ся"
      if Length(sResult) > 3 then
        if sResult[Length(sResult) - 1] + sResult[Length(sResult)] = 'ся' then
          Delete(sResult, Length(sResult) - 1, 2);
     
      if Length(sResult) > 3 then
        while Pos(sResult[Length(sResult) - 2] + sResult[Length(sResult) - 1] +
          sResult[Length(sResult)], sCompletions3) <> 0 do
        begin
          if Length(sResult) > 3 then
            Delete(sResult, Length(sResult) - 1, 3)
          else
            break;
        end;
     
      if Length(sResult) > 3 then
        while Pos(sResult[Length(sResult) - 1] + sResult[Length(sResult)], sCompletions2) <> 0 do
        begin
          if Length(sResult) > 3 then
            Delete(sResult, Length(sResult) - 1, 2)
          else
            break;
        end;
     
      // Гласные
      if Length(sResult) > 3 then
      begin
        iGlasCount := 0;
        for i := Length(sResult) downto 1 do
          if Pos(sResult[i], sGlas) <> 0 then // Если последний символ - гласная
            inc(iGlasCount)
          else
            break;
        if iGlasCount <> 0 then
        begin
          iGlasCount := iGlasCount - 1;
          Delete(sResult, Length(sResult) - iGlasCount, iGlasCount + 1);
        end;
      end;
     
      // Приставки
      iCnt := 4;
      if Length(sResult) > iCnt then
        if Pos(Copy(sResult, 1, iCnt), sAttachments4) <> 0 then
          Delete(sResult, 1, iCnt);
     
      iCnt := 3;
      if Length(sResult) > iCnt then
        if Pos(Copy(sResult, 1, iCnt), sAttachments3) <> 0 then
          Delete(sResult, 1, iCnt);
     
      iCnt := 2;
      if Length(sResult) > iCnt then
        if Pos(Copy(sResult, 1, iCnt), sAttachments2) <> 0 then
          Delete(sResult, 1, iCnt);
     
      iCnt := 1;
      if Length(sResult) > iCnt then
        if Pos(Copy(sResult, 1, iCnt), sAttachments1) <> 0 then
          Delete(sResult, 1, iCnt);
     
      inc(iCheckCount);
      if iCheckCount < 2 then
        goto start;
     
      Result := sResult;
    end;

