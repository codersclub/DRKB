<h1>Как открыть HTML-файл в стандартном браузере?</h1>
<div class="date">01.01.2007</div>


<pre>
//------------------------------------------------------------- 
// HTMLView - пример, показывающий, как открыть HTM/HTML файл в браузере,
// установленном поумолчанию.
// Пример использует Win32API функцию ShellExecute с параметром 'open',
// которая заставляет систему найти в реестре приложение, связанное
// с расширением HTM/HTML.
//------------------------------------------------------------- 
unit HTMLUnit; 
interface 
uses 
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, 
  StdCtrls, ShellAPI; 
type 
  TForm1 = class(TForm) 
    OpenDialog1: TOpenDialog; 
    Button1: TButton; 
    Button2: TButton; 
    Label1: TLabel; 
    procedure Button1Click(Sender: TObject); 
    procedure Button2Click(Sender: TObject); 
  private 
    { Private declarations } 
  public 
    { Public declarations } 
  end; 
var 
  Form1    : TForm1; 
  HTMLFile : Array[0..79] of Char; 
implementation 
{$R *.DFM} 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
If OpenDialog1.Execute then 
   begin 
// получаем имя выбранного файла
    StrPCopy(HTMLFile, OpenDialog1.FileName); 
// разрешаем пользователю открывать (т.е. просматривать) его в браузере
    Button2.Enabled := True; 
   end; 
end; 
procedure TForm1.Button2Click(Sender: TObject); 
begin 
// запускаем функцию ShellExecute с параметром 'open'
ShellExecute(Handle, 'open', HTMLFile, nil, nil, SW_SHOWNORMAL); 
end; 
end.
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

