---
Title: Автозагрузка программ (как и откуда?)
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Автозагрузка программ (как и откуда?)
====================================

По материалам: <https://www.tlsecurity.net/auto.html>

### 1. Папка автозагрузки (Autostart folder)

    C:\windows\start menu\programs\startup

Адрес папки автозагрузки хранится в следующих ключах реестра:

[HKEY\_CURRENT\_USER\\Software\\Microsoft\\Windows\\CurrentVersion\\Explorer\\Shell Folders]

    Startup="C:\windows\start menu\programs\startup"

[HKEY\_CURRENT\_USER\\Software\\Microsoft\\Windows\\CurrentVersion\\Explorer\\User Shell Folders]

    Startup="C:\windows\start menu\programs\startup"

[HKEY\_LOCAL\_MACHINE\\Software\\Microsoft\\Windows\\CurrentVersion\\explorer\\User Shell Folders]

    "Common Startup"="C:\windows\start menu\programs\startup"

[HKEY\_LOCAL\_MACHINE\\Software\\Microsoft\\Windows\\CurrentVersion\\explorer\\Shell Folders]

    "Common Startup"="C:\windows\start menu\programs\startup"

Установка любого другого значения, кроме C:\\windows\\start menu\\programs\\startup,
приведет к выполнению ВСЕХ и КАЖДОГО исполняемого файла внутри установленного каталога.

### 2. Win.ini

    [windows]

    load=file.exe
    run=file.exe

### 3. System.ini

    [boot]

    Shell=Explorer.exe file.exe

### 4. c:\\windows\\winstart.bat

**Примечание:**  
ведет себя как обычный BAT-файл. Используется для копирования и удаления определенных файлов. Автозапуск каждый раз.

### 5. Registry

[HKEY\_LOCAL\_MACHINE\\Software\\Microsoft\\Windows\\CurrentVersion\\RunServices]

    "Whatever"="c:\runfolder\program.exe"

[HKEY\_LOCAL\_MACHINE\\Software\\Microsoft\\Windows\\CurrentVersion\\RunServicesOnce]

    "Whatever"="c:\runfolder\program.exe"

[HKEY\_LOCAL\_MACHINE\\Software\\Microsoft\\Windows\\CurrentVersion\\Run]

    "Whatever"="c:\runfolder\program.exe"

[HKEY\_LOCAL\_MACHINE\\Software\\Microsoft\\Windows\\CurrentVersion\\RunOnce]

    "Whatever"="c:\runfolder\program.exe"

[HKEY\_LOCAL\_MACHINE\\SOFTWARE\\Microsoft\\Windows\\CurrentVersion\\RunOnceEx\\000x]

    "RunMyApp"="||notepad.exe"

Формат:

    DllFileName|FunctionName|CommandLineArguments

или

    ||параметры команды

Для следующих систем:

- Microsoft Windows 98 Microsoft
- Windows 2000 Professional
- Microsoft Windows 2000 Server
- Microsoft Windows 2000 Advanced Server
- Microsoft Windows Millennium Edition

Источник: <http://support.microsoft.com/support/kb/articles/Q232/5/09.ASP>

[HKEY\_CURRENT\_USER\\Software\\Microsoft\\Windows\\CurrentVersion\\Run]

    "Whatever"="c:\runfolder\program.exe"

[HKEY\_CURRENT\_USER\\Software\\Microsoft\\Windows\\CurrentVersion\\RunOnce]

    "Whatever"="c:\runfolder\program.exe"

### 6. c:\\windows\\wininit.ini 

**ПРИМЕЧАНИЕ:**  
Часто используется программами установки.
Если файл существует, он запускается ОДИН РАЗ и
затем удаляется Windows.

Пример содержимого wininit.ini:

    [Rename]

    NUL=c:\windows\picture.exe

**ПРИМЕЧАНИЕ:**  
В этом примере файл c:\\windows\\picture.exe отправляется в NUL,
что означает, что он удаляется.
Это не требует взаимодействия с пользователем и работает полностью скрытно.

### 7. Autoexec.bat

Этот bat-файл запускается каждый раз на уровне Dos.

### 8. Registry Shell Spawning

[HKEY\_CLASSES\_ROOT\\exefile\\shell\\open\\command] @="%1" %*

[HKEY\_CLASSES\_ROOT\\comfile\\shell\\open\\command] @="%1" %*

[HKEY\_CLASSES\_ROOT\\batfile\\shell\\open\\command] @="%1" %*

