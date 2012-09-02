<h1>Как получить активный URL из браузера?</h1>
<div class="date">01.01.2007</div>


<p class="author">Автор: Ruslan Abu Zant</p>
<p>Приводимая здесь функция показывает, как Ваше приложение может извлечь из браузера (IE или Netscape) URL , как, например, это делает аська.</p>
<p>Совместимость: Delphi 4.x (или выше)</p>
<p>Не забудьте добавить DDEMan в Ваш проект!</p>
<pre>
uses windows, ddeman, ...... 
 
 
function Get_URL(Servicio: string): String; 
var 
   Cliente_DDE: TDDEClientConv; 
   temp:PChar;      //&lt;&lt;-------------------------This is new 
begin 
    Result := ''; 
    Cliente_DDE:= TDDEClientConv.Create( nil ); 
     with Cliente_DDE do 
        begin 
           SetLink( Servicio,'WWW_GetWindowInfo'); 
           temp := RequestData('0xFFFFFFFF'); 
           Result := StrPas(temp); 
           StrDispose(temp);  //&lt;&lt;-Предотвращаем утечку памяти 
           CloseLink; 
        end; 
      Cliente_DDE.Free; 
end; 
 
procedure TForm1.Button1Click(Sender); 
begin 
   showmessage(Get_URL('Netscape')); 
      или 
   showmessage(Get_URL('IExplore')); 
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
