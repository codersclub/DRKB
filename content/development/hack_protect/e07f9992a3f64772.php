<h1>Как определить, находится ли ваше приложение в режиме отладки?</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Simon Carter</div>
<p>Обычно господа взломщики, для того, чтобы взломать защиту приложения, запускают его в режиме отладки и анализируют машинный код для определения точки перехвата ввода пароля с клавиатуры.</p>
<p>Обычно таким способом ломаются игрушки :)</p>
<p>Конечно данный способ не сможет полностью защитить Ваш программный продукт от взлома, но прекратить выполнение секретного кода - запросто. Для этого мы будем использовать API функцию IsDebuggerPresent. Единственный недостаток этой функции, заключается в том, что она не работет под Windows 95.</p>
<p>Теперь посмотрим как эту функцию реализовать в Delphi: </p>
<pre>
function DebuggerPresent: boolean; 
type 
  TDebugProc = function: boolean; stdcall; 
var 
  Kernel32: HMODULE; 
  DebugProc: TDebugProc; 
begin 
  Result := False; 
  Kernel32 := GetModuleHandle('kernel32.dll'); 
  if Kernel32 &lt;&gt; 0 then 
  begin 
    @DebugProc := GetProcAddress(Kernel32, 'IsDebuggerPresent'); 
    if Assigned(DebugProc) then 
      Result := DebugProc; 
  end; 
end; 
</pre>


<p>А это окончательный пример вызова нашей функции:</p>
<pre>
if DebuggerPresent then 
  ShowMessage('debugging') 
else 
  ShowMessage('NOT debugging'); 
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


