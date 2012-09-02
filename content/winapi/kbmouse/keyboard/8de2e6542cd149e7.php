<h1>Регистрируем горячие клавиши</h1>
<div class="date">01.01.2007</div>


<p>Пример демонстрирует установку горячей клавиши CTRL-F7:</p>
<pre>
unit Unit1;
interface
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,StdCtrls;
 
type
  TForm1 = class(TForm)
    procedure FormActivate(Sender: TObject);
    procedure FormDestroy(Sender: TObject);
  private
    procedure WMHotKey(var Message: TMessage); message WM_HOTKEY;
  end;
 
var
  Form1: TForm1;
implementation
 
{$R *.DFM}
procedure Tform1.WMHotKey(var Message: TMessage);
begin
  application.Restore;
  application.bringtofront;
  showmessage('Нажата CTRL-F7!');
end;
 
procedure TForm1.FormActivate(Sender: TObject);
begin
  RegisterHotKey(form1.Handle,123,mod_control,vk_f7);
end;
 
procedure TForm1.FormDestroy(Sender: TObject);
begin
  UnregisterHotKey(Handle, 123)
end;
 
end.
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


<hr />
<pre>
{ 
  The following example demonstrates registering hotkeys with the 
  system to globally trap keys. 
 
  Das Folgende Beispiel zeigt, wie man Hotkeys registrieren und 
  darauf reagieren kann, wenn sie gedruckt werden. (systemweit) 
}
 
 unit Unit1;
 
 interface
 
 uses
   Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
   Dialogs;
 
 type
   TForm1 = class(TForm)
     procedure FormCreate(Sender: TObject);
     procedure FormDestroy(Sender: TObject);
   private
     { Private declarations }
     id1, id2, id3, id4: Integer;
     procedure WMHotKey(var Msg: TWMHotKey); message WM_HOTKEY;
   public
     { Public declarations }
   end;
 
 var
   Form1: TForm1;
 
 implementation
 
 {$R *.dfm}
 
 // Trap Hotkey Messages 
procedure TForm1.WMHotKey(var Msg: TWMHotKey);
 begin
   if Msg.HotKey = id1 then
     ShowMessage('Ctrl + A pressed !');
   if Msg.HotKey = id2 then
     ShowMessage('Ctrl + Alt + R pressed !');
   if Msg.HotKey = id3 then
     ShowMessage('Win + F4 pressed !');
   if Msg.HotKey = id4 then
     ShowMessage('Print Screen pressed !');
 end;
 
 procedure TForm1.FormCreate(Sender: TObject);
   // Different Constants from Windows.pas 
const
   MOD_ALT = 1;
   MOD_CONTROL = 2;
   MOD_SHIFT = 4;
   MOD_WIN = 8;
   VK_A = $41;
   VK_R = $52;
   VK_F4 = $73;
 begin
   // Register Hotkey Ctrl + A 
  id1 := GlobalAddAtom('Hotkey1');
   RegisterHotKey(Handle, id1, MOD_CONTROL, VK_A);
 
   // Register Hotkey Ctrl + Alt + R 
  id2 := GlobalAddAtom('Hotkey2');
   RegisterHotKey(Handle, id2, MOD_CONTROL + MOD_Alt, VK_R);
 
   // Register Hotkey Win + F4 
  id3 := GlobalAddAtom('Hotkey3');
   RegisterHotKey(Handle, id3, MOD_WIN, VK_F4);
 
   // Globally trap the Windows system key "PrintScreen" 
  id4 := GlobalAddAtom('Hotkey4');
   RegisterHotKey(Handle, id4, 0, VK_SNAPSHOT);
 end;
 
 // Unregister the Hotkeys 
procedure TForm1.FormDestroy(Sender: TObject);
 begin
   UnRegisterHotKey(Handle, id1);
   GlobalDeleteAtom(id1);
   UnRegisterHotKey(Handle, id2);
   GlobalDeleteAtom(id2);
   UnRegisterHotKey(Handle, id3);
   GlobalDeleteAtom(id3);
   UnRegisterHotKey(Handle, id4);
   GlobalDeleteAtom(id4);
 end;
 
 end.
 
 { 
  RegisterHotKey fails if the keystrokes specified for the hot key have 
  already been registered by another hot key. 
 
  Windows NT4 and Windows 2000/XP: The F12 key is reserved for use by the 
  debugger at all times, so it should not be registered as a hot key. Even 
  when you are not debugging an application, F12 is reserved in case a 
  kernel-mode debugger or a just-in-time debugger is resident. 
}
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>

<hr />
<p>Вот код о том как назначить горячие клавиши если даже активна другая программа. Код взят из рассылки "Мастера DELPHI. Новости мира компонент, FAQ, статьи..."</p>
<pre>
type 
TForm1 = class(TForm) 
  procedure FormCreate(Sender: TObject); 
  procedure FormDestroy(Sender: TObject); 
protected 
  procedure hotykey(var msg:TMessage); message WM_HOTKEY; 
end; 
 
var 
  Form1: TForm1; 
  id,id2:Integer; 
 
implementation 
 
{$R *.DFM} 
 
procedure TForm1.hotykey(var msg:TMessage); 
begin 
if (msg.LParamLo=MOD_CONTROL) and (msg.LParamHi=81) then 
begin 
ShowMessage('Ctrl + Q wurde gedrьckt !'); 
end; 
if (msg.LParamLo=MOD_CONTROL) and (msg.LParamHi=82) then 
begin 
ShowMessage('Ctrl + R wurde gedrьckt !'); 
end; 
end; 
 
procedure TForm1.FormCreate(Sender: TObject); 
begin 
id:=GlobalAddAtom('hotkey'); 
RegisterHotKey(handle,id,mod_control,81); 
id2:=GlobalAddAtom('hotkey2'); 
RegisterHotKey(handle,id2,mod_control,82); 
end; 
 
procedure TForm1.FormDestroy(Sender: TObject); 
begin 
UnRegisterHotKey(handle,id); 
UnRegisterHotKey(handle,id2); 
end;
</pre>

<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

