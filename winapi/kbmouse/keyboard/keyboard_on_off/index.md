---
Title: Включение и выключение клавиатуры
Date: 01.01.2007
---


Включение и выключение клавиатуры
=================================

Вариант 1:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    // используемые переменные
    var
      Dummy: integer = 0;
      OldKbHook: HHook = 0;
     
    implementation
     
    function KbHook(code: Integer; wparam: Word; lparam: LongInt): LongInt; stdcall;
    begin
      if code < 0 then
        Result := CallNextHookEx(oldKbHook, code, wparam, lparam)
      else
        Result := 1;
    end;
     
    // включение клавы
     
    procedure TForm1.KeyBoardOn(Sender: TObject);
    begin
      if OldKbHook <> 0 then
      begin
        UnHookWindowshookEx(OldKbHook);
        OldKbHook := 0;
      end;
      SystemParametersInfo(SPI_SETFASTTASKSWITCH, 0, 0, 0);
      SystemParametersInfo(SPI_SCREENSAVERRUNNING, 0, 0, 0);
    end;
     
    // выключение клавы
     
    procedure TForm1.KeyBoardOff(Sender: TObject);
    begin
      SystemParametersInfo(SPI_SETFASTTASKSWITCH, 1, @Dummy, 0);
      SystemParametersInfo(SPI_SCREENSAVERRUNNING, 1, @Dummy, 0);
      OldKbHook := SetWindowsHookEx(WH_KEYBOARD, @KbHook, HInstance, 0);
    end;

Некоторые замечания по поводу этих процедур:

Если программу упаковать UPX-ом - клава не будет отключаться (причин не
знаю).

В ДОС-окне клава будет работать (FAR, VC и т.п.) :(

Состояния клавиш NumLock,CapsLock,ScrollLock не отслеживаются и могут
быть изменены.

Возможно EnableHardwareKeyboard более эффективен и прост, но я тоже, к
сожалению, не знаю, как им пользоваться.

Если вместо WH\_KEYBOARD поставить WH\_MOUSE, то можно выключать таким
образом мышь :-)


------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    program antiklava;
    { подключение необходимых модулей }
    uses
      Windows;
    { объявление логической переменной}
    var
      klava: boolean;
    begin
      { устанавливаем значение переменной }
      klava:=true;
      { начинаем бесконечный цикл }
      while true do
      begin
        { делаем так, чтобы всё не подвисло :)}
        Yield;
        { ничего не делаем 2 минуты }
        Sleep(2*60*1000);
        { присваиваем переменной противоположное значение }
        klava:=not klava;
        { и в зависимости от переменной,
        отключаем или включаем клаву с мышкой}
        EnableHardwareInput(klava);
      end;
    end.


------------------------------------------------------------------------

Вариант 3:

Вот недокументированная функция из User32.dll, которая блокирует ввод
(мышь, клавиатуру кроме Ctrl+Alt+Del). При нажатии Ctrl+Alt+Del все
разблокируется :-(

    procedure BlockInput; external 'user32.dll'; 

Передаем параметры в стек вручную через push, иначе что-то глючит:

1 - заблокировать  
0 - разблокировать

    procedure Block;
    asm
      push 1
      call BlockInput
    end;
     
    procedure UnBlock;
    asm
      push 0
      call BlockInput
    end;
