---
Title: Развертывание приложения, использующего dbExpress
Author: Андрей Пащенко
Date: 01.01.2007
---


Развертывание приложения, использующего dbExpress
=================================================

::: {.date}
01.01.2007
:::

Автор: Андрей Пащенко

Специально для Королевства Delphi

Начиная с Delphi 6 в палитре компонентов появилась новая закладка
dbExpress. В настоящее время данные \"кирпичики\" широко используются в
приложения для доступа к различным базам данных. Однако развернув
готовое приложение на компьютере, без установленной Delphi, разработчик
недоумевает о неработоспособности приложения. Возникает резонный вопрос:
ЧТО ДЕЛАТЬ?

Согласно справочной системе Delphi корректную работу вашего приложения в
операционной системе Windows можно обеспечить двумя способами: в виде
одного exe файла, либо используя дополнительные DLL библиотеки.

Первый способ - единый exe файл

Все что необходимо сделать для нормальной работы вашего приложения это
добавить в оператор USES ссылку на три DCU файла, находящихся в
директории Lib (по умолчанию C:\\Program
Files\\Borland\\Delphi6\\Lib\\).

Первый файл имеет имя Crtl. Ссылку на него необходимо добавлять всегда,
когда в приложении используется dbExpress и планируется обойтись без
дополнительных DLL.

Если в программе используются классы TSQLClientDataSet, TClientDataSet
или их потомки, возникает необходимость добавления ссылки на файл
MidasLib.

В зависимости от используемого SQL сервера в оператор USES необходимо
добавить:

для MySQL - dbExpMy (в случае установленного Service Pack 2 -
dbExpMySQL);

для InterBase - dbExpInt;

для Oracle - dbExpOra;

для DB2 - dbExpDb2

Второй способ - применение дополнительных DLL.

Работу механизма dbExpress в программе выполняют две библиотеки. Их
имена совпадают с именами DCU файлов.

При наличии в устанавливаемом приложении классов TSQLClientDataSet,
TClientDataSet или их потомков необходимо наличие файла Midas.dll.

Вторая DLL обеспечивает связь с конкретным SQL сервером:

для MySQL - dbexpmy.dll (в случае установленного Service Pack 2 -
dbExpMySQL.dll);

для InterBase - dbexpint.dll;

для Oracle - dbExpOra.dll;

для DB2 - dbExpDb2.dll

Все дополнительные библиотеки должны находится либо в директории вашей
программы, либо в директориях указанных в переменной PATH. Например:
C:\\Windows\\SYSTEM\\ или C:\\Winnt\\SYSTEM32\\

Независимо от выбранного способа вам вероятно потребуется и
дополнительная DLL для доступа к серверу, которую можно найти в
дистрибутиве используемого вами SQL сервера (например для MySQL это файл
libmySQL.dll).

Что же выбрать?

В череде экспериментов in vitro (т.е. в искусственных условиях) были
выявлены только два различия.

Различие №1. Размеры распространяемого приложения.

Если вы обходитесь без дополнительных DLL библиотек, то ваш exe файл
увеличивается в размере.

Приложение для тестов:

Тестовый пример состоял из формы на которой размещены два не визуальных
компонента: TSQLConnection, TSQLClientDataSet. Компоненты настроены для
работы с SQL сервером MySQL. Все настройки компиляции установлены по
умолчанию.

Размер EXE файла без дополнительных DLL больше после компилирования на
245248 байта (239,5 Кб). В то же время суммарный размер одного
приложения без дополнительных DLL меньше на 140800 байта (137,5 Кб)
(табл. 1).

Таблица 1. Размеры распространяемых файлов для приложения использующего
dbExpress для доступа к SQL серверу

Тип файла Размер файлов необходимых для приложения без дополнительных
DLL(байты) Размер файлов необходимых для приложения с дополнительными
DLL(байты)

Исполняемый файл 985600 740352

Дополнительные DLL

для MySQL - dbexpmysql.dll - 92160

Midas.dll - 293888

ИТОГО 985600 1126400

Таким образом если на компьютере используется больше, чем одно
приложение, то выгода от использования дополнительных DLL очевидна.

Различие №2. Реестр Windows.

Если приложение использует дополнительные DLL, то при первом запуске
приложения в реестре добавляются ссылки на файл Midas.dll. (см. файл
MidasReg.zip).

При перемещении или удалении файла из данного места все приложения
использующие Midas.dll перестают работать. Для восстановления
работоспособности приходится вручную удалять данные записи из реестра.

Приемлемым выходом из данной ситуации можно считать размещение данной
библиотеки в системной директории Windows (C:\\Windows\\SYSTEM\\ или
C:\\Winnt\\SYSTEM32\\).

Если приложение распространяется без Midas.dll или dbExpress
используется в DLL, то данных изменений в реестре на наблюдается.

Таким образом если необходимо избежать \"мусора\" в реестре, то
необходимо подготовить ваше приложения к работе без дополнительных DLL.

Взято с <https://delphiworld.narod.ru>