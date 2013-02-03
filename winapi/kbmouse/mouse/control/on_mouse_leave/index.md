---
Title: Добавление события OnMouseLeave
Date: 01.01.2007
---


Добавление события OnMouseLeave
===============================

::: {.date}
01.01.2007
:::

Все потомки TComponent могут посылать сообщения CM\_MOUSEENTER и
CM\_MOUSELEAVE во время вхождения и покидания курсора мыши области
компонента. Если вам необходимо, чтобы ваши компоненты обладали реакцией
на эти события, необходио написать для них соответствующие обработчики.

    procedure CMMouseEnter(var msg:TMessage); message CM_MOUSEENTER;
    procedure CMMouseLeave(var msg: TMessage); message CM_MOUSELEAVE;
    ..
    ..
    ..
    procedure MyComponent.CMMouseEnter(var msg:TMessage);
    begin
     
    inherited;
    {действия на вход мыши в область компонента}
    end;
     
    procedure MyComponent.CMMouseLeave(var msg: TMessage);
    begin
     
    inherited;
    {действия на покидание мыши области компонента}
    end; 

Дополнение

Часто приходится сталкиваться с ситуацией, когда необходимо обработать
два важных события для визуальных компонентов:

MouseEnter - когда событие мыши входит в пределы визуального компонента;

MouseLeave - когда событие мыши оставляет его пределы.

Известно, что все Delphi объявляет эти сообщения в виде:

Cm\_MouseEnter;

Cm\_MouseLeave.

Т.е. все визуальные компоненты, которые порождены от TControl, могут
отлавливать эти события. Следующий пример показывает как создать
наследника от TLabel и добавить два необходимых события OnMouseLeave и
OnMouseEnter.

    {*///////////////////////////////////////////////////////*)
    (*// Author: Briculski Serge
    (*// E-Mail: bserge@airport.md
    (*// Date: 26 Apr 2000
    (*///////////////////////////////////////////////////////*}
     
    unit BS_Label;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls;
     
    type
      TBS_Label = class(TLabel)
      private
        { Private declarations }
        FOnMouseLeave: TNotifyEvent;
        FOnMouseEnter: TNotifyEvent;
        procedure CMMouseEnter(var Message: TMessage); message CM_MOUSEENTER;
        procedure CMMouseLeave(var Message: TMessage); message CM_MOUSELEAVE;
      protected
        { Protected declarations }
      public
        { Public declarations }
      published
        { Published declarations }
        property OnMouseLeave: TNotifyEvent read FOnMouseLeave write FOnMouseLeave;
        property OnMouseEnter: TNotifyEvent read FOnMouseEnter write FOnMouseEnter;
      end;
     
    procedure Register;
     
    implementation
     
    procedure Register;
    begin
      RegisterComponents('Custom', [TBS_Label]);
    end;
     
    { TBS_Label }
     
    procedure TBS_Label.CMMouseEnter(var Message: TMessage);
    begin
      if Assigned(FOnMouseEnter) then
        FOnMouseEnter(Self);
    end;
     
    procedure TBS_Label.CMMouseLeave(var Message: TMessage);
    begin
      if Assigned(FOnMouseLeave) then
        FOnMouseLeave(Self);
    end;
     
    end.
     
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
