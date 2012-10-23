<h1>Выполняем встроенные команды Windows</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Ruslan Abu Zant</div>
<p>Компилятор: Delphi 4.x (или выше)</p>
<p>Впринципе эти команды можно запускать в меню "Выполнить..." (Run), кнопки Пуск. Ну а в Delphi они запускаются путём всем извесной команды winexec(Pchar('ABCD'),sw_Show);</p>
<p>где 'ABCD' - одна из следующих команд ... </p>
<p>"rundll32 shell32,Control_RunDLL" - Запустить Панель Управления </p>
<p>"rundll32 shell32,OpenAs_RunDLL" - Открыть диалог "Открыть Как ..." ('Open With...') </p>
<p>"rundll32 shell32,ShellAboutA Info-Box" - Открыть 'About Window Window' </p>
<p>"rundll32 shell32,Control_RunDLL desk.cpl" - Открыть диалог "Свойства: Экран" (Display Properties) </p>
<p>"rundll32 user,cascadechildwindows" - Выстроить все окна каскадно </p>
<p>"rundll32 user,tilechildwindows" - Свернуть все окна </p>
<p>"rundll32 user,repaintscreen" - Обновить Десктоп </p>
<p>"rundll32 shell,shellexecute Explorer" - Перезапустить Проводник </p>
<p>"rundll32 keyboard,disable" - Заблокировать Клавиатуру </p>
<p>"rundll32 mouse,disable" - Запретить мышку </p>
<p>"rundll32 user,swapmousebutton" - Поменять кнопки мыши </p>
<p>"rundll32 user,setcursorpos" - Установить Курсор в позицию (0,0) </p>
<p>"rundll32 user,wnetconnectdialog" - Показать диалог "Подключить сетевой диск" ('Map Network Drive') </p>
<p>"rundll32 user,wnetdisconnectdialog" - Показать диалог "Отключить сетевой диск" ('Disconnect Network Disk')</p>
<p>"rundll32 user,disableoemlayer" - Отобразить окно BSOD ('''(BSOD) = Blue Screen Of Death ''') </p>
<p>"rundll32 diskcopy,DiskCopyRunDll" - Показать диалог копирования диска </p>
<p>"rundll32 rnaui.dll,RnaWizard" - Запустить 'Internet Connection Wizard' </p>
<p>"rundll32 shell32,SHFormatDrive" - Запустить окно форматирования дискеты ('Format Disk (A)') </p>
<p>"rundll32 shell32,SHExitWindowsEx -1" - "Холодный" перезапуск Проводника </p>
<p>"rundll32 shell32,SHExitWindowsEx 1" - Выключить компьютер </p>
<p>"rundll32 shell32,SHExitWindowsEx 0" - Завершить сеанс текущего пользователя </p>
<p>"rundll32 shell32,SHExitWindowsEx 2" Быстрый перезапуск Windows9x </p>
<p>"rundll32 krnl386.exe,exitkernel" - Выход из Windows 9x без потверждения </p>
<p>"rundll rnaui.dll,RnaDial "MyConnect" - Запустить диалог 'Net Connection' </p>
<p>"rundll32 msprint2.dll,RUNDLL_PrintTestPage" - Выбор и печать тестовой страницы текущего принтера </p>
<p>"rundll32 user,setcaretblinktime" - Усатновить скорость мигания курсора</p>
<p>"rundll32 user, setdoubleclicktime" - Установить скорость двойного нажатия </p>
<p>"rundll32 sysdm.cpl,InstallDevice_Rundll" - Поиск устройств не PnP. </p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
