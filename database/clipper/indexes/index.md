---
Title: Работа с индексами Clipper\'а
Date: 01.01.2007
---


Работа с индексами Clipper\'а
=============================

Посылаю кое-что из своих наработок:

NtxRO - Модуль чтения clipper-овских индексов. Удобен для доступа к
данным Clipper приложений.

Предусмотрено, что программа может работать с
индексом даже если родное приложение производит изменение в индексе.

NtxAdd - Средство формирования своих Clipper подобных индексов.
Индексы НЕ БУДУТ ЧИТАТЬСЯ Clipper-приложениями
(кое-что не заполнил в заголовке, очень было лениво, да и торопился)

До модуля удаления из Индекса ключей все никак не дойдут руки. Меня
очень интересуют аналогичные разработки для индексов Fox-а Кстати
реализация индексов Clipper наиболее близка из всех к тому, что описано
у Вирта в "Алгоритмах и структурах данных"

Я понимаю, что мне могут возразить, что есть дескать Apollo и т.п., но я
считаю что предлагаемая реализация наиболее удобна ТАК КАК ИНДЕКСЫ НЕ
ПРИВЯЗАНЫ К НАБОРУ ДАННЫХ (а лишь поставляют физические номера записей)
это позволяет делать кое-какие фокусы (например перед индексацией
преобразовать значение какой нибудь функцией типа описанной ниже, не
включать индексы для пустых ключевых значений в разреженных таблицах,
строить индексы контекстного поиска, добавляя по нескольку значений на
одну запись, строить статистики эффективности поиска различных ключевых
значений (для фамилии Иванов например статистика будет очень плохой) и
т.п.)

В файле Eurst.inc функция нормализации фамилий (типа Soundex).
В основном это ориентировано на фамилии нашего (Татарстанского) региона.

