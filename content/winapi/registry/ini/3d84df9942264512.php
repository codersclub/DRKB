<h1>Работа с INI-файлами</h1>
<div class="date">01.01.2007</div>


<p>Почему иногда лучше использовать INI-файлы, а не реестр?</p>

<p>1. INI-файлы можно просмотреть и отредактировать в обычном блокноте.</p>
<p>2. Если INI-файл хранить в папке с программой, то при переносе папки на другой компьютер настройки сохраняются. (Я еще не написал ни одной программы, которая бы не поместилась на одну дискету :)</p>
<p>3. Новичку в реестре можно запросто запутаться или (боже упаси), чего-нибудь не то изменить.</p>
<p>Поэтому для хранения параметров настройки программы удобно использовать стандартные INI файлы Windows. Работа с INI файлами ведется при помощи объекта TIniFiles модуля IniFiles. Краткое описание методов объекта TIniFiles дано ниже.</p>

<p>Constructor Create('d:\test.INI');</p>
<p>Создать экземпляр объекта и связать его с файлом. Если такого файла нет, то он создается, но только тогда, когда произведете в него запись информации.</p>

<p>WriteBool(const Section, Ident: string; Value: Boolean);</p>
<p>Присвоить элементу с именем Ident раздела Section значение типа boolean</p>

<p>WriteInteger(const Section, Ident: string; Value: Longint);</p>
<p>Присвоить элементу с именем Ident раздела Section значение типа Longint</p>

<p>WriteString(const Section, Ident, Value: string);</p>
<p>Присвоить элементу с именем Ident раздела Section значение типа String</p>

<p>ReadSection (const Section: string; Strings: TStrings);</p>
<p>Прочитать имена всех корректно описанных переменных раздела Section (некорректно описанные опускаются)</p>

<p>ReadSectionValues(const Section: string; Strings: TStrings);</p>
<p>Прочитать имена и значения всех корректно описанных переменных раздела Section. Формат :</p>
<p>имя_переменной = значение</p>

<p>EraseSection(const Section: string);</p>
<p>Удалить раздел Section со всем содержимым</p>

<p>ReadBool(const Section, Ident: string; Default: Boolean): Boolean;</p>
<p>Прочитать значение переменной типа Boolean раздела Section с именем Ident, и если его нет, то вместо него подставить значение Default.</p>

<p>ReadInteger(const Section, Ident: string; Default: Longint): Longint;</p>
<p>Прочитать значение переменной типа Longint раздела Section с именем Ident, и если его нет, то вместо него подставить значение Default.</p>

<p>ReadString(const Section, Ident, Default: string): string;</p>
<p>Прочитать значение переменной типа String раздела Section с именем Ident, и если его нет, то вместо него подставить значение Default.</p>

<p>Free;</p>
<p>Закрыть и освободить ресурс. Необходимо вызвать при завершении работы с INI файлом</p>

<p>Property Values[const Name: string]: string;</p>
<p>Доступ к существующему параметру по имени Name</p>

<p>Пример :</p>
<pre>
Procedure TForm1.FormClose(Sender: TObject);
var
 IniFile:TIniFile;
begin
  IniFile := TIniFile.Create('d:\test.INI'); { Создали экземпляр объекта }
  IniFile.WriteBool('Options', 'Sound', True); { Секция Options: Sound:=true }
  IniFile.WriteInteger('Options', 'Level', 3); { Секция Options: Level:=3 }
  IniFile.WriteString('Options' , 'Secret password', Pass); 
   { Секция Options: в Secret password записать значение переменной Pass }
  IniFile.ReadSection('Options ', memo1.lines); { Читаем имена переменных}
  IniFile.ReadSectionValues('Options ', memo2.lines); { Читаем имена и значения }
  IniFile.Free; { Закрыли файл, уничтожили объект и освободили память }
end;
</pre>


<p>Источник: <a href="https://dmitry9.nm.ru/info/" target="_blank">https://dmitry9.nm.ru/info/</a></p>
<p class="note">Примечание от Vit.</p>
<p>INI файлы имеют ограничение на размер (конкретно зависит от версии операционной системы), поэтому если нужна поддержка файлов более 64 Kb прийдётся воспользоваться сторонними библиотеками или самому работать с файлами как с текстом. Однако следует помнить, что для хранения больших массивов информации ini файлы представляют не самое удачное решение, при увеличении ini файлов до таких размеров следует подумать об альтернативных методах хранения информации: XML, файлы прямого доступа или базы данных.</p>
