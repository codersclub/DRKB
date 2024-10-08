---
Title: Как найти скорость процессора?
Author: Shady
Date: 01.01.2007
---

Как найти скорость процессора?
==============================

Вариант 1:

Source: Vingrad.ru <https://forum.vingrad.ru>

Пример взят из рассылки: СообЧА. Программирование на Delphi
(<https://Subscribe.Ru/catalog/comp.soft.prog.delphi2000>)

    function GetCPUSpeed: Double;
      const DelayTime = 500;
    var TimerHi : DWORD;
         TimerLo : DWORD;
         PriorityClass : Integer;
         Priority : Integer;
    begin
      PriorityClass := GetPriorityClass(GetCurrentProcess);
      Priority := GetThreadPriority(GetCurrentThread); 
      SetPriorityClass(GetCurrentProcess, REALTIME_PRIORITY_CLASS);
      SetThreadPriority(GetCurrentThread, THREAD_PRIORITY_TIME_CRITICAL);
      Sleep(10);
      asm
        DW 310Fh // rdtsc
        MOV TimerLo, EAX
        MOV TimerHi, EDX
      end;
      Sleep(DelayTime);
      asm
        DW 310Fh // rdtsc
        SUB EAX, TimerLo
        SBB EDX, TimerHi
        MOV TimerLo, EAX
        MOV TimerHi, EDX
      end;
      SetThreadPriority(GetCurrentThread, Priority);
      SetPriorityClass(GetCurrentProcess, PriorityClass);
      Result := TimerLo / (1000.0 * DelayTime);
    end;
     
    // Usage ...
     
    LabelCPUSpeed.Caption := Format('CPU speed: %f MHz', [GetCPUSpeed]);


------------------------------------------------------------------------

Вариант 2:

Source: <https://forum.sources.ru>

    function GetCPUSpeed: real; 
     
      function IsCPUID_Available: Boolean; assembler; register; 
      asm 
                PUSHFD                { прямой доступ к флагам невозможен, только через стек }
                POP    EAX            { флаги в EAX } 
                MOV    EDX,EAX        { сохраняем текущие флаги }
                XOR    EAX,$200000    { бит ID не нужен }
                PUSH   EAX            { в стек } 
                POPFD                 { из стека в флаги, без бита ID } 
                PUSHFD                { возвращаем в стек }
                POP    EAX            { обратно в EAX } 
                XOR    EAX,EDX        { проверяем, появился ли бит ID }
                JZ     @exit          { нет, CPUID не доступен }
                MOV    AL,True        { Result=True } 
        @exit: 
      end; 
     
      function hasTSC: Boolean; 
      var 
        Features: Longword; 
      begin 
        asm 
                  MOV    Features,0    { Features = 0 } 
     
                  PUSH   EBX 
                  XOR    EAX,EAX 
                  DW     $A20F 
                  POP    EBX 
     
                  CMP    EAX,$01 
                  JL     @Fail 
     
                  XOR    EAX,EAX 
                  MOV    EAX,$01 
                  PUSH   EBX 
                  DW     $A20F 
                  MOV    Features,EDX 
                  POP    EBX 
           @Fail: 
        end; 
     
        hasTSC := (Features and $10) <> 0; 
      end; 
     
    const 
      DELAY = 500; 
    var 
      TimerHi, TimerLo: Integer; 
      PriorityClass, Priority: Integer; 
    begin 
      Result := 0; 
      if not (IsCPUID_Available and hasTSC) then Exit; 
      PriorityClass := GetPriorityClass(GetCurrentProcess); 
      Priority := GetThreadPriority(GetCurrentThread); 
     
      SetPriorityClass(GetCurrentProcess, REALTIME_PRIORITY_CLASS); 
      SetThreadPriority(GetCurrentThread, THREAD_PRIORITY_TIME_CRITICAL); 
     
      SleepEx(10, FALSE); 
     
      asm 
                DB      $0F           { $0F31 op-code for RDTSC Pentium инструкции } 
                DB      $31           { возвращает 64-битное целое (Integer) } 
                MOV    TimerLo,EAX 
                MOV    TimerHi,EDX 
      end; 
     
      SleepEx(DELAY, FALSE); 
     
      asm 
                DB      $0F           { $0F31 op-code для RDTSC Pentium инструкции } 
                DB      $31           { возвращает 64-битное целое (Integer) } 
                SUB    EAX,TimerLo 
                SBB    EDX,TimerHi 
                MOV    TimerLo,EAX 
                MOV    TimerHi,EDX 
      end; 
     
      SetThreadPriority(GetCurrentThread, Priority); 
      SetPriorityClass(GetCurrentProcess, PriorityClass); 
      Result := TimerLo / (1000 * DELAY); 
    end;

------------------------------------------------------------------------

Вариант 3:

Source: <https://forum.sources.ru>

    const 
    ID_BIT=$200000; // EFLAGS ID bit 
     
    function GetCPUSpeed: Double; 
    const 
      DelayTime = 500; 
    var 
      TimerHi, TimerLo: DWORD; 
      PriorityClass, Priority: Integer; 
    begin 
    try 
      PriorityClass := GetPriorityClass(GetCurrentProcess); 
      Priority := GetThreadPriority(GetCurrentThread); 
     
      SetPriorityClass(GetCurrentProcess, REALTIME_PRIORITY_CLASS); 
      SetThreadPriorit(GetCurrentThread,THREAD_PRIORITY_TIME_CRITICAL); 
     
      Sleep(10); 
      asm 
        dw 310Fh // rdtsc 
        mov TimerLo, eax 
        mov TimerHi, edx 
      end; 
      Sleep(DelayTime); 
      asm 
        dw 310Fh // rdtsc 
        sub eax, TimerLo 
        sbb edx, TimerHi 
        mov TimerLo, eax 
        mov TimerHi, edx 
      end; 
     
      SetThreadPriority(GetCurrentThread, Priority); 
      SetPriorityClass(GetCurrentProcess, PriorityClass); 
     
      Result := TimerLo / (1000.0 * DelayTime); 
      except end; 
    end; 
     
     
    procedure TForm1.Button1Click(Sender: TObject); 
    var cpuspeed:string; 
    begin 
      cpuspeed:=Format('%f MHz', [GetCPUSpeed]); 
      edit1.text := cpuspeed; 
    end;

------------------------------------------------------------------------

Вариант 4:

Source: <https://forum.sources.ru>

    function RdTSC : int64; register; 
    asm 
      db   $0f, $31
    end;
     
    function GetCyclesPerSecond : int64; 
    var 
      hF, T, et, sc : int64; 
    begin 
      QueryPerformanceFrequency(hF); // HiTicks / second 
      QueryPerformanceCounter(T);    // Determine start HiTicks 
      et := T + hF;                  // (Cycles are passing, but we can still USE them!) 
      sc := RdTSC;                   // Get start cycles 
      repeat                         // Use Hi Perf Timer to loop for 1 second 
        QueryPerformanceCounter(T);  // Check ticks NOW 
      until (T >= et);               //  Break the moment we equal or exceed et 
      Result := RdTSC - sc;          // Get stop cycles and calculate result 
    end;


------------------------------------------------------------------------

Вариант 5:

Author: ISV

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>


_Новейший российский микропроцессор имеет не только повышенное быстродействие
и уменьшенное энергопотребление, но и четыре удобные ручки для его переноски грузчиками,
и улучшенную систему охлаждения, легко подключаемую к обычному водопроводному крану._

Данная тема уже обсуждалась, но у меня есть своя реализация сабжа.

Начиная с Pentium MMX, Intel ввели в процессор счетчик тактов на 64 бита
(Присутствуэт точно и в К6). Для того чтобы посотреть на его содержание,
была введена команда "rdtsc" (подробное описание в интеловской
мануале). Эту возможность можно использовать для реализации сабжа.

Посоку Делфя не вкурсе насчет rdtsc, то пришлось юзать опкод (0F31).
Привожу простенький примерчик юзания, Вы уж извините - немножко кривоват
получился, да и ошибка компалера какая-то вылезла :(

    (V4 Bld5.104 Upd 2).

Кому интересно, поделитесь своими соображениями по этому поводу.
Особенно интерисует работа в режиме когда меняется частота процессора
(Duty Cycle, StandBy).

    // (C) 1999 ISV
    unit Unit1;
     
    interface
     
    uses
    Windows, Messages, SysUtils, Classes, Graphics,
     Controls, Forms,Dialogs,  StdCtrls, Buttons, ExtCtrls;
     
    type
    TForm1 = class(TForm)
        Label1: TLabel;
        Timer1: TTimer;
        Label2: TLabel;
        Label3: TLabel;
        Button1: TButton;
        Button2: TButton;
        Label4: TLabel;
        procedure Timer1Timer(Sender: TObject);
        procedure FormActivate(Sender: TObject);
        procedure Button1Click(Sender: TObject);
        procedure Button2Click(Sender: TObject);
      private    
      { Private declarations }
      public    
      { Public declarations }
        Counter:integer;
        //Счетчик срабатывания таймера    
        Start:int64;              
        //Начало роботы    
        Previous:int64;        
        //Предыдущее значение    
        PStart,PStop:int64;
        //Для примера выч. времени   
        CurRate:integer;
        //Текущая частота проца    
        function GetCPUClick:int64;    
        function GetTime(Start,Stop:int64):double;
    end;
    
    var  Form1: TForm1;
    
    implementation
    {$R *.DFM}
    
    // Функция работает на пнях ММХ или выше а
    // также проверялась на К6
    function TForm1.GetCPUClick:int64;
    begin
      asm    db  0fh,31h   
      // Опкод для команды rdtsc
      // mov dword ptr result,eax
      // mov dword ptr result[4],edx
      end;
      // Не смешно :(. Без ?той штуки
      // Компайлер выдает Internal error C1079  
      Result:=Result;
    end;
    
    // Время в секундах между старт и стоп
    function TForm1.GetTime(Start,Stop:int64):double;
    begin
      try
        result:=(Stop-Start)/CurRate
      except
        result:=0;
      end;
    end;
    
    // Обработчик таймера считает текущую частоту, выводит ее, а также
    // усредненную частоту, текущий такт с момента старта процессора.
    // При постоянной частоте процессора желательно интервал братьпобольше
    // 1-5с для точного прощета частоты процессора.
    procedure TForm1.Timer1Timer(Sender: TObject);
    var
      i:int64;
    begin
      i:=GetCPUClick;
      if Counter=0 then
        Start:=i
      else 
      begin
        Label2.Caption:=Format('Частота общая:%2f',
          [(i-Start)/(Counter*Timer1.Interval*1000)]);
          Label3.Caption:=Format('Частота текущая:%2f',
          [(i-Previous)/(Timer1.Interval*1000)]);
        CurRate:=Round(((i-Previous)*1000)/(Timer1.Interval));
      end;
      Label1.Caption:='Такты: '+IntToStr(i);
      Previous:=i;
      Inc(Counter);
    end;
    
    procedure TForm1.FormActivate(Sender: TObject);
    begin
      Counter:=0;
    end;
    
    // Заносим стартовое время для примера
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      PStart:=GetCPUClick;
    end;
    
    // Останавливаем отсчет времени и показуем соко
    // прошло секунд
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      PStop:=GetCPUClick;
      Label4.Caption:=Format!
      ('Время между нажатиями:%gсек',[GetTime(PStart,PStop)])
      end;
    end.

Проверялось под еНТями на Пне 2 333.

------------------------------------------------------------------------

Вариант 6:

Author: Shady

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    uses registry;
    ...
     
    function GetCpuMhz: Word;
    begin
      with tregistry.Create do
      begin
        rootkey := HKEY_LOCAL_MACHINE;
        openkey('\hardware\description\system\centralprocessor\0\', false);
        result := readinteger('~mhz');
        free;
      end;
    end;

