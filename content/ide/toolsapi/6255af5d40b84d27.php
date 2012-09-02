<h1>Редактор свойства Color с заданными ограничениями</h1>
<div class="date">01.01.2007</div>


<p>Редактор свойства, пример которого приведен ниже, имеет ограничение на устанавливаемые цвета: только clRed, clWhite или clBlue.</p>
<pre>
unit ClrComps;
 
interface
 
uses
  SysUtils, WinTypes, WinProcs, Messages, Classes,
  Graphics, Controls, Forms, Dialogs, DsgnIntf;
 
type
  TColorComponent = class(TComponent)
  private
    FColor: TColor;
  protected
    procedure SetColor(Value: TColor);
  public
    constructor Create(AnOwner: TComponent); override;
  published
    property Color: TColor read FColor write SetColor;
  end;
 
{ Это специальный редактор свойства выбора цветов... }
  TMyColorProperty = class(TIntegerProperty)
  public
    function GetAttributes: TPropertyAttributes; override;
    function GetValue: string; override;
    procedure GetValues(Proc: TGetStrProc); override;
    procedure SetValue(const Value: string); override;
  end;
 
procedure Register;
 
implementation
 
{ TMyColorProperty }
 
function TMyColorProperty.GetAttributes: TPropertyAttributes;
begin
  Result := [paMultiSelect, paValueList];
end;
 
function TMyColorProperty.GetValue: string;
begin
  Result := ColorToString(TColor(GetOrdValue));
end;
 
procedure TMyColorProperty.GetValues(Proc: TGetStrProc);
begin
  Proc('clRed');
  Proc('clWhite');
  Proc('clBlue');
end;
 
procedure TMyColorProperty.SetValue(const Value: string);
var
  NewValue: Longint;
begin
  if IdentToColor(Value, NewValue) and
    ((NewValue = clRed) or
    (NewValue = clWhite) or
    (NewValue = clBlue)) then
    SetOrdValue(NewValue);
end;
 
{ Образец компонента... }
 
constructor TColorComponent.Create(AnOwner: TComponent);
begin
  inherited Create(AnOwner);
  FColor := clRed;
end;
 
procedure TColorComponent.SetColor(Value: TColor);
begin
  if (Value = clRed) or
    (Value = clWhite) or
    (Value = clBlue) then
    begin
      FColor := Value;
    end;
end;
 
procedure Register;
begin
  RegisterComponents('Samples', [TColorComponent]);
  RegisterPropertyEditor(TypeInfo(TColor), TColorComponent,
    'Color', TMyColorProperty);
end;
 
end.
</pre>

<p>- Ed Jordan</p>
<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>

