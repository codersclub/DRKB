---
Title: Реализация закладки свойств файла
Date: 01.01.2007
Author: Александр (Rouse\_) Багель
Source: <https://rouse.drkb.ru>
---


Реализация закладки свойств файла
=================================

Достаточно полезная демка для программистов увлекающихся копанием в РЕ
формате.
Выводит список импорта - экспорта выбранного РЕ файла на закладке
свойств файла.

Собственно, помимо демо получения самих списков импорта/экспорта
показывает работу с IShellPropSheetExt,
при помощи которого реализуется сама закладка, есть работа с
активизацией контекста манифеста
(интересно будет тем, кто работает с диалогами под ХР),
в качестве вкусностей - юнит с реализацией функций ImageRvaToVa и
ImageDirectoryEntryToData.
Надеюсь данная работа будет вам интересна.

Скачать демонстрационный пример: [propsheet.zip](propsheet.zip) 139k


**PS:**
Для тех, кто будет собирать проект под Delphi версии 6 и ниже
потребуются дополнительные файлы.

Скачать дополнительные файлы: [uses.zip](uses.zip) 14k

