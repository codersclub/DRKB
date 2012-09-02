<h1>Оглавление файлов помощи (Contents)</h1>
<div class="date">01.01.2007</div>


<p>Используйте HELP_FINDER, если "текущая закладка" не является закладкой 'Index' или 'Find'. HELP_FINDER открывает окно Help Topics, но не меняет закладку с оглавлением (Contents), если текущая закладка - 'Index' или 'Find'. </p>
<p>Попробуйте следующий код:</p>
<pre>
Function L1InvokeHelpMacro(const i_strMacro: String; const i_bForceFile:
  Boolean): Boolean;
Begin
  if i_bForceFile then
    Application.HelpCommand(HELP_FORCEFILE, 0);
  Result:=Application.HelpCommand(HELP_COMMAND,
    Longint(PChar(i_strMacro))); //Приведение типа PChar здесь необязательно.
End;
</pre>


<p>Ищем ассоциированный файл помощи, открываем его (если не открыт) и переходим на закладку 'Index':</p>
<p>L1InvokeHelpMacro('Search()', True);</p>

<p>Ищем ассоциированный файл помощи, открываем его (если не открыт) и переходим на закладку 'Contents':</p>
<p>L1InvokeHelpMacro('Contents()', True);</p>

<p>Ищем ассоциированный файл помощи, открываем его (если не открыт) и переходим на закладку 'Find' (только для WinHelp 4):</p>
<p>L1InvokeHelpMacro('Find()', True);</p>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
