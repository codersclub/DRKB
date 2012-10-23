<h1>Поток с доступом к глобальной переменной основной программы</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Xavier Pacheco</div>
<pre>
unit Main;
 
interface
 
uses
 Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
 StdCtrls;
 
type
 TMainForm = class(TForm)
   Button1: TButton;
   procedure Button1Click(Sender: TObject);
 private
   { Private declarations }
 public
   { Public declarations }
 end;
 
var
 MainForm: TMainForm;
 
implementation
 
{$R *.DFM}
 
{ NOTE: Change GlobalStr from var to threadvar to see difference }
var
 //threadvar
 GlobalStr: string;
 
type
 TTLSThread = class(TThread)
 private
   FNewStr: string;
 protected
   procedure Execute; override;
 public
   constructor Create(const ANewStr: string);
 end;
 
procedure SetShowStr(const S: string);
begin
 if S = '' then
   MessageBox(0, PChar(GlobalStr), 'The string is...', MB_OK)
 else
   GlobalStr := S;
end;
 
constructor TTLSThread.Create(const ANewStr: string);
begin
 FNewStr := ANewStr;
 inherited Create(False);
end;
 
procedure TTLSThread.Execute;
begin
 FreeOnTerminate := True;
 SetShowStr(FNewStr);
 SetShowStr('');
end;
 
procedure TMainForm.Button1Click(Sender: TObject);
begin
 SetShowStr('Hello world');
 SetShowStr('');
 TTLSThread.Create('Dilbert');
 Sleep(100);
 SetShowStr('');
end;
 
end.
</pre>

<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
