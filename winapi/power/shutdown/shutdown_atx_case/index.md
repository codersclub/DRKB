---
Title: Выключение питания ATX коpпуса из-под DOS
author: Колесников Сергей Александрович [rovd@inbox.ru]
Date: 01.01.2007
Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com) Сборник Kuliba
---

Выключение питания ATX коpпуса из-под DOS
=========================================

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

