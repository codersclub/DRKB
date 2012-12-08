---
Title: Выключение питания ATX коpпуса из-под DOS
Date: 01.01.2007
---

Выключение питания ATX коpпуса из-под DOS
=========================================

::: {.date}
01.01.2007
:::

    mov ax,5301h
    sub bx,bx
    int 15h
    jb stop
    mov ax,530eh
    sub bx,bx
    int 15h
    jb stop
    mov ax,5307h
    mov bx,0001h
    mov cx,0003h
    int 15h
    stop: int 20h

Код прислал Колесников Сергей Александрович \[mailto:rovd\@inbox.ru\]

Взято из Советов по Delphi от [Валентина
Озерова](mailto:mailto:webmaster@webinspector.com)

Сборник Kuliba
