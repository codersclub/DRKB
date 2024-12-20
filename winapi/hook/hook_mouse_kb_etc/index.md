---
Title: Использование ловушек: блокировка мыши, клавиатуры и т.д.
Author: Song
Date: 13.10.2002
---


Использование ловушек: блокировка мыши, клавиатуры и т.д.
=========================================================

Возможные вариации: Любые вопросы, связанные с постановкой хука.
Например:
- Как отследить [что-то],
- Как подменить [какое-то действие],
- Как заблокировать комбинации клавиш,
- Как заблокировать определённые действия,
- Как не дать запускаться определённым приложениям,
- Как не дать открываться определённым окнам?,
- Как получить список запущенных оконных приложений?

 и т.д.

Рабочий пример глобальной блокировки правой кнопки мыши:

DLL:

    library Project2;
    Uses Windows,Messages;
    Var SysHook:HHook=0;
     
    Function SysMsgProc(Code:Integer; WParam:LongInt; LParam:LongInt):LongInt; stdcall;
    Var Msg:TMessage;
    Begin
     IF Code=HC_ACTION then
      Case TMsg(Pointer(LParam)^).Message OF
       WM_RBUTTONDOWN,WM_RBUTTONUP,WM_RBUTTONDBLCLK: TMsg(Pointer(LParam)^).Message:=WM_NULL
       else Result:=CallNextHookEx(SysHook,Code,WParam,LParam);
      End;
    end;
     
    procedure Hook(Flag:Boolean); export; stdcall;
    Begin
     IF Flag then SysHook:=SetWindowsHookEx(WH_GETMESSAGE,@SysMsgProc,HInstance,0) Else
      Begin
       UnhookWindowsHookEx(SysHook);
       SysHook:=0;
      End;
    End;
     
    exports Hook;
     
    {$R *.res}
     
    begin
    end. 

Project:

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, Menus, StdCtrls;
     
    type
      MyProcType = procedure (Flag: Boolean); stdcall;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        Button2: TButton;
        procedure FormMouseDown(Sender: TObject; Button: TMouseButton;
          Shift: TShiftState; X, Y: Integer);
        procedure Button1Click(Sender: TObject);
        procedure Button2Click(Sender: TObject);
        procedure FormDestroy(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
      HDLL:HWND;
     
    implementation
     
    {$R *.dfm}
     
    procedure TForm1.FormMouseDown(Sender: TObject; Button: TMouseButton;
     Shift: TShiftState; X, Y: Integer);
    begin
     IF Button=mbRight then ShowMessage('Right mouse key pressed');
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    Var Hook: MyProcType;
    Begin
     @Hook:=nil;
     HDLL:=LoadLibrary(PChar('project2.dll')); 
     IF HDLL>HINSTANCE_ERROR then           
      Begin
       @Hook:=GetProcAddress(HDLL,'Hook');  
       Hook(True);
      End else MessageDlg('Ошибка загрузки DLL.',mtError,[mbIgnore],0);
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    Var Hook: MyProcType;
    Begin
     @Hook:=nil;
     IF HDLL>HINSTANCE_ERROR then
      Begin                                   
       @Hook:=GetProcAddress(HDLL,'Hook');  
       Hook(False);                        
      End;
    End;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
     Button2.Click;
    end;
     
    end. 

Файлы для демонстрации можно взять здесь: [hook.rar](hook.rar) 9k

Работает так:

- при неустановленном хуке правая кнопка работает (о чём
свидетельствует нажатие правой кнопки мыши - событие TForm.onMouseDown и
сообщение).
- После установки хука кнопкой "Install", события от мыши
перестают обрабатываться (сообщение "Right mouse key pressed" не
выдаётся).
- после снятия хука (кнопка "Remove") - всё возвращается к
первоначальному состоянию.

Если требуется перехватывать клавиши, тогда из вышеобозначенной теории
нам известны варианты: WH\_KEYBOARD, WH\_KEYBOARD\_LL или
WH\_GETMESSAGE+WM\_CHAR/WM\_KEYDOWN/UP

Однако, если требуется перехватить всего лишь отдельную клавишу, будь то
одну, либо с нажатым Ctrl, Alt, Shift, рациональней для этого
воспользоваться назначением горячей клавиши, через RegisterHotKey().

Рабочий пример такого приёма:

    type
      TForm1 = class(TForm)
        procedure FormCreate(Sender: TObject);
        procedure FormDestroy(Sender: TObject);
      protected
        procedure hotykey(var msg: TMessage); message WM_HOTKEY;
      end;
     
    var
      Form1: TForm1;
      id, id2: Integer;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.hotykey(var msg: TMessage);
    begin
      if (msg.LParamLo = MOD_CONTROL) and (msg.LParamHi = 81) then
        begin
          ShowMessage('Ctrl + Q was pressed !');
        end;
     
      if (msg.LParamLo = MOD_CONTROL) and (msg.LParamHi = 82) then
        begin
          ShowMessage('Ctrl + R was pressed !');
        end;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      id := GlobalAddAtom('hotkey');
      RegisterHotKey(handle, id, mod_control, 81);
     
      id2 := GlobalAddAtom('hotkey2');
      RegisterHotKey(handle, id2, mod_control, 82);
    end;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
      UnRegisterHotKey(handle, id);
      UnRegisterHotKey(handle, id2);
    end;

--------------------------------------------------
Вариант 2:

Author: Song

**Блокировка клавиатуры/мыши.**

> Родственная тема, поэтому помещена в этот же вопрос.

Итак, заблокировать можно хуком. Но в некоторых случаях можно обойтись и
"малой кровью".

Вы можете использовать ф-ию BlockInput. Она живёт в user32.dll Также она
блокирует одновременно и мышь.

    Procedure BlockInput(ABlockInput : Boolean); stdcall; external 'USER32.DLL';

- BlockInput(True); - заблокировать

- BlockInput(False); - разблокировать

Однако имейте ввиду, что BlockInput() не заблокирует Control-Alt-Del.
Кроме того, её работа блокируется по нажатию трёх пальцев.
Для блокировки CAD в w9x, мы
можем использовать режим скринсэйвера, а в NT, увы никак.

Ф-ия BlockInput() явилась продолжением ф-ии EnableHardwareInput(),
которая как мы знаем использовалась в 16-разрядных приложениях.

Кроме того, для блокировки, мы можем использовать некоторые
недокументированные возможности, однако их недастаток в том, что обратно
клавиатуру/мышь уже включить нельзя:

"rundll32 keyboard,disable" - заблокироовать клавиатуру

"rundll32 mouse,disable" - заблокировать мышь

Запустить эти команды мы можем самое простое через ShellExecute() или
WinExec():

    ShellExecute(Application.Handle,'open','C:\Windows\Rundll32.exe',
                 'команда','C:\Windows\',SW_HIDE);

