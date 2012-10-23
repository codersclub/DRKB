<h1>Как узнать версию компиллятора?</h1>
<div class="date">01.01.2007</div>


<p>Иногда надо выполнить разный код в зависимости от версии Дельфи, особенно актуально это при разработки компонентов и модулей, которые используются в разных приложениях.</p>
<p>В Дельфи предопределены специальные константы компиляции для этого:</p>
<p>Ver80 - Дельфи 1</p>
<p>Ver90 - Дельфи 2</p>
<p>Ver93 - С Buider 1</p>
<p>Ver100 - Дельфи 3</p>
<p>Ver110 - С Buider 3</p>
<p>Ver120 - Дельфи 4</p>
<p>Ver125 - С Buider 4</p>
<p>Ver130 - Дельфи 5</p>
<p>Ver140 - Дельфи 6</p>
<p>Ver150 - Дельфи 7</p>
<p>Пример использования:</p>
<pre>
procedure TForm1.Button2Click(Sender: TObject);

const Version=
{$Ifdef Ver80}'Дельфи 1';{$EndIf}  
{$Ifdef Ver90}'Дельфи 2';{$EndIf} 
{$Ifdef Ver100}'Дельфи 3';{$EndIf}
{$Ifdef Ver120}'Дельфи 4';{$EndIf} 
{$Ifdef Ver130}'Дельфи 5 ';{$EndIf}
{$Ifdef Ver140}'Дельфи 6';{$EndIf}
{$Ifdef Ver150}'Дельфи 7';{$EndIf} 
begin
  ShowMessage('Для компиляции этой программы был использован '+Version);
end;
</pre>
<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
