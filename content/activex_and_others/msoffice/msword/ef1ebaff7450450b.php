<h1>Работа с Word через OLE</h1>
<div class="date">01.01.2007</div>


<pre>
unit Unit1; 
interface
uses Windows, Messages, SysUtils, Classes, Graphics,      Controls, Forms,      Dialogs, Buttons,ComCtrls, ExtCtrls, OleCtnrs;
 
type TForm1 = class(TForm)
    OleContainer1: TOleContainer;
    Panel1: TPanel;
    StatusBar1: TStatusBar;
    mbLoad: TSpeedButton;
    mbPrint: TSpeedButton;
    OpenDialog1: TOpenDialog;
    procedure mbLoadClick(Sender: TObject);
    procedure mbPrintClick(Sender: TObject);
  private
 { Private declarations }
  public
{ Public declarations }
  end;
var Form1: TForm1; i
  mplementation{$R *.DFM}
 
procedure TForm1.mbLoadClick(Sender: TObject);
begin
  // Покажем диалог, и если он отработал, то загрузим в контейнер
  if OpenDialog1.Execute and (OpenDialog1.FileName &lt;&gt; '') then
    OleContainer1.CreateObjectFromFile(OpenDialog1.FileName, false);
  / Если загрузилось что - нибудь, то покажем
    if OleContainer1.State &lt;&gt; osEmpty then OleContainer1.DoVerb(ovShow);
end;
 
procedure TForm1.mbPrintClick(Sender: TObject);
var V: Variant;
begin
  if OleContainer1.State = osEmpty then
    begin
      MessageDlg('OLE не загружен !!', mtError, [mbOk], 0);
      exit;
    end;
// Получаем объект, который воплощает в себе WordBasic интерфейс
  V := OleContainer1.OleObject.Application.WordBasic;
// Командуем до одурения ....
  V.FilePrint; end; end.
</pre>


<p>Взято с сайта <a href="https://blackman.wp-club.net/" target="_blank">https://blackman.wp-club.net/</a></p>

