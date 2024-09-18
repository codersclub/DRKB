---
Title: Как запретить показ курсора в TEdit и ему подобных контролах?
Date: 01.01.2007
---

Как запретить показ курсора в TEdit и ему подобных контролах?
=============================================================

Создайте своего потомка с обработчиками:

    procedure WMPaint(var Msg: TMessage); message WM_Paint;
    procedure WMSetFocus(var Msg: TMessage); message WM_SetFocus;
    procedure WMNCHitTest(var Msg: TMessage); message WM_NCHitTest;

в которых вызывайте:

    inherited;
    HideCaret(Handle);