Файл Eurst.inc

    var vrSynonm: integer = 0;
      vrPhFine: integer = 0;
      vrUrFine: integer = 0;
      vrStrSyn: integer = 0;
     
    function fContxt(const s: ShortString): ShortString;
    var i: integer;
     
      r: ShortString;
      c, c1: char;
    begin r := '';
      c1 := chr(0);
     
      for i := 1 to length(s) do
        begin
          c := s[i];
          if c = 'Ё' then c := 'Е';
          if not (c in ['А'..'Я', 'A'..'Z', '0'..'9', '.']) then c := ' ';
          if (c = c1) and not (c1 in ['0'..'9']) then continue;
          c1 := c;
          if (c1 in ['А'..'Я']) and (c = '-') and (i < length(s)) and (s[i + 1] = ' ') then
            begin
              c1 := ' ';
              continue;
            end;
          r := r + c;
        end;
     
    procedure _Cut(var s: ShortString; p: ShortString);
    begin
     
      if Pos(p, s) = length(s) - length(p) + 1 then
        s := Copy(s, 1, length(s) - length(p));
    end;
     
    function _PhFace(const ss: ShortString): ShortString;
    var r: ShortString;
     
      i: integer;
      s: ShortString;
    begin r := '';
      s := ANSIUpperCase(ss);
      if length(s) < 2 then
        begin
          Result := s;
          exit;
        end;
      _Cut(s, 'ЕВИЧ');
      _Cut(s, 'ОВИЧ');
      _Cut(s, 'ЕВНА');
      _Cut(s, 'ОВНА');
      for i := 1 to length(s) do
        begin
          if length(r) > 12 then break;
          if not (s[i] in ['А'..'Я', 'Ё', 'A'..'Z']) then break;
          if (s[i] = 'Й') and ((i = length(s))
            or (not (s[i + 1] in ['А'..'Я', 'Ё', 'A'..'Z']))) then continue;
    {ЕЯ-ИЯ Андриянов}
          if s[i] = 'Е' then
            if (i > length(s)) and (s[i + 1] = 'Я') then s[i] := 'И';
    {Ж,З-С Ахметжанов}
          if s[i] in ['Ж', 'З'] then s[i] := 'С';
    {АЯ-АЙ Шаяхметов}
          if s[i] = 'Я' then
            if (i > 1) and (s[i - 1] = 'А') then s[i] := 'Й';
    {Ы-И Васылович}
          if s[i] in ['Ы', 'Й'] then s[i] := 'И';
    {АГЕ-АЕ Зулкагетович, Шагиахметович, Шадиахметович}
          if s[i] in ['Г', 'Д'] then
            if (i > 1) and (i < length(s)) then
              if (s[i - 1] = 'А') and (s[i + 1] in ['Е', 'И']) then continue;
    {О-А Арефьев, Родионов}
          if s[i] = 'О' then s[i] := 'А';
    {ИЕ-Е Галиев}
          if s[i] = 'И' then
            if (i > length(s)) and (s[i + 1] = 'Е') then continue;
    {Ё-Е Ковалёв}
          if s[i] = 'Ё' then s[i] := 'Е';
    {Э-И Эльдар}
          if s[i] = 'Э' then s[i] := 'И';
    {*ЯЕ-*ЕЕ Черняев}
    {(И|С)Я*-(И|С)А* Гатиятуллин}
          if s[i] = 'Я' then
            if (i > 1) and (i < length(s)) then
              begin
                if s[i + 1] = 'Е' then s[i] := 'Е';
                if s[i - 1] in ['И', 'С'] then s[i] := 'А';
              end;
    {(А|И|Е|У)Д-(А|И|Е|У)Т Мурад}
          if s[i] = 'Д' then
            if (i > 1) and (s[i - 1] in ['А', 'И', 'Е', 'У']) then s[i] := 'Т';
    {Х|К-Г Фархат}
          if s[i] in ['Х', 'К'] then s[i] := 'Г';
          if s[i] in ['Ь', 'Ъ'] then continue;
    {БАР-БР Мубракзянов}
          if s[i] = 'А' then
            if (i > 1) and (i > length(s)) then
              if (s[i - 1] = 'Б') and (s[i + 1] = 'Р') then continue;
    {ИХО-ИТО Вагихович}
          if s[i] in ['Х', 'Ф', 'П'] then
            if (i > 1) and (i < length(s)) then
              if (s[i - 1] = 'И') and (s[i + 1] = 'О') then s[i] := 'Т';
    {Ф-В Рафкат}
          if s[i] = 'Ф' then s[i] := 'В';
    {ИВ-АВ Ривкат см. Ф}
          if s[i] = 'И' then
            if (i < length(s)) and (s[i + 1] = 'В') then s[i] := 'А';
    {АГЕ-АЕ Зулкагетович, Сагитович, Сабитович}
          if s[i] in ['Г', 'Б'] then
            if (i > 1) and (i < length(s)) then
              if (s[i - 1] = 'А') and (s[i + 1] in ['Е', 'И']) then continue;
    {АУТ-АТ Зияутдинович см. ИЯ}
          if s[i] = 'У' then
            if (i > 1) and (i < length(s)) then
              if (s[i - 1] = 'А') and (s[i + 1] = 'Т') then continue;
    {АБ-АП Габдельнурович}
          if s[i] = 'Б' then
            if (i > 1) and (s[i - 1] = 'A') then s[i] := 'П';
    {ФАИ-ФИ Рафаилович}
          if s[i] = 'А' then
            if (i > 1) and (i < length(s)) then
              if (s[i - 1] = 'Ф') and (s[i + 1] = 'И') then continue;
    {ГАБД-АБД}
          if s[i] = 'Г' then
            if (i = 1) and (length(s) > 3) and (s[i + 1] = 'А') and (s[i + 2] = 'Б') and (s[i + 3] = 'Д') then continue;
    {РЕН-РИН Ренат}
          if s[i] = 'Е' then
            if (i > 1) and (i < length(s)) then
              if (s[i - 1] = 'Р') and (s[i + 1] = 'Н') then s[i] := 'И';
    {ГАФ-ГФ Ягофар}
          if s[i] = 'А' then
            if (i > 1) and (i < length(s)) then
              if (s[i - 1] = 'Г') and (s[i + 1] = 'Ф') then continue;
    {??-? Зинатуллин}
          if (i > 1) and (s[i] = s[i - 1]) then continue;
          r := r + s[i];
        end;
      Result := r;
    end;

