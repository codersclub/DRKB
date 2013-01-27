---
Title: Как работать с TOpenFileDialog и TSaveFileDialоg?
Author: Vit
Date: 01.01.2007
---


Как работать с TOpenFileDialog и TSaveFileDialоg?
=================================================

::: {.date}
01.01.2007
:::

как именно с ними работать чтобы на с: открыть файл?

Похоже я понял что тебя смущает: OpenFileDialog и SaveFileDialog -
ничего сами по себе не открывают и не сохраняют. Они нужны только для
выбора имени файла. Ставишь их на форму. Там куча свойств и опций - типа
исходны каталог, показыать скрытые файлы или нет и т.п. Впрочем по
началу можно их вообще не указывать. Тебе надо знать только 1 метод -
execute - открыть диалог:

    OpenFileDialog1.execute 

ты можешь проверить действительно ли пользователь выбрал файл или нажал
Cancel:

    if OpenFileDialog1.execute then 

если файл выбран то свойство FileName возвращает тебе строку - имя файла

    if OpenFileDialog1.execute then showmessage(OpenFileDialog1.FileName);

Сам файл не открывается и ничего с ним не делается, все это надо делать
вручную:

    if OpenFileDialog1.execute then
    begin
      assignFile(f,OpenFileDialog1.Filename);
      reset(f);
      seek(f, $10000);
      write(f,b);
      CloseFile(f);
    end;

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>
