---
Title: Перекодирование из одних кодировок в другие
Date: 01.01.2007
---

Перекодирование из одних кодировок в другие
===========================================

Вариант 1:

Source: <https://blackman.wp-club.net/>

Этот алгоритм позволяет перекодировать текст.

Реализованы кодировки Windows-1251, KOI8-R, ISO-8859-5 и DOS.

Кодировка - это таблица, в которой указано,
например, что символ под номером 160 - это русская буква "а", а под
номером 150 - "Ц" и т. д.

Кодировки различаются номерами русских букв
(как располагать английские буквы договорились).
Разные компьютеры в Интернете используют разные кодировки.
И поэтому, когда русский текст идет по Интернету, его многократно
перекодируют.

Этот алгоритм обеспечивает высокую скорость перекодирования больших
объемов данных.

    procedure TForm1.Button1Click(Sender: TObject);
    var
      code1, code2: TCode;
      s: string;
      c: char;
      i: integer;
      chars: array [char] of char;
      str: array [TCode] of string;
    begin
      case ComboBox1.ItemIndex of
        1: code1 := koi;
        2: code1 := iso;
        3: code1 := dos;
        else code1 := win;
      end;
      case ComboBox2.ItemIndex of
        1: code2 := koi;
        2: code2 := iso;
        3: code2 := dos;
        else code2 := win;
      end;
      s := Memo1.Text;
     
      Str[win] := 'АаБбВвГгДдЕеЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя';
      Str[koi] := 'юЮаАбБцЦдДеЕфФгГхХиИйЙкКлЛмМнНоОпПяЯрРсСтТуУжЖвВьЬыЫзЗшШэЭщЩчЧъЪ';
      Str[iso] := 'РрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯяа№бёвђгѓдєеѕжізїијйљкњлћмќн§оўпџ';
      Str[dos] := 'Ђ ЃЎ‚ўѓЈ„¤…Ґ†¦‡§€Ё‰©ЉЄ‹"Њ¬Ќ­Ћ®ЏЇђа'б'в"г"д•е–ж—з?и™йљк›лњмќнћоџп';
     
      for c := #0 to #255 do
        Chars[c] := c;
     
      for i := 1 to Length(Str[win]) do
        Chars[Str[code2][i]] := Str[code1][i];
     
      for i := 1 to Length(s) do
        s[i] := Chars[s[i]];
     
      Memo2.Text := s;
    end;


------------------------------------------------------------------------

Вариант 2:

Author: RoboSol

