---
Title: Создание ловушек в Delphi
Author: Chris Cummings (http://wibblovia.topcities.com)
Date: 01.01.2007
---


Создание ловушек в Delphi
=========================

::: {.date}
01.01.2007
:::

Автор: Chris Cummings (http://wibblovia.topcities.com)

Рано или поздно каждый программист сталкивается с таким понятим как
ловушки. Чтобы приступить к ипользованию ловушек необходимо обзавестись
windows SDK, который можно так же скачать с сайта Microsoft. В
прилагаемом к статье архиве содержатся два проекта: hooks.dpr - это
пример приложения работающего с ловушками, а hookdll.dpr - собственно
сама DLL.

Что такое ловушки (Hooks)?

Проще говоря, ловушка - это функция, которая является частью DLL или
часть Вашего приложения, при помощи которой можно контролировать
\'происходящее\' внутри окошек операционной системы. Идея состоит в том,
чтобы написать функцию, которая будет вызываться каждый раз, когда будет
возникать определённое событие - например, когда пользователь нажмёт
клавишу или переместит мышку. Ловушки были задуманы Microsoft в первую
очередь, чтобы облегчить программистам отладку приложений. Однако
существует множество способов использования ловушек - например, чаще
всего при помощи ловушек пишутся клавиатурные шпионы.

Итак, существует два типа ловушек - глобальные и локальные. Локальная
ловушка отслеживает только те события, которые происходят только в одной
программе (или потоке). Глобальная ловушка отслеживает события во всей
системе (во всех потоках). Оба типа ловушек устанавливаются одинаково,
однако единственно отличие заключается в том, что локальная ловушка
вызывается в пределах Вашего приложения, в то время как глобальную
ловушку необходимо хранить и вызывать из отдельной DLL.

Процедуры ловушки

Далее следует краткое описание каждой процедуры и структуры, необходимой
для ловушки.

функция The SetWindowsHookEx

Функция SetWindowsHookEx необходима для установки ловушки. Давайте
посмотрим на аргументы данной функции:

Name        Type        Description       idHook        Integer      
 Число, представляющее тип ловушки - например WH\_KEYBOARD       lpfn  
     TFNHookProc        Адрес в памяти функции ловушки       hMod      
 Hinst        Дескриптор dll в которой находится функция. Если это
локальная ловушка, то этот параметр 0.       dwThreadID        Cardinal
       \'id потока\', который Ваша программа будет контролировать. Если
это глобальная ловушка, то параметр должен быть 0.      

SetWindowsHookEx возвращает дескриптор (т.е. идентификатор) текущей
ловушки, который можно использовать в функции UnhookWindowsHookEx для
последующего удаления ловушки.

Функция hook

Функция hook это процедура, которая вызывает в случае, если необходимое
нам событие происходит. Например, если установлена ловушка типа
WH\_KEYBOARD, то окно будет передавать в ловушку информацию о том, какая
клавища была нажата. Для Вашей процедуры hook необходимы следующие
аргументы:

Name        Type        Description       Code        Integer      
 Указывает на то, что означают следующие два параметра       wParam    
   word        Параметр размером в 1 слово (word)       lParam      
 longword        Параметр размером в 2 слова      

Функция hook возвращает значение типа longword.

Функция CallNextHookEx

Данная функция предназначена для работы с цепочкой функций ловушек.
Когда ловушка установлена на определённое событие, то может возникнуть
такая ситуация, когда кто-нибудь тоже захочет установить ловушку на это
же событие. Когда Вы устанавливаете ловушку при помощи SetWindowsHookEx,
то Ваша процедура ловушки добавляется в начало списка процедур ловушек.
Поэтому основная задача функции CallNextHookEx заключается в том, чтобы
вызвать следующий в списке обработчик ловушки. Когда Ваша процедура
ловушки завершится, то она должна вызовать CallNextHookEx, а затем
вернуть заданное значение, в зависимости от типа ловушки.

Функция UnhookWindowsHookEx

Данная функция просто напросто удаляет Вашу ловушку. Единственный
аргумент этой функции - это дескриптор ловушки, возвращаемы функцией
SetWindowsHookEx.

Локальная ловушка

Сперва давайте создадим локальную ловушку. Необходимый для неё код
содержится в \'local.pas\'. При запуске Hooks.exe будет отображена
небольшая форма. Для использования локальной ловушки достаточно нажать
кнопку Add/Remove Local Hook на этой форме. После установки локальной
ловушки, Вы заметите, что при нажатии и отпускании любой клавиши будет
раздаваться звуковой сигнал (естевственно, когда hooks.exe будет иметь
фокус. Ведь это локальная ловушка).

Самая первая функция в local.pas - SetupLocalHook, которая соственно и
создаёт локальную ловушку, указывая на процедуру ловушки KeyboardHook. В
данном случае это простой вызов SetWindowsHookEx, и, если возвращённый
дескриптор \> 0, указывающий на то, что процедура работает, то сохраняет
этот дескриптор в CurrentHook и возвращает true, иначе будет возвращено
значение false. Далее идёт функция RemoveLocalHook, которая получает в
качестве параметра сохранённый дескриптор в CurrentHook и использует его
в UnhookWindowsHookEx для удаления ловушки. Последняя идёт процедура
hook, которая всего навсего проверяет - была ли отпущена клавиша и если
надо, то выдаёт звуковой сигнал.

Глобальная ловушка

Глобальная ловушка выглядит немного сложнее. Для создания глобальной
ловушки нам понадобится два проекта - певый для создания исполняемого
файла и второй для создания DLL, содержащей процедуру ловушки.
Глобальная ловушка, которая представлена в примере, сохраняет в файле
log.txt каждые 20 нажатий клавиш. Чтобы использовать глобальную ловушку,
достаточно на форме hook.exe нажать кнопку add/remove global hook.
Затем, например, в записной книжке (notepad) достаточно набрать
какой-нибудь текст, и Вы увидите, что в log.txt этот текст сохранится.

Наша Dll содержит две процедуры. Первая - это процедура hook, которая
идентична для той, которую мы рассмотрели для локальной ловушки. Вторая
процедура необходима инициализации dlls, и содержит текущий номер
клавиши, которая была нажата, а также дескриптор ловушки, которая была
создана.

Исполняемый файл сперва должен загрузить процедуры из DLL, а затем
использовать SetWindowsHookEx, чтобы создать глобальную ловушку.

В заключении\...

Представленный пример объясняет - как перехватывать события клавиатуры.
Чтобы узнать, как использовать ловушки других типов, таких как
WH\_MOUSE, необходимо разобраться с windows SDK.

Приложения:

    library HookDll;
     
     
    uses
      SysUtils,
      Classes,windows;
     
    var CurrentHook: HHook;
        KeyArray: array[0..19] of byte;
        KeyArrayPtr: integer;
        CurFile: file of byte;
    {
    GlobalKeyboardHook
    ------------
    This is the hook procedure to be loaded from hooks.exe when you
    try and create a global hook. It is similar in structure to that defined
    in hook.dpr for creating a local hook, but this time it does not beep!
    Instead it stores each key pressed in an array of bytes (20 long). Whenever
    this array gets full, it writes it to a file, log.txt and starts again.
    }
    function GlobalKeyBoardHook(code: integer; wParam: word; lParam: longword): longword; stdcall;
    begin
        if code<0 then begin  //if code is <0 your keyboard hook should always run CallNextHookEx instantly and
           GlobalKeyBoardHook:=CallNextHookEx(CurrentHook,code,wParam,lparam); //then return the value from it.
           Exit;
        end;
        //firstly, is the key being pressed, and is it between A and Z
        //note that wParam contains the scan code of the key (which for a-z is the same as the ascii value)
        if ((lParam and KF_UP)=0) and (wParam>=65) and (wParam<=90) then begin
             //store the keycode in the list of keys pressed and increase the pointer
             KeyArray[KeyArrayPtr]:=wParam;
             KeyArrayPtr:=KeyArrayPtr+1;
             //if 20 keys have been recorded, save them to log.txt and start again
             if KeyArrayPtr>19 then begin
                assignfile(CurFile,'log.txt');
                if fileexists('log.txt')=false then rewrite(CurFile) else reset(CurFile); //if log.txt exists, add to it, otherwise recreate it
                blockwrite(CurFile,KeyArray[0],20);
                closefile(CurFile);
                KeyArrayPtr:=0;
             end;
        end;
        CallNextHookEx(CurrentHook,code,wParam,lparam);  //call the next hook proc if there is one
        GlobalKeyBoardHook:=0; //if GlobalKeyBoardHook returns a non-zero value, the window that should get
                         //the keyboard message doesnt get it.
        Exit;
    end;
     
    {
    SetHookHandle
    -------------
    This procedure is called by hooks.exe simply to 'inform' the dll of
    the handle generated when creating the hook. This is required
    if the hook procedure is to call CallNextHookEx. It also resets the
    position in the key list to 0.
     
    }
    procedure SetHookHandle(HookHandle: HHook); stdcall;
    begin
        CurrentHook:=HookHandle;
        KeyArrayPtr:=0;
    end;
     
    exports GlobalKeyBoardHook index 1,
            SetHookHandle index 2;
    begin
     
    end.

    unit MainFormUnit;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, Local, global,
      StdCtrls;
     
    type
      TMainForm = class(TForm)
        Button1: TButton;
        Button2: TButton;
        procedure Button1Click(Sender: TObject);
        procedure FormCreate(Sender: TObject);
        procedure FormDestroy(Sender: TObject);
        procedure Button2Click(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      MainForm: TMainForm;
     
    implementation
     
    {$R *.DFM}
     
    procedure TMainForm.Button1Click(Sender: TObject);
    begin
        if GHookInstalled=true then exit; //if a global hook is installed, exit routine
         //if a local hook not installed, then attempt to install one, else attempt to remove one
         if HookInstalled=false then HookInstalled:=SetupLocalHook else HookInstalled:=not(RemoveLocalHook);
    end;
     
    procedure TMainForm.FormCreate(Sender: TObject);
    begin
         HookInstalled:=false;
         GHookInstalled:=false;
         LibLoaded:=false;
    end;
     
    procedure TMainForm.FormDestroy(Sender: TObject);
    begin
         if HookInstalled=true then RemoveLocalHook;
    end;
     
    procedure TMainForm.Button2Click(Sender: TObject);
    begin
         if HookInstalled=true then exit; //if a local hook is installed, exit routine
         //if a local hook not installed, then attempt to install one, else attempt to remove one
         //note that removelocalhook can still be used no matter whether the hook is global or local
         if GHookInstalled=false then GHookInstalled:=SetupGlobalHook else GHookInstalled:=not(RemoveLocalHook);
    end;
     
    end.

Взято из <https://forum.sources.ru>
