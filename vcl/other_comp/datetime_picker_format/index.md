---
Title: Как поставить свой формат в TDateTimePicker?
Date: 01.01.2007
---


Как поставить свой формат в TDateTimePicker?
============================================

    uses CommCtrl;
     
    const fmt: PChar = 'hh:mm';
     
    SendMessage(DateTimePicker1.Handle, DTM_SETFORMAT, 0, LongInt(fmt));
