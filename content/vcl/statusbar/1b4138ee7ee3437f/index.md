---
Title: TStatusBar с другими контролами
Author: man2002ua
Date: 01.01.2007
---


TStatusBar с другими контролами
===============================

::: {.date}
01.01.2007
:::

Этот StatusBar позволит размещать на себе любые другие контролы.

Создаем новый компонент от StatusBar и првим код как внизу. Потом
инсталлируем и все.

    unit StatusBarExt;
     
    interface
     
    uses Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, ComCtrls;
     
    type
      TStatusBarExt = class(TStatusBar)
    public
      constructor Create(AOwner: TComponent); override; // добавить конструктор
    end;
     
    procedure Register;
     
    implementation
     
    uses Consts; // не забыть
     
    constructor TStatusBarExt.Create( AOwner : TComponent );
    begin
      inherited Create(AOwner);
      ControlStyle := ControlStyle + [csAcceptsControls]; // собственно все!
    end;
     
    procedure Register;
    begin
      RegisterComponents('Samples', [TStatusBarExt]);
    end;
     
    end.

Автор: man2002ua

Взято с Vingrad.ru <https://forum.vingrad.ru>
