---
Title: Как использовать протокол res?
Date: 01.01.2007
---


Как использовать протокол res?
==============================

::: {.date}
01.01.2007
:::

Взято из FAQ:<https://blackman.km.ru/myfaq/cont4.phtml>

Перевод материала с сайта members.home.com/hfournier/webbrowser.htm

Протокол " res:" позволяет просмотреть HTML файл, сохранённый как
ресурс.

Более подробная информация доступна на Microsoft site:

    procedure TForm1.LoadHTMLResource;
    var
      Flags, TargetFrameName, PostData, Headers: OleVariant;
    begin
      WebBrowser1.Navigate('res://' + Application.ExeName + '/myhtml',
        Flags, TargetFrameName, PostData, Headers)
    end; 

Создайте файл ресурса (*.rc) со следующими строками и откомпилируйте

его при помощи brcc32.exe: MYHTML 23 " .\\html\\myhtml.htm" MOREHTML
23 " .\\html\\morehtml.htm" Отредактируйте файл проекта, чтобы он
выглядел примерно так: {$R *.RES}

{$R HTML.RES} //где html.rc будет скомпилирован в html.res
