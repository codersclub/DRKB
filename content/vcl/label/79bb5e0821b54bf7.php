<h1>Как переделать TLabel в URL?</h1>
<div class="date">01.01.2007</div>


<p>By Kevin Lange (klange@partslink.com) </p>
<p>Приложение содержит ссылку, которая позволяет запускать Браузер и сразу перейти по указанному в ссылке адресу. Процесс создания URL заключается в переделке компоненты TLabel в URL. </p>
<p>Следующие 3 шага показывают как переделать TLabel в URL.</p>
<p>Шаг 1&nbsp;&nbsp; Установите в свойствах шрифта подчёркивание и цвет ссылки. </p>
<p>Шаг 2&nbsp;&nbsp; Установите свойства курсора. Когда мышка попадает на URL, то курсор должен превращаться в ручку. </p>
<p>Шаг 3&nbsp;&nbsp; Записываем событие OnClick для ссылки. Когда пользователь нажимает на ссылку, то запускается браузер, который автоматически переходит на заданный адрес. Однако этого мало! Нужно будет добавить в приложение ещё одну строчку </p>
<p>  Та самая строчка: </p>
<p>ShellExecute(0,'open',pChar(URL),NIL,NIL,SW_SHOWNORMAL); </p>
<p>Внимание: функция ShellExecute содержится в ShellAPI, поэтому вам прийдётся включить его в проект.</p>
<p>Пример приложения </p>
<pre>
unit Unit1;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
  StdCtrls, ShellAPI;
 
type
  TForm1 = class(TForm)
    URLLabel: TLabel;
    Button1: TButton;
    procedure Button1Click(Sender: TObject);
    procedure URLLabelClick(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  Close;
end;
 
procedure TForm1.URLLabelClick(Sender: TObject);
Const
  URL : String = 'http://www.sources.ru';
begin
  ShellExecute(0,'open',pChar(URL),NIL,NIL,SW_SHOWNORMAL);
end;
 
end.
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

