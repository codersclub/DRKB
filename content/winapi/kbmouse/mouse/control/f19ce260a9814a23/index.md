---
Title: Подсветка компонента во время перемещения над ним мыши
Date: 01.01.2007
---


Подсветка компонента во время перемещения над ним мыши
======================================================

::: {.date}
01.01.2007
:::

Вы должны обрабатывать сообщения CM\_MOUSEENTER и CM\_MOUSELEAVE
примерно таким образом:

    TYourObject = class(TAnyControl)
      ...
      private
      FMouseInPos: Boolean;
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

\...затем читать параметр FMouseInPos при прорисовке области компонента
или использовать иное решение.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
