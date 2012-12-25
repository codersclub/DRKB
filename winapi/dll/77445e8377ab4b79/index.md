---
Title: Пример простейшей DLL в Delphi
Date: 01.01.2007
---


Пример простейшей DLL в Delphi
==============================

::: {.date}
01.01.2007
:::

Код, представленный ниже демонстрирует простейшую DLL с всего одной
функцией \"TestDLL\". Результат этой процедуры - диалоговое окошко с
текстом.

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

Теперь достаточно достаточно объявить в приложении процедуру из DLL и
скопировать саму DLL в директорию с приложением.

Procedure TestDLL (TestStr : Sting); Stdcall; External \'Test.dll\';

Взято из <https://forum.sources.ru>