[HKEY\_CLASSES\_ROOT\\htafile\\Shell\\Open\\Command] @="%1" %*

[HKEY\_CLASSES\_ROOT\\piffile\\shell\\open\\command] @="%1" %*

[HKEY\_LOCAL\_MACHINE\\Software\\CLASSES\\batfile\\shell\\open\\command] @="%1" %*

[HKEY\_LOCAL\_MACHINE\\Software\\CLASSES\\comfile\\shell\\open\\command] @="%1" %*

[HKEY\_LOCAL\_MACHINE\\Software\\CLASSES\\exefile\\shell\\open\\command] @="%1" %*

[HKEY\_LOCAL\_MACHINE\\Software\\CLASSES\\htafile\\Shell\\Open\\Command] @= "%1" %*

[HKEY\_LOCAL\_MACHINE\\Software\\CLASSES\\piffile\\shell\\open\\command] @="%1" %*

Ключ должен иметь значение Value \<"%1" %\*\>,
если это изменить на \<server.exe "%1 %\*"\>,
то server.exe будет выполняться КАЖДЫЙ РАЗ, когда выполняется exe/pif/com/bat/hta.

Известен как «Неизвестный метод запуска» и в настоящее время используется Subseven.

### 9. Icq Inet

[HKEY\_CURRENT\_USER\\Software\\Mirabilis\\ICQ\\Agent\\Apps\\test]

    "Path"="test.exe"
    "Startup"="c:\test"
    "Parameters"=""
    "Enable"="Yes"

[HKEY\_CURRENT\_USER\\Software\\Mirabilis\\ICQ\\Agent\\Apps\

Этот ключ включает в себя все приложения, которые выполняются,
ЕСЛИ ICQNET обнаруживает подключение к Интернету.

### 10. Explorer start-up

**Для Windows 95,98,ME:**

Explorer.exe запускается через запись system.ini,
сама запись не содержит информации о пути, поэтому, если существует c:\\explorer.exe,
то он будет запущен вместо c:\\$winpath\\explorer.exe.

**Для Windows NT/2000:**

Оболочка Windows — это знакомый рабочий стол, который используется для взаимодействия с Windows.
Во время запуска системы Windows NT 4.0 и Windows 2000 обращаются к записи реестра «Shell»:

    HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows NT\CurrentVersion\Winlogon\Shell

чтобы определить имя исполняемого файла, который должен быть загружен как оболочка.

По умолчанию это значение указывает на Explorer.exe.

Проблема связана с порядком поиска, который возникает во время запуска системы.
Всякий раз, когда запись реестра указывает имя модуля кода,
но использует относительный путь, Windows инициирует процесс поиска для нахождения кода.

Порядок поиска следующий:

1) Поиск в текущем каталоге.

2) Если код не найден, выполняется поиск в каталогах,
указанных в

    HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet\Control\Session Manager\Environment\Path

в том порядке, в котором они указаны.

3) Если код не найден, выполняется поиск в каталогах,
указанных в `HKEY\CURRENT_USER\Environment\Path`,
в том порядке, в котором они указаны.

Больше информации:  
<http://www.microsoft.com/technet/security/bulletin/fq00-052.asp>

Апдейт:
<http://www.microsoft.com/technet/support/kb.asp?ID=269049>


**Обобщение:**

Если троян устанавливается как c:\\explorer, ключи запуска или другие элементы запуска не требуются.
Если файл c:\\explorer.exe окажется поврежден, то доступ пользователя к системе будет заблокирован.
Влияет на все версии Windows на сегодняшний день.

### 11. Компонент Active-X

HKEY\_LOCAL\_MACHINE\\Software\\Microsoft\\Active Setup\\Installed Components\\KeyName

    StubPath=C:\PathToFile\Filename.exe

Хотите верьте, хотите нет, но файл filename.exe запускается ДО того,
как оболочка и любая другая программа обычно запускаются с помощью клавиш запуска.


**Другая информация**

[HKEY\_LOCAL\_MACHINE\\Software\\CLASSES\\ShellScrap] @="Scrap object"

    "NeverShowExt"=""

Ключ `NeverShowExt` имеет функцию СКРЫТИЯ реального расширения файла (здесь) SHS.
Это означает, что если вы переименуете файл как «Girl.jpg.shs»,
то он будет отображаться как «Girl.jpg» во всех программах, включая Explorer.

Ваш реестр должен быть полон ключей NeverShowExt, просто удалите этот ключ,
чтобы появилось настоящее расширение файла.
