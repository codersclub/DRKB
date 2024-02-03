---
Title: Выбор и настройка принтера
Date: 01.01.2007
---


Выбор и настройка принтера
==========================

::: {.date}
01.01.2007
:::


Если принтеры не установлены, то функции выбора и настройки принтера и
задания параметров страницы для печати не могут быть выполнены. Выбор
принтера можно осуществить разными способами. Один из них - активизация
диалогового окна "Выбор принтера". В Visual Basic это осуществляется
оператором Application.Dialogs.Item (xlDialogPrinterSetup).Show, где
Dialogs - коллекция диалогов, а xlDialogPrinterSetup - константа,
определяющая выбор диалога. В Delphi это можно реализовать в виде
функции ShowDialogPrinterSetup, которая возвращает True или False, в
зависимости от результата.

    Function ShowDialogPrinterSetup:boolean;
     const xlDialogPrinterSetup = 9;
    begin
     ShowDialogPrinterSetup:=true;
     try
      ShowDialogPrinterSetup:=E.Dialogs.Item
       [xlDialogPrinterSetup].Show;
     except
      ShowDialogPrinterSetup:=false;
     end;
    End;

Для того, чтобы выбрать принтер и отправить задание на печать,
необходимо вызвать диалог с использованием следующего оператора
Application.Dialogs.Item (xlDialogPrint).Show. Константа xlDialogPrint
определяет вызов стандартного диалога печати. Функция ShowPrintDialog
реализует эти возможности.

    Function ShowPrintDialog:boolean;
    begin
     ShowPrintDialog:=true;
     try
      ShowPrintDialog:=E.Dialogs.Item[xlDialogPrint].Show;
     except
      ShowPrintDialog:=false;
     end;
    End;


Можно расширить возможности этого диалога, предварительно задав
некоторые параметры, например, диапазон страниц и количество копий:

    result=Application.Dialogs.Item(xlDialogPrint).Show(arg2:=1, arg3:=2, arg4:=3).

В Delphi это выглядит так:

    ShowPrintDialog:=E.Dialogs.Item[xlDialogPrint].Show(arg2:=1, arg3:=2, arg4:=3).
