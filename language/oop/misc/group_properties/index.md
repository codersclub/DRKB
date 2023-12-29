---
Title: Сгруппировать свойства наподобие Font
Date: 01.01.2007
---


Сгруппировать свойства наподобие Font
=====================================

::: {.date}
01.01.2007
:::

...чтобы сгруппировать свойства наподобие Font, вам необходимо создать
наследника (подкласс) TPersistent. Например:

    TBoolList = class(TPersistent)
      private
        FValue1: Boolean;
        FValue2: Boolean
      published
        property Value1: Boolean read FValue1 write FValue1;
        property Value2: Boolean read FValue2 write FValue2;
    end;

Затем, в вашем новом компоненте, для этого подкласса необходимо создать
ivar. Чтобы все работало правильно, вам необходимо перекрыть
конструктор.

    TMyPanel = class(TCustomPanel)
      private
        FBoolList: TBoolList;
      public
        constructor Create( AOwner: TComponent ); override;
      published
        property BoolList: TBoolList read FBoolList write FBoolLisr;
    end;

Затем добавьте следующий код в ваш конструктор:

    constructor TMyPanel.Create( AOwner: TComponent );
    begin
      inherited Create( AOwner );
      FBoolList := TBoolList.Create;
    end;

Взято с <https://delphiworld.narod.ru>
