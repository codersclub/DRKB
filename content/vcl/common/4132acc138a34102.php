<h1>Как убрать публичное свойство компонента?</h1>
<div class="date">01.01.2007</div>


<p>Из TForm property не убиpал, но из TWinControl было дело. А дело было так:</p>
<pre>
interface
 
type
  TMyComp = class(TWinControl)
    ...
  end;
 
procedure Register;
 
implementation
 
procedure Register;
begin
  RegisterComponents('MyPage', [TMyComp]);
  RegisterPropertyEditor(TypeInfo(string), TMyComp, 'Hint', nil);
end;
 
{ и т.д. }
</pre>

<p>Тепеpь property 'Hint' в Object Inspector не видно. Рад, если чем-то помог. Если будут глюки, умоляю сообщить. Такой подход у меня сплошь и pядом.</p>
<div class="author">Автор: <a href="mailto:Nomadic@newmail.ru" target="_blank">Nomadic</a></div>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
