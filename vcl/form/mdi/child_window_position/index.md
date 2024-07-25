---
Title: Позиция дочерних MDI-окон
Author: Richard Cox
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Позиция дочерних MDI-окон
=========================

> Проблема, с которой я столкнулся, заключается в том, что нижняя часть
> дочерней формы загораживает панель состояния родительской формы...

У меня была аналогичная проблема - она проявлялась при условии, когда
свойство главной формы WindowState устанавливалось на wsMinimized.

Вот мое решение: добавьте этот небольшой метод к вашей главной форме:

    interface
     
    procedure CMShowingChanged(var Message: TMessage); message CM_SHOWINGCHANGED;
     
    implementation
     
    procedure TMainForm.CMShowingChanged(var Message: TMessage);
    var
      theRect: TRect;
    begin
      inherited;
      theRect := GetClientRect;
      AlignControls(nil, theRect);
    end;

Это работает, поскольку вызов AlignControls (в TForm) делает две вещи:
выравнивает элементы управления (включая ваш проблемный StatusBar) и
вновь позиционирует окно клиента относительно главной формы (оно
ссылается на ClientHandle) после того, как элементы управления будут
выравнены... что, впрочем, мы и хотели.

