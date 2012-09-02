<h1>Запретить использовать RegEdit</h1>
<div class="date">01.01.2007</div>

<p>Например мы вынесли компонент класса TCheckBox, назвали его "Использовать редактор системного реестра". Задача такова: когда флажок установлен пользователь может воспользоваться редактором реестра, когда не установлен - соответственно, не может!!! </p>
<p>Что нужно для осуществления этой задачи? Нужно воспользоваться ключом </p>
<p>HKEY_CURRENT_USER\Software\Microsoft\ Windows\CurrentVersion\Policies\System</p>
<p>создать в нём параметр: </p>
<p>DisableRegistryTools</p>
<p>и задать ему в качестве значение 1, т.е. задействовать его. </p>
<p>Код пишем по нажатию на самом Checkbox'e: </p>
<pre>
procedure TForm1.CheckBox1Click(Sender: TObject);
var
  H: TRegistry;
begin
  H := TRegistry.Create;
  with H do
  begin
    RootKey := HKEY_CURRENT_USER;
    OpenKey('\Software\Microsoft\Windows\CurrentVersion\Policies\System', true);
    if CheckBox1.Checked then
      WriteInteger('DisableRegistryTools', 0)
    else
      WriteInteger('DisableRegistryTools', 1);
    CloseKey;
    Free;
  end;
end;
</pre>
<p>Не забудьте в области uses объявить модуль Registry: </p>
<pre>
uses
  Registry; 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
