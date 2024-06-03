---
Title: Как внести изменения в код VCL?
Date: 01.01.2007
---


Как внести изменения в код VCL?
===============================

> **Примечание**
> 
> Внесение изменений в VCL не поддерживается Borland или Borland Developer
> Support.
> 
> Но если Вы всё-таки решили сделать это...

Изменения в код VCL никогда не должны вноситься в секцию "interface"
модуля - только в секцию "implementation".

Наиболее безопасный способ
внести изменения в VCL - создать новый каталог, названный "исправленный
VCL". Скопируйте файл VCL, который Вы хотите изменить, в этот каталог.
Внесите изменения (лучше прокомментировать их) в этот файл. Затем
добавьте путь к Вашему каталогу "исправленный VCL" в самое начало
"library path". Перезапустите Delphi/C++ Builder и перекомпилируйте
Ваш проект. "library path" можно изменить в меню:

- Delphi 1 :    Options \| Environment \| Library
- Delphi 2 :    Tools   \| Options     \| Library
- Delphi 3 :    Tools   \| Environment Options \| Library
- Delphi 4 :    Tools   \| Environment Options \| Library
- C++ Builder : Options \| Environment \| Library
