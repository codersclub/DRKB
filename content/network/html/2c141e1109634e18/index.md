---
Title: Как получить TextRange страницы без фреймов?
Author: Good Man
Date: 01.01.2007
---


Как получить TextRange страницы без фреймов?
============================================

::: {.date}
01.01.2007
:::

    HTML_Doc := WebBrowser1.Document As IHTMLDocument2;
    Window := HTML_Doc.parentWindow As IHTMLWindow2;
    Body := HTML_Doc.get_body As IHTMLBodyElement;
    Range := oBody.createTextRange;

Можно еще так:

    var
    a:IHTMLTxtRange;
    a:=IHTMLDocument2(webbrowser1.Document).selection.createRange as IHTMLTxtRange;

Автор: Good Man

Взято с Vingrad.ru <https://forum.vingrad.ru>
