<h1>Как добавить кнопку в панель инструментов IE?</h1>
<div class="date">01.01.2007</div>


<p>1. ButtonText = Всплывающая подсказка к кнопке</p>
<p>2. MenuText = Текст, который будет использован для пункта в меню "Сервис"</p>
<p>3. MenuStatusbar = *Ignore*</p>
<p>4. CLSID = Ваш уникальный classID. Для создания нового CLSID (для каждой кнопки) можно использовать GUIDTOSTRING.</p>
<p>5. Default Visible := Показать ей.</p>
<p>6. Exec := Путь к Вашей программе.</p>
<p>7. Hoticon := иконка из shell32.dll когда мышка находится над кнопкой</p>
<p>8. Icon := иконка из shell32.dll</p>
<pre>
procedure CreateExplorerButton;
const
  TagID = '\{10954C80-4F0F-11d3-B17C-00C0DFE39736}\';
var
  Reg: TRegistry;
        ProgramPath: string;
  RegKeyPath: string;
begin
 ProgramPath := 'c:\folder\exename.exe';
 Reg := TRegistry.Create;
 try
  with Reg do begin
   RootKey := HKEY_LOCAL_MACHINE;
   RegKeyPath := 'Software\Microsoft\Internet Explorer\Extensions';
   OpenKey(RegKeyPath + TagID, True);
   WriteString('ButtonText', 'Your program Button text');
   WriteString('MenuText', 'Your program Menu text');
   WriteString('MenuStatusBar', 'Run Script');
   WriteString('ClSid', '{1FBA04EE-3024-11d2-8F1F-0000F87ABD16}');
   WriteString('Default Visible', 'Yes'); 
   WriteString('Exec', ProgramPath);
   WriteString('HotIcon', ',4');
   WriteString('Icon', ',4');
  end
 finally
  Reg.CloseKey;
  Reg.Free;
 end;
end;
</pre>
<p>После выполнения этого кода достаточно просто запустить IE.</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

