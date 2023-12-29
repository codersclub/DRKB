---
Title: Компиляция ресурсов
Author: Ralph Friedman 
Date: 01.01.2007
---

Компиляция ресурсов
===================

::: {.date}
01.01.2007
:::

Автор: Ralph Friedman 

У меня имеется приблизительно 36 маленьких растровых изображений,
которые я хочу сохранить в файле и затем прилинковать его к exe. Как мне
поместить их в res-файл?

Самый простой путь - создать файл с именем "BITMAPS.RC" и поместить в
него список ваших .BMP-файлов:

BMAP1 BITMAP BMAP1.BMP

BMAP2 BITMAP BMAP2.BMP

CLOCK BITMAP CLOCK.BMP

DBLCK BITMAP DBLCK.BMP

DELOK BITMAP DELOK.BMP

LUPE BITMAP LUPE.BMP

OK BITMAP OK.BMP

TIMEEDIT BITMAP TIMEEDIT.BMP

Затем загрузите Resource Workshop (RW) и выберите пункт меню
File\|Project Open. В выпадающем списке "File Type" (тип файла)
выберите RC-Resource Script и откройте файл, который вы только что
создали. После того, как RW загрузит ваш файл, выберите пункт меню
File\|Project save as. Выберите объект RES-Resource из выпадающего
списка "File Type" (тип файла). В поле редактирования "New File
name" задайте имя нового файла, скажем, BITMAPS.RES. Нажмите OK. Теперь
у вас есть файл ресурса. В вашем модуле Delphi добавьте после строки
{$R *.RES} строку {$R BITMAPS.RES}. После компиляции вы получите
exe-файл с скомпилированными ресурсами. Для получения доступа к ресурсам
во время выполнения программы нужно сделать следующее:

    myImage.Picture.Bitmap.Handle := LoadBitmap(HInstance, 'TIMEEDIT');

В качестве предостережения: убедитесь в том, что имена (в самой левой
колонке) изображений в .RC файле написаны в верхнем регистре, при вызове
также необходимо писать их имена в верхнем регистре.

Взято с <https://delphiworld.narod.ru>
