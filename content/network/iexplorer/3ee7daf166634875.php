<h1>Как получить handle на editbox в IE?</h1>
<div class="date">01.01.2007</div>


<pre>
var
  hndl: HWND;
  main: HWND;
begin
  main := FindWindow('IEFrame', nil);
 
  if main &lt;&gt; 0 then
  begin
    hndl := findwindowex(main, 0, 'Worker', nil);
 
    if hndl &lt;&gt; 0 then
    begin
      hndl := findwindowex(hndl, 0, 'ReBarWindow32', nil);
 
      if hndl &lt;&gt; 0 then
      begin
        hndl := findwindowex(hndl, 0, 'ComboBoxEx32', nil);
 
        if hndl &lt;&gt; 0 then
        begin
          hndl := findwindowex(hndl, 0, 'ComboBox', nil);
 
          if hndl &lt;&gt; 0 then
          begin
            hndl := findwindowex(hndl, 0, 'Edit', nil);
</pre>

<hr />
<pre>
unit Unit1;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, StdCtrls;
 
type
  TForm1 = class(TForm)
    Label1: TLabel;
    Button1: TButton;
    procedure Button1Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
    procedure FindIEEditHandle;
  end;
 
var
  Form1: TForm1;
  EditHandle: THandle;
 
implementation
 
{$R *.DFM}
 
function EnumIEChildProc(AHandle: hWnd; AnObject: TObject): BOOL; stdcall;
var
  tmpS: string;
  theClassName: string;
  theWinText: string;
begin
  Result := True;
  SetLength(theClassName, 256);
  GetClassName(AHandle, PChar(theClassName), 255);
  SetLength(theWinText, 256);
  GetWindowText(AHandle, PChar(theWinText), 255);
  tmpS := StrPas(PChar(theClassName));
  if theWinText &lt;&gt; EmptyStr then
    tmpS := tmpS + '"' + StrPas(PChar(theWinText)) + '"'
  else
    tmpS := tmpS + '""';
  if Pos('Edit', tmpS) &gt; 0 then
  begin
    EditHandle := AHandle;
  end;
end;
 
function IEWindowEnumProc(AHandle: hWnd; AnObject: TObject): BOOL; stdcall;
{callback for EnumWindows.}
var
  theClassName: string;
  theWinText: string;
  tmpS: string;
begin
  Result := True;
  SetLength(theClassName, 256);
  GetClassName(AHandle, PChar(theClassName), 255);
  SetLength(theWinText, 256);
  GetWindowText(AHandle, PChar(theWinText), 255);
  tmpS := StrPas(PChar(theClassName));
  if theWinText &lt;&gt; EmptyStr then
    tmpS := tmpS + '"' + StrPas(PChar(theWinText)) + '"'
  else
    tmpS := tmpS + '""';
  if Pos('IEFrame', tmpS) &gt; 0 then
  begin
    EnumChildWindows(AHandle, @EnumIEChildProc, longInt(0));
  end;
end;
 
procedure TForm1.FindIEEditHandle;
begin
  Screen.Cursor := crHourGlass;
  try
    EnumWindows(@IEWindowEnumProc, LongInt(0));
  finally
    Screen.Cursor := crDefault;
  end;
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  FindIEEditHandle;
  if EditHandle &gt; 0 then
    Label1.Caption := IntToStr(EditHandle)
  else
    label1.Caption := 'Not Found';
end;
 
end.
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>

