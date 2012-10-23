<h1>Имя класса компонента и модуля</h1>
<div class="date">01.01.2007</div>


<p>Мне необходима функция, которая возвращала бы имя класса компонента и имя модуля, где определен данный класс.</p>

<p>Например: xxx('TPanel') возвращала бы 'ExtCtrls'</p>

<p>Также мне необходима функция, возвращающая список имен страниц палитры компонентов.</p>
<pre>
Uses TypInfo;
 
Function ObjectsUnit (Obj: TClass): String; 
Begin
  Result := GetTypeData (PTypeInfo(Obj.ClassInfo))^.UnitName
end;
</pre>

<p>Для создания описанной вами функции "Какой модуль" могут использоваться описанные в TOOLINTF.INT методы GetModuleCount, GetModuleName, GetComponentCount и GetComponentName.</p>

<p>Для получения представления о формате палитры компонентов обратитесь к файлу DELPHI.INI.</p><p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

