---
Title: Обмен информацией между приложениями Win32-Win16
Date: 01.01.2007
---

Обмен информацией между приложениями Win32--Win16
=================================================

Пользуйтесь сообщением WM\_COPYDATA.

Для Win16 константа определена как $004A, в Win32 смотрите в WinAPI
Help.

    #define WM_COPYDATA 0x004A
    /*
     * lParam of WM_COPYDATA message points to...
     */
    typedef struct tagCOPYDATASTRUCT {
        DWORD dwData;
        DWORD cbData;
        PVOID lpData;
    } COPYDATASTRUCT, *PCOPYDATASTRUCT;
