---
Title: Использование native kernel32 функций для получения проекции физической памяти
Date: 01.01.2007
---

Использование native kernel32 функций для получения проекции физической памяти
==============================================================================

::: {.date}
01.01.2007
:::

Использование native kernel32 функций для получения проекции физической
памяти

© 2006 Альберт Мамедов (MagDelphi)

В процессе написания программного обеспечения в ряде случаев возникает
необходимость получения данных из физических ячеек памяти. Документации
Delphi по данному вопросу, я найти не смог, поэтому хочу восполнить
данный пробел.

Платформа WinNT(XP) не допускает возможность непосредственного доступа к
памяти средствами Win32API. В этом случае программист должен или
написать свой драйвер доступа к физической памяти или использовать
native kernel32 функции ядра.

Рассмотрим второй вариант использующий объект "проекция файла"
(file-mapping object), представляющем собой блок памяти(раздел)
доступный двум и более процессам для совместного использования.

Совместное использование данных с помощью объекта "раздел" происходит
следующим образом: Задав атрибуты с помощью функции

    procedure InitializeObjectAttributes(InitializedAttributes : PNtObjectAttributes; 
                                         pObjectName : PNtUnicodeString;
                                         const uAttributes : ULONG; 
                                         const hRootDirectory : THandle; 
                                         pSecurityDescriptor : PSECURITY_DESCRIPTOR);
    begin
      with InitializedAttributes^ do
      begin
        Length := SizeOf(TNtObjectAttributes);
        ObjectName := pObjectName;
        Attributes := uAttributes;
        RootDirectory := hRootDirectory;
        SecurityDescriptor := pSecurityDescriptor;
        SecurityQualityOfService := nil;
      end;
    end; 

 

которая фактически заполняет структуру NtObjectAttributes

Используем объект \'\\Device\\PhysicalMemory\' и преобразовав его в тип
TNtUnicodeString;

