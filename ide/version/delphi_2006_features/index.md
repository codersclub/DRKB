---
Title: Новые позможности языка в Delphi 2006
Author: CatATonik
Date: 12.12.2006
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Новые позможности языка в Delphi 2006
=====================================

В Delphi 2006 появилось много расширений языка, в том числе перегрузка
операторов, "Class-like" записи. Что позволяет создавать собственные
типы данных (не классы, а именно типы значения)!

Для демонстрации этих
возможностей я написал тип TDate для работы с датами.

    unit DateType;
     
    interface
     
    uses Windows, SysUtils;
     
    type
      TYear = Integer;
      TMonth = 1..12;
      TDay = 1..31;
     
      EInvalidDateFormat = class(Exception);
     
      TDate = record
      private
        FValue: Integer;
        function  GetText: string;
        procedure SetText(const Value: string);
        procedure SetValue(const Value: Integer);
        function  GetDay: TDay;
        function  GetMonth: TMonth;
        function  GetYear: TYear;
        procedure SetDay(const NewDay: TDay);
        procedure SetMonth(const NewMonth: TMonth);
        procedure SetYear(const NewYear: TYear);
        function  GetISODate: string;
        procedure SetISODate(const Value: string);
        property  Value: Integer read FValue write SetValue;
      public
        class function Today: TDate; static;
        class function FromString(const S, FmtStr: string): TDate; static;
        class function ToString(Date: TDate; const FmtStr: string): string; static;
        function  Format(const FmtStr: string): string;
        property  Year: TYear read GetYear write SetYear;
        property  Month: TMonth read GetMonth write SetMonth;
        property  Day: TDay read GetDay write SetDay;
        property  Text: string read GetText write SetText;
        property  ISODate: string read GetISODate write SetISODate;
      public
        class operator Add(a: TDate; b: Integer): TDate; inline;
        class operator Subtract(a: TDate; b: Integer): TDate; inline;
        class operator Subtract(a: TDate; b: TDate): Integer; inline;
        class operator Implicit(a: Integer): TDate; inline;
        class operator Implicit(a: TDate): Integer; inline;
        class operator Implicit(a: TDateTime): TDate; inline;
        class operator Implicit(a: TDate): TDateTime; inline;
        class operator Inc(a: TDate): TDate; inline;
        class operator Dec(a: TDate): TDate; inline;
        class operator Equal(a, b: TDate): Boolean; inline;
        class operator NotEqual(a, b: TDate): Boolean; inline;
        class operator GreaterThan(a, b: TDate): Boolean; inline;
        class operator GreaterThanOrEqual(a, b: TDate): Boolean; inline;
        class operator LessThan(a, b: TDate): Boolean; inline;
        class operator LessThanOrEqual(a, b: TDate): Boolean; inline;
      end;
     
    const
      January   : TMonth = 1;
      February  : TMonth = 2;
      March     : TMonth = 3;
      April     : TMonth = 4;
      May       : TMonth = 5;
      June      : TMonth = 6;
      July      : TMonth = 7;
      August    : TMonth = 8;
      September : TMonth = 9;
      October   : TMonth = 10;
      November  : TMonth = 11;
      December  : TMonth = 12;
     
    var
      EraStr: array[Boolean] of string = (' i.y.', ' ai i.y.');
      DefaultDateFormat: string = 'DD.MM.YYYYE';
     
    implementation
     
    resourcestring
      SInvalidDateFormat = 'Invalid date format ''%s''';
     
    type
      TSetOfChar = set of Char;
     
    function  IntToStr(const Value: Integer; L: Integer): string; overload;
    begin
      Result := SysUtils.IntToStr(Value);
      if Length(Result) < L then
        Result := StringOfChar('0', L - Length(Result)) + Result;
    end;
     
    procedure DivMod(Dividend: Integer; Divisor: Integer;  var Result, Remainder: Integer); inline;
    begin
      Result := Dividend div Divisor;
      Remainder := Dividend mod Divisor;
    end;
     
    function ScanChars(var P: PChar; Chars: TSetOfChar): Integer; inline;
    begin
      Result := 0;
      while P^ in Chars do
      begin
        Inc(Result);
        Inc(P);
      end;
    end;
     
    function ScanNum(var P: PChar; var Value: Integer): Boolean; inline;
    begin
      Result := False;
      Value := 0;
      while P^ in ['0'..'9'] do
      begin
        Value := (Value * 10) + Ord(P^) - Ord('0');
        Inc(P);
        Result := True;
      end;
    end;
     
    function ScanText(var P: PChar; Text: array of string; var Index: Integer): Boolean; 
    var
      I: Integer;
    begin
      for I := Low(Text) to High(Text) do
        if AnsiSameText(Text[I], Copy(string(P), 1, Length(Text[I]))) then
        begin
          Index := I;
          Result := True;
          Exit;
        end;
      Result := False;
    end;
     
    function  EncodeDate(Year: TYear; Month: TMonth; Day: TDay): Integer; inline;
    var
      I, D: Integer;
      DayTable: PDayTable;
    begin
      DayTable := @MonthDays[IsLeapYear(Year)];
     
      if Year >= 0 then
      begin
        D := Day;
        for I := 1 to Month - 1 do
          Inc(D, DayTable^[I]);
        I := Year - 1;
      end
      else
      begin
        D := Day - DayTable^[Month];
        for I := 12 downto Month + 1 do
          Dec(D, DayTable^[I]);
        I := Year + 1;
      end;
      Result := I * 365 + I div 4 - I div 100 + I div 400 + D;
    end;
     
    procedure DecodeDate(Date: Integer; var Year: TYear; var Month: TMonth; var Day: TDay); inline;
    const
      D1 = 365;
      D4 = D1 * 4 + 1;
      D100 = D4 * 25 - 1;
      D400 = D100 * 4 + 1;
    var
      Y, M, D, I: Integer;
      DayTable: PDayTable;
      T: Integer;
    begin
      if Date = 0 then
      begin
        Year := -1;
        Month := 12;
        Day := 31;
        Exit;
      end
      else if Date < 0 then
        T := -Date + 1
      else
        T := Date;
     
      Dec(T);
      Y := 1;
      while T >= D400 do
      begin
        Dec(T, D400);
        Inc(Y, 400);
      end;
      DivMod(T, D100, I, D);
      if I = 4 then
      begin
        Dec(I);
        Inc(D, D100);
      end;
      Inc(Y, I * 100);
      DivMod(D, D4, I, D);
      Inc(Y, I * 4);
      DivMod(D, D1, I, D);
      if I = 4 then
      begin
        Dec(I);
        Inc(D, D1);
      end;
      Inc(Y, I);
      DayTable := @MonthDays[IsLeapYear(Y)];
      if Date < 0 then
      begin
        M := 1;
        if IsLeapYear(Y) then
          D := 365 - D
        else
          D := 364 - D;
        while True do
        begin
          I := DayTable^[M];
          if D < I then Break;
          Dec(D, I);
          Inc(M);
        end;
        Y := -Y;
      end
      else
      begin
        M := 1;
        while True do
        begin
          I := DayTable^[M];
          if D < I then Break;
          Dec(D, I);
          Inc(M);
        end;
      end;
     
      Year := Y;
      Month := M;
      Day := D + 1;
    end;
     
    { TDate }
     
    class operator TDate.Implicit(a: TDateTime): TDate;
    var
      Y, M, D: Word;
    begin
      SysUtils.DecodeDate(a, Y, M, D);
      Result.FValue := EncodeDate(Y, M, D);
    end;
     
    class operator TDate.Implicit(a: TDate): TDateTime;
    var
      Y: TYear;
      M: TMonth;
      D: TDay;
    begin
      DecodeDate(a.FValue, Y, M, D);
      Result := SysUtils.EncodeDate(Y, M, D);
    end;
     
    class operator TDate.Implicit(a: Integer): TDate;
    begin
      Result.FValue := a;
    end;
     
    class operator TDate.Implicit(a: TDate): Integer;
    begin
      Result := a.FValue;
    end;
     
    class operator TDate.Inc(a: TDate): TDate;
    begin
      Result.FValue := a.FValue + 1;
    end;
     
    class operator TDate.Dec(a: TDate): TDate;
    begin
      Result.FValue := a.FValue - 1;
    end;
     
    class operator TDate.Equal(a, b: TDate): Boolean;
    begin
      Result := a.FValue = b.FValue;
    end;
     
    class operator TDate.NotEqual(a, b: TDate): Boolean;
    begin
      Result := a.FValue <> b.FValue;
    end;
     
    class operator TDate.GreaterThan(a, b: TDate): Boolean;
    begin
      Result := a.FValue > b.FValue;
    end;
     
    class operator TDate.GreaterThanOrEqual(a, b: TDate): Boolean;
    begin
      Result := a.FValue >= b.FValue;
    end;
     
    class operator TDate.LessThan(a, b: TDate): Boolean;
    begin
      Result := a.FValue < b.FValue;
    end;
     
    class operator TDate.LessThanOrEqual(a, b: TDate): Boolean;
    begin
      Result := a.FValue <= b.FValue;
    end;
     
    class operator TDate.Add(a: TDate; b: Integer): TDate;
    begin
      Result.FValue := a.FValue + b;
    end;
     
    class operator TDate.Subtract(a, b: TDate): Integer;
    begin
      Result := a.FValue - b.FValue;
    end;
     
    class operator TDate.Subtract(a: TDate; b: Integer): TDate;
    begin
      Result.FValue := a.FValue - b;
    end;
     
    class function TDate.Today: TDate;
    var
      SystemTime: TSystemTime;
    begin
      GetLocalTime(SystemTime);
      with SystemTime do
        Result.FValue := EncodeDate(wYear, wMonth, wDay);
    end;
     
    class function TDate.FromString(const S, FmtStr: string): TDate;
     
      procedure Error;
      begin
        raise EInvalidDateFormat.CreateResFmt(@SInvalidDateFormat, [S]);
      end;
     
    var
      Fmt, Src: PChar;
      Y, M, D, E, L: Integer;
      HasY, HasM, HasD: Boolean;
    begin
      E := 1;
      Fmt := PChar(FmtStr);
      Src := PChar(S);
      HasY := False;
      HasM := False;
      HasD := False;
      while (Fmt^ <> #0) and (Src^ <> #0) do
      begin
        case Fmt^ of
        'Y', 'y':
          begin
            ScanChars(Fmt, ['Y', 'y']);
            if not ScanNum(Src, Y) then Error;
            HasY := True;
          end;
        'M', 'm':
          begin
            L := ScanChars(Fmt, ['M', 'm']);
            case L of
            1, 2: if not ScanNum(Src, M) then Error;
            3:    if not ScanText(Src, ShortMonthNames, M) then Error;
            else
              if not ScanText(Src, LongMonthNames, M) then Error;
            end;
            HasM := True;
          end;
        'D', 'd':
          begin
            ScanChars(Fmt, ['D', 'd']);
            if not ScanNum(Src, D) then Error;
            HasD := True;
          end;
        'E', 'e':
          begin
            ScanChars(Fmt, ['E', 'e']);
            if ScanText(Src, EraStr, E) then
              if E = 1 then
                E := -1;
          end;
        else
          Inc(Fmt);
          Inc(Src);
        end;
      end;
     
      if not (HasY and HasM and HasD) then Error;
     
      Result := EncodeDate(Y * E, M, D);
    end;
     
    class  function TDate.ToString(Date: TDate; const FmtStr: string): string;
    var
      Y: TYear;
      M: TMonth;
      D: TDay;
      P: PChar;
      L: Integer;
    begin
      Result := '';
      DecodeDate(Date.Value, Y, M, D);
      P := PChar(FmtStr);
      while P^ <> #0 do
      begin
        case P^ of
        'E', 'e':
          begin
            L := ScanChars(P, ['E', 'e']);
            if (L > 1) or (Y < 0) then
              Result := Result + EraStr[Y < 0];
          end;
        'Y', 'y':
          begin
            L := ScanChars(P, ['Y', 'y']);
            Result := Result + IntToStr(Abs(Y), L);
          end;
        'M', 'm':
          begin
            L := ScanChars(P, ['M', 'm']);
            case L of
            1, 2: Result := Result + IntToStr(M, L);
            3: Result := Result + ShortMonthNames[M];
            else
              Result := Result + LongMonthNames[M];
            end;
          end;
        'D', 'd':
          begin
            L := ScanChars(P, ['D', 'd']);
            Result := Result + IntToStr(D, L);
          end;
        else
          begin
            Result := Result + P^;
            Inc(P);
          end;
        end;
      end;
    end;
     
    function TDate.Format(const FmtStr: string): string;
    begin
      Result := TDate.ToString(Self, FmtStr);
    end;
     
    function TDate.GetText: string;
    begin
      Result := Format(DefaultDateFormat);
    end;
     
    procedure TDate.SetText(const Value: string);
    begin
      Self.Value := FromString(Value, DefaultDateFormat);
    end;
     
    function TDate.GetDay: TDay;
    var
      Y: TYear;
      M: TMonth;
    begin
      DecodeDate(FValue, Y, M, Result);
    end;
     
    function TDate.GetISODate: string;
    begin
      Result := Format('YYYY-MM-DD');
    end;
     
    function TDate.GetMonth: TMonth;
    var
      Y: TYear;
      D: TDay;
    begin
      DecodeDate(FValue, Y, Result, D);
    end;
     
    function TDate.GetYear: TYear;
    var
      M: TMonth;
      D: TDay;
    begin
      DecodeDate(FValue, Result, M, D);
    end;
     
    procedure TDate.SetDay(const NewDay: TDay);
    var
      Y: TYear;
      M: TMonth;
      D: TDay;
    begin
      DecodeDate(Value, Y, M, D);
      Value := EncodeDate(Y, M, NewDay);
    end;
     
    procedure TDate.SetISODate(const Value: string);
    begin
      Self.Value := TDate.FromString(Value, 'YYYY-MM-DD');
    end;
     
    procedure TDate.SetMonth(const NewMonth: TMonth);
    var
      Y: TYear;
      M: TMonth;
      D: TDay;
    begin
      DecodeDate(Value, Y, M, D);
      Value := EncodeDate(Y, NewMonth, D);
    end;
     
    procedure TDate.SetValue(const Value: Integer);
    begin
      FValue := Value;
    end;
     
    procedure TDate.SetYear(const NewYear: TYear);
    var
      Y: TYear;
      M: TMonth;
      D: TDay;
    begin
      DecodeDate(Value, Y, M, D);
      Value := EncodeDate(NewYear, M, D);
    end;
     
    end.

А вот пример его использования:

    procedure TForm1.Button1Click(Sender: TObject);
    var
      Date: TDate;
    begin
      Label1.Caption := Date.Text;
      Date := TDate.Today;
      Label2.Caption := Date.Text;
      Dec(Date);
      Label3.Caption := Date.Text;
      Label4.Caption := IntToStr(TDate.Today - Date);
      Date := Now;
      Label5.Caption := Date.Format('DD MMM YYYY');
      Date := MaxInt;
      Label6.Caption := Date.Text;
      Date.ISODate := '2009-11-25';
      Label7.Caption := Date.Text;
      Date.Year := 1993;
      Label8.Caption := Date.Text;
    end;

