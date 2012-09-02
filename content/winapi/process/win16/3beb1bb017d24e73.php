<h1>Обмен информацией между приложениями Win32&ndash;Win16</h1>
<div class="date">01.01.2007</div>


<p>Пользуйтесь сообщением WM_COPYDATA. </p>
<p>Для Win16 константа определена как $004A, в Win32 смотрите в WinAPI Help. </p>

<pre>
#define WM_COPYDATA 0x004A
/*
 * lParam of WM_COPYDATA message points to...
 */
typedef struct tagCOPYDATASTRUCT {
    DWORD dwData;
    DWORD cbData;
    PVOID lpData;
} COPYDATASTRUCT, *PCOPYDATASTRUCT;
</pre>

