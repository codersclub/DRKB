---
Title: Управление метками томов дисков
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Управление метками томов дисков
===============================

Данный совет содержит исходный код модуля, который может помочь Вам
получить, установить и удалить метку тома гибкого или жесткого диска.
Код получения метки тома содержит функцию Delphi FindFirst, код для
установки и удаления метки тома использует вызов DOS-прерывания 21h и
функции 16h и 13h соответственно. Поскольку функция 16h не
поддерживается Windows, она должна вызываться через DPMI-прерывание 31h,
функцию 300h.

    { *** НАЧАЛО КОДА МОДУЛЯ VOLLABEL *** }
    unit VolLabel;
     
    interface
     
    uses Classes, SysUtils, WinProcs;
     
    type
     
      EInterruptError = class(Exception);
      EDPMIError = class(EInterruptError);
      Str11 = string[11];
     
    procedure SetVolumeLabel(NewLabel: Str11; Drive: Char);
    function GetVolumeLabel(Drive: Char): Str11;
    procedure DeleteVolumeLabel(Drv: Char);
     
    implementation
     
    type
     
      PRealModeRegs = ^TRealModeRegs;
      TRealModeRegs = record
        case Integer of
          0: (
            EDI, ESI, EBP, EXX, EBX, EDX, ECX, EAX: Longint;
            Flags, ES, DS, FS, GS, IP, CS, SP, SS: Word);
          1: (
            DI, DIH, SI, SIH, BP, BPH, XX, XXH: Word;
            case Integer of
              0: (
                BX, BXH, DX, DXH, CX, CXH, AX, AXH: Word);
              1: (
                BL, BH, BLH, BHH, DL, DH, DLH, DHH,
                CL, CH, CLH, CHH, AL, AH, ALH, AHH: Byte));
      end;
     
      PExtendedFCB = ^TExtendedFCB;
      TExtendedFCB = record
        ExtendedFCBflag: Byte;
        Reserved1: array[1..5] of Byte;
        Attr: Byte;
        DriveID: Byte;
        FileName: array[1..8] of Char;
        FileExt: array[1..3] of Char;
        CurrentBlockNum: Word;
        RecordSize: Word;
        FileSize: LongInt;
        PackedDate: Word;
        PackedTime: Word;
        Reserved2: array[1..8] of Byte;
        CurrentRecNum: Byte;
        RandomRecNum: LongInt;
      end;
     
    procedure RealModeInt(Int: Byte; var Regs: TRealModeRegs);
    { процедура работает с прерыванием 31h, функцией 0300h для иммитации }
    { прерывания режима реального времени для защищенного режима. }
    var
     
      ErrorFlag: Boolean;
    begin
     
      asm
        mov ErrorFlag, 0       { успешное завершение }
        mov ax, 0300h          { функция 300h }
        mov bl, Int            { прерывание режима реального времени, которое необходимо выполнить }
        mov bh, 0              { требуется }
        mov cx, 0              { помещаем слово в стек для копирования, принимаем ноль }
        les di, Regs           { es:di = Regs }
        int 31h                { DPMI-прерывание 31h }
        jnc @@End              { адрес перехода установлен в error }
        @@Error:
        mov ErrorFlag, 1       { возвращаем false в error }
        @@End:
      end;
      if ErrorFlag then
        raise EDPMIError.Create('Неудача при выполнении DPMI-прерывания');
    end;
     
    function DriveLetterToNumber(DriveLet: Char): Byte;
    { функция преобразования символа буквы диска в цифровой эквивалент. }
    begin
     
      if DriveLet in ['a'..'z'] then
        DriveLet := Chr(Ord(DriveLet) - 32);
      if not (DriveLet in ['A'..'Z']) then
        raise
          EConvertError.CreateFmt('Не могу преобразовать %s в числовой эквивалент диска',
     
          [DriveLet]);
      Result := Ord(DriveLet) - 64;
    end;
     
    procedure PadVolumeLabel(var Name: Str11);
    { процедура заполнения метки тома диска строкой с пробелами }
    var
     
      i: integer;
    begin
     
      for i := Length(Name) + 1 to 11 do
        Name := Name + ' ';
    end;
     
    function GetVolumeLabel(Drive: Char): Str11;
    { функция возвращает метку тома диска }
    var
     
      SR: TSearchRec;
      DriveLetter: Char;
      SearchString: string[7];
      P: Byte;
    begin
     
      SearchString := Drive + ':*.*';
      { ищем метку тома }
      if FindFirst(SearchString, faVolumeID, SR) = 0 then
      begin
        P := Pos('.', SR.Name);
        if P > 0 then
        begin { если у него есть точка... }
          Result := '           '; { пространство между именами }
          Move(SR.Name[1], Result[1], P - 1); { и расширениями }
          Move(SR.Name[P + 1], Result[9], 3);
        end
        else
        begin
          Result := SR.Name; { в противном случае обходимся без пробелов }
          PadVolumeLabel(Result);
        end;
      end
      else
        Result := '';
    end;
     
    procedure DeleteVolumeLabel(Drv: Char);
    { процедура удаления метки тома с данного диска }
    var
     
      CurName: Str11;
      FCB: TExtendedFCB;
      ErrorFlag: WordBool;
    begin
     
      ErrorFlag := False;
      CurName := GetVolumeLabel(Drv); { получение текущей метки тома }
      FillChar(FCB, SizeOf(FCB), 0); { инициализируем FCB нулями }
      with FCB do
      begin
        ExtendedFCBflag := $FF; { всегда }
        Attr := faVolumeID; { Аттрибут Volume ID }
        DriveID := DriveLetterToNumber(Drv); { Номер диска }
        Move(CurName[1], FileName, 8); { необходимо ввести метку тома }
        Move(CurName[9], FileExt, 3);
      end;
      asm
        push ds             { сохраняем ds }
        mov ax, ss          { помещаем сегмент FCB (ss) в ds }
        mov ds, ax
        lea dx, FCB         { помещаем смещение FCB в dx }
        mov ax, 1300h       { функция 13h }
        Call DOS3Call       { вызываем int 21h }
        pop ds              { восстанавливаем ds }
        cmp al, 00h         { проверка на успешность выполнения }
        je @@End
        @@Error:            { устанавливаем флаг ошибки }
        mov ErrorFlag, 1
        @@End:
      end;
      if ErrorFlag then
        raise EInterruptError.Create('Не могу удалить имя тома');
    end;
     
    procedure SetVolumeLabel(NewLabel: Str11; Drive: Char);
    { процедура присваивания метки тома диска. Имейте в виду, что }
    { данная процедура удаляет текущую метку перед установкой новой. }
    { Это необходимое требование для функции установки метки. }
    var
     
      Regs: TRealModeRegs;
      FCB: PExtendedFCB;
      Buf: Longint;
    begin
     
      PadVolumeLabel(NewLabel);
      if GetVolumeLabel(Drive) <> '' then { если имеем метку... }
        DeleteVolumeLabel(Drive); { удаляем метку }
      Buf := GlobalDOSAlloc(SizeOf(PExtendedFCB)); { распределяем реальный буфер }
      FCB := Ptr(LoWord(Buf), 0);
      FillChar(FCB^, SizeOf(FCB), 0); { инициализируем FCB нулями }
      with FCB^ do
      begin
        ExtendedFCBflag := $FF; { требуется }
        Attr := faVolumeID; { Аттрибут Volume ID }
        DriveID := DriveLetterToNumber(Drive); { Номер диска }
        Move(NewLabel[1], FileName, 8); { устанавливаем новую метку }
        Move(NewLabel[9], FileExt, 3);
      end;
      FillChar(Regs, SizeOf(Regs), 0);
      with Regs do
      begin { Сегмент FCB }
        ds := HiWord(Buf); { отступ = ноль }
        dx := 0;
        ax := $1600; { Функция 16h }
      end;
      RealModeInt($21, Regs); { создаем файл }
      if (Regs.al <> 0) then { проверка на успешность выполнения }
        raise EInterruptError.Create('Не могу создать метку тома');
    end;
     
    end.
    { *** КОНЕЦ КОДА МОДУЛЯ VOLLABEL *** }

