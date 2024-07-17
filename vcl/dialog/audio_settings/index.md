---
Title: Как открыть диалог свойств аудио?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как открыть диалог свойств аудио?
=================================

    WinExec('rundll32.exe shell32.dll,Control_RunDLL mmsys.cpl,,2',
            SW_SHOWNORMAL); 