Source: <https://forum.sources.ru>

    unit ConvertEncodingUnit;
    interface
    type // Тип матриц перекодировки
      TCodeMatrix = array[1..255] of char;
    {******************************************************************************
    {ANSI, KOI8-R, KOI8-U, OEM/DOS, ISO
    В этой версии имеется 6 видов матриц перекодирования (тип TCodeMatrix):
    1. cmAnsiToKoi8R - перекодирует строку из кодировки ANSI в кодировку KOI8-R
    2. cmAnsiToKoi8U - перекодирует строку из кодировки ANSI в кодировку KOI8-U
    3. cmKoi8RToAnsi - перекодирует строку из кодировки KOI8-R в кодировку ANSI
    4. cmKoi8UToAnsi - перекодирует строку из кодировки KOI8-U в кодировку ANSI
    5. cmOemDosToAnsi - перекодирует строку из кодировки OEM/DOS в кодировку ANSI
    6. cmIsoToAnsi - перекодирует строку из кодировки ISO в кодировку ANSI
    ******************************************************************************}
       function ConvertEncoding(sIn: string; sCoding: string): string;
     
    const // Матрицы перекодировки
      FirstCodes =
        #1#2#3#4#5#6#7#8#9#10#11#12#13#14#15#16#17#18#19#20#21#22#23#24#25#26#27#28+
        #29#30#31' !"#$%&''()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[]^' +
        '_`abcdefghijklmnopqrstuvwxyz{|}~';
      cmAnsiToKoi8R: TCodeMatrix = FirstCodes // ver 1.0, ©VEG, 31.10.2003
        + 'ЂЃ‚ѓ„…†‡€‰Љ‹ЊЌЋЏђ‘’“”•–—?™љ›њќћџ ЎўЈ¤Ґ¦§Ё©Є«¬®Ї°±Ііґµ¶·Ј—є»јЅѕїбвчздецъй'
        + 'клмнопртуфхжигюыэящшьасБВЧЗДЕЦЪЙКЛМНОПРТУФХЖИГЮЫЭЯЩШЬАС';
      cmAnsiToKoi8U: TCodeMatrix = FirstCodes // ver 0.8, ©VEG, 31.10.2003
        + 'ЂЃ‚ѓ„…†‡€‰Љ‹ЊЌЋЏђ‘’“”•–—?™љ›њќћџ ЎўЈ¤Ґ¦§Ё©Є«¬®Ї°±Ііґµ¶·Ј—є»јЅѕїбвчздецъй'
        + 'клмнопртуфхжигюыэящшьасБВЧЗДЕЦЪЙКЛМНОПРТУФХЖИГЮЫЭЯЩШЬАС';
      cmKoi8RToAnsi: TCodeMatrix = FirstCodes // ver 1.0, ©VEG, 31.10.2003
        + '-¦-¬L-++T++---¦¦---?¦•v??? ?°?·?=¦-ёгг¬¬¬LLL---¦¦¦¦Ё¦¦TTT¦¦¦+++©юабцдефгх'
        + 'ийклмнопярстужвьызшэщчъЮАБЦДЕФГХИЙКЛМНОПЯРСТУЖВЬЫЗШЭЩЧЪ';
      cmKoi8UToAnsi: TCodeMatrix = FirstCodes // ver 1.0, ©VEG, 31.10.2003
        + '-¦-¬L-++T++---¦¦---?¦•v??? ?°?·?=¦-ёєгії¬LLL-ґў¦¦¦¦ЁЄ¦ІЇT¦¦¦+ҐЎ©юабцдефгх'
        + 'ийклмнопярстужвьызшэщчъЮАБЦДЕФГХИЙКЛМНОПЯРСТУЖВЬЫЗШЭЩЧЪ';
      cmOemDosToAnsi: TCodeMatrix = FirstCodes // ver 1.0, ©VEG, 31.10.2003
        + 'АБВГДЕЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдежзийклмноп---¦+¦¦¬¬¦¦¬---¬L+T+-+¦¦L'
        + 'г¦T¦=+¦¦TTLL-г++----¦¦-рстуфхцчшщъыьэюяЁёЄєЇїЎў°•·v№¤¦ ';
      cmIsoToAnsi: TCodeMatrix = FirstCodes // ver 1.0, ©VEG, 31.10.2003
        + '???????????????????????????????? ЁЂЃЄЅІЇЈЉЊЋЌЎЏАБВГДЕЖЗИЙКЛМНОПРСТУФХЦЧШ'
        + 'ЩЪЫЬЭЮЯабвгдежзийклмнопрстуфхцчшщъыьэюя№ёђѓєѕіїјљњћќ§ўџ';   
     
    implementation
     
    function ConvertEncoding(sIn: string; sCoding: string): string;
    //sIn - строка для перекодирования
    //sCoding - матрица для перекодирования
    //result - полученная перекодированная строка
    var
      iFtd: integer;
    begin
      Result:='';
      for iFtd := 1 to length(sIn) do
        result := result + sCoding[ord(sIn[iFtd])];
    end; // ver 1.0, (C)Vrublevsky Evgeny Gennadyevich (BELARUS/SLUTSK), 31.10.2003
    {******************************************************************************}
    end.


------------------------------------------------------------------------

Вариант 3:

Source: <https://blackman.wp-club.net/>

Как можно перекодировать сообщение (содержание) из Win в КОИ8-Р для
отправки по EMail?

    const
     Koi: Array[0..66] of Char = ("T", "Ё", "ё", "А", "Б", "В", "Г", "Д", "Е", "Ж",
                    "З", "И", "Й", "К", "Л", "М", "Н", "О", "П", "Р",
                    "С", "Т", "У", "Ф", "Х", "Ц", "Ч", "Ш", "Щ", "Ъ",
                    "Ы", "Ь", "Э", "Ю", "Я", "а", "б", "в", "г", "д",
                    "е", "ж", "з", "и", "й", "к", "л", "м", "н", "о",
                    "п", "р", "с", "т", "у", "ф", "х", "ц", "ч", "ш",
                    "щ", "ъ", "ы", "ь", "э", "ю", "я");
     Win: Array[0..66] of Char = ("ё", "Ё", "T", "ю", "а", "б", "ц", "д", "е", "ф",
                    "г", "х", "и", "й", "к", "л", "м", "н", "о", "п",
                    "я", "р", "с", "т", "у", "ж", "в", "ь", "ы", "з",
                    "ш", "э", "щ", "ч", "ъ", "Ю", "А", "Б", "Ц", "Д",
                    "Е", "Ф", "Г", "Х", "И", "Й", "К", "Л", "М", "Н",
                    "О", "П", "Я", "Р", "С", "Т", "У", "Ж", "В", "Ь",
                    "Ы", "З", "Ш", "Э", "Щ", "Ч", "Ъ");
     
     
    function WinToKoi(Str: String): String;
    var
     i, j, Index: Integer;
    begin
     Result := ""
     
     for i := 1 to Length(Str) do
     begin
      Index := -1;
      for j := Low(Win) to High(Win) do
       if Win[j] = Str[i] then
       begin
        Index := j;
        Break;
       end;
     
      if Index = -1 then Result := Result + Str[i]
             else Result := Result + Koi[Index];
     end;
    end;
     
    function KoiToWin(Str: String): String;
    var
     i, j, Index: Integer;
    begin
     Result := ""
     
     for i := 1 to Length(Str) do
     begin
      Index := -1;
      for j := Low(Win) to High(Win) do
       if Koi[j] = Str[i] then
       begin
        Index := j;
        Break;
       end;
     
      if Index = -1 then Result := Result + Str[i]
             else Result := Result + Win[Index];
     end;
    end;
     
     
    procedure SendFileOnSMTP(Host: String;
                 Port: Integer;
                 Subject,
                 FromAddress, ToAddress,
                 Body,
                 FileName: String);
    var
     NMSMTP: TNMSMTP;
    begin
     if DelSpace(ToAddress) = "" then Exit;
     if ToAddress[1] = "" then Exit;
     
     if (DelSpace(FileName) <> "") and not FileExists(FileName) then
      raise Exception.Create("SendFileOnSMTP: file not exist: " + FileName);
     
     NMSMTP := TNMSMTP.Create(nil);
     try
      NMSMTP.Host := Host;
      NMSMTP.Port := Port;
      NMSMTP.Charset := "koi8-r"
      NMSMTP.PostMessage.FromAddress := FromAddress;
      NMSMTP.PostMessage.ToAddress.Text := ToAddress;
      NMSMTP.PostMessage.Attachments.Text := FileName;
      NMSMTP.PostMessage.Subject := Subject;
      NMSMTP.PostMessage.Date := DateTimeToStr(Now);
      NMSMTP.UserID := "netmaster"
      NMSMTP.PostMessage.Body.Text := WinToKoi(Body);
      NMSMTP.FinalHeader.Clear;
      NMSMTP.TimeOut := 5000;
      NMSMTP.Connect;
      NMSMTP.SendMail;
      NMSMTP.Disconnect;
     finally
      NMSMTP.Free;
     end;
    end;


------------------------------------------------------------------------

Вариант 4:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Этот алгоритм позволяет перекодировать текст. Реализованы кодировки
Windows-1251, KOI8-R, ISO-8859-5 и DOS. Кодировка - это таблица, в
которой указано, например, что символ под номером 160 - это русская
буква "а", а под номером 150 - "Ц" и т. д. Кодировки различаются
номерами русских букв (как располагать английские буквы договорились).
Разные компьютеры в Интернете используют разные кодировки. И поэтому,
когда русский текст идет по Интернету, его многократно перекодируют.

Этот алгоритм обеспечивает высокую скорость перекодирования больших
объемов данных.

    procedure TForm1.Button1Click(Sender: TObject);
    var
      code1, code2: TCode;
      s: string;
      c: char;
      i: integer;
      chars: array [char] of char;
      str: array [TCode] of string;
    begin
      case ComboBox1.ItemIndex of
        1: code1 := koi;
        2: code1 := iso;
        3: code1 := dos;
        else code1 := win;
      end;
      case ComboBox2.ItemIndex of
        1: code2 := koi;
        2: code2 := iso;
        3: code2 := dos;
        else code2 := win;
      end;
      s := Memo1.Text;
     
      Str[win] := 'АаБбВвГгДдЕеЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя';
      Str[koi] := 'юЮаАбБцЦдДеЕфФгГхХиИйЙкКлЛмМнНоОпПяЯрРсСтТуУжЖвВьЬыЫзЗшШэЭщЩчЧъЪ';
      Str[iso] := 'РрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯяа?б?в?г?д?е?ж?з?и?йsк?лzм?н§о?пY';
      Str[dos] := '€ ??‚???„¤…?†¦‡§??‰©S?‹"?¬?­Z®???а'б'в“г”д•е–ж—з?и™йsк›л?м?нzоYп';
     
      for c := #0 to #255 do
        Chars[c] := c;
     
      for i := 1 to Length(Str[win]) do
        Chars[Str[code2][i]] := Str[code1][i];
     
      for i := 1 to Length(s) do
        s[i] := Chars[s[i]];
     
      Memo2.Text := s;
    end;


------------------------------------------------------------------------

Вариант 5:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Перекодировка текста DOS-Windows-Koi8

    procedure WinToDos;
    var
      Src, Str: PChar;
    begin
      Src := Memo1.Lines.GetText; //Берем текст из TMemo как тип PChar
      CharToOem(Src, Str); //API функция для перевода текста
      Memo2.Lines.Text := StrPas(Str);//Записываем назад
    end;
     
    procedure DosToWin;
    var
      Src, Str: PChar;
    begin
      Src := Memo1.Lines.GetText; //Берем текст из TMemo как тип PChar
      OemToChar(Src, Str); //API функция для перевода текста
      Memo2.Lines.Text := StrPas(Str);//Записываем назад
    end;
     
    var
      koi8toalt : array [0..127] of char = (
      CHR($c4), Chr($b3), Chr($da), Chr($bf),
      Chr($c0), Chr($d9), Chr($c3), Chr($b4),
      Chr($c2), Chr($c1), Chr($c5), Chr($df),
      Chr($dc), Chr($db), Chr($dd), Chr($de),
      Chr($b0), Chr($b1), Chr($b2), Chr($f4),
      Chr($fe), Chr($f9), Chr($fb), Chr($f7),
      Chr($f3), Chr($f2), Chr($ff), Chr($f5),
      Chr($f8), Chr($fd), Chr($fa), Chr($f6),
      Chr($cd), Chr($ba), Chr($d5), Chr($f1),
      Chr($d6), Chr($c9), Chr($b8), Chr($b7),
      Chr($bb), Chr($d4), Chr($d3), Chr($c8),
      Chr($be), Chr($bd), Chr($bc), Chr($c6),
      Chr($c7), Chr($cc), Chr($b5), Chr($f0),
      Chr($b6), Chr($b9), Chr($d1), Chr($d2),
      Chr($cb), Chr($cf), Chr($d0), Chr($ca),
      Chr($d8), Chr($d7), Chr($ce), Chr($fc),
      Chr($ee), Chr($a0), Chr($a1), Chr($e6),
      Chr($a4), Chr($a5), Chr($e4), Chr($a3),
      Chr($e5), Chr($a8), Chr($a9), Chr($aa),
      Chr($ab), Chr($ac), Chr($ad), Chr($ae),
      Chr($af), Chr($ef), Chr($e0), Chr($e1),
      Chr($e2), Chr($e3), Chr($a6), Chr($a2),
      Chr($ec), Chr($eb), Chr($a7), Chr($e8),
      Chr($ed), Chr($e9), Chr($e7), Chr($ea),
      Chr($9e), Chr($80), Chr($81), Chr($96),
      Chr($84), Chr($85), Chr($94), Chr($83),
      Chr($95), Chr($88), Chr($89), Chr($8a),
      Chr($8b), Chr($8c), Chr($8d), Chr($8e),
      Chr($8f), Chr($9f), Chr($90), Chr($91),
      Chr($92), Chr($93), Chr($86), Chr($82),
      Chr($9c), Chr($9b), Chr($87), Chr($98),
      Chr($9d), Chr($99), Chr($97), Chr($9a));
     
    function Koi8toWin(const Data: PChar; DataLen: Integer): PChar;
    var
      PCh: PChar;
      i: Integer;
    begin
      PCh := Data;
      for i := 1 to DataLen do
      begin
        if Ord(Pch^) > 127 then
          Pch^ := koi8toalt[Ord(Pch^) - 128];
        Inc(PCh);
      end;
      PCh := Data;
      OemToCharBuff(PCh, PCh, DWORD(DataLen));
      Result := Data;
    end;


------------------------------------------------------------------------

Вариант 6:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Перекодировка текста из Win1251 в KOI8-R и наоборот

    type
      TConvertChars = array [#128..#255] of char;
     
    const
      Win_KoiChars: TConvertChars = (
      #128,#129,#130,#131,#132,#133,#134,#135,#136,#137,#060,#139,#140,#141,#142,#143,
      #144,#145,#146,#147,#148,#169,#150,#151,#152,#153,#154,#062,#176,#157,#183,#159,
      #160,#246,#247,#074,#164,#231,#166,#167,#179,#169,#180,#060,#172,#173,#174,#183,
      #156,#177,#073,#105,#199,#181,#182,#158,#163,#191,#164,#062,#106,#189,#190,#167,
      #225,#226,#247,#231,#228,#229,#246,#250,#233,#234,#235,#236,#237,#238,#239,#240,
      #242,#243,#244,#245,#230,#232,#227,#254,#251,#253,#154,#249,#248,#252,#224,#241,
      #193,#194,#215,#199,#196,#197,#214,#218,#201,#202,#203,#204,#205,#206,#207,#208,
      #210,#211,#212,#213,#198,#200,#195,#222,#219,#221,#223,#217,#216,#220,#192,#209);
     
      Koi_WinChars: TConvertChars = (
      #128,#129,#130,#131,#132,#133,#134,#135,#136,#137,#138,#139,#140,#141,#142,#143,
      #144,#145,#146,#147,#148,#149,#150,#151,#152,#153,#218,#155,#176,#157,#183,#159,
      #160,#161,#162,#184,#186,#165,#166,#191,#168,#169,#170,#171,#172,#173,#174,#175,
      #156,#177,#178,#168,#170,#181,#182,#175,#184,#185,#186,#187,#188,#189,#190,#185,
      #254,#224,#225,#246,#228,#229,#244,#227,#245,#232,#233,#234,#235,#236,#237,#238,
      #239,#255,#240,#241,#242,#243,#230,#226,#252,#251,#231,#248,#253,#249,#247,#250,
      #222,#192,#193,#214,#196,#197,#212,#195,#213,#200,#201,#202,#203,#204,#205,#206,
      #207,#223,#208,#209,#210,#211,#198,#194,#220,#219,#199,#216,#221,#217,#215,#218);
     
    function Win_KoiConvert(const St: string): string;
    var
      i: integer;
    begin
      Result:=St;
      for i:=1 to Length(St) do
        if St[i]>#127 then
          Result[i]:=Win_KoiChars[St[i]];
    end;

