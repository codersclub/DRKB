<h1>Как использовать консоль в неконсольном приложении?</h1>
<div class="date">01.01.2007</div>


<p>Для того, чтобы добавить в не-консольное приложение ввод/вывод из консоли, необходимо воспользоваться функциями AllocConsole и FreeConsole.</p>

<p>Пример:</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject); 
var 
   s: string; 
begin 
  AllocConsole; 
  try 
    Write('Type here your words and press ENTER: '); 
    Readln(s); 
    ShowMessage(Format('You typed: "%s"', [s])); 
  finally 
    FreeConsole; 
  end; 
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


<hr />
<pre>
{ 
 
  For implementing console input/output for non-console applications you 
  should use the AllocConsole and FreeConsole functions. 
  The AllocConsole function allocates a new console for the calling process. 
  The FreeConsole function detaches the calling process from its console. 
  Example below demonstrates using these functions: 
 
}
 
 
 procedure TForm1.Button1Click(Sender: TObject);
 var
   s: string;
 begin
   AllocConsole;
   try
     // Change color attributes 
    SetConsoleTextAttribute(GetStdHandle(STD_OUTPUT_HANDLE),
                                          FOREGROUND_BLUE OR FOREGROUND_GREEN or
                                          BACKGROUND_RED );
     Write('Type here your words and press ENTER: ');
     Readln(s);
     ShowMessage(Format('You typed: "%s"', [s]));
   finally
     FreeConsole;
   end;
 end;
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>