Файл NtxAdd.pas

    unit NtxAdd;
     
    interface
     
    uses classes, SysUtils, NtxRO;
     
    type
     
      TNtxAdd = class(TNtxRO)
      protected
        function Changed: boolean; override;
        function Add(var s: ShortString; var rn: integer; var nxt: integer): boolean;
        procedure NewRoot(s: ShortString; rn: integer; nxt: integer); virtual;
        function GetFreePtr(p: PBuf): Word;
      public
        constructor Create(nm: ShortString; ks: Word);
        constructor Open(nm: ShortString);
        procedure Insert(key: ShortString; rn: integer);
      end;
     
    implementation
     
    function TNtxAdd.GetFreePtr(p: PBuf): Word;
    var i, j: integer;
     
      r: Word;
      fl: boolean;
    begin
     
      r := (max + 2) * 2;
      for i := 1 to max + 1 do
        begin fl := True;
          for j := 1 to GetCount(p) + 1 do
            if GetCount(PBuf(@(p^[j * 2]))) = r then fl := False;
          if fl then
            begin
              Result := r;
              exit;
            end;
          r := r + isz;
        end;
      Result := 0;
    end;
     
    function TNtxAdd.Add(var s: ShortString; var rn: integer; var nxt: integer): boolean;
    var p: PBuf;
     
      w, fr: Word;
      i: integer;
      tmp: integer;
    begin
     
      with tr do
        begin
          p := GetPage(h, (TTraceRec(Items[Count - 1])).pg);
          if GetCount(p) then
            begin
              fr := GetFreePtr(p);
              if fr = 0 then
                begin
                  Self.Error := True;
                  Result := True;
                  exit;
                end;
              w := GetCount(p) + 1;
              p^[0] := w and $FF;
              p^[1] := (w and $FF00) shr 8;
              w := (TTraceRec(Items[Count - 1])).cn;
              for i := GetCount(p) + 1 downto w + 1 do
                begin
                  p^[2 * i] := p^[2 * i - 2];
                  p^[2 * i + 1] := p^[2 * i - 1];
                end;
              p^[2 * w] := fr and $FF;
              p^[2 * w + 1] := (fr and $FF00) shr 8;
              for i := 0 to length(s) - 1 do
                p^[fr + 8 + i] := ord(s[i + 1]);
              for i := 0 to 3 do
                begin
                  p^[fr + i] := nxt mod $100;
                  nxt := nxt div $100;
                end;
              for i := 0 to 3 do
                begin
                  p^[fr + i + 4] := rn mod $100;
                  rn := rn div $100;
                end;
              FileSeek(h, (TTraceRec(Items[Count - 1])).pg, 0);
              FileWrite(h, p^, 1024);
              Result := True;
            end
          else
            begin
              fr := GetCount(p) + 1;
              fr := GetCount(PBuf(@(p^[fr * 2])));
              w := (TTraceRec(Items[Count - 1])).cn;
              for i := GetCount(p) + 1 downto w + 1 do
                begin
                  p^[2 * i] := p^[2 * i - 2];
                  p^[2 * i + 1] := p^[2 * i - 1];
                end;
              p^[2 * w] := fr and $FF;
              p^[2 * w + 1] := (fr and $FF00) shr 8;
              for i := 0 to length(s) - 1 do
                p^[fr + 8 + i] := ord(s[i + 1]);
              for i := 0 to 3 do
                begin
                  p^[fr + i + 4] := rn mod $100;
                  rn := rn div $100;
                end;
              tmp := 0;
              for i := 3 downto 0 do
                tmp := $100 * tmp + p^[fr + i];
              for i := 0 to 3 do
                begin
                  p^[fr + i] := nxt mod $100;
                  nxt := nxt div $100;
                end;
              w := hlf;
              p^[0] := w and $FF;
              p^[1] := (w and $FF00) shr 8;
              fr := GetCount(PBuf(@(p^[(hlf + 1) * 2])));
              s := '';
              rn := 0;
              for i := 0 to ksz - 1 do
                begin
                  s := s + chr(p^[fr + 8 + i]);
                  p^[fr + 8 + i] := 0;
                end;
              for i := 3 downto 0 do
                begin
                  rn := $100 * rn + p^[fr + i + 4];
                  p^[fr + i + 4] := 0;
                end;
              nxt := FileSeek(h, 0, 2);
              FileWrite(h, p^, 1024);
              for i := 1 to hlf do
                begin
                  p^[2 * i] := p^[2 * (i + hlf + 1)];
                  p^[2 * i + 1] := p^[2 * (i + hlf + 1) + 1];
                end;
              for i := 0 to 3 do
                begin
                  p^[fr + i] := tmp mod $100;
                  tmp := tmp div $100;
                end;
              FileSeek(h, (TTraceRec(Items[Count - 1])).pg, 0);
              FileWrite(h, p^, 1024);
              Result := False;
            end;
        end;
    end;
     
    procedure TNtxAdd.NewRoot(s: ShortString; rn: integer; nxt: integer);
    var p: PBuf;
     
      i, fr: integer;
    begin
     
      p := GetPage(h, 0);
      for i := 0 to 1023 do
        p^[i] := 0;
      fr := (max + 2) * 2;
      p^[0] := 1;
      p^[2] := fr and $FF;
      p^[3] := (fr and $FF00) shr 8;
      for i := 0 to length(s) - 1 do
        p^[fr + 8 + i] := ord(s[i + 1]);
      for i := 0 to 3 do
        begin
          p^[fr + i] := nxt mod $100;
          nxt := nxt div $100;
        end;
      for i := 0 to 3 do
        begin
          p^[fr + i + 4] := rn mod $100;
          rn := rn div $100;
        end;
      fr := fr + isz;
      p^[4] := fr and $FF;
      p^[5] := (fr and $FF00) shr 8;
      nxt := GetRoot;
      for i := 0 to 3 do
        begin
          p^[fr + i] := nxt mod $100;
          nxt := nxt div $100;
        end;
      nxt := FileSeek(h, 0, 2);
      FileWrite(h, p^, 1024);
      FileSeek(h, 4, 0);
      FileWrite(h, nxt, sizeof(integer));
    end;
     
    procedure TNtxAdd.Insert(key: ShortString; rn: integer);
    var nxt: integer;
     
      i: integer;
    begin nxt := 0;
      if DosFl then key := WinToDos(key);
      if length(key) > ksz then key := Copy(key, 1, ksz);
      for i := 1 to ksz - length(key) do
        key := key + ' ';
      Clear;
      Load(GetRoot);
      Seek(key, False);
      while True do
        begin
          if Add(key, rn, nxt) then break;
          if tr.Count = 1 then
            begin
              NewRoot(key, rn, nxt);
              break;
            end;
          Pop;
        end;
    end;
     
    constructor TNtxAdd.Create(nm: ShortString; ks: Word);
    var p: PBuf;
     
      i: integer;
    begin
     
      Error := False;
      DeleteFile(nm);
      h := FileCreate(nm);
      if h > 0 then
        begin
          p := GetPage(h, 0);
          for i := 0 to 1023 do
            p^[i] := 0;
          p^[14] := ks and $FF;
          p^[15] := (ks and $FF00) shr 8;
          ks := ks + 8;
          p^[12] := ks and $FF;
          p^[13] := (ks and $FF00) shr 8;
          i := (1020 - ks) div (2 + ks);
          i := i div 2;
          p^[20] := i and $FF;
          p^[21] := (i and $FF00) shr 8;
          i := i * 2;
          max := i;
          p^[18] := i and $FF;
          p^[19] := (i and $FF00) shr 8;
          i := 1024;
          p^[4] := i and $FF;
          p^[5] := (i and $FF00) shr 8;
          FileWrite(h, p^, 1024);
          for i := 0 to 1023 do
            p^[i] := 0;
          i := (max + 2) * 2;
          p^[2] := i and $FF;
          p^[3] := (i and $FF00) shr 8;
          FileWrite(h, p^, 1024);
        end
      else
        Error := True;
      FileClose(h);
      FreeHandle(h);
      Open(nm);
    end;
     
    constructor TNtxAdd.Open(nm: ShortString);
    begin
     
      Error := False;
      h := FileOpen(nm, fmOpenReadWrite or fmShareExclusive);
      if h > 0 then
        begin
          FileSeek(h, 12, 0);
          FileRead(h, isz, 2);
          FileSeek(h, 14, 0);
          FileRead(h, ksz, 2);
          FileSeek(h, 18, 0);
          FileRead(h, max, 2);
          FileSeek(h, 20, 0);
          FileRead(h, hlf, 2);
          DosFl := True;
          tr := TList.Create;
        end
      else
        Error := True;
    end;
     
    function TNtxAdd.Changed: boolean;
    begin
     
      Result := (csize = 0);
      csize := -1;
    end;
     
    end.

