---
Title: Работа с INI-файлами
Date: 01.01.2007
Source: <https://dmitry9.nm.ru/info/>
---

Работа с INI-файлами
====================

Почему иногда лучше использовать INI-файлы, а не реестр?

1. INI-файлы можно просмотреть и отредактировать в обычном блокноте.

2. Если INI-файл хранить в папке с программой, то при переносе папки на
другой компьютер настройки сохраняются. (Я еще не написал ни одной
программы, которая бы не поместилась на одну дискету :)

3. Новичку в реестре можно запросто запутаться или (боже упаси),
чего-нибудь не то изменить.

Поэтому для хранения параметров настройки программы удобно использовать
стандартные INI файлы Windows. Работа с INI файлами ведется при помощи
объекта TIniFiles модуля IniFiles. Краткое описание методов объекта
TIniFiles дано ниже.

    Constructor Create('d:\test.INI');

Создать экземпляр объекта и связать его с файлом. Если такого файла нет,
то он создается, но только тогда, когда произведете в него запись
информации.

    WriteBool(const Section, Ident: string; Value: Boolean);

Присвоить элементу с именем Ident раздела Section значение типа boolean

    WriteInteger(const Section, Ident: string; Value: Longint);

Присвоить элементу с именем Ident раздела Section значение типа Longint

    WriteString(const Section, Ident, Value: string);

Присвоить элементу с именем Ident раздела Section значение типа String

    ReadSection (const Section: string; Strings: TStrings);

Прочитать имена всех корректно описанных переменных раздела Section
(некорректно описанные опускаются)

    ReadSectionValues(const Section: string; Strings: TStrings);

Прочитать имена и значения всех корректно описанных переменных раздела
Section. Формат :

имя\_переменной = значение

    EraseSection(const Section: string);

Удалить раздел Section со всем содержимым

    ReadBool(const Section, Ident: string; Default: Boolean): Boolean;

Прочитать значение переменной типа Boolean раздела Section с именем
Ident, и если его нет, то вместо него подставить значение Default.

    ReadInteger(const Section, Ident: string; Default: Longint): Longint;

Прочитать значение переменной типа Longint раздела Section с именем
Ident, и если его нет, то вместо него подставить значение Default.

    ReadString(const Section, Ident, Default: string): string;

Прочитать значение переменной типа String раздела Section с именем
Ident, и если его нет, то вместо него подставить значение Default.

    Free;

Закрыть и освободить ресурс. Необходимо вызвать при завершении работы с
INI файлом

    Property Values[const Name: string]: string;

Доступ к существующему параметру по имени Name

Пример :

    Procedure TForm1.FormClose(Sender: TObject);
    var
     IniFile:TIniFile;
    begin
      IniFile := TIniFile.Create('d:\test.INI'); { Создали экземпляр объекта }
      IniFile.WriteBool('Options', 'Sound', True); { Секция Options: Sound:=true }
      IniFile.WriteInteger('Options', 'Level', 3); { Секция Options: Level:=3 }
      IniFile.WriteString('Options', 'Secret password', Pass); 
       { Секция Options: в Secret password записать значение переменной Pass }
      IniFile.ReadSection('Options ', memo1.lines); { Читаем имена переменных}
      IniFile.ReadSectionValues('Options ', memo2.lines); { Читаем имена и значения }
      IniFile.Free; { Закрыли файл, уничтожили объект и освободили память }
    end;


**Примечание от Vit.**

INI файлы имеют ограничение на размер (конкретно зависит от версии
операционной системы), поэтому если нужна поддержка файлов более 64 Kb
придётся воспользоваться сторонними библиотеками или самому работать с
файлами как с текстом. Однако следует помнить, что для хранения больших
массивов информации ini файлы представляют не самое удачное решение, при
увеличении ini файлов до таких размеров следует подумать об
альтернативных методах хранения информации: XML, файлы прямого доступа
или базы данных.
