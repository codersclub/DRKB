---
Title: Работа с ресурсами
Author: Vit
Date: 01.01.2007
---

Работа с ресурсами
==================

::: {.date}
01.01.2007
:::

Сохранить файл в ресурсе программы на этапе компилляции можно выполнив
следующие шаги:

1) Поставить себе RxLib

2) Появится в меню "Project" дополнительный пункт меню "Resources"

3) Открой его, создай новый ресурс "User Data", в него загрузи нужный
файл, измени имя ресурса на что-нибудь типа 'MyResName'.

Теперь при компилляции проэкта в exe файл будет прикомпиллирован ваш
файл в виде ресурса. Извлечь его на этапе выполнения можно следующим
образом:

    with TResourceStream.Create(hInstance, 'MyResName', RT_RCDATA) do 

    try 
    Seek(0, soFromBeginning); 
    SaveToFile('MyFileName.exe'); 
    finally 
    Free; 
    end;  

       

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>

А вот целый проект, сделанный LENIN INC показывающий различные приёмы
работы с ресурсами:

[reswork.zip](https://vingrad.ru/download/delphi/reswork.zip)

Автор: LENIN INC

Взято с Vingrad.ru <https://forum.vingrad.ru>

Исходники программы для чтения и изменения ресурсов готовой программы

Большое спасибо Song нашедшему эту программу
[ResEdit.zip](https://forum.vingrad.ru/index.php?s=2e1a44e8fd0d842dc2781c6bd964f18a&act=Attach&type=post&id=21633)

Автор: Song

Взято с Vingrad.ru <https://forum.vingrad.ru>
