<h1>Ловить события мышки вне вашего приложения</h1>
<div class="date">01.01.2007</div>


<pre>
unit Unit1;
 
 interface
 
 uses
   Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
   Dialogs, AppEvnts, StdCtrls;
 
 type
   TForm1 = class(TForm)
     ApplicationEvents1: TApplicationEvents;
     Button_StartJour: TButton;
     Button_StopJour: TButton;
     ListBox1: TListBox;
     procedure ApplicationEvents1Message(var Msg: tagMSG;
       var Handled: Boolean);
     procedure Button_StartJourClick(Sender: TObject);
     procedure Button_StopJourClick(Sender: TObject);
     procedure FormClose(Sender: TObject; var Action: TCloseAction);
   private
     { Private declarations }
     FHookStarted : Boolean;
   public
     { Public declarations }
   end;
 
 var
   Form1: TForm1;
 
 
 implementation
 
 {$R *.dfm}
 
 var
   JHook: THandle;
 
 // The JournalRecordProc hook procedure is an application-defined or library-defined callback 
// function used with the SetWindowsHookEx function. 
// The function records messages the system removes from the system message queue. 
// A JournalRecordProc hook procedure does not need to live in a dynamic-link library. 
// A JournalRecordProc hook procedure can live in the application itself. 
 
// WH_JOURNALPLAYBACK Hook Function 
 
//Syntax 
 
// JournalPlaybackProc( 
// nCode: Integer;  {a hook code} 
// wParam: WPARAM;  {this parameter is not used} 
// lParam: LPARAM  {a pointer to a TEventMsg structure} 
// ): LRESULT;  {returns a wait time in clock ticks} 
 
 
function JournalProc(Code, wParam: Integer; var EventStrut: TEventMsg): Integer; stdcall;
 var
   Char1: PChar;
   s: string;
 begin
   {this is the JournalRecordProc}
   Result := CallNextHookEx(JHook, Code, wParam, Longint(@EventStrut));
   {the CallNextHookEX is not really needed for journal hook since it it not 
  really in a hook chain, but it's standard for a Hook}
   if Code &lt; 0 then Exit;
 
   {you should cancel operation if you get HC_SYSMODALON}
   if Code = HC_SYSMODALON then Exit;
   if Code = HC_ACTION then
   begin
     { 
    The lParam parameter contains a pointer to a TEventMsg 
    structure containing information on 
    the message removed from the system message queue. 
    }
     s := '';
 
     if EventStrut.message = WM_LBUTTONUP then
       s := 'Left Mouse UP at X pos ' +
         IntToStr(EventStrut.paramL) + ' and Y pos ' + IntToStr(EventStrut.paramH);
 
     if EventStrut.message = WM_LBUTTONDOWN then
       s := 'Left Mouse Down at X pos ' +
         IntToStr(EventStrut.paramL) + ' and Y pos ' + IntToStr(EventStrut.paramH);
 
     if EventStrut.message = WM_RBUTTONDOWN then
       s := 'Right Mouse Down at X pos ' +
         IntToStr(EventStrut.paramL) + ' and Y pos ' + IntToStr(EventStrut.paramH);
 
     if (EventStrut.message = WM_RBUTTONUP) then
       s := 'Right Mouse Up at X pos ' +
         IntToStr(EventStrut.paramL) + ' and Y pos ' + IntToStr(EventStrut.paramH);
 
     if (EventStrut.message = WM_MOUSEWHEEL) then
       s := 'Mouse Wheel at X pos ' +
         IntToStr(EventStrut.paramL) + ' and Y pos ' + IntToStr(EventStrut.paramH);
 
     if (EventStrut.message = WM_MOUSEMOVE) then
       s := 'Mouse Position at X:' +
         IntToStr(EventStrut.paramL) + ' and Y: ' + IntToStr(EventStrut.paramH);
 
     if s &lt;&gt; '' then
        Form1.ListBox1.ItemIndex :=  Form1.ListBox1.Items.Add(s);
   end;
 end;
 
 procedure TForm1.Button_StartJourClick(Sender: TObject);
 begin
   if FHookStarted then
   begin
     ShowMessage('Mouse is already being Journaled, can not restart');
     Exit;
   end;
   JHook := SetWindowsHookEx(WH_JOURNALRECORD, @JournalProc, hInstance, 0);
   {SetWindowsHookEx starts the Hook}
   if JHook &gt; 0 then
   begin
     FHookStarted := True;
   end
   else
     ShowMessage('No Journal Hook availible');
 end;
 
 procedure TForm1.Button_StopJourClick(Sender: TObject);
 begin
   FHookStarted := False;
   UnhookWindowsHookEx(JHook);
   JHook := 0;
 end;
 
 procedure TForm1.ApplicationEvents1Message(var Msg: tagMSG;
   var Handled: Boolean);
 begin
   {the journal hook is automaticly camceled if the Task manager 
  (Ctrl-Alt-Del) or the Ctrl-Esc keys are pressed, you restart it 
  when the WM_CANCELJOURNAL is sent to the parent window, Application}
   Handled := False;
   if (Msg.message = WM_CANCELJOURNAL) and FHookStarted then
     JHook := SetWindowsHookEx(WH_JOURNALRECORD, @JournalProc, 0, 0);
 end;
 
 procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
 begin
   {make sure you unhook it if the app closes}
   if FHookStarted then
     UnhookWindowsHookEx(JHook);
 end;
 
 end.
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

