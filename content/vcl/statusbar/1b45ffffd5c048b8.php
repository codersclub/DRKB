<h1>TStatusBar + TProgressBar</h1>
<div class="date">01.01.2007</div>


<p>Вставить ProgressBar в StatusBar:</p>
<p>Вот эту функцию применять вместо стандартного Create</p>
<pre>
function CreateProgressBar(StatusBar:TStatusBar; index:integer):TProgressBar;
  var findleft:integer;
        i:integer;
begin
  result:=TProgressBar.create(Statusbar);
  result.parent:=Statusbar;
  result.visible:=true;
  result.top:=2;
  findleft:=0;
  for i:=0 to index-1 do 
    findleft:=findleft+Statusbar.Panels[i].width+1;
  result.left:=findleft;
  result.width:=Statusbar.Panels[index].width-4;
  result.height:=Statusbar.height-2;
end;
</pre>

<p class="author">Автор: Vit</p>
<hr />
<pre>
var pb: TProgressBar;

begin
....
pb:= TProgressBar.Create(self);
  with pb do begin
    Parent:= StatusBar1;
    Position:= 30;
    Top:= 2;
    Left:= 0;
    Height:= StatusBar1.Height - Top;
    Width:= StatusBar1.Panels[0].Width - Left;
  end;  //with;
pb.Visible:= True;
....
end; 
</pre>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<pre>
unit adStatba;
 
interface
 
uses
 
Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
ComCtrls;
 
type
 
TAdrockStatusBar = class(TStatusBar)
private
{ Private declarations }
protected
{ Protected declarations }
public
{ Public declarations }
Constructor Create(Aowner : TComponent); override;
published
{ Published declarations }
end;
 
procedure Register;
 
implementation
 
Constructor TAdrockStatusBar.Create(Aowner : TComponent);
begin
 
inherited Create(Aowner);
  ControlStyle := ControlStyle + [csAcceptsControls];
end;
 
procedure Register;
begin
  RegisterComponents('Adrock', [TAdrockStatusBar]);
end;
 
end. 
</pre>

<p>Это позволит вам разместить элемент управления в панели. Но этот способ не поддерживает использование вложенных панелей. Вероятно, вам также понадобиться выровнять элемент управления по правому краю. Не так это все сложно... </p>
<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>
<hr /><p>pgProgress положить на форму как Visible := false; StatusPanel надо OwnerDraw сделать и pефpешить, если Position меняется.</p>
<pre>
procedure TMainForm.stStatusBarDrawPanel(StatusBar: TStatusBar; Panel: TStatusPanel; const Rect: TRect);
begin

  if Panel.Index = pnProgress then
  begin
    pgProgress.BoundsRect := Rect;
    pgProgress.PaintTo(stStatusBar.Canvas.Handle, Rect.Left, Rect.Top);
  end;
end; 
</pre>

<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr /><p>With TProgressBar.Create(StatusBar1) Do Parent:=StatusBar1; </p>
<p class="author">Автор: Song</p>
