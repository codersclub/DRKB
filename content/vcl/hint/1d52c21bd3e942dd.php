<h1>Многострочные подсказки</h1>
<div class="date">01.01.2007</div>


<p>Если подсказка длинная, то удобно ее разместить в две или более строк.</p>
<pre>
procedure TForm1.FormCreate(Sender: TObject);
begin
  Button1.Hint := 'Only one string';
  Button2.Hint := 'There will be' + #13#10 + 'two strings';
  Form1.ShowHint := true;
end;
</pre>


<div class="author">Автор: Даниил Карапетян (delphi4all@narod.ru)</div>
<div class="author">Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)</div>


<hr />

<p>Необходимо создать соответствующую компоненту которая показывает "быструю подсказку" (Hints) с более чем одной <br>
строкой. Компонента наследуется от TComponent и называется TMHint. Hint-текст можно задавать следующим образом: <br>
"Строка 1@Строка 2@Строка 3". Символ '@' используется как разделитель строк. Если Вам нравится другой символ - <br>
измените свойство Separator. Свойство Active указывает на активность (TRUE) или неактивность (FALSE) <br>
<p>"многострочности"</p>
<pre>
unit MHint;
 
 
interface
 
uses
  SysUtils, WinTypes, WinProcs, Messages,
  Classes, Graphics, Controls, Forms, Dialogs;
 
type
  TMHint = class(TComponent)
  private
    ScreenSize: Integer;
    FActive: Boolean;
    FSeparator: Char;
    FOnShowHint: TShowHintEvent;
  protected
    procedure SetActive(Value: Boolean);
    procedure SetSeparator(Value: char);
    procedure NewHintInfo(var HintStr: string;
      var CanShow: Boolean;
      var HintInfo: THintInfo);
  public
    constructor Create(AOwner: TComponent); override;
  published
    property Active: Boolean
      read FActive write SetActive;
    property Separator: Char
      read FSeparator write SetSeparator;
  end;
 
procedure Register;
 
implementation
 
constructor TMHint.Create(AOwner: TComponent);
 
begin
  inherited Create(AOwner);
  FActive := True;
  FSeparator := '@';
  Application.OnShowHint := NewHintInfo;
  ScreenSize := GetSystemMetrics(SM_CYSCREEN);
end;
 
procedure TMHint.SetActive(Value: Boolean);
 
begin
  FActive := Value;
end;
 
procedure TMHint.SetSeparator(Value: Char);
 
begin
  FSeparator := Value;
end;
 
procedure TMHint.NewHintInfo(var HintStr: string;
  var CanShow: Boolean;
  var HintInfo: THintInfo);
 
var
  I: Byte;
 
begin
  if FActive then
    begin
      I := Pos(FSeparator, HintStr);
      while I &gt; 0 do
        begin
          HintStr[I] := #13;
          I := Pos(FSeparator, HintStr);
        end;
      if HintInfo.HintPos.Y+10 &gt; ScreenSize then
        HintInfo.HintPos.Y := ScreenSize-11;
    end;
end;
 
procedure Register;
 
begin
  RegisterComponents('MyComponents', [TMHint]);
end;
 
end.
</pre>

<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

