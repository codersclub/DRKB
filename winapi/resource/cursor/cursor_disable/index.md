---
Title: Как запретить показ курсора в TEdit и ему подобных контролах?
Date: 01.01.2007
---

Как запретить показ курсора в TEdit и ему подобных контролах?
=============================================================

::: {.date}
01.01.2007
:::

Создайте своего потомка с обработчиками:

procedure WMPaint(var Msg: TMessage); message WM\_Paint;

procedure WMSetFocus(var Msg: TMessage); message WM\_SetFocus;

procedure WMNCHitTest(var Msg: TMessage); message WM\_NCHitTest;

в которых вызывайте:

inherited;

HideCaret(Handle);
