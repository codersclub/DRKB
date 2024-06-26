---
Title: Как реализовать сверхточный таймер?
Author: 7jin
Date: 01.01.2007
---


Как реализовать сверхточный таймер?
===================================

Вариант 1:

Source: <https://www.lmc-mediaagentur.de/dpool>

Windows не является операционной системой реального времени,
поэтому она не может надежно обеспечить высокую точность синхронизации
без использования драйвера устройства.
Лучшее, что мне удалось получить, - это несколько наносекунд,
с использованием QueryPerformanceCounter.

Вот процедура, которую я использую:

    var
      WaitCal: Int64;
     
    procedure Wait(ns: Integer);
    var
      Counter, Freq, WaitUntil: Int64;
    begin
      if QueryPerformanceCounter(Counter) then
      begin
        QueryPerformanceFrequency(Freq);
        WaitUntil := Counter + WaitCal + (ns * (Freq div 1000000));
        while Counter < WaitUntil do
          QueryPerformanceCounter(Counter);
      end
      else
        Sleep(ns div 1000);
    end;

Чтобы повысить точность, сделайте вот это до того, как использовать Wait().

    var
      Start, Finish: Int64;
     
    Application.ProcessMessages;
    Sleep(10);
    QueryPerformanceCounter(Start);
    Wait(0);
    QueryPerformanceCounter(Finish);
    WaitCal := Start - Finish;

Я нашел трюк, позволяющий повысить надежность этого метода на моём компьютере:
нужно вызывать Wait следующим образом:

    Application.ProcessMessages;
    Sleep(0);
    DoSomething;
    Wait(10);
    DoSomethingElse;

------------------------------------------------------------------------

Вариант 2:

Author: 7jin

