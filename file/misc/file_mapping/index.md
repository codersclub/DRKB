---
Title: Как поместить в буфер файл с помощью File Mapping?
Date: 01.01.2007
---


Как поместить в буфер файл с помощью File Mapping?
==================================================

::: {.date}
01.01.2007
:::

1.

В файлике Delphi5\\Demos\\Resxplor\\exeimage.pas ищи слово
CreateFileMapping

2.

идея простая открываешь файл .. (или создаешь)

создаешь Mapping ... CreateFileMapping

отображаешь Mapping в свой процесс MapViewOfFile

и всё

    var
      SharedHandle: THandle;
      FileView: Pointer;
      MyFile: HFILE;
    begin
      MyFile := OpenFile('c:\1.txt', // pointer to filename
        ..., // pointer to buffer for file information
        ... // action and attributes
        );
      SharedHandle := CreateFileMapping(MyFile, nil, PAGE_READWRITE, 0,
        size {размер файла}, PChar('MyFile'));
      FileView := MapViewOfFile(SharedHandle, FILE_MAP_WRITE, 0, 0, size {размер файла});
      ...
        ...
        ...
        ...
    // потом
      UnmapViewOfFile(FileView);

Взято с Vingrad.ru <https://forum.vingrad.ru>
