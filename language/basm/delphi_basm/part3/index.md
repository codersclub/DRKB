---
Title: Примеры
Date: 01.01.2007
---


Примеры
=======

::: {.date}
01.01.2007
:::

Примеры

В данной главе, мы приведем несколько примеров на basm. Это только
первая часть моих статей по Дельфи и встроенному ассемблеру, которая
опубликована на данном сайте. Расположено это на странице featured
articles, и называется Considerations for writing and using Intel
assembly code in Delphi projects (Последнее изменение 1 сентября 2001).
Мы будем признательны за замечания или советы по этим страницам.

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"}
  --- ------------------------------------------
  •   Прямой доступ к портам в Windows 95 и 98
  --- ------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"}
  --- ------------------------------------------------
  •   Подсчет количества установленных бит в integer
  --- ------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"}
  --- -------------------------------------------
  •   Проверка установки отдельного бита (0-31)
  --- -------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"}
  --- --------------------------------------------
  •   Установка отдельного бита (0-31) в единицу
  --- --------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"}
  --- -----------------------
  •   Сброс отдельного бита
  --- -----------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"}
  --- -------------------------------------
  •   Извлечение битовой маски их integer
  --- -------------------------------------
:::

Есть замечания насчет этих примеров? Пожалуйста, посылайте их по адресу
в главе Как связаться с Гуйдо Гайбелсом!

Прямой доступ к портам в Windows 95 и 98

    function PortInByte(PortAddress: Word): Byte;
    asm
      mov dx,ax
      in al,dx
    end;
     
    procedure PortOutByte(PortAddress: Word; Data: Byte);
    asm
      xchg dx,ax
      out dx,al
    end;

 

Подсчет количества установленных бит в integer

    function CountBits(const Value: Integer): Integer;
    asm
      mov ECX,EAX
      xor EAX,EAX
      test ECX,ECX
      jz @@ending
     @@counting:
      shr ECX,1
      adc EAX,0
      test ECX,ECX
      jnz @@counting
     @@ending:
    end;

 

Проверка установки отдельного бита (0-31)

    function IsBit(Value, Pos: Integer): Boolean;
    asm
      mov ECX,EAX
      xor EAX,EAX
      and EDX,31
      bt ECX,EDX
      adc EAX,0
    end;

 

Установка отдельного бита (0-31) в единицу

    function SetBit(const Value, Pos: Integer): Integer;
    asm
      and        EDX,31
      bts        EAX,EDX
    end;

 

Сброс отдельного бита

    function ClearBit(const Value, Pos: Integer): Integer;
    asm
      and        EDX,31
      btr        EAX,EDX
    end;

 

Извлечение битовой маски из integer

    function ExtractBits(const Value, Start, Count: Integer): Integer;
    const
      Mask: array[0..31] of Integer = 
                                ($01,$03,$07,$0F,$1F,$3F,$7F,$FF,
                                 $01FF,$03FF,$07FF,$0FFF,$1FFF,$3FFF,$7FFF,$FFFF,
                                 $01FFFF,$03FFFF,$07FFFF,$0FFFFF,
                                 $1FFFFF,$3FFFFF,$7FFFFF,$FFFFFF,
                                 $01FFFFFF,$03FFFFFF,$07FFFFFF,$0FFFFFFF,
                                 $1FFFFFFF,$3FFFFFFF,$7FFFFFFF,$FFFFFFFF);
    asm
      xchg ECX,EDX
      test EDX,EDX
      jnz @@isoke
      xor EAX,EAX
      jmp @@ending
     @@isoke:
      dec EDX
      and EDX,31
      shr EAX,cl
      and EAX,dword ptr [Mask+EDX*4]
     @@ending:
    end;

Модуль CpuInfo

