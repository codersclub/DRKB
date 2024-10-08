---
Title: Распознавание кодировки
Date: 01.01.2007
---

Распознавание кодировки
=======================

Вариант 1:

Author: Даниил Карапетян (delphi4all@narod.ru)

Алгоритм распознавания кодировки нужен для автоматического декодирования
текста. Этот алгоритм основан на том, что некоторые буквы русского
алфавита встречается очень часто, а некоторые редко. Поскольку этот
способ статистический, то лучше всего он работает с большими текстами.

    type
      TCode = (win, koi, iso, dos);
     
    const
      CodeStrings: array [TCode] of String = ('win','koi','iso','dos');
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      str: array [TCode] of string;
      norm: array ['А'..'я'] of single;
      code1, code2: TCode;
      min1, min2: TCode;
      count: array [char] of integer;
      d, min: single;
     
      s, so: string;
      chars: array [char] of char;
      c: char;
      i: integer;
    begin
      so := Memo1.Text;
     
      norm['А'] := 0.001;
      norm['Б'] := 0;
      norm['В'] := 0.002;
      norm['Г'] := 0;
      norm['Д'] := 0.001;
      norm['Е'] := 0.001;
      norm['Ж'] := 0;
      norm['З'] := 0;
      norm['И'] := 0.001;
      norm['Й'] := 0;
      norm['К'] := 0.001;
      norm['Л'] := 0;
     
      norm['М'] := 0.001;
      norm['Н'] := 0.001;
      norm['О'] := 0.001;
      norm['П'] := 0.002;
      norm['Р'] := 0.002;
      norm['С'] := 0.001;
      norm['Т'] := 0.001;
      norm['У'] := 0;
      norm['Ф'] := 0;
      norm['Х'] := 0;
      norm['Ц'] := 0;
      norm['Ч'] := 0.001;
      norm['Ш'] := 0.001;
      norm['Щ'] := 0;
      norm['Ъ'] := 0;
      norm['Ы'] := 0;
      norm['Ь'] := 0;
     
      norm['Э'] := 0.001;
      norm['Ю'] := 0;
      norm['Я'] := 0;
      norm['а'] := 0.057;
      norm['б'] := 0.01;
      norm['в'] := 0.031;
      norm['г'] := 0.011;
      norm['д'] := 0.021;
      norm['е'] := 0.067;
      norm['ж'] := 0.007;
      norm['з'] := 0.013;
      norm['и'] := 0.052;
      norm['й'] := 0.011;
      norm['к'] := 0.023;
      norm['л'] := 0.03;
      norm['м'] := 0.024;
     
      norm['н'] := 0.043;
      norm['о'] := 0.075;
      norm['п'] := 0.026;
      norm['р'] := 0.038;
      norm['с'] := 0.034;
      norm['т'] := 0.046;
      norm['у'] := 0.016;
      norm['ф'] := 0.001;
      norm['х'] := 0.006;
      norm['ц'] := 0.002;
      norm['ч'] := 0.011;
      norm['ш'] := 0.004;
      norm['щ'] := 0.004;
      norm['ъ'] := 0;
      norm['ы'] := 0.012;
      norm['ь'] := 0.012;
     
      norm['э'] := 0.003;
      norm['ю'] := 0.005;
      norm['я'] := 0.015;
     
      Str[win] := 'АаБбВвГгДдЕеЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя';
      Str[koi] := 'юЮаАбБцЦдДеЕфФгГхХиИйЙкКлЛмМнНоОпПяЯрРсСтТуУжЖвВьЬыЫзЗшШэЭщЩчЧъЪ';
      Str[iso] := 'РрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯяа№бёвђгѓдєеѕжізїијйљкњлћмќн§оўпџ';
      Str[dos] := 'Ђ ЃЎ‚ўѓЈ„¤…Ґ†¦‡§ЂЁ‰©ЉЄ‹"Њ¬ЌЋ®ЏЇђа'б'в"г"д•е–ж—з?и™йљк›лњмќнћоџп';
     
      for c := #0 to #255 do
        Chars[c] := c;
     
      min1 := win;
      min2 := win;
      min := 0;
      s := so;
      fillchar(count, sizeof(count), 0);
      for i := 1 to Length(s) do
        inc(count[s[i]]);
      for c := 'А' to 'я' do
        min := min + sqr(count[c] / Length(s) - norm[c]);
      for code1 := low(TCode) to high(TCode) do begin
        for code2 := low(TCode) to high(TCode) do begin
     
          if code1 = code2 then continue;
     
          s := so;
          for i := 1 to Length(Str[win]) do
            Chars[Str[code2][i]] := Str[code1][i];
          for i := 1 to Length(s) do
            s[i] := Chars[s[i]];
          fillchar(count, sizeof(count), 0);
          for i := 1 to Length(s) do
            inc(count[s[i]]);
          d := 0;
          for c := 'А' to 'я' do
     
            d := d + sqr(count[c] / Length(s) - norm[c]);
          if d < min then begin
            min1 := code1;
            min2 := code2;
            min := d;
          end;
        end;
      end;
     
      s := Memo1.Text;
      if min1 <> min2 then begin
        for c := #0 to #255 do
          Chars[c] := c;
        for i := 1 to Length(Str[win]) do
          Chars[Str[min2][i]] := Str[min1][i];
     
        for i := 1 to Length(s) do
          s[i] := Chars[s[i]];
      end;    
      Form1.Caption := CodeStrings[min2] + ' ' + CodeStrings[min1];
     
      Memo2.Text := s;
    end;


Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)

------------------------------------------------------------------------

Вариант 2:

Автор: Stas Malinovski 

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Методом таблицы модельных распределений:

    type
      TCodePage = (cpWin1251, cp866, cpKOI8R);
      PMap = ^TMap;
      TMap = array[#$80..#$FF] of Char;
     
    function GetMap(CP: TCodePage): PMap;
    { должна возвращать указатель на таблицу перекодировки из CP в Windows1251
    (nil для CP = cpWin1251) }
    begin
      GetMap := nil;
    end;
     
    function DetermineRussian(Buf: PChar; Count: Integer): TCodePage;
    const
      ModelBigrams: array[0..33, 0..33] of Byte = (
        {АБВГДЕЖЗИЙКЛМHОПРСТУФХЦЧШЩЪЫЬЭЮЯ_?}
        {А}(0, 20, 44, 12, 22, 23, 16, 60, 4, 9, 63, 93, 47, 110, 0, 16, 35, 61, 81,
          1, 5, 13, 24, 17, 12, 4, 0, 0, 0, 0, 14, 31, 205, 1),
        {Б}(19, 0, 0, 0, 4, 19, 0, 0, 8, 0, 2, 15, 1, 4, 41, 0, 15, 5, 0, 15, 0, 2,
          1, 0, 0, 6, 16, 37, 0, 0, 0, 4, 3, 0),
        {В}(97, 0, 1, 0, 2, 57, 0, 5, 40, 0, 4, 25, 2, 23, 78, 2, 8, 28, 4, 12, 0,
          1, 0, 0, 8, 1, 0, 40, 1, 0, 0, 5, 106, 3),
        {Г}(13, 0, 0, 0, 9, 5, 0, 0, 15, 0, 1, 17, 1, 2, 96, 0, 24, 0, 0, 7, 0, 0,
          0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 8, 0),
        {Д}(63, 0, 9, 1, 2, 71, 1, 0, 35, 0, 3, 16, 2, 22, 50, 2, 19, 9, 2, 25, 0,
          2, 1, 0, 1, 0, 1, 9, 4, 0, 1, 5, 17, 4),
        {Е}(4, 14, 15, 34, 56, 22, 13, 14, 2, 34, 39, 77, 73, 150, 6, 9, 101, 64,
          81, 1, 0, 15, 5, 12, 10, 6, 0, 0, 0, 0, 3, 4, 235, 1),
        {Ж}(13, 0, 0, 0, 12, 47, 0, 0, 16, 0, 1, 0, 0, 23, 0, 0, 0, 0, 0, 3, 0, 0,
          0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 2),
        {З}(76, 2, 11, 3, 11, 4, 1, 0, 7, 0, 2, 4, 11, 24, 17, 0, 6, 1, 0, 8, 0, 0,
          0, 0, 0, 0, 0, 16, 6, 0, 1, 4, 17, 0),
        {И}(7, 9, 32, 5, 18, 60, 4, 42, 31, 27, 28, 46, 55, 49, 12, 7, 26, 60, 53,
          0, 5, 25, 14, 28, 4, 1, 0, 0, 0, 0, 9, 56, 255, 0),
        {Й}(0, 0, 0, 0, 2, 0, 0, 0, 0, 0, 1, 3, 0, 3, 0, 0, 0, 10, 3, 0, 0, 0, 0, 1,
          1, 0, 0, 0, 0, 0, 0, 0, 122, 0),
        {К}(92, 0, 3, 0, 0, 7, 2, 1, 39, 0, 0, 27, 0, 14, 110, 0, 18, 5, 35, 18, 0,
          0, 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5, 5, 0),
        {Л}(85, 1, 0, 2, 1, 70, 6, 0, 85, 0, 5, 3, 0, 9, 67, 1, 0, 9, 0, 15, 0, 0,
          0, 2, 0, 0, 0, 9, 66, 0, 15, 43, 57, 4),
        {М}(44, 0, 0, 0, 0, 65, 0, 0, 47, 0, 1, 1, 10, 15, 57, 7, 0, 2, 0, 24, 0, 0,
          0, 0, 0, 0, 0, 28, 0, 0, 0, 8, 109, 3),
        {}(139, 0, 0, 1, 11, 108, 0, 4, 152, 0, 7, 0, 1, 69, 161, 0, 0, 8, 25, 24,
          5, 1, 5, 2, 0, 1, 0, 83, 10, 0, 1, 29, 38, 5),
        {О}(0, 72, 139, 76, 74, 32, 32, 19, 12, 52, 21, 93, 68, 72, 7, 34, 93, 102,
          98, 1, 2, 6, 6, 19, 15, 2, 0, 0, 0, 1, 4, 9, 252, 2),
        {П}(17, 0, 0, 0, 0, 43, 0, 0, 14, 0, 1, 9, 0, 1, 125, 3, 120, 1, 2, 8, 0, 0,
          0, 0, 0, 0, 0, 3, 6, 0, 0, 3, 2, 2),
        {Р}(151, 1, 6, 4, 3, 103, 7, 0, 76, 0, 4, 0, 11, 10, 117, 1, 0, 5, 9, 39, 2,
          5, 0, 1, 3, 0, 0, 24, 7, 0, 1, 10, 22, 5),
        {С}(24, 1, 21, 0, 3, 39, 0, 0, 33, 0, 56, 41, 11, 15, 58, 30, 5, 30, 183,
          16, 0, 4, 1, 4, 1, 0, 0, 8, 25, 0, 1, 50, 41, 2),
        {Т}(83, 0, 43, 0, 3, 87, 0, 0, 71, 0, 9, 3, 2, 26, 180, 0, 55, 33, 1, 23, 1,
          0, 1, 4, 0, 0, 0, 20, 78, 0, 0, 5, 82, 4),
        {У}(3, 6, 7, 14, 19, 8, 13, 6, 0, 1, 13, 15, 10, 7, 0, 12, 17, 16, 19, 0, 1,
          3, 0, 12, 5, 8, 0, 0, 0, 0, 22, 1, 65, 0),
        {Ф}(4, 0, 0, 0, 0, 4, 0, 0, 11, 0, 0, 1, 0, 0, 9, 0, 3, 0, 0, 4, 1, 0, 0, 0,
          0, 0, 0, 0, 0, 0, 0, 0, 2, 0),
        {Х}(9, 0, 2, 0, 0, 2, 0, 0, 5, 0, 0, 1, 0, 5, 26, 0, 4, 1, 0, 1, 0, 0, 0, 0,
          0, 0, 0, 0, 0, 0, 0, 0, 76, 0),
        {Ц}(5, 0, 0, 0, 0, 16, 0, 0, 48, 0, 1, 0, 0, 0, 4, 0, 0, 0, 0, 3, 0, 0, 0,
          0, 0, 0, 0, 2, 0, 0, 0, 0, 3, 0),
        {Ч}(30, 0, 0, 0, 0, 52, 0, 0, 23, 0, 3, 1, 0, 14, 1, 0, 0, 0, 36, 5, 0, 0,
          0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 2),
        {Ш}(13, 0, 0, 0, 0, 28, 0, 0, 17, 0, 4, 4, 0, 4, 3, 0, 0, 0, 1, 3, 0, 0, 0,
          0, 0, 0, 0, 0, 3, 0, 0, 0, 1, 1),
        {Щ}(6, 0, 0, 0, 0, 23, 0, 0, 16, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0,
          0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1),
        {Ъ}(0, 0, 0, 0, 0, 16, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
          0, 0, 0, 0, 0, 0, 1, 1, 0, 0),
        {Ы}(0, 5, 14, 1, 3, 28, 0, 2, 0, 22, 6, 19, 21, 2, 0, 5, 4, 7, 10, 0, 0, 37,
          0, 3, 4, 0, 0, 0, 0, 0, 0, 1, 84, 0),
        {Ь}(0, 1, 0, 0, 0, 9, 0, 10, 1, 0, 13, 0, 2, 26, 0, 0, 0, 10, 3, 0, 0, 0, 1,
          0, 6, 0, 0, 0, 0, 0, 6, 4, 117, 0),
        {Э}(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3, 3, 0, 0, 0, 0, 0, 0, 31, 0, 1, 0, 0, 0,
          0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
        {Ю}(0, 5, 0, 0, 3, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 15, 0, 0, 0, 1, 4,
          1, 15, 0, 0, 0, 0, 0, 0, 38, 0),
        {Я}(0, 0, 9, 2, 7, 10, 3, 19, 0, 0, 1, 6, 7, 8, 0, 0, 2, 6, 19, 0, 0, 3, 5,
          1, 0, 3, 0, 0, 0, 0, 5, 2, 177, 0),
        {_}(42, 80, 193, 43, 109, 41, 18, 53, 159, 0, 144, 27, 83, 176, 187, 229,
          70, 231, 99, 47, 15, 13, 6, 58, 7, 0, 0, 0, 0, 38, 0, 22, 0, 2),
        {?}(0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 2, 4, 4, 8, 0, 0, 5, 3, 4, 0, 0, 0, 0, 0,
          0, 0, 0, 0, 0, 0, 0, 0, 0, 0));
      { "рейтинг"  буквы ? условно принимается равным 1/20 от "рейтинга"  буквы E,
      если сочетание с участием ? корректно, иначе - 0 }
    type
      TVariation = array[0..33, 0..33] of Integer;
    var
      I, J, iC, iPredC, Max: Integer;
      C: Char;
      CP: TCodePage;
      D, MinD, Factor: Double;
      AMap: PMap;
      PV: ^TVariation;
      Vars: array[TCodePage] of TVariation;
    begin
      DetermineRussian := cpWin1251; { по yмолчанию }
      { вычисление распределений биграмм }
      FillChar(Vars, SizeOf(Vars), 0);
      for CP := Low(Vars) to High(Vars) do
      begin
        AMap := GetMap(CP);
        PV := @Vars[CP];
        iPredC := 32;
        for I := 0 to Count - 1 do
        begin
          C := Buf[I];
          iC := 32;
          if C > = #128 then
          begin
            if AMap < > nil then
              C := AMap^[C];
            if not (C in ['?', '?']) then
            begin
              C := Chr(Ord(C) and not 32); { 'a'..'я' ->  'А'..'Я' }
              if C in ['А'..'Я'] then
                iC := Ord(C) - Ord('А');
            end
            else
              iC := 33;
          end;
          Inc(PV^[iPredC, iC]);
          iPredC := iC;
        end;
      end;
      { вычисление метрики и определение наиболее правдоподобной кодировки }
      MinD := 0;
      for CP := Low(Vars) to High(Vars) do
      begin
        PV := @Vars[CP];
        PV^[32, 32] := 0;
        Max := 1;
        for I := 0 to 33 do
          for J := 0 to 33 do
            if PV^[I, J] > Max then
              Max := PV^[I, J];
        Factor := 255 / Max; { ноpмализация }
        D := 0;
        for I := 0 to 33 do
          for J := 0 to 33 do
            D := D + Abs(PV^[I, J] * Factor - ModelBigrams[I, J]);
        if (MinD = 0) or (D < MinD) then
        begin
          MinD := D;
          DetermineRussian := CP;
        end;
      end;
    end;
     
    begin
      { тест: слово 'Пример' в разных кодировках (веpоятность ошибок на таких
      коpотких текстах высока - в данном слyчае пpосто повезло!) }
      writeln(DetermineRussian(#$CF#$F0#$E8#$EC#$E5#$F0, 6) = cpWin1251);
      writeln(DetermineRussian(#$8F#$E0#$A8#$AC#$A5#$E0, 6) = cp866);
      writeln(DetermineRussian(#$F0#$D2#$C9#$CD#$C5#$D2, 6) = cpKOI8R);
      readln;
    end. 


------------------------------------------------------------------------

Вариант 3:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Автоопределение кодировки ANSI-OEM

    const
      l3_csANSI = 0;
      {-признак кодировки ANSII}
      l3_csOEM = 255;
      {-признак кодировки OEM}
     
    type
      cc_Graph_CriteriaRange = #176..#223; {-критерий для определения псевдографики}
      TChars = set of char;
      Long = LongInt;
     
    const
      cc_OEM_CriteriaEx = [#128..#175] + [#224..#239];
      cc_ANSI_CriteriaEx = [#192..#255];
      cc_Graph_Criteria = [Low(cc_Graph_CriteriaRange)..High(cc_Graph_CriteriaRange)];
     
    type
      T_cc_GraphCounts = array [cc_Graph_CriteriaRange] of Longint;
     
    procedure l3AnalizeCharSetEx(var Buf: PChar; BufEnd: PChar;
    var OEMCount, ANSICount, GraphCount: Long;
    var GraphCounts: T_cc_GraphCounts);
    var
      C : Char;
    begin
      OEMCount := 0;
      ANSICount := 0;
      GraphCount := 0;
      for C := Low(T_cc_GraphCounts) to High(T_cc_GraphCounts) do GraphCounts[C] := 0;
      while (Buf <  BufEnd) do begin
        C := Buf^;
        Inc(Buf);
        if (C in cc_OEM_CriteriaEx) then Inc(OEMCount);
        if (C in cc_ANSI_CriteriaEx) then Inc(ANSICount);
        if (C in cc_Graph_Criteria) then begin
          Inc(GraphCounts[C]);
          Inc(GraphCount);
        end;
      end;{Buf <  BufEnd}
    end;
     
    function l3AnalizeCharSetExEx(Buf, BufEnd: PChar): Byte;
    var
      OEMCount : Long;
      ANSICount : Long;
      GraphCount : Long;
      GraphCount_2: Long;
      GraphCounts : T_cc_GraphCounts;
      C : Char;
    begin
        l3AnalizeCharSetEx(Buf, BufEnd, OEMCount, ANSICount, GraphCount,GraphCounts);
        if (OEMCount >  ANSICount) then
          Result := l3_csOEM
        else if (GraphCount > = ANSICount) then begin
        Result := 0;
        GraphCount_2 := GraphCount div 2;
        for C := Low(T_cc_GraphCounts) to High(T_cc_GraphCounts) do begin
          If (GraphCounts[C] >  GraphCount_2) then begin
            Result := l3_csOEM;
            break;
          end;{GraphCounts[C] >  ..}
        end;{for C}
      end else Result := 0;
    end;
     
    function l3AnalizeCharSetBuf(Buf: PChar; Len: Long): Byte;
    begin
      Result := l3AnalizeCharSetExEx(Buf, Buf + Len);
    end; 


------------------------------------------------------------------------

Вариант 4:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

(Кол-во насчитанных бyков)

А:241790 Б:45768 В:131582 Г:36392 Д:90944 Е:286883 Ж:27470 З:53187

И:221390 Й:35677 К:102705 Л:116371 М:115467 H:185044 О:304716 П:104408

Р:157473 С:143929 Т:202411 У:69038 Ф:14771 Х:19930 Ц:17906 Ч:34798

Ш:9739 Щ:18389 Ъ:4830 Ы:70756 Ь:41913 Э:12354 Ю:23026 Я:67180

(Кол-во насчитанных бyков, отсоpтиpовано)

О:304716 Е:286883 А:241790 И:221390 Т:202411 H:185044 Р:157473 С:143929

В:131582 Л:116371 М:115467 П:104408 К:102705 Д:90944 Ы:70756 У:69038

Я:67180 З:53187 Б:45768 Ь:41913 Г:36392 Й:35677 Ч:34798 Ж:27470

Ю:23026 Х:19930 Щ:18389 Ц:17906 Ф:14771 Э:12354 Ш:9739 Ъ:4830

(Кол-во насчитанных бyков, отсоpтиpовано и pасфасовано)

Гласные:

О:304716 Е:286883 А:241790 И:221390 Ы:70756 У:69038 Я:67180 Й:35677

Э:12354 Ю:23026

Согласные:

Т:202411 H:185044 Р:157473 С:143929 В:131582 Л:116371 М:115467 П:104408

К:102705 Д:90944 З:53187 Б:45768 Г:36392 Ч:34798 Ж:27470 Х:19930

Щ:18389 Ц:17906 Ф:14771 Ш:9739

Фиг знает какие:

Ь:41913 Ъ:4830

Чаще всего встpечаются бyквы: \'ОТЕHАР\'

Тепеpь пеpекодиpовка

    type
      TCoding = array[Char] of Char;
     
    const
      DTW := TCoding(Dos - > Win
        #$00, #$01, #$02, #$03, #$04, #$05, #$06, #$07,
        #$08, #$09, #$0A, #$0B, #$0C, #$0D, #$0E, #$0F,
        #$10, #$11, #$12, #$13, #$14, #$15, #$16, #$17,
        #$18, #$19, #$1A, #$1B, #$1C, #$1D, #$1E, #$1F,
        #$20, #$21, #$22, #$23, #$24, #$25, #$26, #$27,
        #$28, #$29, #$2A, #$2B, #$2C, #$2D, #$2E, #$2F,
        #$30, #$31, #$32, #$33, #$34, #$35, #$36, #$37,
        #$38, #$39, #$3A, #$3B, #$3C, #$3D, #$3E, #$3F,
        #$40, #$41, #$42, #$43, #$44, #$45, #$46, #$47,
        #$48, #$49, #$4A, #$4B, #$4C, #$4D, #$4E, #$4F,
        #$50, #$51, #$52, #$53, #$54, #$55, #$56, #$57,
        #$58, #$59, #$5A, #$5B, #$5C, #$5D, #$5E, #$5F,
        #$60, #$61, #$62, #$63, #$64, #$65, #$66, #$67,
        #$68, #$69, #$6A, #$6B, #$6C, #$6D, #$6E, #$6F,
        #$70, #$71, #$72, #$73, #$74, #$75, #$76, #$77,
        #$78, #$79, #$7A, #$7B, #$7C, #$7D, #$7E, #$7F,
        #$C0, #$C1, #$C2, #$C3, #$C4, #$C5, #$C6, #$C7,
        #$C8, #$C9, #$CA, #$CB, #$CC, #$CD, #$CE, #$CF,
        #$D0, #$D1, #$D2, #$D3, #$D4, #$D5, #$D6, #$D7,
        #$D8, #$D9, #$DA, #$DB, #$DC, #$DD, #$DE, #$DF,
        #$E0, #$E1, #$E2, #$E3, #$E4, #$E5, #$E6, #$E7,
        #$E8, #$E9, #$EA, #$EB, #$EC, #$ED, #$EE, #$EF,
        #$80, #$81, #$82, #$83, #$84, #$C1, #$C2, #$C0,
        #$A9, #$85, #$86, #$87, #$88, #$A2, #$A5, #$89,
        #$8A, #$8B, #$8C, #$8D, #$8E, #$8F, #$E3, #$C3,
        #$90, #$93, #$94, #$95, #$96, #$97, #$98, #$A4,
        #$F0, #$D0, #$CA, #$CB, #$C8, #$D7, #$CD, #$CE,
        #$CF, #$99, #$9A, #$9B, #$9C, #$A6, #$CC, #$9D,
        #$F0, #$F1, #$F2, #$F3, #$F4, #$F5, #$F6, #$F7,
        #$F8, #$F9, #$FA, #$FB, #$FC, #$FD, #$FE, #$FF,
        #$A8, #$B8, #$F7, #$BE, #$B6, #$A7, #$9F, #$B8,
        #$B0, #$A8, #$B7, #$B9, #$B3, #$B2, #$9E, #$A0);
     
      WTD: TCoding = (Win - > Dos
        #$00, #$01, #$02, #$03, #$04, #$05, #$06, #$07,
        #$08, #$09, #$0A, #$0B, #$0C, #$0D, #$0E, #$0F,
        #$10, #$11, #$12, #$13, #$14, #$15, #$16, #$17,
        #$18, #$19, #$1A, #$1B, #$1C, #$1D, #$1E, #$1F,
        #$20, #$21, #$22, #$23, #$24, #$25, #$26, #$27,
        #$28, #$29, #$2A, #$2B, #$2C, #$2D, #$2E, #$2F,
        #$30, #$31, #$32, #$33, #$34, #$35, #$36, #$37,
        #$38, #$39, #$3A, #$3B, #$3C, #$3D, #$3E, #$3F,
        #$40, #$41, #$42, #$43, #$44, #$45, #$46, #$47,
        #$48, #$49, #$4A, #$4B, #$4C, #$4D, #$4E, #$4F,
        #$50, #$51, #$52, #$53, #$54, #$55, #$56, #$57,
        #$58, #$59, #$5A, #$5B, #$5C, #$5D, #$5E, #$5F,
        #$60, #$61, #$62, #$63, #$64, #$65, #$66, #$67,
        #$68, #$69, #$6A, #$6B, #$6C, #$6D, #$6E, #$6F,
        #$70, #$71#$78, #$79, #$7A, #$7B, #$7C, #$7D, #$7E, #$7F,
        #$B0, #$B1, #$B2, #$B3, #$B4, #$B5, #$B6, #$B7,
        #$B8, #$B9, #$BA, #$BB, #$BC, #$BD, #$BE, #$BF,
        #$C0, #$C1, #$C2, #$C3, #$C4, #$C5, #$C6, #$C7,
        #$C8, #$C9, #$CA, #$CB, #$CC, #$CD, #$CE, #$CF,
        #$D0, #$D1, #$D2, #$D3, #$D4, #$D5, #$D6, #$D7,
        #$F0, #$D9, #$DA, #$DB, #$DC, #$DD, #$DE, #$DF,
        #$F0, #$F1, #$F2, #$F3, #$F4, #$F5, #$F6, #$F7,
        #$F1, #$F9, #$FA, #$FB, #$FC, #$FD, #$FE, #$FF,
        #$80, #$81, #$82, #$83, #$84, #$85, #$86, #$87,
        #$88, #$89, #$8A, #$8B, #$8C, #$8D, #$8E, #$8F,
        #$90, #$91, #$92, #$93, #$94, #$95, #$96, #$97,
        #$98, #$99, #$9A, #$9B, #$9C, #$9D, #$9E, #$9F,
        #$A0, #$A1, #$A2, #$A3, #$A4, #$A5, #$A6, #$A7,
        #$A8, #$A9, #$AA, #$AB, #$AC, #$AD, #$AE, #$AF,
        #$E0, #$E1, #$E2, #$E3, #$E4, #$E5, #$E6, #$E7,
        #$E8, #$E9, #$EA, #$EB, #$EC, #$ED, #$EE, #$EF);
     
      {Тепеpь сам пpоцесс подсч?та!}
    type
      TCounts = array[Char] of LongInt;
     
    var
      WinCounts: TCounts;
      DosCounts: TCounts;
     
      {Очистка}
     
    procedure ClearCoding;
    var
      c: Char;
    begin
      for c := #1 to #$FF do
      begin
        WinCounts[c] := 0;
        DosCounts[c] := 0;
      end;
    end;
     
    {Подсч?т}
     
    procedure CalcString(const S: string);
    var
      i: LongInt;
    begin
      for i := 1 to LenGth(s) do
      begin
        {Если в Delphi}
        Inc(WinCounts[S[i]]);
        Inc(DosCounts[DTW[S[i]]]);
     
        {Если в Turbo Pascal
        Inc(WinCounts[WTD[S[i]]]);
        Inc(DosCounts[S[i]]);
        }
      end;
    end;
     
    function TestWinCode: Boolean;
    begin
      TestWinCode :=
        (WinCounts['О'] + WinCounts['Т'] + WinCounts['Е'] + WinCounts['H']) >=
        (DosCounts['О'] + DosCounts['Т'] + DosCounts['Е'] + DosCounts['H']);
    end;
     
    function TestDosCode: Boolean;
    begin
      TestDosCode :=
        (WinCounts['О'] + WinCounts['Т'] + WinCounts['Е'] + WinCounts['H']) <
        (DosCounts['О'] + DosCounts['Т'] + DosCounts['Е'] + DosCounts['H']);
    end;
    { *----------------Откyда-всё-это-???-------------------------* }
    { Можно yбpать последние тpи слагаемые, y меня и так pаботало }
    { Опpеделяет по одномy словy, если там есть хотя бы одна бyква }
    { Можно также сделать по всем бyквам и искать pасстояния в 256 }
    { меpном пpостpанстве, но это я делал, когда символы были за- }
    { шифpованы чеpез Xor или Add Const, а там, пpости, 256 ваpи- }
    { антов, а не два. И то y меня по одномy словy вс? понимала, }
    { только pедкие не понимала, но пpедложения точно понимала! }
    { *-----------------------------------------------------------* }
     
    { *-------------------UpGread---------------------------------* }
    { Можно доpаботать пpогpаммy для игноpиpования повтоpяющихся }
    { последовательностей }
    { *-----------------------------------------------------------* }
     
     
    {Пpимеp использования}
    Var
      S: _String_;
      f: Text;
    Begin
      Assign(f, 'Test.txt');
      Reset(f);
      ClearCoding;
      Repeat
        ReadLn(f, S);
        CalcString(S);
      Until
        EOF(f);
      Close(f);
      If TestWinCode Then
        {Виндовская кодиpовка}
      If TestDosCode Then
        {Досовская кодиpовка}
    End;


------------------------------------------------------------------------

Вариант 5:

Распознавание кодировки. Перекодировка.

Алгоритм распознавания кодировки нужен для автоматического декодирования
текста. Этот алгоритм основан на том, что некоторые буквы русского
алфавита встречается очень часто, а некоторые редко. Поскольку этот
способ статистический, то лучше всего он работает с большими текстами.

    type
      TCode = (win, koi, iso, dos);
     
    const
      CodeStrings: array [TCode] of string = ('win','koi','iso','dos');
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      str: array [TCode] of string;
      norm: array ['А'..'я'] of single;
      code1, code2: TCode;
      min1, min2: TCode;
      count: array [char] of integer;
      d, min: single;
      s, so: string;
      chars: array [char] of char;
      c: char;
      i: integer;
    begin
      so := Memo1.Text;
     
      norm['А'] := 0.001;
      norm['Б'] := 0;
      norm['В'] := 0.002;
      norm['Г'] := 0;
      norm['Д'] := 0.001;
      norm['Е'] := 0.001;
      norm['Ж'] := 0;
      norm['З'] := 0;
      norm['И'] := 0.001;
      norm['Й'] := 0;
      norm['К'] := 0.001;
      norm['Л'] := 0;
      norm['М'] := 0.001;
      norm['Н'] := 0.001;
      norm['О'] := 0.001;
      norm['П'] := 0.002;
      norm['Р'] := 0.002;
      norm['С'] := 0.001;
      norm['Т'] := 0.001;
      norm['У'] := 0;
      norm['Ф'] := 0;
      norm['Х'] := 0;
      norm['Ц'] := 0;
      norm['Ч'] := 0.001;
      norm['Ш'] := 0.001;
      norm['Щ'] := 0;
      norm['Ъ'] := 0;
      norm['Ы'] := 0;
      norm['Ь'] := 0;
      norm['Э'] := 0.001;
      norm['Ю'] := 0;
      norm['Я'] := 0;
      norm['а'] := 0.057;
      norm['б'] := 0.01;
      norm['в'] := 0.031;
      norm['г'] := 0.011;
      norm['д'] := 0.021;
      norm['е'] := 0.067;
      norm['ж'] := 0.007;
      norm['з'] := 0.013;
      norm['и'] := 0.052;
      norm['й'] := 0.011;
      norm['к'] := 0.023;
      norm['л'] := 0.03;
      norm['м'] := 0.024;
      norm['н'] := 0.043;
      norm['о'] := 0.075;
      norm['п'] := 0.026;
      norm['р'] := 0.038;
      norm['с'] := 0.034;
      norm['т'] := 0.046;
      norm['у'] := 0.016;
      norm['ф'] := 0.001;
      norm['х'] := 0.006;
      norm['ц'] := 0.002;
      norm['ч'] := 0.011;
      norm['ш'] := 0.004;
      norm['щ'] := 0.004;
      norm['ъ'] := 0;
      norm['ы'] := 0.012;
      norm['ь'] := 0.012;
      norm['э'] := 0.003;
      norm['ю'] := 0.005;
      norm['я'] := 0.015;
     
      Str[win] := 'АаБбВвГгДдЕеЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя';
      Str[koi] := 'юЮаАбБцЦдДеЕфФгГхХиИйЙкКлЛмМнНоОпПяЯрРсСтТуУжЖвВьЬыЫзЗшШэЭщЩчЧъЪ';
      Str[iso] := 'РрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯяа№бёвђгѓдєеѕжізїијйљкњлћмќн§оўпџ';
      Str[dos] := 'Ђ ЃЎ‚ўѓЈ"¤…Ґ†¦‡§€Ё‰©ЉЄ‹"ЊЌЋ®ЏЇђа'б'в"г"дoе-ж-зи™йљк›лњмќнћоџпз?и™йљк›лњмќнћоџп';
      for c := #0 to #255 do
        Chars[c] := c;
     
      min1 := win;
      min2 := win;
      min := 0;
      s := so;
      fillchar(count, sizeof(count), 0);
      for i := 1 to Length(s) do
        inc(count[s[i]]);
      for c := 'А' to 'я' do
        min := min + sqr(count[c] / Length(s) - norm[c]);
      for code1 := low(TCode) to high(TCode) do
      begin
        for code2 := low(TCode) to high(TCode) do
        begin
          if code1 = code2 then
            continue;
     
          s := so;
          for i := 1 to Length(Str[win]) do
            Chars[Str[code2][i]] := Str[code1][i];
          for i := 1 to Length(s) do
            s[i] := Chars[s[i]];
          fillchar(count, sizeof(count), 0);
          for i := 1 to Length(s) do
            inc(count[s[i]]);
          d := 0;
          for c := 'А' to 'я' do
            d := d + sqr(count[c] / Length(s) - norm[c]);
          if d < min then
          begin
            min1 := code1;
            min2 := code2;
            min := d;
          end;
        end;
      end;
     
      s := Memo1.Text;
      if min1 <> min2 then
      begin
        for c := #0 to #255 do
          Chars[c] := c;
        for i := 1 to Length(Str[win]) do
          Chars[Str[min2][i]] := Str[min1][i];
        for i := 1 to Length(s) do
          s[i] := Chars[s[i]];
      end;
      Form1.Caption := CodeStrings[min2] + ' ' + CodeStrings[min1];
     
      Memo2.Text := s;
    end;


Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>


------------------------------------------------------------------------

Вариант 6:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Определение кодовой страницы

Author: Alexander Trunov (jnc@mail.ru)

    {
      Work with codepages
      (c) 1999 by Alexander Trunov, {2:5069/10}, {jnc@mail.ru}
    }
     
    unit Codepage;
     
    interface
     
    const
      cpWin = 01;
      cpAlt = 02;
      cpKoi = 03;
     
    function DetermineCodepage(const st: string): Byte;
    function Alt2Win(const st: string): string;
    function Win2Alt(const st: string): string;
    function Alt2Koi(const st: string): string;
    function Koi2Alt(const st: string): string;
    function Win2Koi(const st: string): string;
    function Koi2Win(const st: string): string;
    function X2Y(const st: string; srcCp, dstCp: Byte): string;
     
    implementation
     
    const
      AltSet = ['А'..'Я', 'а'..'п', 'р'..'я'];
      KoiSet = ['Б'..'Р', 'Т'..'С'];
      WinSet = ['а'..'п', 'р'..#255];
     
      Win2AltTable: array[0..255] of Byte = (
        $00, $01, $02, $03, $04, $05, $06, $07, $08, $20, $0A, $0B, $0C, $0D, $0E, $0F,
        $10, $11, $12, $13, $14, $15, $16, $17, $18, $19, $1A, $1B, $1C, $1D, $1E, $1F,
        $20, $21, $22, $23, $24, $25, $26, $27, $28, $29, $2A, $2B, $2C, $2D, $2E, $2F,
        $30, $31, $32, $33, $34, $35, $36, $37, $38, $39, $3A, $3B, $3C, $3D, $3E, $3F,
        $40, $41, $42, $43, $44, $45, $46, $47, $48, $49, $4A, $4B, $4C, $4D, $4E, $4F,
        $50, $51, $52, $53, $54, $55, $56, $57, $58, $59, $5A, $5B, $5C, $5D, $5E, $5F,
        $60, $61, $62, $63, $64, $65, $66, $67, $68, $69, $6A, $6B, $6C, $6D, $6E, $6F,
        $70, $71, $72, $73, $74, $75, $76, $77, $78, $79, $7A, $7B, $7C, $7D, $7E, $7F,
        $80, $81, $82, $83, $84, $85, $86, $87, $88, $89, $8A, $8B, $8C, $8D, $8E, $8F,
        $90, $91, $92, $93, $94, $95, $96, $97, $98, $99, $9A, $9B, $9C, $9D, $9E, $9F,
        $A0, $A1, $A2, $A3, $A4, $A5, $A6, $A7, $A8, $A9, $AA, $22, $AC, $AD, $AE, $AF,
        $B0, $B1, $B2, $B3, $B4, $B5, $B6, $B7, $B8, $FC, $BA, $22, $BC, $BD, $BE, $BF,
        $80, $81, $82, $83, $84, $85, $86, $87, $88, $89, $8A, $8B, $8C, $8D, $8E, $8F,
        $90, $91, $92, $93, $94, $95, $96, $97, $98, $99, $9A, $9B, $9C, $9D, $9E, $9F,
        $A0, $A1, $A2, $A3, $A4, $A5, $A6, $A7, $A8, $A9, $AA, $AB, $AC, $AD, $AE, $AF,
        $E0, $E1, $E2, $E3, $E4, $E5, $E6, $E7, $E8, $E9, $EA, $EB, $EC, $ED, $EE, $EF);
     
      Alt2WinTable: array[0..255] of Byte = (
        $00, $01, $02, $03, $04, $05, $06, $07, $08, $09, $0A, $0B, $0C, $0D, $0E, $0F,
        $10, $11, $12, $13, $14, $15, $16, $17, $18, $19, $1A, $1B, $1C, $1D, $1E, $1F,
        $20, $21, $22, $23, $24, $25, $26, $27, $28, $29, $2A, $2B, $2C, $2D, $2E, $2F,
        $30, $31, $32, $33, $34, $35, $36, $37, $38, $39, $3A, $3B, $3C, $3D, $3E, $3F,
        $40, $41, $42, $43, $44, $45, $46, $47, $48, $49, $4A, $4B, $4C, $4D, $4E, $4F,
        $50, $51, $52, $53, $54, $55, $56, $57, $58, $59, $5A, $5B, $5C, $5D, $5E, $5F,
        $60, $61, $62, $63, $64, $65, $66, $67, $68, $69, $6A, $6B, $6C, $6D, $6E, $6F,
        $70, $71, $72, $73, $74, $75, $76, $77, $78, $79, $7A, $7B, $7C, $7D, $7E, $7F,
        $C0, $C1, $C2, $C3, $C4, $C5, $C6, $C7, $C8, $C9, $CA, $CB, $CC, $CD, $CE, $CF,
        $D0, $D1, $D2, $D3, $D4, $D5, $D6, $D7, $D8, $D9, $DA, $DB, $DC, $DD, $DE, $DF,
        $E0, $E1, $E2, $E3, $E4, $E5, $E6, $E7, $E8, $E9, $EA, $EB, $EC, $ED, $EE, $EF,
        $20, $20, $20, $A6, $A6, $A6, $A6, $2B, $2B, $A6, $A6, $2B, $2B, $2B, $2B, $2B,
        $2B, $2D, $2D, $2B, $2D, $2B, $A6, $A6, $2B, $2B, $2D, $2D, $A6, $2D, $2B, $2D,
        $2D, $2D, $2D, $2B, $2B, $2B, $2B, $2B, $2B, $2B, $2B, $5F, $5F, $5F, $5F, $5F,
        $F0, $F1, $F2, $F3, $F4, $F5, $F6, $F7, $F8, $F9, $FA, $FB, $FC, $FD, $FE, $FF,
        $A8, $B8, $AA, $BA, $AF, $BF, $A1, $A2, $B0, $B7, $B7, $5F, $B9, $A4, $5F, $5F);
     
      Koi2AltTable: array[0..255] of Byte = (
        $00, $01, $02, $03, $04, $05, $06, $07, $08, $09, $0A, $0B, $0C, $0D, $0E, $0F,
        $10, $11, $12, $13, $14, $15, $16, $17, $18, $19, $1A, $1B, $1C, $1D, $1E, $1F,
        $20, $21, $22, $23, $24, $25, $26, $27, $28, $29, $2A, $2B, $2C, $2D, $2E, $2F,
        $30, $31, $32, $33, $34, $35, $36, $37, $38, $39, $3A, $3B, $3C, $3D, $3E, $3F,
        $40, $41, $42, $43, $44, $45, $46, $47, $48, $49, $4A, $4B, $4C, $4D, $4E, $4F,
        $50, $51, $52, $53, $54, $55, $56, $57, $58, $59, $5A, $5B, $5C, $5D, $5E, $5F,
        $60, $61, $62, $63, $64, $65, $66, $67, $68, $69, $6A, $6B, $6C, $6D, $6E, $6F,
        $70, $71, $72, $73, $74, $75, $76, $77, $78, $79, $7A, $7B, $7C, $7D, $7E, $7F,
        $80, $81, $82, $83, $84, $85, $86, $87, $88, $89, $8A, $8B, $8C, $8D, $8E, $8F,
        $90, $91, $92, $93, $94, $95, $96, $97, $98, $99, $9A, $9B, $9C, $9D, $9E, $9F,
        $A0, $A1, $A2, $A5, $A4, $A5, $A6, $A7, $A8, $A9, $AA, $AB, $AC, $AD, $AE, $AF,
        $B0, $B1, $B2, $B3, $B4, $B5, $B6, $B7, $B8, $B9, $BA, $BB, $BC, $BD, $BE, $BF,
        $EE, $A0, $A1, $E6, $A4, $A5, $E4, $A3, $E5, $A8, $A9, $AA, $AB, $AC, $AD, $AE,
        $AF, $EF, $E0, $E1, $E2, $E3, $A6, $A2, $EC, $EB, $A7, $E8, $ED, $E9, $E7, $EA,
        $9E, $80, $81, $96, $84, $85, $94, $83, $95, $88, $89, $8A, $8B, $8C, $8D, $8E,
        $8F, $9F, $90, $91, $92, $93, $86, $82, $9C, $9B, $87, $98, $9D, $99, $97, $FF);
     
      Alt2KoiTable: array[0..255] of Byte = (
        $00, $01, $02, $03, $04, $05, $06, $07, $08, $09, $0A, $0B, $0C, $0D, $0E, $0F,
        $10, $11, $12, $13, $14, $15, $16, $17, $18, $19, $1A, $1B, $1C, $1D, $1E, $1F,
        $20, $21, $22, $23, $24, $25, $26, $27, $28, $29, $2A, $2B, $2C, $2D, $2E, $2F,
        $30, $31, $32, $33, $34, $35, $36, $37, $38, $39, $3A, $3B, $3C, $3D, $3E, $3F,
        $40, $41, $42, $43, $44, $45, $46, $47, $48, $49, $4A, $4B, $4C, $4D, $4E, $4F,
        $50, $51, $52, $53, $54, $55, $56, $57, $58, $59, $5A, $5B, $5C, $5D, $5E, $5F,
        $60, $61, $62, $63, $64, $65, $66, $67, $68, $69, $6A, $6B, $6C, $6D, $6E, $6F,
        $70, $71, $72, $73, $74, $75, $76, $77, $78, $79, $7A, $7B, $7C, $7D, $7E, $7F,
        $E1, $E2, $F7, $E7, $E4, $E5, $F6, $FA, $E9, $EA, $EB, $EC, $ED, $EE, $EF, $F0,
        $F2, $F3, $F4, $F5, $E6, $E8, $E3, $FE, $FB, $FD, $9A, $F9, $F8, $FC, $E0, $F1,
        $C1, $C2, $D7, $C7, $C4, $C5, $D6, $DA, $C9, $CA, $CB, $CC, $CD, $CE, $CF, $D0,
        $B0, $B1, $B2, $B3, $B4, $B5, $B6, $B7, $B8, $B9, $BA, $BB, $BC, $BD, $BE, $BF,
        $C0, $C1, $C2, $C3, $C4, $C5, $C6, $C7, $C8, $C9, $CA, $CB, $CC, $CD, $CE, $CF,
        $D0, $D1, $D2, $D3, $D4, $D5, $D6, $D7, $D8, $D9, $DA, $DB, $DC, $DD, $DE, $DF,
        $D2, $D3, $D4, $D5, $C6, $C8, $C3, $DE, $DB, $DD, $DF, $D9, $D8, $DC, $C0, $D1,
        $85, $A3, $F2, $F3, $F4, $F5, $F6, $F7, $F8, $F9, $FA, $FB, $FC, $FD, $FE, $FF);
     
    function X2Y(const st: string; srcCp, dstCp: Byte): string;
    begin
      case srcCp of
        cpWin:
          begin
            case dstCp of
              cpWin:
                begin
                  Result := st;
                end;
              cpAlt:
                begin
                  Result := Win2Alt(st);
                end;
              cpKoi:
                begin
                  Result := Win2Koi(st);
                end;
            end;
          end;
        cpAlt:
          begin
            case dstCp of
              cpWin:
                begin
                  Result := Alt2Win(st);
                end;
              cpAlt:
                begin
                  Result := st;
                end;
              cpKoi:
                begin
                  Result := Alt2Koi(st);
                end;
            end;
          end;
        cpKoi:
          begin
            case dstCp of
              cpWin:
                begin
                  Result := Koi2Win(st);
                end;
              cpAlt:
                begin
                  Result := Koi2Alt(st);
                end;
              cpKoi:
                begin
                  Result := st;
                end;
            end;
          end;
      end;
    end;
     
    function Win2Koi(const st: string): string;
    begin
      Result := Alt2Koi(Win2Alt(st));
    end;
     
    function Koi2Win(const st: string): string;
    begin
      Result := Alt2Win(Koi2Alt(st));
    end;
     
    function Alt2Win(const st: string): string;
    var
      i: Integer;
    begin
      Alt2Win[0] := Char(Length(st));
      for i := 1 to Length(st) do
      begin
        Alt2Win[i] := Char(Alt2WinTable[Byte(st[i])]);
      end;
    end;
     
    function Win2Alt(const st: string): string;
    var
      i: Integer;
    begin
      Win2Alt[0] := Char(Length(st));
      for i := 1 to Length(st) do
      begin
        Win2Alt[i] := Char(Win2AltTable[Byte(st[i])]);
      end;
    end;
     
    function Alt2Koi(const st: string): string;
    var
      i: Integer;
    begin
      Alt2Koi[0] := Char(Length(st));
      for i := 1 to Length(st) do
      begin
        Alt2Koi[i] := Char(Alt2KoiTable[Byte(st[i])]);
      end;
    end;
     
    function Koi2Alt(const st: string): string;
    var
      i: Integer;
    begin
      Koi2Alt[0] := Char(Length(st));
      for i := 1 to Length(st) do
      begin
        Koi2Alt[i] := Char(Koi2AltTable[Byte(st[i])]);
      end;
    end;
     
    function DetermineCodepage(const st: string): Byte;
    var
      WinCount,
        AltCount,
        KoiCount,
        i, rslt: Integer;
    begin
      DetermineCodepage := cpAlt;
      WinCount := 0;
      AltCount := 0;
      KoiCount := 0;
      for i := 1 to Length(st) do
      begin
        if st[i] in AltSet then Inc(AltCount);
        if st[i] in WinSet then Inc(WinCount);
        if st[i] in KoiSet then Inc(KoiCount);
      end;
      DetermineCodepage := cpAlt;
      if KoiCount > AltCount then
      begin
        DetermineCodepage := cpKoi;
        if WinCount > KoiCount then DetermineCodepage := cpWin;
      end
      else
      begin
        if WinCount > AltCount then DetermineCodepage := cpWin;
      end;
    end;
     
    end.


