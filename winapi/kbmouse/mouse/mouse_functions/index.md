---
Title: Функции и процедуры управления мышью
Date: 01.01.2007
Source: <https://atrussk.ru/delphi/>
---


Функции и процедуры управления мышью
====================================

**`FindVCLWindow( const Pos: TPoint ): TWinControl;`**

Функция возвращает оконное средство управления для местоположения,
определенного параметром Pos. Если для данного местоположения нет
оконных средств управления, то функция возвращает nil.

**`GetCaptureControl: TControl;`**

Функция возвращает средство управления класса TControl, которое получает
в текущий момент все сообщения от мыши.

**`SetCaptureControl( Control: TControl );`**

Функция передает управление мышью средству управления, определенному в
параметре Control. Данное средство управления будет получать все
сообщения от мыши, пока управление мышью не будет передано другому
средству управления с помощью функции SetCaptureControl или функцией
ReleaseCapture Windows API.