Source: <https://forum.sources.ru>

    Unit Counter;           (* Written by Jin *)
    {$O-,F-,S-,N-,R-,Q-}
    Interface
     
    Type
       tTimerValue = record
          Micro: Word;      { Счётчик 8253/8254 }
          Counter: Longint  { Счётчик BIOS }
       End;
     
    Const
       MicroFreq = 1193181 { $1234DD };    { Частота обновления счётчика Micro (1/сек) }
       CounterFreq = MicroFreq / 65536;    { Частота обновления счётчика Counter (1/сек) }
       MicroInterval = 1 / MicroFreq;      { Интервал обновления счётчика Micro (сек) }
       CounterInterval = 1 / CounterFreq;  { Интервал обновления счётчика Counter (сек) }
     
    Var
       BIOSCounter: Longint absolute $0040:$006C;
    { Системный счётчик (обновляется CounterFreq раз/сек, }
    { то есть каждые CounterInterval секунд)              }
     
    Procedure InitTimer;
    { Инициализировать таймер (перевести в нужный режим работы).       }
    { Эту  процедуру необходимо выполнять перед использованием функций }
    { и  процедур  для получения значения таймера (или счётчика), если }
    { Вы  в своей программе изменили режим работы таймера. В противном }
    { случае эта процедура Вам не понадобится, так как она выполняется }
    { в секции инициализации модуля (сразу после запуска программы) !  }
    Procedure GetTimerValue(var Timer: tTimerValue);
    { Записать значение таймера в переменную Timer }
    Function GetTimerSec: Real;
    { Получить значение таймера в секундах (с точностью до 1 мкс) }
    Function GetTimerMillisec: Longint;
    { Получить значение таймера в миллисекундах }
     
    Procedure GetTimerDifference(var Older, Newer, Result: tTimerValue);
    { Записать разницу значений Newer и Older в переменную Result }
    Function GetTimerDifSec(var Older, Newer: tTimerValue): Real;
    { Получить разницу значений Newer и Older в секундах }
    Function GetTimerDifMillisec(var Older, Newer: tTimerValue): Longint;
    { Получить разницу значений Newer и Older в миллисекундах }
     
    Function ConvTimer2Sec(var Timer: tTimerValue): Real;
    { Получить количество секунд по значению переменной Timer }
    Function ConvTimer2Millisec(var Timer: tTimerValue): Longint;
    { Получить количество миллисекунд по значению переменной Timer }
    Procedure ConvSec2Timer(Sec: Real; var Timer: tTimerValue);
    { Преобразовать значение секунд Sec типа Real в тип tTimerValue }
    Procedure ConvMillisec2Timer(Millisec: Longint; var Timer: tTimerValue);
    { Преобразовать значение миллисекунд Millisec типа Longint в тип tTimerValue }
     
    Procedure ResetCounter;
    { Сбросить  счётчик (то есть принять текущее значение таймера за ноль для }
    { процедуры GetCounterValue и функции GetCounterSec)                      }
    Procedure GetCounterValue(var Timer: tTimerValue);
    { Записать значение счётчика в переменную Timer }
    Function GetCounterSec: Real;
    { Получить значение секунд счётчика }
    Function GetCounterMillisec: Longint;
    { Получить значение миллисекунд счётчика }
     
    Procedure Delay(MS: Word);
    { Задержка MS миллисекунд (1 сек = 1000 мс) }
    Procedure DelaySec(Sec: Real);
    { Задержка Sec секунд }
    Procedure MDelay(N: Longint);
    { Задержка N * MicroInterval секунд (приближённо N * 0.838095813 мкс). }
    { Если Вам нужны наиболее точные короткие задержки, лучше использовать }
    { эту  процедуру, так как она даёт наименьшую погрешность по сравнению }
    { с двумя предыдущими процедурами.                                     }
     
    Implementation
    Var Now: tTimerValue;
    Var Zero: tTimerValue;
     
    Procedure InitTimer; assembler;
    Asm
       mov al,34h      { Режим 2 таймера 0 }
       out 43h,al
       xor al,al       { 65536 циклов до IRQ }
       out 40h,al
       out 40h,al
    End
     
    Procedure GetTimerValue; assembler;
    Asm
       cld
       xor ax,ax
       mov es,ax
       mov bx,46Ch     { DS:BX = 0000h:046Ch = Таймер BIOS }
       cli
       mov dx,es:[bx]
       mov cx,es:[bx+2]{ CX:DX = Первое значение таймера BIOS }
       sti
       out 43h,al      { Замораживаем таймер 8253/8254 }
       cli
       mov si,es:[bx]
       mov di,es:[bx+2]{ DI:SI = Второе значение таймера BIOS }
       in al,40h
       mov ah,al
       in al,40h
       sti
       xchg ah,al      { AX = Таймер 8253/8254 }
       not ax          { Обратный отсчёт -> Прямой отсчёт }
       cmp dx,si       { Первое значение таймера BIOS равно второму значению ? }
       je @Ok          { Да! Оставляем как есть (CX:DX), иначе... }
       or ax,ax        { Таймер BIOS изменился после заморозки таймера 8253/8254 (между OUT и CLI) ? }
       js @Ok          { Да! Оставляем как есть (CX:DX), иначе... }
       mov dx,si
       mov cx,di       { CX:DX = DI:SI, если таймер BIOS изменился между STI и OUT }
    @Ok:
       les di,Timer
       stosw           { Low Word }
       xchg ax,dx
       stosw           { Middle Word }
       xchg ax,cx
       stosw           { High Word - Записаны из CX:DX:AX }
    End
     
    Function GetTimerSec;
    Begin
       GetTimerValue(Now);
       GetTimerSec := ConvTimer2Sec(Now)
    End;
     
    Function GetTimerMillisec;
    Begin
       GetTimerMillisec := Trunc(GetTimerSec*1000)
    End;
     
    Procedure GetTimerDifference; assembler;
    Asm
       cld
       push ds
       lds si,Newer
       lodsw           { Low Word }
       xchg cx,ax
       lodsw           { Middle Word }
       xchg dx,ax
       lodsw           { High Word }
       xchg cx,ax      { Прочитаны в CX:DX:AX }
       lds si,Older
       sub ax,[si]
       sbb dx,[si+2]
       sbb cx,[si+4]   { Вычитаем Older из Newer }
       les di,Result
       stosw           { Low Word }
       xchg ax,dx
       stosw           { Middle Word }
       xchg ax,cx
       stosw           { High Word - Записано из CX:DX:AX }
       pop ds
    End
     
    Function GetTimerDifSec;
    Begin
       GetTimerDifference(Older, Newer, Now);
       GetTimerDifSec := ConvTimer2Sec(Now)
    End;
     
    Function GetTimerDifMillisec;
    Begin
       GetTimerDifMillisec := Trunc(GetTimerDifSec(Older, Newer)*1000)
    End;
     
    Function ConvTimer2Sec;
    Begin
       ConvTimer2Sec := (Timer.Counter*65536 + Timer.Micro) / MicroFreq
    End;
     
    Function ConvTimer2Millisec;
    Begin
       ConvTimer2Millisec := Trunc(ConvTimer2Sec(Timer)*1000)
    End;
     
    Procedure ConvSec2Timer;
    Begin
       Timer.Counter := Trunc(Sec * CounterFreq);
       Timer.Micro := Trunc(Sec * MicroFreq) mod 65536
    End;
     
    Procedure ConvMillisec2Timer;
    Begin
       Timer.Counter := Trunc(Millisec/1000 * CounterFreq);
       Timer.Micro := Trunc(Millisec/1000 * MicroFreq) mod 65536
    End;
     
    Procedure ResetCounter;
    Begin
       GetTimerValue(Zero)
    End;
     
    Procedure GetCounterValue;
    Begin
       GetTimerValue(Timer);
       GetTimerDifference(Zero, Timer, Timer)
    End;
     
    Function GetCounterSec;
    Begin
       GetTimerValue(Now);
       GetTimerDifference(Zero, Now, Now);
       GetCounterSec := ConvTimer2Sec(Now)
    End;
     
    Function GetCounterMillisec;
    Begin
       GetCounterMillisec := Trunc(GetCounterSec*1000)
    End;
     
    Procedure Delay;
    Var Zero: Longint;
    Begin
       If MS <= 0 then Exit;
       Zero := GetTimerMillisec;
       Repeat
       Until GetTimerMillisec-Zero >= MS
    End;
     
    Procedure DelaySec;
    Var Zero: Real;
    Begin
       If Sec <= 0 then Exit;
       Zero := GetTimerSec;
       Repeat
       Until GetTimerSec-Zero >= Sec
    End;
     
    Procedure MDelay;
    Label Check;
    Var Zero: tTimerValue;
    Begin
       If N <= 0 then Exit;
       GetTimerValue(Zero);
     Check:
       GetTimerValue(Now);
       GetTimerDifference(Zero, Now, Now);
       Asm
          mov ax,word ptr Now
          mov dx,word ptr Now+2  { DX:AX - Прошедшее время }
    {      mov cx,word ptr Now+4
          or cx,cx
          jnz @Exit}
          cmp dx,word ptr N+2    { Проверяем старшие слова }
          jb Check
          cmp ax,word ptr N      { Проверяем младшие слова }
          jb Check
        @Exit:
       EndEnd;
     
    Begin
       InitTimer
    End.



