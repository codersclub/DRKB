---
Title: Добавляем файлы в Recent Documents
Date: 01.01.2007
---


Добавляем файлы в Recent Documents
==================================

::: {.date}
01.01.2007
:::

Предположим Вам захотелось, чтобы Ваше программа сама умела добавлять
файлы \"recent documents list\" (для тех, кто в танке - это такая
менюшка, которая появляется при нажатии на кнопку Пуск(Start) и
наведении мышкой на \"Документы\" (Documents). Сама функция API-шная,
так что применять её можно в любом компиляторе.

Добавляем следующий код в интерфейсную часть формы:

    const 
    SHARD_PIDL = 1; 
    SHARD_PATH = 2; 
     
    procedure SHAddToRecentDocs(Flags: Word; pfname: Pointer); stdcall; external 'shell32.dll' name'SHAddToRecentDocs'; 

А так выглядит вызов этой функции:

    SHAddTorecentDocs(SHARD_PATH,pchar('C:\mydir\myprogram.exe')); 

файл \'myprogram.exe\' будет добавлен в recent documents list

Взято из <https://forum.sources.ru>