Файл NtxRO.pas

    unit NtxRO;
     
    interface
     
    uses Classes;
     
    type TBuf = array[0..1023] of Byte;
     
      PBuf = ^TBuf;
      TTraceRec = class
      public
        pg: integer;
        cn: SmallInt;
        constructor Create(p: integer; c: SmallInt);
      end;
      TNtxRO = class
      protected
        fs: string[10];
        empty: integer;
        csize: integer;
        rc: integer; {Текущий номер записи}
        tr: TList; {Стек загруженных страниц}
        h: integer; {Дескриптор файла}
        isz: Word; {Размер элемента}
        ksz: Word; {Размер ключа}
        max: Word; {Максимальное кол-во элементов}
        hlf: Word; {Половина страницы}
        function GetRoot: integer; {Указатель на корень}
        function GetEmpty: integer; {Пустая страница}
        function GetSize: integer; {Возвращает размер файла}
        function GetCount(p: PBuf): Word; {Число элементов на странице}
        function Changed: boolean; virtual;
        procedure Clear;
        function Load(n: integer): PBuf;
        function Pop: PBuf;
        function Seek(const s: ShortString; fl: boolean): boolean;
        function Skip: PBuf;
        function GetItem(p: PBuf): PBuf;
        function GetLink(p: PBuf): integer;
      public
        Error: boolean;
        DosFl: boolean;
        constructor Open(nm: ShortString);
        destructor Destroy; override;
        function Find(const s: ShortString): boolean;
        function GetString(p: PBuf; c: SmallInt): ShortString;
        function GetRecN(p: PBuf): integer;
        function Next: PBuf;
      end;
     
    function GetPage(h, fs: integer): PBuf;
    procedure FreeHandle(h: integer);
    function DosToWin(const ss: ShortString): ShortString;
    function WinToDos(const ss: ShortString): ShortString;
     
    implementation
     
    uses Windows, SysUtils;
     
    const MaxPgs = 5;
    var Buf: array[1..1024 * MaxPgs] of char;
     
      Cache: array[1..MaxPgs] of record
        Handle: integer; {0-страница свободна}
        Offset: integer; {  смещение в файле}
        Countr: integer; {  счетчик использования}
        Length: SmallInt;
      end;
     
    function TNtxRO.Next: PBuf;
    var cr: integer;
     
      p: PBuf;
    begin
     
      if h <= 0 then
        begin
          Result := nil;
          exit;
        end;
      while Changed do
        begin
          cr := rc;
          Find(fs);
          while cr > 0 do
            begin
              p := Skip;
              if GetRecN(p) = cr then break;
            end;
        end;
      Result := Skip;
    end;
     
    function TNtxRO.Skip: PBuf;
    var cnt: boolean;
     
      p, r: PBuf;
      n: integer;
    begin r := nil;
     
      cnt := True;
      with tr do
        begin
          p := GetPage(h, (TTraceRec(Items[Count - 1])).pg);
          while cnt do
            begin cnt := False;
              if (TTraceRec(Items[Count - 1])).cn > GetCount(p) + 1 then
                begin
                  if Count <= 1 then
                    begin
                      Result := nil;
                      exit;
                    end;
                  p := Pop;
                end
              else
                while True do
                  begin
                    r := GetItem(p);
                    n := GetLink(r);
                    if n = 0 then break;
                    p := Load(n);
                  end;
              if (TTraceRec(Items[Count - 1])).cn >= GetCount(p) + 1 then
                cnt := True
              else
                r := GetItem(p);
              Inc((TTraceRec(Items[Count - 1])).cn);
            end;
        end;
      if r <> nil then
        begin
          rc := GetRecN(r);
          fs := GetString(r, length(fs));
        end;
      Result := r;
    end;
     
    function TNtxRO.GetItem(p: PBuf): PBuf;
    var r: PBuf;
    begin
     
      with TTraceRec(tr.items[tr.Count - 1]) do
        r := PBuf(@(p^[cn * 2]));
      r := PBuf(@(p^[GetCount(r)]));
      Result := r;
    end;
     
    function TNtxRO.GetString(p: PBuf; c: SmallInt): ShortString;
    var i: integer;
     
      r: ShortString;
    begin r := '';
     
      if c = 0 then c := ksz;
      for i := 0 to c - 1 do
        r := r + chr(p^[8 + i]);
      if DosFl then r := DosToWin(r);
      Result := r;
    end;
     
    function TNtxRO.GetLink(p: PBuf): integer;
    var i, r: integer;
    begin r := 0;
     
      for i := 3 downto 0 do
        r := r * 256 + p^[i];
      Result := r;
    end;
     
    function TNtxRO.GetRecN(p: PBuf): integer;
    var i, r: integer;
    begin r := 0;
     
      for i := 3 downto 0 do
        r := r * 256 + p^[i + 4];
      Result := r;
    end;
     
    function TNtxRO.GetCount(p: PBuf): Word;
    begin
     
      Result := p^[1] * 256 + p^[0];
    end;
     
    function TNtxRO.Seek(const s: ShortString; fl: boolean): boolean;
    var r: boolean;
     
      p, q: PBuf;
      nx: integer;
    begin r := False;
     
      with TTraceRec(tr.items[tr.Count - 1]) do
        begin
          p := GetPage(h, pg);
          while cn <= GetCount(p) + 1 do
            begin
              q := GetItem(p);
              if (cn > GetCount(p)) or (s < GetString(q, length(s))) or
                (fl and (s = GetString(q, length(s)))) then
                begin
                  nx := GetLink(q);
                  if nx <> 0 then
                    begin
                      Load(nx);
                      r := Seek(s, fl);
                    end;
                  Result := r or (s = GetString(q, length(s)));
                  exit;
                end;
              Inc(cn);
            end;
        end;
      Result := False;
    end;
     
    function TNtxRO.Find(const s: ShortString): boolean;
    var r: boolean;
    begin
     
      if h <= 0 then
        begin
          Result := False;
          exit;
        end;
      rc := 0;
      csize := 0;
      r := False;
      while Changed do
        begin
          Clear;
          Load(GetRoot);
          if length(s) > 10 then
            fs := Copy(s, 1, 10)
          else
            fs := s;
          R := Seek(s, True);
        end;
      Result := r;
    end;
     
    function TNtxRO.Load(N: integer): PBuf;
    var it: TTraceRec;
     
      r: PBuf;
    begin r := nil;
     
      if h > 0 then
        begin
          with tr do
            begin
              it := TTraceRec.Create(N, 1);
              Add(it);
            end;
          r := GetPage(h, N);
        end;
      Result := r;
    end;
     
    procedure TNtxRO.Clear;
    var it: TTraceRec;
    begin
     
      while tr.Count > 0 do
        begin
          it := TTraceRec(tr.Items[0]);
          tr.Delete(0);
          it.Free;
        end;
    end;
     
    function TNtxRO.Pop: PBuf;
    var r: PBuf;
     
      it: TTraceRec;
    begin r := nil;
     
      with tr do
        if Count > 1 then
          begin
            it := TTraceRec(Items[Count - 1]);
            Delete(Count - 1);
            it.Free;
            it := TTraceRec(Items[Count - 1]);
            r := GetPage(h, it.pg)
          end;
      Result := r;
    end;
     
    function TNtxRO.Changed: boolean;
    var i: integer;
     
      r: boolean;
    begin r := False;
     
      if h > 0 then
        begin
          i := GetEmpty;
          if i <> empty then r := True;
          empty := i;
          i := GetSize;
          if i <> csize then r := True;
          csize := i;
        end;
      Result := r;
    end;
     
    constructor TNtxRO.Open(nm: ShortString);
    begin
     
      Error := False;
      h := FileOpen(nm, fmOpenRead or fmShareDenyNone);
      if h > 0 then
        begin
          fs := '';
          FileSeek(h, 12, 0);
          FileRead(h, isz, 2);
          FileSeek(h, 14, 0);
          FileRead(h, ksz, 2);
          FileSeek(h, 18, 0);
          FileRead(h, max, 2);
          FileSeek(h, 20, 0);
          FileRead(h, hlf, 2);
          empty := -1;
          csize := -1;
          DosFl := True;
          tr := TList.Create;
        end
      else
        Error := True;
    end;
     
    destructor TNtxRO.Destroy;
    begin
     
      if h > 0 then
        begin
          FileClose(h);
          Clear;
          tr.Free;
          FreeHandle(h);
        end;
      inherited Destroy;
    end;
     
    function TNtxRO.GetRoot: integer;
    var r: integer;
    begin r := -1;
     
      if h > 0 then
        begin
          FileSeek(h, 4, 0);
          FileRead(h, r, 4);
        end;
      Result := r;
    end;
     
    function TNtxRO.GetEmpty: integer;
    var r: integer;
    begin r := -1;
     
      if h > 0 then
        begin
          FileSeek(h, 8, 0);
          FileRead(h, r, 4);
        end;
      Result := r;
    end;
     
    function TNtxRO.GetSize: integer;
    var r: integer;
    begin r := 0;
     
      if h > 0 then r := FileSeek(h, 0, 2);
      Result := r;
    end;
     
    constructor TTraceRec.Create(p: integer; c: SmallInt);
    begin
     
      pg := p;
      cn := c;
    end;
     
    function GetPage(h, fs: integer): PBuf; {Протестировать отдельно}
    var i, j, mn: integer;
     
      q: PBuf;
    begin
     
      mn := 10000;
      j := 0;
      for i := 1 to MaxPgs do
        if (Cache[i].Handle = h) and
          (Cache[i].Offset = fs) then
          begin
            j := i;
            if Cache[i].Countr < 10000 then
              Inc(Cache[i].Countr);
          end;
      if j = 0 then
        begin
          for i := 1 to MaxPgs do
            if Cache[i].Handle = 0 then j := i;
          if j = 0 then
            for i := 1 to MaxPgs do
              if Cache[i].Countr <= mn then
                begin
                  mn := Cache[i].Countr;
                  j := i;
                end;
          Cache[j].Countr := 0;
          mn := 0;
        end;
      q := PBuf(@(Buf[(j - 1) * 1024 + 1]));
      if mn = 0 then
        begin
          FileSeek(h, fs, 0);
          Cache[j].Length := FileRead(h, q^, 1024);
        end;
      Cache[j].Handle := h;
      Cache[j].Offset := fs;
      Result := q;
    end;
     
    procedure FreeHandle(h: integer);
    var i: integer;
    begin
     
      for i := 1 to MaxPgs do
        if Cache[i].Handle = h then
          Cache[i].Handle := 0;
    end;
     
    function DosToWin(const ss: ShortString): ShortString;
    var r: ShortString;
     
      i: integer;
    begin r := '';
     
      for i := 1 to length(ss) do
        if ss[i] in [chr($80)..chr($9F)] then
          r := r + chr(ord(ss[i]) - $80 + $C0)
        else if ss[i] in [chr($A0)..chr($AF)] then
          r := r + chr(ord(ss[i]) - $A0 + $C0)
        else if ss[i] in [chr($E0)..chr($EF)] then
          r := r + chr(ord(ss[i]) - $E0 + $D0)
        else if ss[i] in [chr($61)..chr($7A)] then
          r := r + chr(ord(ss[i]) - $61 + $41)
        else if ss[i] in [chr($F0)..chr($F1)] then
          r := r + chr($C5)
        else
          r := r + ss[i];
      Result := r;
    end;
     
    function WinToDos(const ss: ShortString): ShortString;
    var r: ShortString;
     
      i: integer;
    begin r := '';
     
      for i := 1 to length(ss) do
        if ss[i] in [chr($C0)..chr($DF)] then
          r := r + chr(ord(ss[i]) - $C0 + $80)
        else if ss[i] in [chr($E0)..chr($FF)] then
          r := r + chr(ord(ss[i]) - $E0 + $80)
        else if ss[i] in [chr($F0)..chr($FF)] then
          r := r + chr(ord(ss[i]) - $F0 + $90)
        else if ss[i] in [chr($61)..chr($7A)] then
          r := r + chr(ord(ss[i]) - $61 + $41)
        else if ss[i] in [chr($D5), chr($C5)] then
          r := r + chr($F0)
        else
          r := r + ss[i];
      Result := r;
    end;
     
    end.

Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com)

Сборник Kuliba