И вот ещё программа-тестер:

    Uses Counter;
    Var
       Ans: Char;
       i: Longint;
       Sec: Real;
     
    Begin
       Asm
          mov ah,0Dh
          int 21h      { Сбрасываем кэш }
          mov ax,1681h
          int 2Fh      { Запрещаем Windows Task Switch }
       End
     
       Write('Без задержки...');
       ResetCounter;
       Sec := GetCounterSec;
       WriteLn(#8#8#8': прошло ', Sec: 0: 6, ' сек');
     
       Write('1000 раз холостой цикл...');
       ResetCounter;
       For i := 1 to 1000 do ;
       Sec := GetCounterSec;
       WriteLn(#8#8#8': прошло ', Sec: 0: 6, ' сек');
     
       Write('1000 раз по 0 сек...');
       ResetCounter;
       For i := 1 to 1000 do
          DelaySec(0);
       Sec := GetCounterSec;
       WriteLn(#8#8#8': прошло ', Sec: 0: 6, ' сек');
     
       WriteLn('-------------------------------------------------');
     
       Write('1 раз 1 сек...');
       ResetCounter;
       DelaySec(1);
       Sec := GetCounterSec;
       WriteLn(#8#8#8': прошло ', Sec: 0: 6, ' сек');
     
       Write('1000 раз по 0.001 сек...');
       ResetCounter;
       For i := 1 to 1000 do
          DelaySec(0.001);
       Sec := GetCounterSec;
       WriteLn(#8#8#8': прошло ', Sec: 0: 6, ' сек');
     
       Write('10000 раз по 0.0001 сек...');
       ResetCounter;
       For i := 1 to 10000 do
          DelaySec(0.0001);
       Sec := GetCounterSec;
       WriteLn(#8#8#8': прошло ', Sec: 0: 6, ' сек');
     
       Write('100000 раз по 0.00001 сек...');
       ResetCounter;
       For i := 1 to 100000 do
          DelaySec(0.00001);
       Sec := GetCounterSec;
       WriteLn(#8#8#8': прошло ', Sec: 0: 6, ' сек');
     
       Write('119318 раз по 1/119318.1 сек...');
       ResetCounter;
       For i := 1 to 119318 do
          MDelay(10);
       Sec := GetCounterSec;
       WriteLn(#8#8#8': прошло ', Sec: 0: 6, ' сек');
     
       WriteLn('-------------------------------------------------');
     
       Write('Запускать тесты по микросекундам (м.б. очень долгими) [Y/N] ? : ');
       Asm
        @Repeat:
          xor ah,ah
          int 16h
          or al,20h
          cmp al,'y'
          je @Ok
          cmp al,'n'
          jne @Repeat
        @Ok:
          mov Ans,al
       End
       WriteLn(Ans);
     
       If Ans = 'y' then
       Begin
          Write('1000000 раз по 0.000001 сек...');
          ResetCounter;
          For i := 1 to 1000000 do
             DelaySec(0.000001);
          Sec := GetCounterSec;
          WriteLn(#8#8#8': прошло ', Sec: 0: 6, ' сек');
     
          Write('1193181 раз по 1/1193181 сек...');
          ResetCounter;
          For i := 1 to 1193181 do
             MDelay(1);
          Sec := GetCounterSec;
          WriteLn(#8#8#8': прошло ', Sec: 0: 6, ' сек')
       End;
     
       Asm
          mov ax,1682h
          int 2Fh      { Разрешаем Windows Task Switch }
       EndEnd.


Не забывайте, что погрешности, которые будет выдавать программа-тестер
будут из-за того, что какое-то время тратиться на вызов процедуры, циклы
и т.д. (т.к. там используются процедуры DelaySec, MDelay).... Но если
вызвать ResetCounter, а через некоторое время GetCounterSec, то
результат будет точным (собственно, именно так здесь и измеряются
погрешности)! И можно вызывать его (GetCounterSec) ещё хоть 10000 раз!
;D

Кстати, запускайте тестер только в полноэкранном режиме, т.к. программа
отключает многозадачность Windows, и на экране вы ничего не увидите
(будет впечатление, что прога повисла).

------------------------------------------------------------------------

Вариант 3:

Author: 7jin

Source: <https://forum.sources.ru>

А вот ещё один способ (работает только на Pentium или выше)....

    Unit TSCDelay;          (* Работает только на Pentium (и то не всегда ;) *)
    {$O-,F-,G+,S-,R-}
    Interface
     
    Var
       CPUClock: Longint;   { Тактовая частота процессора (гц) }
     
    Procedure CalcCPUClock;
    { Вычислить тактовую частоту процессора и записать в переменную CPUClock. }
    Procedure MDelay(N: Longint);
    { Производит задержку в N микросекунд. Задержки более 4294967296/CPUClock }
    { (на 300-м ~ 14) секунд будут работать неправильно из-за переполнения!!! }
    { Перед  использованием  это  процедуры  необходимо установить правильное }
    { значение  переменной  CPUClock.  Это  можно  сделать либо вручную, либо }
    { выполнив процедуру CalcCPUClock.                                        }
    Procedure TDelay(N: Longint);
    { Производит задержку в N тактов процессора }
     
    Implementation
    Uses Dos;
    Var
       SaveInt08: Pointer;
       Stage: Byte;
     
    Procedure SpeedCounter; far; assembler;  { Наш IRQ 0 }
    Asm
       push ax
       push ds
       mov ax,seg @Data
       mov ds,ax
       inc Stage            { Прибавляем к Stage единицу }
       mov al,20h
       out 20h,al           { Посылаем сигнал "конец IRQ" }
       pop ds
       pop ax
       iret                 { Выходим }
    End
     
    Procedure CalcCPUClock;
    Begin
       Asm
          mov ah,0Dh
          int 21h                     { Сбрасываем кэш }
          mov ax,1681h
          int 2Fh                     { Отключаем Windows Task Switch }
          in al,0A1h                  { Маски IRQ 8-15 }
          mov ah,al
          in al,21h                   { Маски IRQ 0-7 }
          push ax                     { Сохраняем маски }
          mov al,0FEh
          out 21h,al                  { Запрещаем IRQ 1-7 (нулевой нам нужен) }
          inc ax
          out 0A1h,al                 { Запрещаем IRQ 8-15 }
          mov al,36h
          out 43h,al                  { Устанавливаем нормальный режим работы таймера }
          xor al,al
          out 40h,al
          out 40h,al                  { 65536 циклов до IRQ 0 }
          mov Stage,0                 { Готовимся к началу отсчёта }
       End
       GetIntVec(8, SaveInt08);       { Сохраняем старый IRQ 0 }
       SetIntVec(8, @SpeedCounter);   { Устанавливаем свой IRQ 0 }
       Asm
       @1:cmp Stage,1
          jne @1                      { Цикл до первого IRQ 0 }
          db 0Fh,31h  { RDTSC }
          db 66h; xchg cx,ax          { Запоминаем значение счётчика }
       @2:cmp Stage,2
          jne @2                      { Цикл до второго IRQ 0 }
          db 0Fh,31h  { RDTSC }
          db 66h; sub ax,cx           { Вычитаем из текущего значение счётчика запомненное }
          db 66h,0B9h; dd 1234DDh     { mov ecx,1234DDh }
          db 66h; mul cx              { Умножаем значение на 1193181 }
          db 66h,0Fh,0ACh,0D0h,10h    { shrd eax,edx,16 - делим на 65536 }
          db 66h; mov word ptr CPUClock,ax { Записываем результат в CPUClock }
          pop ax
          out 21h,al                  { Восстанавливаем маску IRQ 0-7 }
          mov al,ah
          out 0A1h,al                 { Восстанавливаем маску IRQ 8-15 }
       End
       SetIntVec(8, SaveInt08);       { Восстанавливаем старый IRQ 0 }
       Asm
          mov ax,1682h
          int 2Fh                     { Включаем Windows Task Switch }
       EndEnd;
     
    Procedure MDelay; assembler;
    Asm
       db 0Fh,31h  { RDTSC }
       db 66h; push ax
       db 66h; push dx           { Сохраняем счётчик в стеке }
       db 66h; mov ax,word ptr N
       db 66h; mov cx,word ptr CPUClock
       db 66h; mul cx            { Умножаем N на CPUClock }
       db 66h,0B9h; dd 1000000   { mov ecx,1000000 }
       db 66h; div cx            { Затем делим на 1000000 }
       db 66h; xchg si,ax        { Сохраняем значение в ESI }
       db 66h; pop cx
       db 66h; pop bx            { Восстанавливаем значение счётчика в ECX:EBX }
     @:db 0Fh,31h  { RDTSC }
       db 66h; sub ax,bx
       db 66h; sbb dx,cx         { Вычитаем из текущего счётчика ECX:EBX }
       db 66h; or dx,dx          { Старшая часть разницы д.б. всегда 0, проверяем это }
       jnz @Exit                 { Нет - выходим! }
       db 66h; cmp ax,si         { Проверяем - прошло ли столько, сколько нам надо }
       jb @                      { Нет - ждём ещё }
     @Exit:
    End
     
    Procedure TDelay; assembler;
    Asm
       db 0Fh,31h  { RDTSC }
       db 66h; mov bx,ax
       db 66h; mov cx,dx         { Сохраняем счётчик в ECX:EBX }
     @:db 0Fh,31h  { RDTSC }
       db 66h; sub ax,bx
       db 66h; sbb dx,cx         { Вычитаем из текущего счётчика ECX:EBX }
       db 66h; or dx,dx          { Старшая часть разницы д.б. всегда 0, проверяем это }
       jnz @Exit                 { Нет - выходим! }
       db 66h; cmp ax,word ptr N { Проверяем - прошло ли столько, сколько нам надо }
       jb @                      { Нет - ждём ещё }
     @Exit:
    End
     
    End.


И программа-тестер:

    Uses TSCDelay;
    Var N: Longint;
    Begin
       CalcCPUClock;
       WriteLn('Тактовая частота процессора: ', CPUClock/1000000: 0: 3,' МГц');
       Write('Введите количество микросекунд (не более ', 4294967296.0/CPUClock: 0: 3, ' млн): ');
       ReadLn(N);
       Write('Задержка...');
       MDelay(N);
       WriteLn(' всё!')
    End.

