---
Title: Симулировать нажатие клавиш для копии и вставки из буфера
Date: 01.01.2007
---


Симулировать нажатие клавиш для копии и вставки из буфера
=========================================================

::: {.date}
01.01.2007
:::

    //Ctrl+C, Strg+C: 
     
    keybd_event(VK_CONTROL, MapVirtualKey(VK_CONTROL, 0), 0, 0);
     keybd_event(Ord('C'), MapVirtualKey(Ord('C'), 0), 0, 0);
     keybd_event(Ord('C'), MapVirtualKey(Ord('C'), 0), KEYEVENTF_KEYUP, 0);
     keybd_event(VK_CONTROL, MapVirtualKey(VK_CONTROL, 0), KEYEVENTF_KEYUP, 0)
     
     
     
     //Ctrl+V, Strg+V: 
     
    keybd_event(VK_CONTROL, MapVirtualKey(VK_CONTROL, 0), 0, 0);
     keybd_event(Ord('V'), MapVirtualKey(Ord('V'), 0), 0, 0);
     keybd_event(Ord('V'), MapVirtualKey(Ord('V'), 0), KEYEVENTF_KEYUP, 0);
     keybd_event(VK_CONTROL, MapVirtualKey(VK_CONTROL, 0), KEYEVENTF_KEYUP, 0)

Взято с сайта: <https://www.swissdelphicenter.ch>
