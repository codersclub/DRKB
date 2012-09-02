<h1>Как сделать subform?</h1>
<div class="date">01.01.2007</div>


<p>Those programmers who use the Win API in their programs know that Win32 allows you to insert one dialog box into another one and you'll can deal with subdialog's controls as them were in parent dialog. The good example of it is PropertySheet. I don't know why Borland hided this ability from us and why didn't it insert 'subforming' ability in TForm control. Here I can tell how to use a form as control (subform) in other one and how to create subform controls. It will work in D2, D3 and may be D4 (unfortunatelly, I have not it and can't check). The next steps shows how to make subform component:</p>

<p>First, we have to make the form to be a child. For this we need to override the method CreateParams.</p>

<pre>
type
  TSubForm = class(TForm)
  protected
    procedure CreateParams(var Params: TCreateParams); override;
  end;
 
procedure TSubForm.CreateParams(var Params: TCreateParams);
begin
  inherited CreateParams(Params);
  Params.Style := WS_CHILD or WS_DLGFRAME or WS_VISIBLE or DS_CONTROL;
end;
</pre>

<p>It's enough if you will not register this control into Delphi IDE. Now you can insert TSubForm control into a form at run time as shown below:</p>

<pre>
{ ... }
with TSubForm.Create(YourForm) do
begin
  Parent := YourForm;
  Left := 8;
  Top := 8;
end;
{ ... }
</pre>


<p>Unfortunately, it's not enough if you want insert this control into Delphi IDE. You have to do next two important things for it. Override TSubForm's destructor for prevent Delphi from break when subform will be deleted at design time (by user or Delphi). It can be fixed with next code:</p>
<pre>
destructor TSubForm.Destroy;
begin
  SetDesigning(False);
  inherited Destroy;
end;
</pre>

<p>Now your subform (sure inserted into form) looks like gray rectangle. The good deal is to make subform to show it's components at design time:</p>
<pre>
constructor TSubForm.Create(aOwner: TComponent);
begin
  inherited Create(aOwner);
  if csDesigning in ComponentState then
    ReadComponentRes(Self.ClassName, Self);
end;
</pre>

<p>Now you have a nice subform control which can be used at run time or design time. You can do it with any form which you wish see as subform.</p>

<p>Note: You can define events handler for subform and them will work. In case subform already has some event handler defined and you try redefine it, only subform's event handler will work at run time!</p>

<p>Full source code of the subform control:</p>

<pre>
unit SubForm;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Menus, Dialogs,
    StdCtrls;
 
type
  TSubForm = class(TForm)
  protected
    procedure CreateParams(var Params: TCreateParams); override;
  public
    constructor Create(aOwner: TComponent); override;
    destructor Destroy; override;
  end;
 
procedure Register;
 
implementation
 
{$R *.DFM}
 
procedure Register;
begin
  RegisterComponents('SubForms', [TSubForm]);
end;
 
constructor TSubForm.Create(aOwner: TComponent);
begin
  inherited Create(aOwner);
  if (csDesigning in ComponentState) then
    ReadComponentRes(Self.ClassName, Self);
end;
 
destructor TSubForm.Destroy;
begin
  SetDesigning(False);
  inherited Destroy;
end;
 
procedure TSubForm.CreateParams(var Params: TCreateParams);
begin
  inherited CreateParams(Params);
  Params.Style := WS_CHILD or WS_DLGFRAME or WS_VISIBLE or DS_CONTROL;
end;
 
end.
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>

