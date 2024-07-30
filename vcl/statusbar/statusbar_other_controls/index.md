---
Title: TStatusBar с другими контролами
Author: man2002ua
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


TStatusBar с другими контролами
===============================

Этот StatusBar позволит размещать на себе любые другие контролы.

Создаем новый компонент от StatusBar и правим код как внизу.
Потом инсталлируем и всё.

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

