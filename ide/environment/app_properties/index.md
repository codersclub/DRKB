---
Title: Смена свойств приложения, открываемого по умолчанию
Author: Jin X
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Смена свойств приложения, открываемого по умолчанию
===================================================

Большинство стандартных темплейтов зашиты в delphide70.bpl (70 -
версия), остальные - в каталоге Objrepos. Описаны же последние в файле
bin\\delphi32.dro. Т.о:

1. Добавляем в "delphi32.dro" строки:

  ```
  [C:\Program Files\Lang\Delphi7\ObjRepos\MyApp\MyApp]
  Type=ProjectTemplate
  Page=Projects
  Name=My Application
  Description=This is my application template
  Author=Eugene
  Icon=C:\Program Files\Lang\Delphi7\ObjRepos\MyApp\MyApp.ico
  DefaultProject=1
  Designer=dfm
  ```

  (для темплейтов формы Type=FormTemplate, DefaultMainForm=0/1, DefaultNewForm=0/1)

2. Размещаем нашу темплейт-прогу в каталоге "C:\\Program
Files\\Lang\\Delphi7\\ObjRepos\\MyApp\\" и называем её "MyApp.dpr".

3. Жмём "File/New/Application" (т.к. у нас DefaultProject=1), либо
заходим во вкладку "Projects", а затем кликаем два раза по "My
Application".

4. Радуемся! 

