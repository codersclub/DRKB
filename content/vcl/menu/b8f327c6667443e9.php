<h1>Как поместить маленькие битмапы в TPopupMenu?</h1>
<div class="date">01.01.2007</div>


<p>Следующий пример демонстрирует добавление битмапа в пункт PopUpMenu при помощи API функции SetMenuItemBitmaps(). Эта функция имеет следующие параметры: дескриптор всплывающего меню, номер (начиная с нуля) пункта меню в который мы хотим добаить битмап, и два дескриптора битмапов (одна картинка для меню в активном состоянии, а вторая для неактивного состояния).</p>
<pre>
type
  TForm1 = class(TForm)
    PopupMenu1: TPopupMenu;
    Pop11: TMenuItem;
    Pop21: TMenuItem;
    Pop31: TMenuItem;
    procedure FormCreate(Sender: TObject);
    procedure FormDestroy(Sender: TObject);
    procedure FormMouseUp(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
  private
    { Private declarations }
    bmUnChecked : TBitmap;
    bmChecked : TBitmap;
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  bmUnChecked := TBitmap.Create;
  bmUnChecked.LoadFromFile(
    'C:\Program Files\Borland\BitBtns\ALARMRNG.BMP');
  bmChecked := TBitmap.Create;
  bmChecked.LoadFromFile(
    'C:\Program Files\Borland\BitBtns\CHECK.BMP');
{Добавляем битмапы в пункт меню начиная с 1 в PopUpMenu}
  SetMenuItemBitmaps(PopUpMenu1.Handle,
                     1,
                     MF_BYPOSITION,
                     BmUnChecked.Handle,
                     BmChecked.Handle);
end;
 
procedure TForm1.FormDestroy(Sender: TObject);
begin
  bmUnChecked.Free;
  bmChecked.Free;
end;
 
procedure TForm1.FormMouseUp(Sender: TObject; Button: TMouseButton;
  Shift: TShiftState; X, Y: Integer);
var
  pt : TPoint;
begin
  pt := ClientToScreen(Point(x, y));
  PopUpMenu1.Popup(pt.x, pt.y);
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


