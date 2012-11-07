<h1>Как написать DLL, которую можно было бы выполнить с помощью RunDll, RunDll32?</h1>
<div class="date">01.01.2007</div>


<p>Вы должны определить в программе вызываемую снаружи функцию.</p>
<p>Функция должна быть __stdcall (или WINAPI, что то же самое ;)) и иметь</p>
<p>четыре аргумента. Первый - HWND окна, порождаемого rundll32 (можно</p>
<p>использовать в качестве owner'а своих dialog box'ов), второй - HINSTANCE</p>
<p>задачи, третий - остаток командной строки (LPCSTR, даже под NT),</p>
<p>четвертый - не знаю ;). Hапример,</p>
<pre>
int __stdcall __declspec(dllexport) Test 

( 
  HWND hWnd, 
  HINSTANCE hInstance, 
  LPCSTR lpCmdLine, 
  DWORD dummy 
  ) 
{ 
MessageBox(hWnd, lpCmdLine, "Command Line", MB_OK); 
return 0; 
} 
</pre>


<p>rundll32 test.dll,_Test@16 this is a command line</p>

<p>выдаст message box со строкой "this is a command line".</p>

<p>Oleg Moroz</p>
<p>(2:5020/701.22)</p>

<pre>
function Test(
  hWnd: Integer;
  hInstance: Integer;
  lpCmdLine: PChar;
  dummy: Longint
  ): Integer; stdcall; export;
begin
  Windows.MessageBox(hWnd, lpCmdLine, 'Command Line', MB_OK);
  Result := 0;
end;
</pre>


<p>Akzhan Abdulin</p>
<p>(2:5040/55)</p>

<p>    Давненько я ждал эту инфоpмацию! Сел пpовеpять и наткнулся на очень</p>
<p>забавную вещь. А именно -- пусть у нас есть исходник на Си пpимеpно такого</p>
<p>вида:</p>

<p>int WINAPI RunDll( HWND hWnd, HINSTANCE hInstance, LPCSTR lpszCmdLine, DWORD</p>
<p>dummy )</p>
<p>......</p>
<p>int WINAPI RunDllW( HWND hWnd, HINSTANCE hInstance, LPCWSTR lpszCmdLine, DWORD</p>
<p>dummy )</p>
<p>......</p>

<p>    и .def-файл пpимеpно такого вида:</p>

<p>EXPORTS</p>
<p>    RunDll</p>
<p>    RunDllA=RunDll</p>

<p>    RunDllW</p>

<p>    то rundll32 становится pазбоpчивой -- под HТ вызывает UNICODE-веpсию. Под</p>
<p>95, pазумеется, ANSI. Rulez.</p>

<p>Alexey A Popoff</p>
<p>pvax@glas.apc.org, posp@ccas.ru</p>
<p>https://www.ccas.ru/~posp/popov/pvax.html</p>
<p>(2:5020/487.26)Администрирование</p>

