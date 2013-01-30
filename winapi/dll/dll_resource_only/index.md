---
Title: Как создать DLL только с ресурсами?
Date: 01.01.2007
---


Как создать DLL только с ресурсами?
===================================

::: {.date}
01.01.2007
:::

Создайте и откомпилируйте пустой проект DLL, который содержит ссылку на
файл ресурсов .res, который содержит Ваши ресурсы.

    library ResTest; 
    uses 
      SysUtils; 
     
    {$R MYRES.RES} 
     
    begin 
    end. 
     
    Для использования такой DLL, просто загрузите dll и ресурсы, которые Вы будете использовать:
     
    Пример:
     
    {$IFDEF WIN32} 
    const BadDllLoad = 0; 
    {$ELSE} 
    const BadDllLoad = 32; 
    {$ENDIF} 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      h : THandle;   
      Icon : THandle; 
     
    begin 
      h := LoadLibrary('RESTEST.DLL'); 
     
      if h <= BadDllLoad then 
        ShowMessage('Bad Dll Load') 
      else begin 
        Icon := LoadIcon(h, 'ICON_1'); 
        DrawIcon(Form1.Canvas.Handle, 10, 10, Icon); 
        FreeLibrary(h); 
      end; 
    end; 

Взято из <https://forum.sources.ru>
