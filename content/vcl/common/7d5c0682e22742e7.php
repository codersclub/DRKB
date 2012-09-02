<h1>Как добавить событие OnMouseLeave?</h1>
<div class="date">01.01.2007</div>


<p>Все потомки TComponent могут посылать сообщения CM_MOUSEENTER и CM_MOUSELEAVE во время вхождения и покидания курсора мыши области компонента. Если вам необходимо, чтобы ваши компоненты обладали реакцией на эти события, необходио написать для них соответствующие обработчики. </p>
<pre>
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
</pre>


<p>Дополнение </p>

<p>Часто приходится сталкиваться с ситуацией, когда необходимо обработать два важных события для визуальных компонентов: </p>

<p>MouseEnter - когда событие мыши входит в пределы визуального компонента; </p>
<p>MouseLeave - когда событие мыши оставляет его пределы.</p>
<p>Известно, что все Delphi объявляет эти сообщения в виде: </p>
<p>Cm_MouseEnter; </p>
<p>Cm_MouseLeave.</p>
<p>Т.е. все визуальные компоненты, которые порождены от TControl, могут отлавливать эти события. Следующий пример показывает как создать наследника от TLabel и добавить два необходимых события OnMouseLeave и OnMouseEnter.</p>

<pre>
(*///////////////////////////////////////////////////////*)
(*// Author: Briculski Serge
(*// E-Mail: bserge@airport.md
(*// Date: 26 Apr 2000
(*///////////////////////////////////////////////////////*)
 
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
</pre>


<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

