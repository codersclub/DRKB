---
Title: Как узнать конфигурацию железа?
Date: 01.01.2007
---

Как узнать конфигурацию железа?
===============================

Вариант 1:

Source: Vingrad.ru <https://forum.vingrad.ru>

Вот компонент для этого нашел:

https://delphi.mastak.ru/cgi-bin/download.pl?get=1020812496&n=0  
http://www.mitec.cz/

описание от авторов:

> File: msi.zip  
> Product: MiTeC System Information Component  
> Version: 6.2  
> Author: MichaL MutL  
> E-Mail: michal.mutl@atlas.cz  
> Target: Delphi 5.x, Delphi 6.x  
> Platform: W95, W98, NT, W2000, Windows ME, Windows XP  
> Status: Fully Functional  
> Source: Included  
> 
> Description: Component providing detailed system information
> 
> - Registered organization, owner
> - Time Zone info
> - Machine name, IP address, MAC Address
> - Last boot date and time, Boot time
> - CPU architecture, type, active mask, count, level, revision, vendor, id, speed,
> - OS version, build number, platform, CSD version, version name, user name, serial number
> - DVD Region, folders
> - Graphic adapter chip name, dac, memory, screen width and height, color depth, modes
> - Sound card name, WaveIn, WaveOut, MIDIIn, MIDIOut, AUX, Mixer device name
> - Printers
> - Memory info, allocation granularity, min.and max.application address
> - Disk info, file system, controllers
> - BIOS name, copyright, extended info, date
> - Video BIOS version and date
> - Network adapter, protocols, sevices, clients,
> - Winsock info
> - BDE, ODBC, DAO, ADO version
> - DirectX info
> - Device overview (like Device Manager)
> - Win9x resources
> - Running process enumeration
> - Installed software enumeration
> - Startup runs enumeration
> - Performance Library interface (NT & 9x)
> - Internet settings
> - Sharepoints enumeration
> - Component showing CPU usage

------------------------------------------------------------------------

Вариант 2:

Author: Diamond cat

Source: Vingrad.ru <https://forum.vingrad.ru>

Почти все о железе можно прочитать из реестра по ключу:

    HKEY_LOCAL_MACHINE\System\CurrentControlSet\Services\Class\

