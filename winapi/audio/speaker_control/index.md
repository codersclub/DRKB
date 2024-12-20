---
Title: Как управлять спикером под 9х?
Date: 01.01.2007
---


Как управлять спикером под 9х?
==============================

Вариант 1:

Source: <https://forum.sources.ru>

Author: Ненашев Илья Николаевич

Под WinNT/2000/XP вы можете использовать `Beep(Tone, Duration)`
(задавать тон и продолжительность звучания).

А под 9.x/Me эта функция не
реализована, но можно командовать железом через порты, и сделать
универсальную:

    unit BeepUnit; 
     
    procedure Beep(Tone, Duration: Word); // универсальная - версию виндовса проверяет 
     
    procedure Sound(Freq : Word); 
    procedure NoSound; 
     
    procedure SetPort(address, Value:Word); 
    function GetPort(address:word):word; 
     
    implementation 
     
    procedure SetPort(address, Value:Word); 
    var 
      bValue: byte; 
    begin 
      bValue := trunc(Value and 255); 
      asm 
        mov dx, address 
        mov al, bValue 
        out dx, al 
      end; 
    end; 
     
    function GetPort(address:word):word; 
    var 
      bValue: byte; 
    begin 
      asm 
        mov dx, address 
        in al, dx 
        mov bValue, al 
      end; 
      GetPort := bValue; 
    end; 
     
    procedure Sound(Freq : Word); 
    var 
      B : Byte; 
    begin 
      if Freq > 18 then begin 
        Freq := Word(1193181 div LongInt(Freq)); 
        B := Byte(GetPort($61)); 
        if (B and 3) = 0 then begin 
          SetPort($61, Word(B or 3)); 
          SetPort($43, $B6); 
        end; 
        SetPort($42, Freq); 
        SetPort($42, Freq shr 8); 
      end; 
    end; 
     
    procedure NoSound; 
    var 
      Value: Word; 
    begin 
      Value := GetPort($61) and $FC; 
      SetPort($61, Value); 
    end; 
     
    procedure Beep(Tone, Duration: Word); 
    begin 
      if SysUtils.Win32Platform = VER_PLATFORM_WIN32_NT 
        then Windows.Beep(Tone, Duration) 
        else begin 
          Sound(Tone); 
          Windows.Sleep(Duration); 
          NoSound; 
        end; 
    end; 
     
    end.


------------------------------------------------------------------------

Вариант 2:

Author: Steve Keyser

Source: <https://delphiworld.narod.ru>

Вот мой старый способ, которым я извлекал звуки в Visual Basic (это было
много времени назад) с помощью функций API. Ниже приведена функция,
требующая на входе два параметра: тон и длительность воспроизведения.

(**Примечание:** функции Windows API требуют гораздо большее количество
параметров, но вам нужно беспокоиться только о тех, которые изменяются
от вызова до вызова... т.е. только о тоне и длительности.)

    procedure MakeSound(note, duration: integer);
    {
    Цель:      Проигрывание звуков на динамике PC.
    Параметры:
    note = шаг тона (правильный диапазон с 1 по 84
           (1 - самый низкий тон и 84 - самый высокий)
    duration = продолжительность звучания
               (допустимый диапазон с 1 по 128...
               но это мои догадки...
               чем меньше значение - тем короче продолжительность)
    }
    var
      result: integer;
    begin
      {проверка на правильность величины... должно быть 1-84}
      if (note < 1) or (note > 84) then
        exit;
      {проверка на правильность величины... по моим догадкам,
       должно быть в диапазоне от 1 до 128}
      if (duration < 1) or (duration > 128) then
        exit;
      {открываем звуковой канал}
      result := OpenSound;
      {устанавливаем размер звуковой очереди
       (не очищайте это! Я думаю что каждая нота требует 6 байт.)}
      result := SetVoiceQueueSize(1, 6);
      {устанавливаем звуковую ноту (и ее длительность)}
      result := SetVoiceNote(1, note, duration, 1);
      {проигрываем ноту}
      result := StartSound;
      {ожидаем окончания звучания}
      result := WaitSoundState(S_QUEUEEMPTY);
      {закрываем звуковой канал}
      CloseSound;
    end;

Затем можно вызвать эту функцию следующим образом...

    MakeSound(1,1);
    MakeSound(32,10);

Эти две строчки заставят динамик вашего PC зазвучать сначала в низком
диапазоне (продолжительностью в секунду или две), и затем немного дольше
в более высоком диапазоне.

