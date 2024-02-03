---
Title: Функция приблизительного (нечеткого) сравнения строк
Author: Дмитрий Кузан
Date: 01.01.2007
---


Функция приблизительного (нечеткого) сравнения строк
====================================================

::: {.date}
01.01.2007
:::

Автор: Дмитрий Кузан

Недавно в поисках информации по интеллектуальным алгоритмам сравнения я
нашел такой алгоритм --- алгоритм сравнения (совпадения) двух строк, Так
как он был написан на VBA, я под свои нужды переписал его на Delphi

Уважаемые пользователи проекта DelphiWorld, я думаю данная функция
пригодится тем, кто часто пишет функции поиска, особенно когда поиск
приблизителен. То есть, например, в БД забито "Иванав Иван" - с
ошибкой при наборе, а ищется "Иванов". Так вот, данный алгоритм может
вам найти "Иванав" при вводе "Иванов",а также при "Иван Иванов" -
даже наоборот с определенной степенью релевантности при сравнении. А
используя сравнение в процентном отношении, вы можете производить поиск
по неточным данным с более-менее степенью похожести.

Еще раз повторяю, алгоритм не мой, я только его портировал на Delphi.

А метод был предложен Владимиром Кива, за что ему огромное спасибо.

    //Функция нечеткого сравнения строк БЕЗ УЧЕТА РЕГИСТРА 
    //------------------------------------------------------------------------------
    //MaxMatching - максимальная длина подстроки (достаточно 3-4)
    //strInputMatching - сравниваемая строка
    //strInputStandart - строка-образец
     
    // Сравнивание без учета регистра
    // if IndistinctMatching(4, "поисковая строка", "оригинальная строка  - эталон") > 40 then ...
    type
      TRetCount = packed record
        lngSubRows: Word;
        lngCountLike: Word;
      end;
     
    //------------------------------------------------------------------------------
     
    function Matching(StrInputA: WideString;
      StrInputB: WideString;
      lngLen: Integer): TRetCount;
    var
      TempRet: TRetCount;
      PosStrB: Integer;
      PosStrA: Integer;
      StrA: WideString;
      StrB: WideString;
      StrTempA: WideString;
      StrTempB: WideString;
    begin
      StrA := string(StrInputA);
      StrB := string(StrInputB);
     
      for PosStrA := 1 to Length(strA) - lngLen + 1 do
      begin
        StrTempA := System.Copy(strA, PosStrA, lngLen);
     
        PosStrB := 1;
        for PosStrB := 1 to Length(strB) - lngLen + 1 do
        begin
          StrTempB := System.Copy(strB, PosStrB, lngLen);
          if SysUtils.AnsiCompareText(StrTempA, StrTempB) = 0 then
          begin
            Inc(TempRet.lngCountLike);
            break;
          end;
        end;
     
        Inc(TempRet.lngSubRows);
      end; // PosStrA
     
      Matching.lngCountLike := TempRet.lngCountLike;
      Matching.lngSubRows := TempRet.lngSubRows;
    end; { function }
     
    //------------------------------------------------------------------------------
     
    function IndistinctMatching(MaxMatching: Integer;
      strInputMatching: WideString;
      strInputStandart: WideString): Integer;
    var
      gret: TRetCount;
      tret: TRetCount;
      lngCurLen: Integer; //текущая длина подстроки
    begin
        //если не передан какой-либо параметр, то выход
      if (MaxMatching = 0) or (Length(strInputMatching) = 0) or
        (Length(strInputStandart) = 0) then
      begin
        IndistinctMatching := 0;
        exit;
      end;
     
      gret.lngCountLike := 0;
      gret.lngSubRows := 0;
        // Цикл прохода по длине сравниваемой фразы
      for lngCurLen := 1 to MaxMatching do
      begin
            //Сравниваем строку A со строкой B
        tret := Matching(strInputMatching, strInputStandart, lngCurLen);
        gret.lngCountLike := gret.lngCountLike + tret.lngCountLike;
        gret.lngSubRows := gret.lngSubRows + tret.lngSubRows;
            //Сравниваем строку B со строкой A
        tret := Matching(strInputStandart, strInputMatching, lngCurLen);
        gret.lngCountLike := gret.lngCountLike + tret.lngCountLike;
        gret.lngSubRows := gret.lngSubRows + tret.lngSubRows;
      end;
     
      if gret.lngSubRows = 0 then
      begin
        IndistinctMatching := 0;
        exit;
      end;
     
      IndistinctMatching := Trunc((gret.lngCountLike / gret.lngSubRows) * 100);
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 

 

------------------------------------------------------------------------

    uses
       Math;
     
     function DoStringMatch(s1, s2: string): Double;
     var
       i, iMin, iMax, iSameCount: Integer;
     begin
       iMax := Max(Length(s1), Length(s2));
       iMin := Min(Length(s1), Length(s2));
       iSameCount := -1;
       for i := 0 to iMax do
       begin
         if i > iMin then
           break;
         if s1[i] = s2[i] then
           Inc(iSameCount)
         else
           break;
       end;
       if iSameCount > 0 then
         Result := (iSameCount / iMax) * 100
       else
         Result := 0.00;
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     var
       match: Double;
     begin
       match := DoStringMatch('SwissDelphiCenter', 'SwissDelphiCenter.ch');
       ShowMessage(FloatToStr(match) + ' % match.');
       // Resultat: 85% 
      // Result  : 85% 
    end;

Взято с сайта: <https://www.swissdelphicenter.ch>

 
