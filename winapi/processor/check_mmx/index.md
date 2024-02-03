---
Title: Поддерживается ли MMX?
Date: 01.01.2007
---

Поддерживается ли MMX?
======================

::: {.date}
01.01.2007
:::

    function SupportsMMX: Boolean;
    begin
      Result := False;
      try
        asm
          push     eax
          push     ebx
          push     ecx
          push     edx
          pushfd
          pop      eax
          mov      ebx,eax
          xor      eax,$00200000
          push     eax
          popfd
          pushfd
          pop      eax
          xor      eax,ebx
          je       @NoMMX
          mov      eax,$01
          test     edx,$800000
          jz       @NoMMX
          mov byte ptr[Result],1
     
      @NoMMX:
          pop      edx
          pop      ecx
          pop      ebx
          pop      eax
     end;
      except;
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      if SupportsMMX then ShowMessage('Computer supports MMX');
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>

------------------------------------------------------------------------

Наша программа выполняет несложную операцию по определению наличия в
процессоре технологии MMX, но при помощи этого кода можно узнать и много
других характеристик процессора, путем посылки в регистр eax значений от
0 до 2 и при этом тестированием отдельных бит таких регистров как
eax,ebx,ecx и edx командой bt (bit test), но наша задача заключается в
том, чтоб показать различные способы подключения к delphi ассемблерного
кода.

Для создания объектного модуля нужен файл TASM32.EXE, линковать
объектный модуль файлом TLINK.EXE ненужно.

Например:

TASM32.EXE /ml CPU2.ASM

Полученный объектный модуль на ассемблере CPU2.OBJ

    .586 ; Будут использоваться дополнительные команды 586 
    .MODEL use32 small ; Модель памяти small используется для 
    ; большинства программ на ассемблере 
    stack 100h ; Выделяем область памяти под стек 256 байт
    .data
    .code
    start:
    DelCpu proc 
    PUBLIC DelCpu ; объявляем процедуру видимую за пределами 
    ; данного модуля 
    xor edx,edx ; обнуляем регистр edx для помещения в него 
    ; результатов команды cpuid 
    mov eax,1 ; засылаем в eax 1 для заполнения регистра edx 
    ; соответствующими полями после выполнения 
    ; cpuid команды 
    cpuid ; команда идентификация процессора 
    bt edx,23 ; команда для тестирования отдельных бит в 
    ; операнде, в нашем случае проверяем в edx 23 бит 
    ; и если он устанавнен в 1 значит технология MMX 
    ; в процессоре есть, а если 0 то нет. Эта команда 
    ; также присваивает флагу переноса cf значение 
    ; проверяемого бита 
    jnc no ; проверяем значение флага cf если оно равно 0 то 
    ; на перейти на метку (no), если 1 то продолжаем 
    mov eax,1 ; в ассемблере для возврата результата в функцию 
    ; нужно результат поместить в регистр eax, что мы 
    ; и делаем 
    jmp exit ; безусловный переход на выход
    no:
    mov eax,0 
    exit:
    ret ; выход из процедуры
    DelCpu endp
    end start

Модуль на Delphi

Очень важный момент, когда будете подключать модуль директивой {$L
cpu2.obj} нужно чтоб все строки кода были или закомментированы или чтоб
их еще не было вообще.

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls;
     
    type
      TForm1 = class(TForm)
        Edit1: TEdit;
        Button1: TButton;
        procedure Button1Click(Sender: TObject);
        procedure FormCreate(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
    end;
     
    var
      Form1: TForm1;
      rez: DWORD;
     
    implementation
    {$L cpu2.obj} //подключение нашего asm модуля к delphi
    {$R *.dfm}
     
    function DelCpu: DWORD; external; // объявляем функцию DelCpu
    // внешней
    // ну дальше все понятно
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      rez:=DelCpu;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      if rez = 1 then
        edit1.Text:='MMX-технология есть'
      else
        edit1.Text:='MMX-технологии нет';
    end;
     
    end.
     
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Определение поддержки MMX
     
    Зависимости: Types
    Автор:       Gua, gua@ukr.net, ICQ:141585495, Simferopol
    Copyright:   Unknown
    Дата:        17 июля 2002 г.
    ***************************************************** }
     
    function CheckMMX: Boolean;
    var
      TempCheck: dword;
    begin
      TempCheck := 1;
      asm
      push ebx
      mov eax,1
      db $0F,$A2
      test edx,$800000
      jz @NOMMX
      mov edx,0
      mov TempCheck,edx
      @NOMMX:
      pop ebx
      end;
      CheckMMX := (TempCheck = 0);
    end;