Здесь приведена часть проекта, модуль CpuInfo. Полностью проект
находится на сайте Гуйдо Гайбелса
http://www.optimalcode.com/Guido/cpuinfo.html и в виде архива
cpuinfo.zip вместе с этой книгой.

    unit cpuinfo;
    {Author: Guido GYBELS, april 2001, All rights reserved.
     This unit offers some types and a global instance that
     uses the features of the CPUID instruction as it is
     implemented on modern Intel processors.
     By using the properties of the global CPUID object,
     application builders can quickly evaluate the features
     of the CPU their program is running on. This allows to
     optimise routines for specific CPU's.
     REVISION HISTORY:
     - april 2001, First version}
    interface
     
    uses Windows, Sysutils;
     
    type
    {The TCPUIDResult record type contains fields that
     stores the values returned by the various levels of
     the CPUID instruction.}
    TCPUIDResult = packed record
    IsValid: ByteBool;
    HighestLevel: dWord;
    GenuineIntel: ByteBool;
    VendorID: packed array[0..11] of Char;
    ProcessorSignature: dWord;
    MiscInfo: dWord;
    FeatureFlags: packed array[0..1] of dWord;
    Stepping: Byte;
    Model: Byte;
    Family: Byte;
    ProcessorType: Byte;
    ExtendedModel: Byte;
    ExtendedFamily: Byte;
    FPUPresent: ByteBool;
    TimeStampCounter: ByteBool;
    CX8Supported: ByteBool;
    FastSystemCallSupported: ByteBool;
    CMOVSupported: ByteBool;
    FCOMISupported: ByteBool;
    MMXSupported: ByteBool;
    SSESupported: ByteBool;
    SSE2Supported: ByteBool;
    SerialNumberEnabled: ByteBool;
    CacheDescriptors: packed array[0..47] of Byte;
    SerialNumber: packed array[0..1] of dWord;
    end;
    TCPUType = (ctOriginal, ctOverDrive, ctDualProcessor, ctUnknown);
    TCPUFamily = (cfUnknown, cf486, cfPentium, cfPentiumPro, cfPentium4);
    TCPUFeature = (ftFPU, ftTSC, ftCX8, ftFSC, ftCMOV, ftFCOMI, ftMMX, ftSSE, ftSSE2, ftSerialNumber);
    TCacheSize = (caSizeUnknown, caNoCache, Ca128K, Ca256K, ca512K, ca1M, ca2M);
    TCPUBrandID = (brUnsupported, brCeleron, brP3, brP3Xeon, brP4);
    {The TCPUID class is the class for the global CPUID instance
    that is created by this unit and that offers several properties
    usefull in identifying the CPU your application is running on.
    Application builders should use the global CPUID object since
    there is no need to create new, additional, instances of this
    class (because they would simply return an identical object).
    All properties are read-only since it is impossible to change
    the CPU characteristics.}
    TCPUID = class
    private
    FCPUIDResult: TCPUIDResult;
    function GetBooleanField(Index: Integer): Boolean;
    function GetCPUBrand: TCPUBrandID;
    function GetCPUFamily: TCPUFamily;
    function GetCPUType: TCPUType;
    function GetFeature(Index: TCPUFeature): Boolean;
    function GetIntegerField(Index: Integer): Integer;
    function GetLevel2Cache: TCacheSize;
    function GetProcessor: String;
    function GetSerialNumber: String;
    function GetVendorID: String;
      public
    constructor Create;
    property BrandID: TCPUBrandID read GetCPUBrand;
    property CanIdentify: Boolean index 0 read GetBooleanField;
    property CPUFamily: TCPUFamily read GetCPUFamily;
    property CPUID: TCPUIDResult read FCPUIDResult;
    property CPUType: TCPUType read GetCPUType;
    property Family: Integer index 3 read GetIntegerField;
    property Features[Index: TCPUFeature]: Boolean read GetFeature;
    property GenuineIntel: Boolean index 1 read GetBooleanField;
    property HighestIDLevel: Integer index 0 read GetIntegerField;
    property CacheSize: TCacheSize read GetLevel2Cache;
    property Model: Integer index 2 read GetIntegerField;
    property Processor: String read GetProcessor;
    property SerialNumber: String read GetSerialNumber;
    property Stepping: Integer index 1 read GetIntegerField;
    property VendorID: String read GetVendorID;
      end;
     
    var
    CPUID: TCPUID;
     
    implementation
     
    const
    SizeOfTCPUIDResult = SizeOf(TCPUIDResult);
     
    {GetCPUIDResult is a basm routine that performs the actual
    CPUID calls and stores the results in a record of type
    TCPUIDResult. If the CPUID instruction is supported by the
    processor, this routine will call it for every value of
    eax allowed for that processor, making one call for each
    value and storing the results in the record. Only for eax=2
    is it possible that multiple calls are performed in order
    to get to all the cache descriptors.
    More information about the CPUID function can be found in
    the Intel Application Note AP-485.}
     
    function GetCPUIDResult: TCPUIDResult;
    var
    Counter: Byte;
    asm
    push ebx  {changes all general registers...}
    push edi  {...so, make sure we save what needs to be preserved}
    push esi
    mov edi,eax {pointer to result in edi}
    mov ecx,SizeOfTCPUIDResult
    mov esi,edi {zero the entire record out}
    add esi,ecx
    neg ecx
    @loop:
    mov BYTE PTR [esi+ecx],0
    inc ecx
    jnz @loop
    pushfd {test if bit 21 of extended flags}
    pop eax {can toggle. If yes, then cpuid is supported}
    mov ebx,eax
    xor eax,1 shl 21
    push eax
    popfd
    pushfd
    pop eax
    xor eax,ebx
    and eax,1 shl 21 {Only if bit 21 can toggle...}
    setnz TCPUIDResult(edi).IsValid {...are the results valid}
    jz @ending {don't continue if cpuid is not supported}
    xor eax,eax {eax=0: get highest value and Vendor ID}
    db $0f,$a2 {cpuid}
    mov DWORD PTR TCPUIDResult(edi).VendorID,ebx
    mov DWORD PTR TCPUIDResult(edi).VendorID+4,edx
    mov DWORD PTR TCPUIDResult(edi).VendorID+8,ecx
    xor ebx,$756e6547 {Check if Vendor is Intel...}
    xor edx,$49656e69
    xor ecx,$6c65746e
    or ebx,edx
    or ebx,ecx
    test ebx,ebx
    setz TCPUIDResult(edi).GenuineIntel {...and set boolean accordingly}
    mov TCPUIDResult(edi).HighestLevel,eax {also save highest level...}
    cmp eax,0
    setnz TCPUIDResult(edi).IsValid {...and if it is 0, results not valid}
    jz @ending {if level 1 is not supported, bail out}
    mov eax,1
    db $0f,$a2 {cpuid} {else get processor signature and feature flags}
    mov TCPUIDResult(edi).ProcessorSignature,eax
    mov TCPUIDResult(edi).MiscInfo,ebx
    mov DWORD PTR TCPUIDResult(edi).FeatureFlags,ecx
    mov DWORD PTR TCPUIDResult(edi).FeatureFlags+4,edx
    mov ebx,eax {Then isolate the various items from...}
    and al,$0f {...the processor signature into their fields}
    mov TCPUIDResult(edi).Stepping,al
    mov eax,ebx
    shr eax,4
    and al,$0f
    mov TCPUIDResult(edi).Model,al
    mov eax,ebx
    shr eax,8
    and al,$0f
    mov TCPUIDResult(edi).Family,al
    mov eax,ebx
    shr eax,12
    and al,$03
    mov TCPUIDResult(edi).ProcessorType,al
    mov eax,ebx
    shr eax,16
    and al,$0f
    mov TCPUIDResult(edi).ExtendedModel,al
    mov eax,ebx
    shr eax,20
    mov TCPUIDResult(edi).ExtendedFamily,al
    test edx,1 {Next, check various feature bits and set their...}
    setnz TCPUIDResult(edi).FPUPresent {...respective flags in the record}
    test edx,1 shl 4
    setnz TCPUIDResult(edi).TimeStampCounter
    test edx,1 shl 8
    setnz TCPUIDResult(edi).CX8Supported
    test edx,1 shl 11
    setnz TCPUIDResult(edi).FastSystemCallSupported
    test edx,1 shl 15
    setnz TCPUIDResult(edi).CMOVSupported
    mov eax,edx
    and eax,(1 shl 15) or 1
    cmp eax,(1 shl 15) or 1
    setz TCPUIDResult(edi).FCOMISupported
    test edx,1 shl 18
    setnz TCPUIDResult(edi).SerialNumberEnabled
    test edx,1 shl 23
    setnz TCPUIDResult(edi).MMXSupported
    test edx,1 shl 25
    setnz TCPUIDResult(edi).SSESupported
    test edx,1 shl 26
    setnz TCPUIDResult(edi).SSE2Supported
    cmp TCPUIDResult(edi).HighestLevel,2 {If eax=2 is not supported...}
    jl @ending {...then bail out}
    lea esi,TCPUIDResult(edi).CacheDescriptors
    mov eax,2 {else get the cache descriptors}
    db $0f,$a2 {cpuid}
    and al,3 {first time, al will hold a counter...}
    mov [Counter],al {...that tells us how often we should...}
    xor al,al {...call with eax=2 to get all descriptors...}
    @nextdescriptor:
    test eax,1 shl 31 {If bit 31 is set, then no valid descriptors...}
    jnz @invalidA {...so skip this register}
    mov DWORD PTR [esi],eax
    @invalidA:
    test ebx,1 shl 31
    jnz @invalidB
    mov DWORD PTR [esi+4],ebx
    @invalidB:
    test ecx,1 shl 31
    jnz @invalidC
    mov DWORD PTR [esi+8],ecx
    @invalidC:
    test edx,1 shl 31
    jnz @invalidD
    mov DWORD PTR [esi+12],edx
    @invalidD:
    add esi,16
    dec [Counter] {...see if there are more descriptors...}
    jz @descriptorsfull {...if not, continue with next step}
    db $0f,$a2 {cpuid} {...else, get next serie of descriptors}
    jmp @nextdescriptor
    @descriptorsfull:
    cmp TCPUIDResult(edi).HighestLevel,3 {see if serial number...}
    jl @ending {...is supported. If not, bail out.}
    mov eax,3 {else get lower 64 bits of serial number...}
    db $0f,$a2 {cpuid} {upper 32 bits = processor signature}
    mov DWORD PTR TCPUIDResult(edi).SerialNumber,ecx {...and store them}
    mov DWORD PTR TCPUIDResult(edi).SerialNumber+4,edx
    @ending:
    pop esi
    pop edi
    pop ebx
    end;
     
    {TCPUID}
    resourcestring
    rsUnknownVendor = 'UnknownVendor';
     
    constructor TCPUID.Create;
    begin
    inherited;
    FCPUIDResult:=GetCPUIDResult;
    end;
     
    function TCPUID.GetBooleanField(Index: Integer): Boolean;
    begin
    case Index of
    0: {CanIdentify} Result:=FCPUIDResult.IsValid;
    1: {GenuineIntel} Result:=FCPUIDResult.GenuineIntel;
    else
    Result:=False;
    end;
    end;
     
    function TCPUID.GetIntegerField(Index: Integer): Integer;
    begin
    case Index of
       0: {HighestLevel} Result:=FCPUIDResult.HighestLevel;
       1: {Stepping} Result:=FCPUIDResult.Stepping;
       2: {Model} if FCPUIDResult.Model=15 then
            Result:=FCPUIDResult.ExtendedModel
          else Result:=FCPUIDResult.Model;
       3: {Family} if FCPUIDResult.Family=15 then
            Result:=15+FCPUIDResult.ExtendedFamily
          else Result:=FCPUIDResult.Family;
    else
       Result:=0;
    end;
    end;
     
    function TCPUID.GetVendorID: String;
    begin
    if CanIdentify then Result:=FCPUIDResult.VendorID
    else Result:=rsUnknownVendor;
    end;
     
    function TCPUID.GetCPUType: TCPUType;
    begin
    case FCPUIDResult.Processortype of
      1: Result:=ctOverdrive;
      2: Result:=ctDualProcessor;
      3: Result:=ctUnknown;
    else
      Result:=ctOriginal;
    end;
    end;
     
    function TCPUID.GetCPUFamily: TCPUFamily;
    begin
    case FCPUIDResult.Family of
      4: Result:=cf486;
      5: Result:=cfPentium;
      6: Result:=cfPentiumPro;
      15: case FCPUIDResult.ExtendedFamily of
            0: Result:=cfPentium4;
          else
            Result:=cfUnknown;
          end;
    else
      Result:=cfUnknown;
    end;
    end;
     
    function TCPUID.GetFeature(Index: TCPUFeature): Boolean;
    begin
    case Index of
      ftFPU: Result:=FCPUIDResult.FPUPresent;
      ftTSC: Result:=FCPUIDResult.TimeStampCounter;
      ftCX8: Result:=FCPUIDResult.CX8Supported;
      ftFSC: Result:=FCPUIDResult.FastSystemCallSupported;
      ftCMOV: Result:=FCPUIDResult.CMOVSupported;
      ftFCOMI: Result:=FCPUIDResult.FCOMISupported;
      ftMMX: Result:=FCPUIDResult.MMXSupported;
      ftSSE: Result:=FCPUIDResult.SSESupported;
      ftSSE2: Result:=FCPUIDResult.SSE2Supported;
      ftSerialNumber: Result:=FCPUIDResult.SerialNumberEnabled;
    else
      Result:=False;
    end;
    end;
     
    function TCPUID.GetProcessor: String;
    begin
    if GenuineIntel then Result:='Intel ' else Result:='';
    case CPUFamily of
      cf486: case Model of
        0..1: Result:=Result+'80486DX';
        2: Result:=Result+'80486SX';
        3: Result:=Result+'80486DX2';
        4: Result:=Result+'80486SL';
        5: Result:=Result+'80486SX2';
        7: Result:=Result+'80486DX2/WB-Enh';
        8: Result:=Result+'80486DX4';
      else
        Result:=Result+'80486';
      end;
      cfPentium: if Features[ftMMX] then Result:=Result+'Pentium MMX' else Result:=Result+'Pentium';
      cfPentiumPro: case Model of
        1: Result:=Result+'Pentium Pro';
        3..4: Result:=Result+'Pentium II, Model '+IntToStr(Model);
        5: case CacheSize of
            caNoCache: Result:='Celeron, Model 5';
            ca1M, ca2M: Result:='Pentium II Xeon, Model 5';
           else
            Result:=Result+'Pentium II, Model 5';
           end;
        6: Result:=Result+'Celeron, Model 6';
        7: case CacheSize of
            ca1M, ca2M: Result:=Result+'Pentium III Xeon, Model 7';
           else
            Result:=Result+'Pentium III, Model 7';
           end;
        8: case BrandID of
            brCeleron: Result:=Result+'Celeron, Model 8';
            brP3Xeon: Result:=Result+'Pentium III Xeon, Model 8';
           else
            Result:=Result+'Pentium III, Model 8';
           end;
        9: Result:=Result+'Pentium III Xeon, Model A';
      else
        Result:=Result+'Pentium Pro';
      end;
      cfPentium4: Result:=Result+'Pentium 4';
    else
      Result:=Result+'Unknown CPU';
    end;
    case CPUType of
      ctOverDrive: Result:=Result+' OverDrive';
      ctDualProcessor: Result:=Result+' Dual CPU';
    end;
    Result:=Result+' (Stepping '+IntToStr(Stepping)+')';
    end;
     
    function TCPUID.GetLevel2Cache: TCacheSize;
    var
    I,M,S: Integer;
    F: Boolean;
    begin
    Result:=caSizeUnknown;
    M:=0;
    S:=0;
    F:=False;
    for I:=Low(FCPUIDResult.CacheDescriptors) to High(FCPUIDResult.CacheDescriptors) do begin
    if FCPUIDResult.CacheDescriptors[I]<>0 then F:=True;
    case FCPUIDResult.CacheDescriptors[I] of
      $40: begin
             M:=0;
             break;
            end;
      $41,$79: S:=128;
      $42,$7a,$82: S:=256;
      $43,$7b: S:=512;
      $44,$7c,$84: S:=1024;
      $45,$85: S:=2048;
    end;
    if S>M then M:=S;
    end;
    if F then case M of
    0: Result:=caNoCache;
    128: Result:=ca128K;
    256: Result:=ca256K;
    512: Result:=ca512K;
    1024: Result:=ca1M;
    2048: Result:=ca2M;
    end;
    end;
     
    function GetNibbleGroup(I: Integer): String;
    var
    T: Integer;
    begin
    T:=(I and $FFFF0000) shr 16;
    Result:=IntToHex(T,4);
    T:=(I and $FFFF);
    Result:=Result+'-'+IntToHex(T,4);
    end;
     
    function TCPUID.GetSerialNumber: String;
    begin
    if Features[ftSerialNumber] then begin
    Result:=GetNibbleGroup(FCPUIDResult.ProcessorSignature);
    Result:=Result+'-'+GetNibbleGroup(FCPUIDResult.SerialNumber[1]);
    Result:=Result+'-'+GetNibbleGroup(FCPUIDResult.SerialNumber[0]);
    end else Result:='';
    end;
     
    function TCPUID.GetCPUBrand: TCPUBrandID;
    var
    I: Integer;
    begin
    if (Family>6) or ((Family=6) and (Model>7)) then begin
    I:=FCPUIDResult.MiscInfo and 255;
    case I of
    1: Result:=brCeleron;
    2: Result:=brP3;
    3: Result:=brP3Xeon;
    8: Result:=brP4;
    else
    Result:=brUnsupported;
    end;
    end else Result:=brUnsupported;
    end;
     
    initialization
    CPUID:=TCPUID.Create;
    finalization
    CPUID.Free;
    end.

 

 

Таблица 1: Использование регистров процессора

В данной таблице приведены сведения по использованию регистров
процессора в 32-битных приложениях Дельфи. В первой колонке - список
регистров. Во второй колонке - что содержится в регистре в секции входа
в процедуру, а в третьей - что при выходе. В четвертой колонке -
возможность использования регистра в коде и в последней колонке -
необходимость сохранения регистра (сохранять при входе и восстанавливать
при выходе).

Регистр        Код входа                Код выхода        Можно ли
использовать?        Нужно ли сохранять        

EAX                Self (1),                Первый параметр (2) или не
определен (3)        Результат функции (4)        Да        Нет        

EBX                Неизвестно                Не используется        Да  
     Да        

ECX                Второй параметр (1), третий параметр (2) или не
определен (3)        Не используется        Да        Нет        

EDX                Первый параметр (1), второй параметр (2) или не
определен (3)        Для Int64 старшее двойное слово результата, или не
используется        Да        Нет        

ESI                Не определен        Не используется        Да      
 Да        

EDI                Не определен        Не используется        Да      
 Да        

EBP                Указатель фрейма стека        Указатель фрейма стека
       Да        Да        

ESP                Указатель стека        Указатель стека        Да    
   n/a        

cs                Кодовый сегмент (5)        Не используется        Нет
       Да        

ds                Сегмент модели памяти (5)        Не используется      
 Нет        Да        

es                Сегмент модели памяти (5)        Не используется      
 Нет        Да        

fs                Резервировано для Windows        Резервировано для
Windows        Нет        Да        

gs                Резервировано        Резервировано        Нет      
 Да        

ss                Сегмент стека (5)        Не используется        Нет  
     Да        

(1) Для метода, когда используется соглашение Register

(2) Для автономных функций и процедур, когда используется соглашение
Register

(3) Для всех других случаев при всех соглашенияч о вызове

(4) Только для результата, который полностью помещается в регистр. См.
таблицу для полного обзора как результаты возвращаются из функции.

(5) В плоской 32-битной модели памяти все сегментные регистры нормально
указывают на один и тот же сегмент памяти. Тем не менее, при анализе
поведения Дельфи, оказывается, что регистр cs имеет различное значение.

 

Таблица 2: Передача параметров в функции и процедуры

В следующей таблице приведены сведения о передаче параметров по значению
(включая, директиву const) в процедуры и функции Дельфи. При передаче по
ссылке (директива var), все параметры передаются как 32-битные
указатели.

Тип        Размер        Регистр (1)        

ShortInt        1 байт (2)        Да        

SmallInt        1 слово (2)        Да        

LongInt        1 двойное слово        Да        

Byte        1 байт (2)        Да        

Word        1 слово (2)        Да        

Dword        1 двойное слово        Да        

Int64        8 байт        Нет        

Boolean        1 байт (2)        Да        

ByteBool        1 байт (2)        Да        

WordBool        1 слово (2)        Да        

LongBool        1 двойное слово        Да        

Char        1 байт (2)        Да        

AnsiChar        1 байт (2)        Да        

WideChar        1 слово (2)        Да        

ShortString        32-битный указатель        Да        

AnsiString        32-битный указатель        Да        

WideString        32-битный указатель        Да        

Variant        32-битный указатель        Да        

Pointers        1 двойное слово        Да        

Objects        32-битный указатель        Да        

Class and Class reference        32-битный указатель        Да        

Procedure pointer        1 двойное слово        Да        

Method pointers        Два 32-битных указателя (3)        Нет        

Sets        Значение типа байт/слово/двойное слово или 32-битный
указатель (4)        Да (4)        

Records        Значение типа байт/слово/двойное слово или 32-битный
указатель (4) (5)        Да (4)        

Static Arrays        Значение типа байт/слово/двойное слово или
32-битный указатель (4)        Да (4)        

Dynamic arrays        32-битный указатель        Да        

Open array        Два 32-битных значения (6)        Нет        

Single        4 байта        Нет        

Double        8 байт        Нет        

Extended        12 байт (7)        Нет        

Real48        8 байт (8)        Нет        

Currency        8 байт        Нет        

(1) Если указано, то тип передается через регистр. Типы, которые не
указаны, всегда передаются через стек.

(2) Когда эти типы занимают менее 32 бит, тогда при передаче на стек они
всегда занимают 32 бита, и значение находится в младшей части,
содержимое оставшей части неопределено.

3) Указатели на метод передаются через стек, как два 32-битных
указателя, указатель на экземпляр помещается перед указателем на метод,
так что позже это становится младшим адресом.

