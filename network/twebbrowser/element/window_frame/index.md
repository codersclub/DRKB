---
Title: Как добраться до конкретного фрейма?
Author: Good Man
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как добраться до конкретного фрейма?
====================================

    var
     
      HTML_Doc: IHTMLDocument2;
      Window: IHTMLWindow2;
      oRange1: variant;
      name_frame: OleVariant;
     
      HTML_Doc := WebBrowser1.Document as IHTMLDocument2;
      Window := HTML_Doc.parentWindow as IHTMLWindow2;
      name_frame := 'mainFrame';
      oRange1 := Window.frames.item(name_frame).document.body.createTextRange;

