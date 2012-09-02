<h1>Как получить переменные окружения типа PATH и PROMPT?</h1>
<div class="date">01.01.2007</div>


<p>Вариант 1:</p>

<p>Для этого используется API функция GetEnvironmentVariable.</p>

<p>GetEnvironmentVariable возвращает значения:</p>

<p>- В случае удачного выполнения функции, возвращаемое значение содержит количество символов, хранящихся в буфере, не включая последнего нулевого.</p>

<p>- Если указанная переменная окружения для текущего процесса не найдена, то возвращаемое значение равно нулю.</p>

<p>- Если буфер не достаточного размера, то возвращаемое значение равно требуемому размеру для хранения строки значения и завершающего нулевого символа.</p>

<pre>
function GetDOSEnvVar(const VarName: string): string; 
var 
  i: integer; 
begin 
  Result := ''; 
  try 
    i := GetEnvironmentVariable(PChar(VarName), nil, 0); 
 
    if i &gt; 0 then 
      begin 
        SetLength(Result, i); 
        GetEnvironmentVariable(Pchar(VarName), PChar(Result), i); 
      end; 
  except 
    Result := ''; 
  end; 
end; 
</pre>


<hr />
<p>Вариант 2:</p>
<pre>
procedure TMainFrm.AddVarsToMemo(Sender: TObject); 
var 
  p : pChar; 
begin 
  Memo1.Lines.Clear; 
  Memo1.WordWrap := false; 
  p := GetEnvironmentStrings; 
  while p^ &lt;&gt; #0 do begin 
    Memo1.Lines.Add(StrPas(p)); 
    inc(p, lStrLen(p) + 1); 
  end; 
FreeEnvironmentStrings(p); 
end; 
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


