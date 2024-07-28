---
Title: Обнаружение прокрутки TMemo
Author: Xavier Pacheco
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Обнаружение прокрутки TMemo
===========================

Создайте потомок TMemo, перехватывающий сообщения WM\_HSCROLL и
WM\_VSCROLL:

    TSMemo = class(TMemo)
     
    procedure WM_HScroll(var Msg: TWMHScroll); message WM_HSCROLL;
    procedure WM_VScroll(var Msg: TWMVScroll); message WM_VSCROLL;
    end;
     
    ...
     
    procedure TSMemo.WM_HScroll(var Msg: TWMHScroll);
    begin
      ShowMessage('HScroll');
    end;
     
    procedure TSMemo.WM_VScroll(var Msg: TWMVScroll);
    begin
      ShowMessage('VScroll');
    end;

