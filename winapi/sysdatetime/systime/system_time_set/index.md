---
Title: Как изменить системное время?
Date: 01.01.2007
---

Как изменить системное время?
=============================

Вариант 1:

Author: podval

Source: Vingrad.ru <https://forum.vingrad.ru>

Функция SetSystemTime.

Обрати внимание на привилегии.


------------------------------------------------------------------------

Вариант 2:

    //**********************************************************
    // Функция (раздел Public) SetPCSystemTime изменяет системную дату и время.
    // Параметр(ы) : tDati Новая дата и время
    // Возвращаемые значения: True - успешное завершение
    // False - метод несработал
    //************************************************************
    function SetPCSystemTime(tDati: TDateTime): Boolean;
    var
      tSetDati: TDateTime;
      vDatiBias: Variant;
      tTZI: TTimeZoneInformation;
      tST: TSystemTime;
    begin
      GetTimeZoneInformation(tTZI);
      vDatiBias := tTZI.Bias / 1440;
      tSetDati := tDati + vDatiBias;
      with tST do
      begin
        wYear := StrToInt(FormatDateTime('yyyy', tSetDati));
        wMonth := StrToInt(FormatDateTime('mm', tSetDati));
        wDay := StrToInt(FormatDateTime('dd', tSetDati));
        wHour := StrToInt(FormatDateTime('hh', tSetDati));
        wMinute := StrToInt(FormatDateTime('nn', tSetDati));
        wSecond := StrToInt(FormatDateTime('ss', tSetDati));
        wMilliseconds := 0;
      end;
      SetPCSystemTime := SetSystemTime(tST);
    end; 

------------------------------------------------------------------------

Вариант 3:

Для изменения системного времени используется сложный спобой (через
строки).

    DateTimeToSystemTime(tSetDati,Tst);

- работает быстрее и код короче

------------------------------------------------------------------------

Вариант 4:

Author: Pegas

Source: Vingrad.ru <https://forum.vingrad.ru>

    Procedure settime(hour, min, sec, hundreths : byte); assembler;
    asm
     mov ch, hour
     mov cl, min
     mov dh, sec
     mov dl, hundreths
     mov ah, $2d
     int $21
    end;
     
    ////////////////////////////////////////////////////////////////////////
    Procedure setdate(Year : word; Month, Day : byte); assembler;
    asm
     mov cx, year
     mov dh, month
     mov dl, day
     mov ah, $2b
     int $21
    end; 

------------------------------------------------------------------------

Вариант 5:

Source: <https://forum.sources.ru>

Следующие несколько строк кода позволяют установить системную дату и
время без использования панели управления. Дата и время устанавливаются
двумя раздельными компонентами TDateTimePicker. Дата и время
декодируются и передаются в API функцию.

Из значения часа вычитается 2 для установки правильного времени.
(Примечание Vit: вычитается не 2 часа а разница с Гринвичем)

    procedure TfmTime.btnTimeClick(Sender: TObject); 
    var vsys : _SYSTEMTIME; 
      vYear, vMonth, vDay, vHour, vMin, vSec, vMm : Word; 
    begin 
      DecodeDate( Trunc(dtpDate.Date), vYear, vMonth, vDay ); 
      DecodeTime( dtpTime.Time, vHour, vMin, vSec, vMm ); 
      vMm := 0; 
      vsys.wYear := vYear; 
      vsys.wMonth := vMonth; 
      vsys.wDay := vDay; 
      vsys.wHour := ( vHour - 2 ); 
      vsys.wMinute := vMin; 
      vsys.wSecond := vSec; 
      vsys.wMilliseconds := vMm; 
      vsys.wDayOfWeek := DayOfWeek( Trunc(dtpDate.Date) ); 
      SetSystemTime( vsys ); 
    end;

------------------------------------------------------------------------

Вариант 6:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    function SetTime(DateTime:TDateTime): boolean;
    var
      st: TSystemTime;
      ZoneTime: TTimeZoneInformation;
    begin
      GetTimeZoneInformation(ZoneTime);
      DateTime:=DateTime+ZoneTime.Bias/1440;
      with st do
      begin
        DecodeDate(DateTime, wYear, wMonth, wDay);
        DecodeTime(DateTime, wHour, wMinute, wSecond, wMilliseconds);
      end;
      Result:=SetSystemTime(st);
    end;


------------------------------------------------------------------------

Вариант 7:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Следующие несколько строк кода позволяют установить системную дату и
время без использования панели управления. Дата и время устанавливаются
двумя раздельными компонентами TDateTimePicker. Дата и время
декодируются и передаются в API функцию.

Из значения часа вычитается 2 для установки правильного времени.

    procedure TfmTime.btnTimeClick(Sender: TObject);
    var
      vsys: _SYSTEMTIME;
      vYear, vMonth, vDay, vHour, vMin, vSec, vMm: Word;
    begin
      DecodeDate( Trunc(dtpDate.Date), vYear, vMonth, vDay );
      DecodeTime( dtpTime.Time, vHour, vMin, vSec, vMm );
      vMm := 0;
      vsys.wYear := vYear;
      vsys.wMonth := vMonth;
      vsys.wDay := vDay;
      vsys.wHour := ( vHour - 2 );
      vsys.wMinute := vMin;
      vsys.wSecond := vSec;
      vsys.wMilliseconds := vMm;
      vsys.wDayOfWeek := DayOfWeek( Trunc(dtpDate.Date) );
      SetSystemTime( vsys );
    end;

