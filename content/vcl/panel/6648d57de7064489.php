<h1>Компонент со вложенной панелью</h1>
<div class="date">01.01.2007</div>

Автор: Ray Konopka</p>
<p>Следующий небольшой компонент представляет собой панель, содержащую другую, вложенную панель. Во вложенной панели могут быть размещены другие компоненты, читаться они будут правильно. Ключевым моментом здесь является перекрытие методов WriteComponents и ReadState.</p>
<pre>
unit RzPnlPnl;
 
interface
 
uses
  SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
  Forms, Dialogs, ExtCtrls;
 
type
  TSubPanel = class(TPanel)
  protected
    procedure ReadState(Reader: TReader); override;
  end;
 
  TPanelPanel = class(TPanel)
  private
    FSubPanel: TSubPanel;
  protected
    procedure WriteComponents(Writer: TWriter); override;
    procedure ReadState(Reader: TReader); override;
  public
    constructor Create(AOwner: TComponent); override;
  end;
 
procedure Register;
 
implementation
 
procedure TSubPanel.ReadState(Reader: TReader);
var
  OldOwner: TComponent;
begin
  OldOwner := Reader.Owner;
    { Сохраняем старого владельца, что необходимо для PanelPanel }
  Reader.Owner := Reader.Root; { Задаем в качестве владельца форму }
  try
    inherited ReadState(Reader);
  finally
    Reader.Owner := OldOwner;
  end;
end;
 
constructor TPanelPanel.Create(AOwner: TComponent);
const
  Registered: Boolean = False;
begin
  inherited Create(AOwner);
 
  FSubPanel := TSubPanel.Create(Self);
  FSubPanel.Parent := Self;
  FSubPanel.SetBounds(20, 20, 200, 100);
  FSubPanel.Name := 'SomeName';
 
  if not Registered then
  begin
    Classes.RegisterClasses([TSubPanel]);
      { так TSubPanel может храниться в файле формы }
    Registered := True;
  end;
 
end;
 
procedure TPanelPanel.ReadState(Reader: TReader);
var
  OldOwner: TComponent;
  I: Integer;
begin
  for I := 0 to ControlCount - 1 do
    Controls[0].Free;
 
  OldOwner := Reader.Owner;
  Reader.Owner := Self;
    {Для чтения субкомпонентов, установите данный экземпляр в качестве родителя}
  try
    inherited ReadState(Reader);
  finally
    Reader.Owner := OldOwner;
  end;
end;
 
procedure TPanelPanel.WriteComponents(Writer: TWriter);
var
  I: Integer;
begin
  for I := 0 to ControlCount - 1 do
    Writer.WriteComponent(Controls[I]);
end;
 
procedure Register;
begin
  RegisterComponents('Samples', [TPanelPanel]);
end;
 
end.
 
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