(4) Если тип помещается в байт/слово/двойное слово, то он передается
непосредственно. Иначе, передается 32-битный указатель на память, где
хранится этот тип.

(5) При использовании соглашения по вызову типа cdecl, stdcall или
safecall, записи всегда передаются через стек и их размер округляется в
сторону большего двойного слова.

(6) Первое значение это 32-битный указатель на массив, а второе значение
содержит количество элементов в массиве.

(7) Используются только младшие 10 байт.

(8) Используется только младшие 6 байт.

 

Таблица 3: Результаты возврата функций

В следующей таблице приведен обзор того, как результаты возвращаются из
функции в программу. Для более подробной информации насчет каждого типа,
читайте соответствующий раздел.

Тип Дельфи        Результат        Размер        

ShortInt        al        8-битное значение        

SmallInt        ax        16-битное значение        

LongInt        EAX        32-битное значение        

Byte        al        Значение типа байт        

Word        ax        Значение типа слово        

Dword        EAX        Значение типа двойное слово        

Int64        EDX:EAX        64-битное значение        

Boolean        al        Значение типа байт        

ByteBool        al        Значение типа байт        

WordBool        ax        Значение типа слово        

LongBool        EAX        Значение типа двойное слово        

Char        al        Значение типа байт        

AnsiChar        al        Значение типа байт        

