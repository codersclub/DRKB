---
Title: DLL со строковыми ресурсами
Date: 01.01.2007
---


DLL со строковыми ресурсами
===========================

::: {.date}
01.01.2007
:::

Делаешь текстовый файл с ресурсами, типа

\--my.rc\--

STRINGTABLE

{

00001, "My String \#1"

00002, "My String \#2"

}

Далее компилируешь его:

brcc32 my.rc

У тебя получится my.res.

Делаешь DLL:

\--my.dpr\--

    library my;
     
    {$R my.res}
     
    begin
     
    end.

Компилируешь Дельфиским компилятором:

dcc32 my.dpr

Получаешь, наконец-то свою my.dll

Теперь о том, как использовать.

В своей программе:

    var
      h: THandle;
      S: array [0..255] of Char;
    begin
      h := LoadLibrary('MY.DLL');
      if h <= 0 then 
        ShowMessage('Bad Dll Load')
      else
      begin
        SetLength(S, 512);
        LoadString(h, 1, @S, 255);
        FreeLibrary(h);
      end;
    end;

Взято с <https://delphiworld.narod.ru>
