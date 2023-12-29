---
Title: GIF для HTML в EXE
Date: 01.01.2007
---


GIF для HTML в EXE
==================

::: {.date}
01.01.2007
:::

Есть программа на Delphi, котоpая отображает какой-то html. В html
используется gif-файл. Как в Delphi-пpоекте указать, чтобы этот gif
находился в exe как некий кусок кода. А когда надо будет, записать его
обратно в gif-файл без изменений, выковырнув из exe?

Можно, используя RxLib. После его установки в меню View появится пунктик
Project Resources. Hужно выбрать Project Resources-\>New-\>User Data и
добавить нужный файл. В данном случае ресурс был назван \"RCDATA\_1\".

Если RxLib нет, то нужно создать файл описания ресурсов:

    === Begin gifs.rc ===
    mygif rcdata "имя_gif-файла.gif"
    mygif1 rcdata "RCDATA_1"
    === End dots.rc ===

Потом скомпилировать его командой brcc32 gifs.rc и получить gifs.res В
начало модуля добавь строчку {$R gifs.res}

В своей программе необходимо написать:

    var
      rs: TResourceStream;
      a: Pointer;
    begin
      rs := TResourceStream.Create(hinstance, 'RCDATA_1', RT_RCDATA);
      try
        GetMem(a, rs.size);
        rs.Read(a^, rs.size); {Теперь a - динамический указатель на код}
        { Здесь делается все, что необходимо с кодом, используя указатель a }
        FreeMem(a);
      finally
        rs.Free;
      end;
    end;

А можно и так, если необходимо записать ресурс в файл:

    var
      rs: TResourceStream;
      fs: TFileStream;
    begin
      rs := TResourceStream.Create(hInstance, 'mygif', RT_RCDATA);
      fs := TFileStream.Create('имя_gif-файла.gif', fmCreate);
      try
        fs.CopyFrom(rs, rs.Size);
      finally
        fs.Free;
        rs.Free;
      end;
    end;

Взято с <https://delphiworld.narod.ru>
