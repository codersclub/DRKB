<h1>Изменение вида сортировки объектов в диалогах</h1>
<div class="date">01.01.2007</div>


<pre>
unit Unit1;

 
interface
 
uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, StdCtrls;
 
type
  TForm1 = class(TForm)
    SaveDialog1: TSaveDialog;
    Button1: TButton;
    procedure SaveDialog1Show(Sender: TObject);
    procedure Button1Click(Sender: TObject);
  private
    { Private declarations }
  public
 
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.dfm}
 
// Стили: $7029 - значки, $702B - список, $702C - таблица, $702D - эскизы, $702E - плитка
// ставим, например таблицу
function NewSaveDlgProc(wnd:HWND; uMsg:integer; wParam:integer; lParam:integer):integer; stdcall;
begin
 if uMsg=WM_SHOWWINDOW then
 begin
  MoveWindow(wnd, 10, 30, 500, 300, True) ;
  SendMessage(FindWindowEx(wnd, 0, 'SHELLDLL_DefView', nil), WM_COMMAND, $702C, 0);
 end;
 result:=CallWindowProc(Pointer(GetWindowLong(wnd,GWL_USERDATA)),wnd,uMsg,wParam,lParam)
end;
 
procedure TForm1.SaveDialog1Show(Sender: TObject);
begin
  SetWindowLong(GetParent(SaveDialog1.Handle),GWL_USERDATA,
     SetWindowLong(GetParent(SaveDialog1.Handle),DWL_DLGPROC,DWORD(@NewSaveDlgProc)));
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
 SaveDialog1.Execute
end;
 
end.
</pre>
<p>&nbsp;<br>
<p class="author">Автор: Krid </p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
&nbsp;<br>

