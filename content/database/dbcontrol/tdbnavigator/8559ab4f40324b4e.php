<h1>Выключение кнопок в TDBNavigator</h1>
<div class="date">01.01.2007</div>


<pre>
{ Расширение DBNavigator: позволяет разработчику включать и выключать
отдельные кнопки через методы EnableButton и DisableButton }
 
unit GNav;
 
interface
 
uses
 
  Windows, Messages, SysUtils, Classes, Graphics, Controls,
  Forms, Dialogs, ExtCtrls, DBCtrls;
 
type
  TMyNavigator = class(TDBNavigator)
  public
    procedure EnableButton(Btn: TNavigateBtn);
    procedure DisableButton(Btn: TNavigateBtn);
  end;
 
procedure Register;
 
implementation
 
procedure TMyNavigator.EnableButton(Btn: TNavigateBtn);
begin
  Buttons[Btn].Enabled := True;
end;
 
procedure TMyNavigator.DisableButton(Btn: TNavigateBtn);
begin
  Buttons[Btn].Enabled := False;
end;
 
procedure Register;
begin
  RegisterComponents('Samples', [TMyNavigator]);
end;
 
end.
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
