<h1>Как перехватить события в неклиентской области формы?</h1>
<div class="date">01.01.2007</div>


<p>Создайте обработчик одного из сообщений WM_NC (non client - не клиентских) (посмотрите</p>
<p>WM_NC в Windows API help). Пример показывает как перехватить вижение мыши во всей</p>
<p>неклиенстской области окна (рамка и заголовок).</p>

<p>Пример:</p>
<pre>
unit Unit1;
 
interface
 
uses
   Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, StdCtrls;
 
type
TForm1 = class(TForm)
private
        {Private declarations}
        procedure WMNCMOUSEMOVE(var Message: TMessage);
        message WM_NCMOUSEMOVE;
public
        {Public declarations}
end;
 
var
        Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
procedure TForm1.WMNCMOUSEMOVE(var Message: TMessage);
var
        s : string;
begin
        case Message.wParam of
                HTERROR:         
                        s:= 'HTERROR';
                HTTRANSPARENT:
                        s:= 'HTTRANSPARENT';
                HTNOWHERE:        
                        s:= 'HTNOWHERE';
                HTCLIENT:
                        s:= 'HTCLIENT';
                HTCAPTION:
                        s:= 'HTCAPTION';
                HTSYSMENU:
                        s:= 'HTSYSMENU';
                HTSIZE:
                        s:= 'HTSIZE';
                HTMENU:
                        s:= 'HTMENU';
                HTHSCROLL:
                        s:= 'HTHSCROLL';
                HTVSCROLL:
                        s:= 'HTVSCROLL';
                HTMINBUTTON:
                        s:= 'HTMINBUTTON';
                HTMAXBUTTON:
                        s:= 'HTMAXBUTTON';
                HTLEFT:
                        s:= 'HTLEFT';
                HTRIGHT:
                        s:= 'HTRIGHT';
                HTTOP:
                        s := 'HTTOP';
                HTTOPLEFT:
                        s:= 'HTTOPLEFT';
                HTTOPRIGHT:
                        s:= 'HTTOPRIGHT';
                HTBOTTOM:
                        s:= 'HTBOTTOM';
                HTBOTTOMLEFT:
                        s:= 'HTBOTTOMLEFT';
                HTBOTTOMRIGHT:
                        s:= 'HTBOTTOMRIGHT';
                HTBORDER:
                        s:= 'HTBORDER';
                HTOBJECT:
                        s:= 'HTOBJECT';
                HTCLOSE:
                        s:= 'HTCLOSE';
                HTHELP:
                        s:= 'HTHELP';
                else s:= '';
        end;
        Form1.Caption := s;
        Message.Result := 0;
end;
 
end.
</pre>


<p>Взято из</p>
DELPHI VCL FAQ Перевод с английского &nbsp; &nbsp; &nbsp; 
<p>Подборку, перевод и адаптацию материала подготовил Aziz(JINX)</p>
<p>специально для <a href="https://delphi.vitpc.com/" target="_blank">Королевства Дельфи</a></p>

