---
Title: Как выравнивать текст в документе (по ширине, по центру и т.д.)?
Date: 16.06.2003
Author: Василий КОРНЯКОВ (_kvn@mail.ru)
---


Как выравнивать текст в документе (по ширине, по центру и т.д.)?
================================================================

Если выделить объект (часть объекта), то к нему можно применять операции
выравнивания текста, используя методы и свойства объекта Selection.
Используйте поле Alignment объекта Selection.ParagraphFormat. Например:

    W.Selection.ParagraphFormat.Alignment:=wdAlignParagraphCenter;
    W.Selection.ParagraphFormat.Alignment:=wdAlignParagraphRight;
    W.Selection.ParagraphFormat.Alignment:=wdAlignParagraphJustify;

где:

WdAlignParagraphCenter=1;  
WdAlignParagraphRight=2;  
WdAlignParagraphJustify=3;
