<h1>Пример простейшей DLL в Delphi</h1>
<div class="date">01.01.2007</div>


<p>Код, представленный ниже демонстрирует простейшую DLL с всего одной функцией "TestDLL". Результат этой процедуры - диалоговое окошко с текстом.</p>
<pre>
Library Test; 
 
{ В хелпе Delphi 5 рекомендуют добавлять юнит ShareMem для улучшения управления памятью и экспортирования вызываемых строк. }
 
Uses ShareMem, SysUtils, Windows, Dialogs; 
{$R *.RES} 
 
Const TestConst = 'This is a tests DLL.'; 
{ Так же рекомендуется использовать параметр StdCall. Это позволяет сделать DLL совместимую с другими языками... }
 
Procedure TestDLL (TestStr : String); Stdcall 
Begin 
     MessageDlg (TestConst + Chr (13) + Chr (13) + 'Your string is: ' + TestStr, mtInformation, [mbOk], 0); 
End; 
 
Exports TestDLL;  // С таким именем процедура будет доступна в приложении...
 
Begin 
End. 
</pre>


<p>Теперь достаточно достаточно объявить в приложении процедуру из DLL и скопировать саму DLL в директорию с приложением.</p>

<p>Procedure TestDLL (TestStr : Sting); Stdcall; External 'Test.dll'; </p>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

