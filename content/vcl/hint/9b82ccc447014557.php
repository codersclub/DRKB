<h1>Хинт любой формы</h1>
<div class="date">01.01.2007</div>


<p>Borland Delphi 4, Руководство разработчика", К. Пачеко и С.</p>
<p>Тейксер</p>

<p>З.Ы. Пристегните (uses CoolHint) к любой форме с hint'ами и любуйтесь</p>
<p>подсказками.</p>
<pre>
unit CoolHint 
 
interface 
 
uses Windows, Classes, Controls, Forms, Messages, Graphics 
type 
TddgHintWindow = class(THintWindow) 
private 
  FRegion: THandle 
  procedure FreeCurrentRegion 
public 
  destructor Destroy override 
  procedure ActivateHint(Rect: TRect const AHint: string);override ;
  procedure Paint; override ;
  procedure CreateParams(var Params: TCreateParams); override ;
end 
 
implementation 
 
destructor TddgHintWindow.Destroy 
begin 
FreeCurrentRegion; 
inherited Destroy; 
end 
 
procedure TddgHintWindow.CreateParams(var Params: TCreateParams) 
{ We need to remove the border created on the Windows API-level } 
{ when the window is created. } 
begin 
inherited CreateParams(Params) ;
Params.Style := Params.Style and not ws_Border // remove border ;
end;
 
procedure TddgHintWindow.FreeCurrentRegion 
{ Regions, like other API objects, should be freed when you are } 
{ through using them. Note, however, that you cannot delete a } 
{ region which is currently set in a window, so this method sets } 
{ the window region to 0 before deleting the region object. } 
begin 
if FRegion &lt;&gt;0 then 
begin // if Region is alive... 
SetWindowRgn(Handle, 0, True) // set win region to 0 
DeleteObject(FRegion) // FRegion := 0 // zero out field 
end 
end 
 
procedure TddgHintWindow.ActivateHint(Rect: TRect const AHint: string); 
{ Called when the hint is activated by putting the mouse pointer } 
{ above a control. } 
begin 
with Rect do 
Right := Right + Canvas.TextWidth('WWWW') // add some slop 
BoundsRect := Rect 
FreeCurrentRegion 
with BoundsRect do 
{ Create a round rectangular region to display the hint window } 
FRegion := CreateRoundRectRgn(0, 0, Width, Height, Width, Height) 
if FRegion &lt;&gt;0 then 
SetWindowRgn(Handle, FRegion, True) // set win region 
inherited ActivateHint(Rect, AHint) // call inherited 
end 
procedure TddgHintWindow.Paint 
{ This method gets called by the WM_PAINT handler. It is } 
{ responsible for painting the hint window. } 
var R: TRect 
begin 
R := ClientRect // get bounding rectangle 
Inc(R.Left, 1) // move left side slightly 
Canvas.Font.Color := clInfoText // set to proper color 
{ paint string in the center of the round rect } 
DrawText(Canvas.Handle, PChar(Caption), Length(Caption), R, 
DT_NOPREFIX or DT_WORDBREAK or DT_CENTER or DT_VCENTER) 
end 
 
var 
OldHintClass: THintWindowClass 
 
function SetNewHintClass(AClass: THintWindowClass): THintWindowClass 
var 
DoShowHint: Boolean 
begin 
Result := HintWindowClass // return value is old hint 
window 
DoShowHint := Application.ShowHint 
if DoShowHint then 
Application.ShowHint := False // destroy old hint window 
HintWindowClass := AClass // assign new hint window 
if DoShowHint then 
Application.ShowHint := True // create new hint window 
end 
initialization 
OldHintClass := SetNewHintClass(TddgHintWindow) 
finalization 
SetNewHintClass(OldHintClass) 
end.
</pre>


<p>Взято с сайта <a href="https://blackman.wp-club.net/" target="_blank">https://blackman.wp-club.net/</a></p>
