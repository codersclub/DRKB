---
Title: Выполняем встроенные команды Windows
Author: Ruslan Abu Zant
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Выполняем встроенные команды Windows
====================================

Компилятор: Delphi 4.x (или выше)

В принципе, эти команды можно запускать в меню "Выполнить..." (Run),
кнопки Пуск. Ну а в Delphi они запускаются путём всем извесной команды

    winexec(Pchar('ABCD'),sw_Show);

где `'ABCD'` - одна из следующих команд ...

- "rundll32 shell32,Control\_RunDLL" - Запустить Панель Управления

- "rundll32 shell32,OpenAs\_RunDLL" - Открыть диалог "Открыть Как..." (\'Open With...\')

- "rundll32 shell32,ShellAboutA Info-Box" - Открыть \'About Window Window\'

- "rundll32 shell32,Control\_RunDLL desk.cpl" - Открыть диалог "Свойства: Экран" (Display Properties)

- "rundll32 user,cascadechildwindows" - Выстроить все окна каскадно

- "rundll32 user,tilechildwindows" - Свернуть все окна

- "rundll32 user,repaintscreen" - Обновить Десктоп

- "rundll32 shell,shellexecute Explorer" - Перезапустить Проводник

- "rundll32 keyboard,disable" - Заблокировать Клавиатуру

- "rundll32 mouse,disable" - Запретить мышку

- "rundll32 user,swapmousebutton" - Поменять кнопки мыши

- "rundll32 user,setcursorpos" - Установить Курсор в позицию (0,0)

- "rundll32 user,wnetconnectdialog" - Показать диалог "Подключить сетевой диск" (\'Map Network Drive\')

- "rundll32 user,wnetdisconnectdialog" - Показать диалог "Отключить сетевой диск" (\'Disconnect Network Disk\')

- "rundll32 user,disableoemlayer" - Отобразить окно BSOD (\'\'\'(BSOD) = Blue Screen Of Death \'\'\')

- "rundll32 diskcopy,DiskCopyRunDll" - Показать диалог копирования диска

- "rundll32 rnaui.dll,RnaWizard" - Запустить \'Internet Connection Wizard\'

- "rundll32 shell32,SHFormatDrive" - Запустить окно форматирования дискеты (\'Format Disk (A)\')

- "rundll32 shell32,SHExitWindowsEx -1" - "Холодный" перезапуск Проводника

- "rundll32 shell32,SHExitWindowsEx 1" - Выключить компьютер

- "rundll32 shell32,SHExitWindowsEx 0" - Завершить сеанс текущего пользователя

- "rundll32 shell32,SHExitWindowsEx 2" Быстрый перезапуск Windows9x

- "rundll32 krnl386.exe,exitkernel" - Выход из Windows 9x без потверждения

- "rundll rnaui.dll,RnaDial "MyConnect" - Запустить диалог \'Net Connection\'

- "rundll32 msprint2.dll,RUNDLL\_PrintTestPage" - Выбор и печать тестовой страницы текущего принтера

- "rundll32 user,setcaretblinktime" - Усатновить скорость мигания курсора

- "rundll32 user, setdoubleclicktime" - Установить скорость двойного нажатия

- "rundll32 sysdm.cpl,InstallDevice\_Rundll" - Поиск устройств не PnP.

