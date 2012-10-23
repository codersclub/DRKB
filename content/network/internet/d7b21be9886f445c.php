<h1>Можно ли определить интернет адрес?</h1>
<div class="date">01.01.2007</div>


<pre>
unit Unit1;
 

 
interface
 
uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, ActiveX, SHDocVw, MSHTML_TLB, StdCtrls;
 
type
  TForm1 = class(TForm)
    Memo1: TMemo;
    procedure FormCreate(Sender: TObject);
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.dfm}
 
function GetHTMLCode(WB: IWebbrowser2; ACode: TStrings): Boolean;
var
  Range: IHTMLTxtRange;
begin
  Range := ((WB.Document as IHTMLDocument2).body as
    IHTMLBodyElement).createTextRange;
  ACode.Text :=  ACode.Text + Range.text;
end;
 
procedure TForm1.FormCreate(Sender: TObject);
var
 ShellWindow: IShellWindows;
 WB: IWebbrowser2;
 spDisp: IDispatch;
 IDoc1: IHTMLDocument2;
 k: Integer;
begin
  ShellWindow := CoShellWindows.Create;
  for k := 0 to ShellWindow.Count do
  begin
   spDisp := ShellWindow.Item(k);
   if spDisp = nil then Continue;
   spDisp.QueryInterface(IWebBrowser2, WB);
   if WB &lt;&gt; nil then
   begin
     WB.Document.QueryInterface(IHTMLDocument2, iDoc1);
     if iDoc1 &lt;&gt; nil then
     begin
       WB := ShellWindow.Item(k) as IWebbrowser2;
       begin
         Memo1.Lines.Add('****************************************');
         Memo1.Lines.Add(WB.LocationURL);
         Memo1.Lines.Add('****************************************');
         GetHTMLCode(WB, Memo1.Lines);
       end;
     end;
   end;
  end;
end;
 
end.
</pre>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<div class="author">Автор: Rouse_</div>

