---
Title: Распространение приложений с технологией dbExpress
Date: 01.01.2007
---


Распространение приложений с технологией dbExpress
==================================================

Готовое приложение, использующее технологию dbExpress, можно поставлять
заказчикам двумя способами.

Вместе с приложением поставляется динамическая библиотека для выбранного
сервера. Она находится в папке \\Delphi7\\Bin.

Дополнительно, если в приложении используется компонент TSimpleDataSet,
необходимо включить в поставку динамическую библиотеку Midas.dll.

Приложение компилируется вместе со следующими DCU-файлами: dbExpInt.dcu,
dbExpOra.dcu, dbExpDb2.dcu, dbExpMy.dcu (в зависимости от выбранного
сервера). Если в приложении используется компонент TSimpieDataSet,
следует добавить файлы Crtl.dcu и MidasLib.dcu. В результате необходимо
поставлять только исполняемый файл приложения.

Если дополнительная настройка соединений не требуется, файл
dbxconnections.ini не нужен.
