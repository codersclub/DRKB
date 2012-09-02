<h1>Как прикрепить свою форму к другому приложению?</h1>
<div class="date">01.01.2007</div>


<p>Для этого Вам понадобится переопределить процедуру CreateParams у желаемой формы. А в ней установить params.WndParent в дескриптор окна, к которому Вы хотите прикрепить форму.</p>
<pre>
... = class(TForm) 
  ... 
  protected 
    procedure CreateParams( var params: TCreateParams ); override; 
... 
 
procedure TForm2.Createparams(var params: TCreateParams); 
var 
   aHWnd : HWND; 
begin 
  inherited; 
{как-нибудь получаем существующий дескриптор}
  ahWnd := GetForegroundWindow; 
{а теперь:}
  params.WndParent := ahWnd; 
end; 
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

