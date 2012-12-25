---
Title: Как отследить выход мыши за пределы формы?
Date: 01.01.2007
---


Как отследить выход мыши за пределы формы?
==========================================

::: {.date}
01.01.2007
:::

Можно через события OnMouseEnter/OnMouseLeave:

    TYourObject = class(TAnyControl)
    ...
    private
    FMouseInPos : Boolean;
    procedure CMMouseEnter(var AMsg: TMessage); message CM_MOUSEENTER;
    procedure CMMouseLeave(var AMsg: TMessage); message CM_MOUSELEAVE;
    ...
    end;
     
    implementation
     
     
    procedure TYourObject.CMMouseEnter(var AMsg: TMessage);
    begin
    FMouseInPos := True;
    Refresh;
    end;
     
     
    procedure TYourObject.CMMouseLeave(var AMsg: TMessage);
    begin
    FMouseInPos := False;
    Refresh;
    end;

Затем считывать параметр FMouseInPos.

Взято с сайта <https://blackman.wp-club.net/>