WideChar        ax        Значение типа слово        

ShortString        Указатель в  Result (1)        32-битный указатель  
     

AnsiString        Указатель в  Result (1)        32-битный указатель    
   

WideString        Указатель в  Result (1)        32-битный указатель    
   

Variant        Указатель в  Result (1)        32-битный указатель      
 

Pointers        EAX        32-битный указатель        

Objects        EAX        32-битный указатель        

Class and Class reference        EAX        32-битный указатель        

Procedure pointer        EAX        32-битный указатель        

Method pointers        Указатель в  Result (2)        2 x 32-битных
указателя        

Sets        EAX или Result (3)        Непосредственно или как 32-битный
указатель (3)        

Records        EAX или Result (3)        Непосредственно или как
32-битный указатель (3)        

Static Arrays        EAX или Result (3)        Непосредственно или как
32-битный указатель (3)        

Dynamic arrays        Указатель в  Result (1)        32-битный указатель
       

Single        ST(0)        n/a        

Double        ST(0)        n/a        

Extended        ST(0)        n/a        

Real48        ST(0)        n/a        

Currency        ST(0) (4)        n/a        

(1) Переменная Result в действительности передается в функцию, как
дополнительный var параметр. Эта переменная Result содержит 32-битный
указатель на область результата в памяти. Подлинное местонахождение
зависит от типа использованного соглашения о вызове: Для соглашения
register это может быть EAX, EDX или ECX, в зависимости от количества
переданных параметров. В других случаях Result это 32-битный указатель
на стеке.

(2) Переменная Result указывает на адрес памяти где расположены два
32-битных указателя. Этот указатель передается так, как если бы он был
действительно объявлен, и его точное местонахождение зависит от типа
используемого соглашения о вызове.

(3) Если подлинный тип помещается в 32 бита, то он возвращается напрямую
через регистр al/ax/EAX. Иначе, Result содержит 32-битный указатель на
переменную памяти, и он передается в функцию, как если бы он был
объявлен как дополнительный 32-битный var параметр. Этот параметр
(точное местонахождение зависит от типа использованного соглашения о
вызове) должен содержать указатель на действительные данные в памяти

(4) Значение в ST(0) является маштабированным значением (x10000). Для
примера, значение 5,8745 возвращается как 58745.
