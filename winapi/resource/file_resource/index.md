---
Title: Работа с ресурсами
Date: 01.01.2007
---

Работа с ресурсами
==================

Вариант 1:

Author: Vit

Source: Vingrad.ru <https://forum.vingrad.ru>

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

---------------------------

Вариант 2:

Author: LENIN INC

Source: Vingrad.ru <https://forum.vingrad.ru>

А вот целый проект, сделанный LENIN INC показывающий различные приёмы работы с ресурсами:

<https://vingrad.ru/download/delphi/reswork.zip>

------------------------------------------------------

Вариант 3:

Author: Song

Source: Vingrad.ru <https://forum.vingrad.ru>

Исходники программы для чтения и изменения ресурсов готовой программы

<https://forum.vingrad.ru/index.php?act=Attach&type=post&id=21633>