RtlInitAnsiString(@AnsiPhysicalMemory, \'\\Device\\PhysicalMemory\');
RtlAnsiStringToUnicodeString(@UniPhysicalMemory, @AnsiPhysicalMemory,
true);

InitializeObjectAttributes(@NtObjectAttributes, @UniPhysicalMemory,
OBJ\_KERNEL\_HANDLE, 0, nil);

Получаем дескриптор секции вызывая функцию ядра

 

NtOpenSection(SectionHandle, SECTION\_MAP\_READ, @NtObjectAttributes);

Этим самым мы открываем объект \'\\Device\\PhysicalMemory\' для чтения
отображенного участка физической памяти в процессе пользователя.

Отображение осуществляем с помощью функции NtMapViewOfSection
возвращающей указатель на участок памяти процесса пользователя в который
осуществляется отображение. Более подробную информацию можно найти в
MicrosoftDDK.

Привожу несложный пример.

    unit PhysMemWorks;
     
    interface
     
    uses windows;
     
    type
     
    NTSTATUS = LongInt; 
    PLARGE_INTEGER = ^LARGE_INTEGER; 
    TSectionInherit = (ViewNone,ViewShare,ViewUnmap); 
    SECTION_INHERIT = TSectionInherit;
     
    PHYSICAL_ADDRESS = record 
    LowPart : DWORD ; 
    HighPart : DWORD; 
    end;
     
     
    TNtAnsiString = packed record 
    Length : Word; 
    MaximumLength : Word; 
    Buffer : PChar; 
    end;
     
    PNtAnsiString = ^TNtAnsiString; 
    ANSI_STRING = TNtAnsiString;
     
     
    TNtUnicodeString = packed record 
    Length : Word; 
    MaximumLength : Word; 
    Buffer : PWideChar; 
    end;
     
    UNICODE_STRING = TNtUnicodeString; 
    PNtUnicodeString = ^TNtUnicodeString;
     
     
    TNtObjectAttributes = packed record 
    Length : ULONG; 
    RootDirectory : THandle; 
    ObjectName : PNtUnicodeString; 
    Attributes : ULONG; 
    SecurityDescriptor : Pointer; 
    SecurityQualityOfService : Pointer; 
    end;
     
    OBJECT_ATTRIBUTES = TNtObjectAttributes; 
    PNtObjectAttributes = ^TNtObjectAttributes;
     
     
    function OpenPhysicalMemory:dword;
     
    function MapPhysicalMemory (hPhysMem:tHANDLE; pdwAddress:DWORD; pdwLength:DWORD; pdwBaseAddress:pDWORD):dword;
     
    ///////////
     
    const DLL = 'ntdll.dll';
     
    function RtlAnsiStringToUnicodeString( DestinationString : PNtUnicodeString; SourceString : PNtAnsiString; 
    AllocateDestinationString : Boolean ) : NTSTATUS; stdcall; external DLL name 'RtlAnsiStringToUnicodeString'; 
    procedure RtlInitAnsiString( DestinationString : PNtAnsiString; SourceString : PChar ); stdcall; external DLL name 'RtlInitAnsiString';
     
    function NtMapViewOfSection(SectionHandle : THandle;ProcessHandle : THandle; var BaseAddress : PDWORD; 
    ZeroBits : ULONG; CommitSize : ULONG; SectionOffset : PLARGE_INTEGER; ViewSize : DWORD; 
    InheritDisposition : SECTION_INHERIT; 
    AllocationType : ULONG; Protect : ULONG) : NTSTATUS; stdcall; external DLL name 'NtMapViewOfSection';
     
    function NtUnmapViewOfSection(const ProcessHandle : THandle; 
    const BaseAddress : Pointer) : NTSTATUS; stdcall; external DLL name 'NtUnmapViewOfSection'; 
    function NtOpenSection(out SectionHandle : THandle; const DesiredAccess : ACCESS_MASK; 
    ObjectAttributes : PNtObjectAttributes) : NTSTATUS; stdcall; external DLL name 'NtOpenSection';
     
    implementation
     
    const
    OBJ_KERNEL_HANDLE = $0000200;
     
    var 
    status: dword;
     
    procedure InitializeObjectAttributes(InitializedAttributes : PNtObjectAttributes; 
    pObjectName : PNtUnicodeString; const uAttributes : ULONG; const hRootDirectory : THandle; 
    pSecurityDescriptor : PSECURITY_DESCRIPTOR); 
    begin 
    with InitializedAttributes^ do 
    begin 
    Length := SizeOf(TNtObjectAttributes); 
    ObjectName := pObjectName; 
    Attributes := uAttributes; 
    RootDirectory := hRootDirectory; 
    SecurityDescriptor := pSecurityDescriptor; 
    SecurityQualityOfService := nil; 
    end; 
    end;
     
     
    function OpenPhysicalMemory:dword; 
    var 
    hPhysMem:dword; 
    UniPhysicalMemory : TNtUnicodeString; 
    AnsiPhysicalMemory :TNtAnsiString ; 
    oa :TNtObjectAttributes;
     
    begin 
    RtlInitAnsiString(@AnsiPhysicalMemory, '\Device\PhysicalMemory'); 
    status:= RtlAnsiStringToUnicodeString(@UniPhysicalMemory, @AnsiPhysicalMemory, true); 
    InitializeObjectAttributes(@oa, @UniPhysicalMemory, OBJ_KERNEL_HANDLE, 0, nil) ; 
    status:= NtOpenSection(hPhysMem, SECTION_MAP_READ, @oa); 
    if status <> 0 then result:= 0 else result:= hPhysMem; 
    end;
     
     
    function MapPhysicalMemory (hPhysMem:tHANDLE; pdwAddress:DWORD; pdwLength:DWORD; pdwBaseAddress:pDWORD):dword; 
    var 
    SectionOffset: pLARGE_INTEGER; 
    begin 
    SectionOffset.HighPart := 0; 
    SectionOffset.LowPart:= pdwAddress; 
    NtMapViewOfSection(hPhysMem, 0, pdwBaseAddress, 0, 0, nil,0, ViewNone, 0, PAGE_READONLY); 
    result:=1; 
    end;
     
     
    function UnmapPhysicalMemory (dwBaseAddress:DWORD):dword; 
    begin 
    NtUnmapViewOfSection(0, @dwBaseAddress); 
    result:=1; 
    end;
     
    end. 

 

Используя данный модуль получаем доступ к функциям ядра которые, в свою
очередь, позволяют получить проекцию нужного участка памяти.

На форме разместим компонент StringGrid - для представления информации
в табличном виде, Button, Label и Edit и пишем такой код.

    unit Read_Mem;
     
    interface
     
    uses 
    Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, 
    StdCtrls, Grids, ExtCtrls, PhysMemWorks;
     
    type 
    TForm1 = class(TForm) 
    gridData: TStringGrid; 
    Label12: TLabel; 
    editAddr: TEdit; 
    btnRead: TButton; 
    Label2: TLabel; 
    procedure btnReadClick(Sender: TObject); 
    procedure FormCreate(Sender: TObject);
    end;
     
    var
     
    Form1: TForm1;
     
    implementation
     
    {$R *.DFM} 
    {$R WindowsXP.res}
     
     
    type 
    XData = array[1..16] of Byte; 
    YData = array[1..16] of XData; 
    TPhysPointer =^YData;
     
    procedure TForm1.btnReadClick(Sender: TObject); 
    var
    i, j: longint; 
    nAddr: int64;// 
    s1, s2: String; 
    b: Byte; 
    ch: Char; 
    arrayMemory :pbytearray; 
    PointMemory:pointer; 
    hmemory:dword; 
    xhex: integer; 
    yhex: integer; 
    ofsetHex: integer;
    begin 
    with gridData do 
    begin 
    ColWidths[0] := Canvas.TextWidth(IntToHex(0, 9)); 
    ColWidths[1] := Canvas.TextWidth(Cells[1, 0]); 
    end; 
    nAddr := StrToInt('$' + editAddr.Text); 
    label2.Caption:=inttostr(nAddr div 1024 )+ ' kб'; 
    hmemory:=OpenPhysicalMemory; 
    PointMemory:=MapViewOfFile(hmemory, FILE_MAP_READ, 0, nAddr, $2000); //размер секции 8 кб 
    arrayMemory :=PointMemory; 
    xhex:= nAddr and $0f; 
    yhex:=(nAddr and $00f0) div 16; 
    ofsetHex:= ((nAddr and $0f00) div 16); 
    if yhex = 0 then yhex:=0; 
    if PointMemory <> nil then 
    begin 
    for i:=1 to 16 do 
    begin 
    gridData.Cells[0,i] := IntToHex(nAddr,8); 
    s1 := ''; 
    s2 := ''; 
    for j:=1 to 16 do 
    begin 
    b := arrayMemory^[((i+ofsetHex+yhex-1)*16)+(j+xhex-1)]; 
    s1 := s1 + IntToHex(b, 2) + ' '; 
    if b >= $20 then ch := Char(b) else ch:='.'; 
    s2 := s2 + ch; 
    end; 
    gridData.Cells[1,i] := s1; 
    gridData.Cells[2,i] := s2; 
    nAddr := nAddr + 16; 
    end;
     
    with gridData do 
    begin 
    ColWidths[2] := Canvas.TextWidth(Cells[2, 1] + ' '); 
    end;
     
    end else MessageDlg('Этот участок памяти' +^M+' недоступен!!!', mtWarning, [mbOK], 0);
     
    end;
     
    procedure TForm1.FormCreate(Sender: TObject); 
    var 
    i: integer;
    begin
    with gridData do
    begin
    Cells[0,0]:=' ADDR';
    Cells[1,0]:='';
    for i := 0 to 15 do
    Cells[1,0] := Cells[1,0] + IntToHex(i, 2) + ' ';
    Cells[2,0]:=' ASCII';
    end;
    end;
    end.

 

Готово! У нас есть приложение позволяющее просматривать физическую
память. Наберите, например, в поле адреса 000FFF00, нажмие "Read" и в
ячейках начиная с FFFF5 прочитайте дату прошивки BIOS Вашей материнской
платы.

Используя данные функции Вы легко получаете возможность просмотра всего
объёма физической памяти, за исключением системных адресов операционной
системы.

Copyright© 2006 Альберт Мамедов (MagDelphi) Специально для Delphi Plus
